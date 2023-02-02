<?php

namespace Tests\Feature;

use App\Models\Projects;

use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\ProjectsController;
use App\Http\Requests\SaveProjectsRequest;
class ProjectsTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function projects_page_is_accessible()
    {
        $this->get('api/projects')
            ->assertOk();
    }

    /** @test */
    public function index_returns_all_projects()
    {
        // creamos y guardamos
        Projects::factory()->count(3)->create();
        $expectedProjects = Projects::all();

        // y guardamos la respuesta a comparar
        $response = $this->get('api/projects');

        // verificacion
        $response->assertSuccessful();
        $response->assertJsonCount($expectedProjects->count());
        $response->assertJson($expectedProjects->toArray());
    }

    /** @test */

    public function test_store_without_image()
    {
        $data = [
            'title' => 'Test Project 2',
            'link' => 'https://www.test2.com',
            'image_path' => "test_image_2.png"
        ];

        $this->post('api/projects', $data);

        $this->assertDatabaseHas('projects', [
            'title' => 'Test Project 2',
            'link' => 'https://www.test2.com',
            'image_path' => 'test_image_2.png',
        ]);
    }

    public function test_a_project_can_be_shown()
    {
        $project = Projects::factory()->create();
    
        $response = $this->get("api/projects/{$project->id}");
        $response->assertStatus(200);
        $response->assertJson($project->toArray());
    }

    public function test_a_project_can_be_updated()
    {
        $project = Projects::factory()->create();
        $data = [
            'title' => 'Updated title',
            'link' => 'http://www.example.com/updated-link',
            'image_path' => 'updated_image_path.png'
        ];

        $response = $this->put("api/projects/{$project->id}", $data);
        $response->assertStatus(200);

        $updatedProject = Projects::find($project->id);
        $this->assertEquals($data['title'], $updatedProject->title);
        $this->assertEquals($data['link'], $updatedProject->link);
        $this->assertEquals($data['image_path'], $updatedProject->image_path);
    }

    public function test_a_project_can_be_deleted()
    {
        $project = Projects::factory()->create();
        $response = $this->delete("api/projects/{$project->id}");
        $response->assertStatus(204);
        $this->assertDatabaseMissing('projects', $project->toArray());
    }

    public function test_delete_non_existing_project()
    {
        $response = $this->delete("api/projects/666");
        $response->assertStatus(404);
        $response->assertExactJson(['No se pudo realizar la peticion, el archivo ya no existe o nunca existio']);
    }
}