<?php

namespace Tests\Feature;

use App\Device;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateDeviceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_create_a_device()
    {
        $device = factory(Device::class)->make()
            ->setHidden(['group_id', 'connected_at'])
            ->toArray();

        $this->json('POST', '/api/devices', $device)
            ->assertStatus(200)
            ->assertJson($device)
            ->assertJsonStructure([
                'id',
                'slug',
                'name',
                'ip_address',
                'mac_address',
                'created_at',
                'updated_at',
            ]);

        $this->assertDatabaseHas('devices', $device);
    }

    /** @test */
    public function a_slug_generates_from_the_name()
    {
        $device = factory(Device::class)->make()
            ->setHidden(['slug', 'group_id', 'connected_at'])
            ->toArray();

        $response = $this->json('POST', '/api/devices', $device);

        $device['slug'] = str_slug($device['name']);

        $response->assertStatus(200)
            ->assertJson($device)
            ->assertJsonStructure([
                'id',
                'slug',
                'name',
                'ip_address',
                'mac_address',
                'created_at',
                'updated_at',
            ]);

        $this->assertDatabaseHas('devices', $device);
    }

    /** @test */
    public function a_unique_slug_generates_if_the_slug_already_exists()
    {
        $existingDevice = factory(Device::class)
            ->create(['slug' => 'existing-name']);

        $device = factory(Device::class)
            ->make(['name' => 'Existing name'])
            ->setHidden(['slug', 'group_id', 'connected_at'])
            ->toArray();

        $response = $this->json('POST', '/api/devices', $device);

        $device['slug'] = str_slug($device['name']).'-1';

        $response->assertStatus(200)
            ->assertJson($device)
            ->assertJsonStructure([
                'id',
                'slug',
                'name',
                'ip_address',
                'mac_address',
                'created_at',
                'updated_at',
            ]);

        $this->assertDatabaseHas('devices', $device);
    }

    /** @test */
    public function a_validation_errors_occurs_when_data_invalid()
    {
        $this->json('POST', '/api/devices')
            ->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'ip_address', 'mac_address']);
    }

    /** @test */
    public function a_device_slug_should_be_unique()
    {
        $device = factory(Device::class)->create()->toArray();

        $this->json('POST', '/api/devices', $device)
            ->assertStatus(422)
            ->assertJsonValidationErrors(['slug']);
    }
}
