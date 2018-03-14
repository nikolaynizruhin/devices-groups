<?php

namespace Tests\Unit;

use App\Group;
use App\Device;
use Tests\TestCase;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GroupTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_group_has_many_devices()
    {
        $group = factory(Group::class)->create();
        $device = factory(Device::class)->create(['group_id' => $group->id]);

        $this->assertTrue($group->devices->contains($device));
        $this->assertInstanceOf(Collection::class, $group->devices);
    }
}
