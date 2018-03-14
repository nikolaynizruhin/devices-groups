<?php

namespace App\Http\Controllers;

use App\Device;
use Illuminate\Http\Request;

class DeviceGroupController extends Controller
{
    /**
     * Connect the device to a group.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Device
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Device $device)
    {
        $request->validate([
            'group_id' => 'required|exists:groups,id',
        ]);

        $device->update([
            'group_id' => $request->group_id,
            'connected_at' => now(),
        ]);

        return $device->load('group');
    }

    /**
     * Disconnect the device from a group.
     *
     * @param  \App\Device  $device
     * @return \Illuminate\Http\Response
     */
    public function destroy(Device $device)
    {
        $device->update([
            'group_id' => null,
            'connected_at' => null,
        ]);

        return $device;
    }
}
