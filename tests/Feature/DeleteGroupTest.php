<?php

namespace Tests\Feature;

use App\Group;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteGroupTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_delete_a_group()
    {
        $group = factory(Group::class)->create();

        $response = $this->json('DELETE', '/api/groups/'.$group->slug)
            ->assertStatus(204);

        $this->assertDatabaseMissing('groups', $group->toArray());
    }
}
