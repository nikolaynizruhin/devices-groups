<?php

namespace Tests\Feature;

use App\Group;
use App\Device;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ConnectDeviceToAGroupTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_connect_devices_to_a_group()
    {
        $group = factory(Group::class)->create();
        $device = factory(Device::class)->create(['group_id' => null]);

        $response = $this->json('POST', '/api/devices/'.$device->slug.'/connect', [
                'group_id' => $group->id,
            ]);

        $device = $device->fresh()->load('group');

        $response->assertStatus(200)
            ->assertJson($device->toArray())
            ->assertJsonStructure([
                'id',
                'slug',
                'name',
                'ip_address',
                'mac_address',
                'group_id',
                'group',
                'connected_at',
                'created_at',
                'updated_at',
            ]);
    }

    /** @test */
    public function a_validation_error_occurs_when_group_id_does_not_exist()
    {
        $device = factory(Device::class)->create(['group_id' => null]);

        $response = $this->json('POST', '/api/devices/'.$device->slug.'/connect', [
                'group_id' => 1,
            ])->assertStatus(422)
            ->assertJsonValidationErrors(['group_id']);
    }
}
