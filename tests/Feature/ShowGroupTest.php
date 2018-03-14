<?php

namespace Tests\Feature;

use App\Group;
use App\Device;
use Tests\TestCase;
use App\Queries\GroupDetailsQuery;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShowGroupTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_view_a_group_details()
    {
        $group = factory(Group::class)->create();
        $devices = factory(Device::class, 6)->create([
            'group_id' => $group->id,
        ]);
        $details = (new GroupDetailsQuery)($group)->toArray();

        $this->json('GET', '/api/groups/'.$group->slug)
            ->assertStatus(200)
            ->assertJson($details)
            ->assertJsonStructure([
                'id',
                'slug',
                'name',
                'devices_count',
                'devices',
                'created_at',
                'updated_at',
            ]);

        $this->assertDatabaseHas('groups', $group->toArray());
    }
}
