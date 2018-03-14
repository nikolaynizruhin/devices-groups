<?php

namespace Tests\Feature;

use App\Device;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReadDevicesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_view_all_devices()
    {
        $devices = factory(Device::class, 2)->create();

        $this->json('GET', '/api/devices')
            ->assertStatus(200)
            ->assertJson($devices->toArray())
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'slug',
                    'name',
                    'ip_address',
                    'mac_address',
                    'group_id',
                    'connected_at',
                    'created_at',
                    'updated_at',
                ],
            ]);

        $this->assertDatabaseHas('devices', $devices->first()->toArray());
        $this->assertDatabaseHas('devices', $devices->last()->toArray());
    }
}
