<?php

namespace App\Http\Controllers\Api\Transaction;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Bschmitt\Amqp\Facades\Amqp;
use App\Traits\MainTrait;
use Illuminate\Support\Facades\Http;
use Exception;

class LocationRabbitMQController extends Controller
{
    use MainTrait;

    public function getDataSenseCAP(Request $request)
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
        } catch (Exception $e) {
            return $this->responseArray(500,  'Failed to process data. Error: ' . $e, null);
        }
        // check amqp connection
        $amqpConnected = $this->amqpCheckConnection();

        if ($amqpConnected) {
            Amqp::publish('location.notifications.4197', json_encode($response), [
                'exchange_durable' => 'true',
                'exchange' => 'amq.topic',
                'exchange_type' => 'topic',
                'content_type' => 'application/json',
            ]);
        }
        return $this->responseArray(200, 'Success to Get data device.', $response);
    }
}
