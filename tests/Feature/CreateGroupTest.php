<?php

namespace Tests\Feature;

use App\Group;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateGroupTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_create_a_group()
    {
        $group = factory(Group::class)->make()->toArray();

        $this->json('POST', '/api/groups', $group)
            ->assertStatus(200)
            ->assertJson($group)
            ->assertJsonStructure([
                'id', 'slug', 'name', 'created_at', 'updated_at',
            ]);

        $this->assertDatabaseHas('groups', $group);
    }

    /** @test */
    public function a_slug_generates_from_the_name()
    {
        $group = factory(Group::class)->make()->setHidden(['slug'])->toArray();

        $response = $this->json('POST', '/api/groups', $group);

        $group['slug'] = str_slug($group['name']);

        $response->assertStatus(200)
            ->assertJson($group)
            ->assertJsonStructure([
                'id', 'slug', 'name', 'created_at', 'updated_at',
            ]);

        $this->assertDatabaseHas('groups', $group);
    }

    /** @test */
    public function a_unique_slug_generates_if_the_slug_already_exists()
    {
        $existingGroup = factory(Group::class)
            ->create(['slug' => 'existing-name']);

        $group = factory(Group::class)
            ->make(['name' => 'Existing name'])
            ->setHidden(['slug'])
            ->toArray();

        $response = $this->json('POST', '/api/groups', $group);

        $group['slug'] = str_slug($group['name']).'-1';

        $response->assertStatus(200)
            ->assertJson($group)
            ->assertJsonStructure([
                'id', 'slug', 'name', 'created_at', 'updated_at',
            ]);

        $this->assertDatabaseHas('groups', $group);
    }

    /** @test */
    public function a_validation_errors_occurs_when_data_invalid()
    {
        $this->json('POST', '/api/groups')
            ->assertStatus(422)
            ->assertJsonValidationErrors(['name']);
    }

    /** @test */
    public function a_group_slug_should_be_unique()
    {
        $group = factory(Group::class)->create()->toArray();

        $this->json('POST', '/api/groups', $group)
            ->assertStatus(422)
            ->assertJsonValidationErrors(['slug']);
    }
}
