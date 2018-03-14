<?php

namespace App\Http\Controllers;

use App\Device;
use App\Http\Requests\StoreDevice;
use App\Http\Requests\UpdateDevice;

class DeviceController extends Controller
{
    /**
     * Display a listing of the devices.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Device::all();
    }

    /**
     * Store a newly created device in storage.
     *
     * @param  \App\Http\Requests\StoreDevice  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDevice $request)
    {
        return Device::create($request->only([
            'slug',
            'name',
            'ip_address',
            'mac_address',
        ]));
    }

    /**
     * Display the specified device.
     *
     * @param  \App\Device  $device
     * @return \Illuminate\Http\Response
     */
    public function show(Device $device)
    {
        return $device->load('group');
    }

    /**
     * Update the specified device in storage.
     *
     * @param  \App\Http\Requests\UpdateDevice  $request
     * @param  \App\Device  $device
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDevice $request, Device $device)
    {
        $device->update($request->only([
            'slug',
            'name',
            'ip_address',
            'mac_address',
        ]));

        return $device;
    }

    /**
     * Remove the specified device from storage.
     *
     * @param  \App\Device  $device
     * @return \Illuminate\Http\Response
     */
    public function destroy(Device $device)
    {
        $device->delete();

        return response('', 204);
    }
}
