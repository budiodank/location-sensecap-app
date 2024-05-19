<?php

namespace App\Services\Master;

use App\Repositories\Master\DeviceRepository;
use App\Traits\MainTrait;
use Illuminate\Http\Response;

class DeviceService
{
    use MainTrait;

    public function __construct(
        protected DeviceRepository $deviceRepository,
    ) {
    }

    /**
     * TODO : Fungsi untuk menambahkan data M Device.
     */
    public function insertData($request)
    {
        list($code, $response) = $this->deviceRepository->insertData($request);
        if ($code == Response::HTTP_OK) {
            return $this->sendResponse($response['data'], $response['message']);
        }
        return $this->sendError($response['message'], $code);
    }

    /**
     * TODO : Fungsi untuk menampilkan data M Device.
     */
    public function showData($request)
    {
        list($code, $response) = $this->deviceRepository->showData($request);
        if ($code == Response::HTTP_OK) {
            return $this->sendResponse($response['data'], $response['message']);
        }
        return $this->sendError($response['message'], $code);
    }

    /**
     * TODO : Fungsi untuk menampilkan data by Id M Device.
     */
    public function showDataId($device_uuid)
    {
        list($code, $response) = $this->deviceRepository->showDataId($device_uuid);
        if ($code == Response::HTTP_OK) {
            return $this->sendResponse($response['data'], $response['message']);
        }
        return $this->sendError($response['message'], $code);
    }

    /**
     * TODO : Fungsi untuk update data M Device.
     */
    public function updateData($request, $device_uuid)
    {
        list($code, $response) = $this->deviceRepository->updateData($request, $device_uuid);
        if ($code == Response::HTTP_OK) {
            return $this->sendResponse($response['data'], $response['message']);
        }
        return $this->sendError($response['message'], $code);
    }

    /**
     * TODO : Fungsi untuk menghapus data M Device
     */
    public function deleteData($device_uuid)
    {
        list($code, $response) = $this->deviceRepository->deleteData($device_uuid);
        if ($code == Response::HTTP_OK) {
            return $this->sendResponse($response['data'], $response['message']);
        }
        return $this->sendError($response['message'], $code);
    }
}
