<?php

namespace App\Http\Controllers\Api\Transaction;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Transaction\LocationService;

class LocationController extends Controller
{
    public function __construct(
        protected LocationService $locationService,
    ) {
    }

    /**
     * TODO : Fungsi untuk mengambil data dari sensecap.
     */
    public function showDataSenseCap(Request $request)
    {
        return $this->locationService->showDataSenseCap($request);
    }

    /**
     * TODO : Fungsi untuk mengambil data dari sensecap.
     */
    public function insertDataSenseCap(Request $request)
    {
        return $this->locationService->insertDataSenseCap($request);
    }

    /**
     * TODO : Fungsi untuk menampilkan data node eui.
     */
    public function showDataNodeEui(Request $request)
    {
        return $this->locationService->showDataNodeEui($request);
    }
}
