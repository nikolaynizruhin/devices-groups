<?php

namespace Tests\Feature;

use App\Group;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateGroupTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_update_a_group()
    {
        $group = factory(Group::class)->create();

        $response = $this->json('PUT', '/api/groups/'.$group->slug, [
            'name' => 'Updated name',
        ]);

        $group = $group->fresh();

        $response->assertStatus(200)
            ->assertExactJson($group->toArray())
            ->assertJsonStructure([
                'id', 'slug', 'name', 'created_at', 'updated_at',
            ]);

        $this->assertDatabaseHas('groups', $group->toArray());
    }

    /** @test */
    public function a_validation_errors_occurs_when_data_invalid()
    {
        $group = factory(Group::class)->create();

        $this->json('PUT', '/api/groups/'.$group->slug, [
                'slug' => str_random(260),
                'name' => str_random(260),
            ])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['slug', 'name']);
    }

    /** @test */
    public function a_group_slug_should_be_unique()
    {
        [$phones, $laptops] = factory(Group::class, 2)->create();

        $this->json('PUT', '/api/groups/'.$phones->slug, $laptops->toArray())
            ->assertStatus(422)
            ->assertJsonValidationErrors(['slug']);
    }

    /** @test */
    public function a_group_slug_should_be_unique_except_own()
    {
        $group = factory(Group::class)->create();

        $this->json('PUT', '/api/groups/'.$group->slug, $group->toArray())
            ->assertStatus(200)
            ->assertJson($group->toArray());
    }
}
