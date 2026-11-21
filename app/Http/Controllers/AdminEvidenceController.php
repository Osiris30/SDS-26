<?php

namespace App\Http\Controllers;

use App\Models\ActivityEvidence;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use RuntimeException;
use Throwable;

class AdminEvidenceController extends Controller
{
    public function index(Request $request): View
    {
        $profileSlug = $this->profileSlug($request);
        $user = $request->user();

        return view('admin.evidence.index', [
            'profile' => config('evidence-profiles.'.$profileSlug),
            'profileSlug' => $profileSlug,
            'posts' => Post::query()
                ->where('is_published', true)
                ->where(fn ($query) => $query->whereNull('published_at')->orWhere('published_at', '<=', now()))
                ->orderByDesc('activity_date')
                ->get(),
            'evidences' => ActivityEvidence::with('post.category')
                ->where('user_id', $user->id)
                ->latest()
                ->paginate(12),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $profileSlug = $this->profileSlug($request);
        $data = $request->validate([
            'post_id' => ['required', 'integer', 'exists:posts,id'],
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'caption' => ['nullable', 'string', 'max:180'],
        ], [
            'post_id.required' => 'Selecciona la actividad a la que pertenece la evidencia.',
            'image.required' => 'Selecciona una fotografía.',
            'image.image' => 'El archivo debe ser una imagen.',
            'image.mimes' => 'La evidencia debe ser JPG, PNG o WebP.',
            'image.max' => 'La fotografía no puede pesar más de 5 MB.',
        ]);

        $post = Post::query()
            ->whereKey($data['post_id'])
            ->where('is_published', true)
            ->where(fn ($query) => $query->whereNull('published_at')->orWhere('published_at', '<=', now()))
            ->firstOrFail();

        $path = $request->file('image')->store('evidence/'.$profileSlug, 'public');
        if (! $path) {
            throw new RuntimeException('No se pudo guardar la fotografía de evidencia.');
        }

        try {
            $post->activityEvidences()->create([
                'user_id' => $request->user()->id,
                'image_path' => $path,
                'caption' => $data['caption'] ?: null,
            ]);
        } catch (Throwable $exception) {
            Storage::disk('public')->delete($path);
            throw $exception;
        }

        return redirect()->route('admin.evidence.index')->with('status', 'La evidencia se agregó a la actividad.');
    }

    public function destroy(Request $request, ActivityEvidence $evidence): RedirectResponse
    {
        abort_unless($evidence->user_id === $request->user()->id, 404);

        $path = $evidence->image_path;
        $evidence->delete();
        Storage::disk('public')->delete($path);

        return redirect()->route('admin.evidence.index')->with('status', 'La evidencia se eliminó correctamente.');
    }

    private function profileSlug(Request $request): string
    {
        foreach (config('evidence-profiles') as $slug => $profile) {
            if (in_array($request->user()->email, $profile['emails'], true)) {
                return $slug;
            }
        }

        abort(403, 'Esta cuenta no tiene un perfil de evidencias asignado.');
    }
}
