<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
    }

    /** @test */
    public function it_lists_all_categories()
    {
        $categories = Category::factory()->count(5)->create();

        $response = $this->getJson('/api/categories');

        $response->assertOk();
        $response->assertJsonCount(5, 'data');
    }

    /** @test */
    public function it_creates_a_category()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum');

        $categoryData = [
            'title' => 'New Category',
            'description' => 'New Category Description',
        ];

        $response = $this->postJson('/api/categories', $categoryData);

        $response->assertCreated();
        $this->assertDatabaseHas('categories', ['title' => 'New Category']);
    }

    /** @test */
    public function it_shows_a_category()
    {
        $category = Category::factory()->create();

        $response = $this->getJson("/api/categories/{$category->id}");

        $response->assertOk();
        $response->assertJson([
            'data' => [
                'id' => $category->id,
                'title' => $category->title,
            ]
        ]);
    }

    /** @test */
    public function it_updates_a_category()
    {
        // Crear un usuario de prueba y autenticarlo.
        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum');

        // Crear una categoría de prueba sin especificar 'user_id', ya que no es relevante.
        $category = Category::factory()->create();

        // Datos que se desean actualizar en la categoría.
        $updatedData = [
            'title' => 'Updated Category Title',
            'description' => 'Updated Category Description',
        ];

        // Realizar la solicitud PUT para actualizar la categoría y almacenar la respuesta.
        $response = $this->putJson("/api/categories/{$category->id}", $updatedData);

        // Asegurarse de que la respuesta sea OK (código de estado HTTP 200).
        $response->assertOk();

        // Verificar que los datos actualizados existan en la base de datos.
        $this->assertDatabaseHas('categories', [
            'id' => $category->id, // Asegurarse de que se actualiza la categoría correcta.
            'title' => 'Updated Category Title', // Verificar el nuevo título.
            'description' => 'Updated Category Description', // Verificar la nueva descripción.
        ]);
    }

    /** @test */
    public function it_deletes_a_category()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum');
        
        $category = Category::factory()->create();

        $response = $this->deleteJson("/api/categories/{$category->id}");

        $response->assertNoContent();
        $this->assertSoftDeleted('categories', ['id' => $category->id]);
    }
}
