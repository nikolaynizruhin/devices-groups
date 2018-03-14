<?php

namespace Tests\Feature;

use App\Device;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShowDeviceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_view_a_device()
    {
        $device = factory(Device::class)->create()->load('group');

        $this->json('GET', '/api/devices/'.$device->slug)
            ->assertStatus(200)
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
}
