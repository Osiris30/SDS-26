<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use RuntimeException;
use Throwable;

class AdminPostController extends Controller
{
    public function index(): View
    {
        return view('admin.posts.index', [
            'posts' => Post::with(['category', 'images'])->latest('updated_at')->paginate(10),
        ]);
    }

    public function create(): View
    {
        return view('admin.posts.form', [
            'post' => new Post(),
            'categories' => Category::orderBy('name')->get(),
            'activityFieldSets' => Post::activityFieldSets(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request, null);
        $gallery = $data['images'] ?? [];
        $cover = $data['image'];
        unset($data['images'], $data['image']);
        $data['user_id'] = $request->user()->id;
        $data['authors'] = $request->user()->name;
        $data['slug'] = $this->uniqueSlug($data['title']);
        $publicationMode = (int) $data['is_published'];
        $data['is_published'] = $publicationMode !== 0;
        $data['published_at'] = match ($publicationMode) {
            0 => null,
            1 => now(),
            2 => $data['published_at'],
        };
        $storedPaths = [];

        try {
            DB::transaction(function () use (&$data, $gallery, $cover, &$storedPaths): void {
                $data['image_path'] = $cover->store('posts/covers', 'public');
                if (! $data['image_path']) {
                    throw new RuntimeException('No se pudo guardar la imagen principal.');
                }
                $storedPaths[] = $data['image_path'];
                $post = Post::create($data);
                $post->images()->createMany($this->storeGallery($gallery, $storedPaths));
            });
        } catch (Throwable $exception) {
            Storage::disk('public')->delete($storedPaths);
            throw $exception;
        }

        return redirect()->route('admin.posts.index')->with('status', 'La publicación se creó correctamente.');
    }

    public function edit(Post $post): View
    {
        $post->load('images');

        return view('admin.posts.form', [
            'post' => $post,
            'categories' => Category::orderBy('name')->get(),
            'activityFieldSets' => Post::activityFieldSets(),
        ]);

    }

    public function update(Request $request, Post $post): RedirectResponse
    {
        $data = $this->validated($request, $post);
        $gallery = $data['images'] ?? [];
        $removeImages = $data['remove_images'] ?? [];
        $replaceCover = $data['image'] ?? null;
        unset($data['images'], $data['remove_images'], $data['image']);

        $title = $data['title'];
        $data['slug'] = $this->uniqueSlug($title, $post->id);
        $publicationMode = (int) $data['is_published'];
        $data['is_published'] = $publicationMode !== 0;
        $data['published_at'] = match ($publicationMode) {
            0 => null,
            1 => now(),
            2 => $data['published_at'],
        };

        $storedPaths = [];
        $oldPaths = [];

        try {
            DB::transaction(function () use ($post, &$data, $gallery, $removeImages, $replaceCover, &$storedPaths, &$oldPaths): void {
                if ($replaceCover) {
                    $oldPaths[] = $post->image_path;
                    $data['image_path'] = $replaceCover->store('posts/covers', 'public');
                    if (! $data['image_path']) {
                        throw new RuntimeException('No se pudo guardar la imagen principal.');
                    }
                    $storedPaths[] = $data['image_path'];
                }

                $post->update($data);

                if ($removeImages !== []) {
                    $imagesToRemove = $post->images()->whereIn('id', $removeImages)->get();
                    $oldPaths = [...$oldPaths, ...$imagesToRemove->pluck('path')->all()];
                    $post->images()->whereIn('id', $imagesToRemove->modelKeys())->delete();
                }

                $nextPosition = (int) $post->images()->max('position') + 1;
                $post->images()->createMany($this->storeGallery($gallery, $storedPaths, $nextPosition));
            });
        } catch (Throwable $exception) {
            Storage::disk('public')->delete($storedPaths);
            throw $exception;
        }

        Storage::disk('public')->delete(array_values(array_filter($oldPaths)));

        return redirect()->route('admin.posts.index')->with('status', 'La publicación se actualizó correctamente.');
    }

    public function destroy(Post $post): RedirectResponse
    {
        $paths = $post->images()->pluck('path')->all();
        $paths = [...$paths, ...$post->activityEvidences()->pluck('image_path')->all()];
        if ($post->image_path) {
            $paths[] = $post->image_path;
        }

        $post->delete();
        Storage::disk('public')->delete($paths);

        return redirect()->route('admin.posts.index')->with('status', 'La publicación y sus imágenes fueron eliminadas.');
    }

    private function validated(Request $request, ?Post $post): array
    {
        $removeImageRules = ['integer', 'distinct'];
        if ($post) {
            $removeImageRules[] = Rule::exists('post_images', 'id')->where('post_id', $post->id);
        } else {
            $removeImageRules[] = 'prohibited';
        }

        $data = $request->validate([
            'title' => ['required', 'string', 'max:180'],
            'activity_date' => ['required', 'date'],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'excerpt' => ['nullable', 'string', 'max:300'],
            'body' => ['required', 'string', 'max:50000'],
            'is_published' => ['required', Rule::in(['0', '1', '2'])],
            'published_at' => ['nullable', 'required_if:is_published,2', 'prohibited_unless:is_published,2', 'date', 'after:now'],
            'image' => [$post ? 'nullable' : 'required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'images' => ['nullable', 'array', 'max:8'],
            'images.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'remove_images' => ['nullable', 'array'],
            'remove_images.*' => $removeImageRules,
        ], [
            'title.required' => 'El título de la entrada es obligatorio.',
            'activity_date.required' => 'Indica la fecha de la actividad.',
            'category_id.required' => 'Selecciona una categoría.',
            'category_id.exists' => 'La categoría seleccionada ya no está disponible.',
            'is_published.in' => 'Selecciona si la publicación se publica, se programa o queda como borrador.',
            'published_at.required_if' => 'Indica la fecha y hora para programar la publicación.',
            'published_at.after' => 'La fecha programada debe ser futura.',
            'body.required' => 'Escribe el contenido de la entrada.',
            'image.required' => 'Agrega la imagen principal de la entrada.',
            'image.image' => 'La imagen principal debe ser un archivo de imagen.',
            'image.mimes' => 'La imagen principal debe ser JPG, PNG o WebP.',
            'image.max' => 'La imagen principal no puede pesar más de 5 MB.',
            'images.max' => 'Puedes agregar hasta 8 imágenes adicionales.',
            'images.*.image' => 'Cada archivo de la galería debe ser una imagen.',
            'images.*.mimes' => 'La galería solo admite archivos JPG, PNG o WebP.',
            'images.*.max' => 'Cada imagen de la galería debe pesar hasta 5 MB.',
        ]);

        if ($post) {
            $removeCount = $post->images()->whereIn('id', $request->input('remove_images', []))->count();
            $galleryCount = count($data['images'] ?? []);
            if ($post->images()->count() - $removeCount + $galleryCount > 8) {
                Validator::make([], ['images' => ['required']], ['images.required' => 'La galería permite un máximo de 8 imágenes; quita algunas o selecciona menos archivos.'])->validate();
            }

        }

        $category = Category::findOrFail($data['category_id']);
        $fields = Post::activityFieldSets()[$category->slug] ?? [];
        $detailRules = [];
        $detailMessages = [];
        foreach ($fields as $key => $field) {
            $detailRules["activity_details.$key"] = ['required', 'string', 'max:'.($field['max'] ?? 3000)];
            $detailMessages["activity_details.$key.required"] = 'Completa «'.$field['label'].'» para esta actividad.';
        }
        if ($detailRules !== []) {
            $details = $request->validate($detailRules, $detailMessages);
            $data['activity_details'] = [];
            foreach ($fields as $key => $field) {
                $data['activity_details'][$key] = trim($details['activity_details'][$key]);
            }
        } else {
            $data['activity_details'] = [];
        }

        return $data;
    }

    private function storeGallery(array $images, array &$storedPaths, int $position = 0): array
    {
        $records = [];
        foreach ($images as $image) {
            $path = $image->store('posts/gallery', 'public');
            if (! $path) {
                throw new RuntimeException('No se pudo guardar una imagen de la galería.');
            }
            $storedPaths[] = $path;
            $records[] = [
                'path' => $path,
                'caption' => Str::limit(pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME), 180, ''),
                'position' => $position++,
            ];
        }

        return $records;
    }

    private function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title) ?: 'publicacion';
        $slug = $base;
        $suffix = 2;

        while (Post::where('slug', $slug)->when($ignoreId, fn ($query) => $query->whereKeyNot($ignoreId))->exists()) {
            $slug = $base.'-'.$suffix++;
        }

        return $slug;
    }
}
