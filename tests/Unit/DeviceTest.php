<?php

namespace Tests\Unit;

use App\Group;
use App\Device;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeviceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_device_has_a_group()
    {
        $device = factory(Device::class)->create();
        $group = Group::first();

        $this->assertInstanceOf(Group::class, $device->group);
        $this->assertEquals($device->group->id, $group->id);
    }
}
