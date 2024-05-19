<?php

namespace App\Repositories\Transaction;

use App\Models\Transaction\Location;
use App\Traits\MainTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class LocationRepository
{
    use MainTrait;

    //Show Data SenseCAP
    public function showDataSenseCap($request)
    {
        try {
            //request data to sensecap
            $response = Http::withBasicAuth(config('custom.API_KEY_SENSECAP'), config('custom.API_PASS_SENSECAP'))
                ->get(config('custom.API_URL_SENSECAP') . "/view_latest_telemetry_data", [
                    'device_eui' => $request->device_eui,
                ]);
            //get data from sensecap
            if ($response->successful()) {
                $jsonData = $response->json();

                if (isset($jsonData["data"])) {

                    if ($jsonData["data"] > 0) {

                        if (isset($jsonData["data"][0]["points"])) {
                            $arrLatLongValue = [];
                            // check data longitude and latitude from response sensecap
                            foreach ($jsonData["data"][0]["points"] as $item) {
                                if ($item["measurement_id"] == "4197") {
                                    array_push($arrLatLongValue, array("longitude" => $item));
                                } else if ($item["measurement_id"] == "4198") {
                                    array_push($arrLatLongValue, array("latitude" => $item));
                                }
                            }
                            if ($arrLatLongValue > 1) {
                                $response = $arrLatLongValue;
                            } else {
                                return $this->responseArray(500,  'Failed to process data. Error: Data not latitude or longitude', $arrLatLongValue);
                            }
                        } else {
                            return $this->responseArray(500,  'Failed to process data. Error: Data points not found', null);
                        }
                    } else {
                        return $this->responseArray(500,  'Failed to process data. Error: Data array not found', null);
                    }
                } else {
                    return $this->responseArray(500,  'Failed to process data. Error: Data not exists', null);
                }
            } else {
                $statusCode = $response->status();
                return $this->responseArray($statusCode,  'Failed to process data. Error: ' . $response->message(), null);
            }
        } catch (\Exception $e) {
            return $this->responseArray(500,  'Failed to process data. Error: ' . $e, null);
        }
        return $this->responseArray(200, 'Success to Get data device.', $response);
    }

    //Insert from API SenseCap
    public function insertDataSenseCap($request)
    {
        DB::beginTransaction();
        try {
            $response = Http::withBasicAuth(config('custom.API_KEY_SENSECAP'), config('custom.API_PASS_SENSECAP'))
                ->get(config('custom.API_URL_SENSECAP') . "/view_latest_telemetry_data", [
                    'device_eui' => $request->device_eui,
                ]);

            if ($response->successful()) {
                $jsonData = $response->json();

                if (isset($jsonData["data"])) {

                    if ($jsonData["data"] > 0) {

                        if (isset($jsonData["data"][0]["points"])) {
                            $arrLatLongValue = [];
                            foreach ($jsonData["data"][0]["points"] as $item) {
                                if ($item["measurement_id"] == "4197") {
                                    array_push($arrLatLongValue, array("longitude" => $item));
                                } else if ($item["measurement_id"] == "4198") {
                                    array_push($arrLatLongValue, array("latitude" => $item));
                                }
                            }
                            if ($arrLatLongValue > 1) {
                                $location = Location::where('node_eui', $request->device_eui)->orderBy('created_tm', 'desc')->first();

                                if ($location->created_tm == Carbon::parse($arrLatLongValue[0]["longitude"]["time"])) {
                                    return $this->responseArray(200, 'Data has been inserted', false);
                                }
                                Location::create([
                                    "longitude"     => $arrLatLongValue[0]["longitude"]["measurement_value"],
                                    "latitude"      => $arrLatLongValue[1]["latitude"]["measurement_value"],
                                    "node_eui"      => $request->device_eui,
                                    "created_tm"    => Carbon::parse($arrLatLongValue[0]["longitude"]["time"])
                                ]);
                            } else {
                                return $this->responseArray(500,  'Failed to process data. Error: Data not latitude or longitude', $arrLatLongValue);
                            }
                        } else {
                            return $this->responseArray(500,  'Failed to process data. Error: Data points not found', null);
                        }
                    } else {
                        return $this->responseArray(500,  'Failed to process data. Error: Data array not found', null);
                    }
                } else {
                    return $this->responseArray(500,  'Failed to process data. Error: Data not exists', null);
                }
            } else {
                $statusCode = $response->status();
                return $this->responseArray($statusCode,  'Failed to process data. Error: ' . $response->message(), null);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->responseArray(500,  'Failed to process data. Error: ' . $e, null);
        }
        DB::commit();
        return $this->responseArray(200, 'Success to Get data device.', true);
    }

    /** Fungsi untuk menampilkan data dari model atau database berdasarkan request yang telah diberikan oleh service*/
    public function showDataNodeEui($request): array
    {
        try {
            $location = Location::with('device')
                ->where('node_eui', $request->device_eui)->get();

            if (!$location) {
                return $this->responseArray(200, 'Data not available.', []);
            }
        } catch (\Exception $e) {
            return $this->responseArray(500,  'Failed to process data. Error: ' . $e->getMessage(), null);
        }
        return $this->responseArray(200, 'Success to Get data device.', $location);
    }
}
