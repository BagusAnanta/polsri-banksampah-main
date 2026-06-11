<?php

namespace App\Http\Controllers;
use App\Models\sensorSelenoid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MonitoringController extends Controller
{
    public function index()
    {
        return view('monitoring.viewSensor');
    }

    public function selenoidControl()
    {
        $data['selenoid_sensor'] = sensorSelenoid::get();
        return view('monitoring.selenoidSwitch', $data);
    }

    
}
