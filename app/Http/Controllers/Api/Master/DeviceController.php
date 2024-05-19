<?php

namespace App\Http\Controllers\Api\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Master\DeviceRequest;
use App\Services\Master\DeviceService;

class DeviceController extends Controller
{
    public function __construct(
        protected DeviceService $deviceService,
    ) {
    }

    /**
     * TODO : Fungsi untuk menambahkan data Device.
     */
    public function insertData(DeviceRequest $request)
    {
        return $this->deviceService->insertData($request);
    }

    /**
     * TODO : Fungsi untuk menampilkan data Device.
     */
    public function showData(Request $request)
    {
        return $this->deviceService->showData($request);
    }

    /**
     * TODO : Fungsi untuk menampilkan data by Id Device.
     */
    public function showDataId($device_uuid)
    {
        return $this->deviceService->showDataId($device_uuid);
    }

    /**
     * TODO : Fungsi untuk mengubah data Device.
     */
    public function updateData(DeviceRequest $request, $device_uuid)
    {
        return $this->deviceService->updateData($request, $device_uuid);
    }

    /**
     * TODO : Fungsi untuk menghapus data Device.
     */
    public function deleteData($device_uuid)
    {
        return $this->deviceService->deleteData($device_uuid);
    }
}
