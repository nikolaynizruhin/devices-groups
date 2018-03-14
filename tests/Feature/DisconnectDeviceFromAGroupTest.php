<?php

namespace Tests\Feature;

use App\Device;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DisconnectDeviceFromAGroupTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_disconnect_devices_from_a_group()
    {
        $device = factory(Device::class)->create();

        $response = $this->json('DELETE', '/api/devices/'.$device->slug.'/disconnect');

        $device = $device->fresh()->toArray();

        $response->assertStatus(200)
            ->assertJson($device)
            ->assertJsonStructure([
                'id',
                'slug',
                'name',
                'ip_address',
                'mac_address',
                'group_id',
                'connected_at',
                'created_at',
                'updated_at',
            ]);
    }
}
