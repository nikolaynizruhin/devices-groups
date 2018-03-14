<?php

namespace Tests\Feature;

use App\Device;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateDeviceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_update_a_device()
    {
        $device = factory(Device::class)->create();

        $response = $this->json('PUT', '/api/devices/'.$device->slug, [
            'name' => 'Updated name',
        ]);

        $device = $device->fresh();

        $response->assertStatus(200)
            ->assertExactJson($device->toArray())
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

        $this->assertDatabaseHas('devices', $device->toArray());
    }

    /** @test */
    public function a_validation_errors_occurs_when_data_invalid()
    {
        $device = factory(Device::class)->create();

        $this->json('PUT', '/api/devices/'.$device->slug, [
                'slug' => str_random(260),
                'name' => str_random(260),
                'ip_address' => str_random(10),
                'mac_address' => str_random(10),
            ])
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'slug', 'name', 'ip_address', 'mac_address',
            ]);
    }

    /** @test */
    public function a_device_slug_should_be_unique()
    {
        [$phone, $laptop] = factory(Device::class, 2)->create();

        $this->json('PUT', '/api/devices/'.$phone->slug, $laptop->toArray())
            ->assertStatus(422)
            ->assertJsonValidationErrors(['slug']);
    }

    /** @test */
    public function a_device_slug_should_be_unique_except_own()
    {
        $device = factory(Device::class)->create();

        $this->json('PUT', '/api/devices/'.$device->slug, $device->toArray())
            ->assertStatus(200)
            ->assertJson($device->toArray());
    }
}
