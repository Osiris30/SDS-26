<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAccessAndCategoriesTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_sign_in_and_sign_out(): void
    {
        $admin = User::factory()->create(['is_admin' => true, 'password' => 'secret-pass']);

        $this->post(route('login.store'), ['email' => $admin->email, 'password' => 'secret-pass'])
            ->assertRedirect(route('admin.categories.index'));
        $this->assertAuthenticatedAs($admin);

        $this->post(route('logout'))->assertRedirect(route('home'));
        $this->assertGuest();
    }

    public function test_regular_user_cannot_sign_in_to_admin_or_access_admin_routes(): void
    {
        $user = User::factory()->create(['is_admin' => false, 'password' => 'secret-pass']);

        $this->post(route('login.store'), ['email' => $user->email, 'password' => 'secret-pass'])
            ->assertSessionHasErrors('email');
        $this->assertGuest();

        $this->actingAs($user)->get(route('admin.categories.index'))->assertForbidden();
    }

    public function test_guest_is_redirected_away_from_admin_routes(): void
    {
        $this->get(route('admin.categories.index'))->assertRedirect(route('login'));
    }

    public function test_admin_can_create_update_and_delete_categories(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $this->actingAs($admin)->post(route('admin.categories.store'), [
            'name' => 'IoT y tecnología',
            'description' => 'Ideas conectadas.',
        ])->assertRedirect(route('admin.categories.index'));

        $category = Category::where('slug', 'iot-y-tecnologia')->firstOrFail();
        $this->assertDatabaseHas('categories', ['id' => $category->id, 'name' => 'IoT y tecnología']);

        $this->put(route('admin.categories.update', $category), [
            'name' => 'Tecnología verde',
            'description' => 'Innovación responsable.',
        ])->assertRedirect(route('admin.categories.index'));
        $this->assertDatabaseHas('categories', ['id' => $category->id, 'slug' => 'tecnologia-verde']);

        $this->delete(route('admin.categories.destroy', $category))->assertRedirect(route('admin.categories.index'));
        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }

    public function test_publication_list_can_be_filtered_by_category_and_hides_unpublished_posts(): void
    {
        $category = Category::create(['name' => 'Sostenibilidad', 'slug' => 'sostenibilidad']);
        Post::create(['category_id' => $category->id, 'title' => 'Campo conectado', 'slug' => 'campo-conectado', 'body' => 'Sensores para cultivos.', 'is_published' => true, 'published_at' => now()]);
        Post::create(['category_id' => $category->id, 'title' => 'Borrador privado', 'slug' => 'borrador-privado', 'body' => 'No debe mostrarse.', 'is_published' => false]);
        Post::create(['title' => 'Otra categoría', 'slug' => 'otra-categoria', 'body' => 'Otra historia.', 'is_published' => true, 'published_at' => now()]);

        $this->get(route('home', ['categoria' => 'sostenibilidad']))
            ->assertOk()
            ->assertSee('Campo conectado')
            ->assertDontSee('Borrador privado')
            ->assertDontSee('Otra categoría');
    }

    public function test_public_search_matches_published_titles_excerpts_or_bodies(): void
    {
        Post::create(['title' => 'Cultivos conectados', 'slug' => 'cultivos-conectados', 'excerpt' => 'Tecnología para el campo.', 'body' => 'Sensores IoT para agricultura.', 'is_published' => true, 'published_at' => now()]);
        Post::create(['title' => 'Borrador IoT', 'slug' => 'borrador-iot', 'body' => 'Cultivos.', 'is_published' => false]);

        $this->get(route('home', ['q' => 'AGRICULTURA']))
            ->assertOk()
            ->assertSee('Cultivos conectados')
            ->assertDontSee('Borrador IoT');
    }
}
