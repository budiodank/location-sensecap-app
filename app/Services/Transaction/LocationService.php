<?php

namespace App\Services\Transaction;

use App\Repositories\Transaction\LocationRepository;
use App\Traits\MainTrait;
use Illuminate\Http\Response;

class LocationService
{
    use MainTrait;

    public function __construct(
        protected LocationRepository $locationRepository,
    ) {
    }

    /**
     * TODO : Fungsi untuk mendapatkan nilai dari sensecap.
     */
    public function showDataSenseCap($request)
    {
        list($code, $response) = $this->locationRepository->showDataSenseCap($request);
        if ($code == Response::HTTP_OK) {
            return $this->sendResponse($response['data'], $response['message']);
        }
        return $this->sendError($response['message'], $code);
    }


    /**
     * TODO : Fungsi untuk mendapatkan nilai dari sensecap.
     */
    public function insertDataSenseCap($request)
    {
        list($code, $response) = $this->locationRepository->insertDataSenseCap($request);
        if ($code == Response::HTTP_OK) {
            return $this->sendResponse($response['data'], $response['message']);
        }
        return $this->sendError($response['message'], $code);
    }

    /**
     * TODO : Fungsi untuk menampilkan data node eui.
     */
    public function showDataNodeEui($request)
    {
        list($code, $response) = $this->locationRepository->showDataNodeEui($request);
        if ($code == Response::HTTP_OK) {
            return $this->sendResponse($response['data'], $response['message']);
        }
        return $this->sendError($response['message'], $code);
    }
}
