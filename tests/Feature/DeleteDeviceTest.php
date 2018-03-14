<?php

namespace Tests\Feature;

use App\Device;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteDeviceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_delete_a_device()
    {
        $device = factory(Device::class)->create();

        $response = $this->json('DELETE', '/api/devices/'.$device->slug)
            ->assertStatus(204);

        $this->assertDatabaseMissing('devices', $device->toArray());
    }
}
