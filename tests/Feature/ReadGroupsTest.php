<?php

namespace Tests\Feature;

use App\Group;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReadGroupsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_view_all_groups()
    {
        $groups = factory(Group::class, 2)->create();

        $this->json('GET', '/api/groups')
            ->assertStatus(200)
            ->assertExactJson($groups->toArray())
            ->assertJsonStructure([
                '*' => ['id', 'slug', 'name', 'created_at', 'updated_at'],
            ]);

        $this->assertDatabaseHas('groups', $groups->first()->toArray());
        $this->assertDatabaseHas('groups', $groups->last()->toArray());
    }
}
