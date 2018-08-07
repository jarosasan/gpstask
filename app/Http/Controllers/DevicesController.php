<?php

namespace App\Http\Controllers;

use App\Device;
use App\Http\Requests\StoreDeviceRequest;
use Illuminate\Http\Request;
use App\Facades\AddressService;
use App\Services\DistanceService;
use Mail;
use App\Mail\DeviceInWork;

class DevicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDeviceRequest $request)
    {
        $latlon = explode(',', $request['latlon']);
        $latitude = floatval($latlon[0]);
        $longitude = floatval($latlon[1]);
        $storedDevice = Device::create($request->except(['_token', 'latlon']) + ['latitude' => $latitude, 'longitude' => $longitude]);
        if ($request->place == 'work') {
            $address = AddressService::getAddress($storedDevice->latitude, $storedDevice->longitude);
            $email = 'gpstest@gpstest.com';
            Mail::to($email)->send(new DeviceInWork($storedDevice->name, $address));
        }
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Device  $device
     * @return \Illuminate\Http\Response
     */
    public function show(Device $device, DistanceService $distanceService)
    {
        $distance = $distanceService->getDistance();
        $devices = Device::orderBy('id', 'DESC')->get();
        $address = AddressService::getAddress($devices[0]->latitude, $devices[0]->longitude);

        return view('admin', ['devices' => $devices, 'address'=>$address, 'range'=>$distance]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Device  $device
     * @return \Illuminate\Http\Response
     */
    public function edit(Device $device)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Device  $device
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Device $device)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Device  $device
     * @return \Illuminate\Http\Response
     */
    public function destroy(Device $device)
    {
        //
    }
}
