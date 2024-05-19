<?php

namespace App\Traits;

// use App\Models\Log\LogActivity;
// use App\Models\Notification;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
// use PhpAmqpLib\Connection\AMQPStreamConnection;

trait MainTrait
{
    public function sendResponse($result, $message)
    {
        $response = [
            'code' => 200,
            'message' => $message,
            'status' => true,
            'result' => $result
        ];
        return response()->json($response, 200);
    }

    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */

    public function sendError($errorMessages, $code = 404)
    {
        $response = [
            'code' => $code,
            'message' => gettype($errorMessages) == 'array' ? implode('\n', $errorMessages) : $errorMessages,
            'status' => false,
            'result' => null
        ];
        throw new HttpResponseException(response()->json($response, $code));
    }

    public function sendResponseData(
        int $statusCode = 200,
        mixed $message = 'Success',
        bool $isSuccess = true,
        mixed $data = null,
    ): JsonResponse {
        return response()->json([
            'code'          => $statusCode,
            'message'       => $message,
            'status'        => $isSuccess,
            'result'        => $data,
        ], $statusCode);
    }

    /** fungsi untuk mendapatkan nama user yang sedang login
     * disini menggunkan token yang terdapat pada header ( Jika ada )
     * dan response menggunakan array
     */
    public function decodeJwtToken()
    {
        $request    = app()->make(Request::class);
        $jwtToken   = $request->bearerToken();

        $parts = explode('.', $jwtToken);

        if (count($parts) !== 3) {
            return  [400, 'Invalid JWT token '];
        }

        $header = base64_decode($parts[0]);
        $payload = base64_decode($parts[1]);

        $headerJson = json_decode($header, true);
        $payloadJson = json_decode($payload, true);

        if (empty($headerJson) || empty($payloadJson)) {
            return  [400, 'Invalid JWT token '];
        }
        return  [200, $payloadJson['name']];
    }

    public function responseArray($code, $message, $data): array
    {
        return [$code, [
            'message'   => $message,
            'data'      => $data
        ]];
    }

    public function timestampFormat($data)
    {
        return date('Y-m-d H:i:s', strtotime($data . '+7 hours'));
    }

    // public function recordLog($activity){
    //     LogActivity::create($activity);
    //     return null;
    // }

    // public function pushNotification($notification){
    //     $result = Notification::create($notification);

    //     return [
    //         'id'                => $result->id,
    //         'title'             => $result->title,
    //         'description'       => $result->description,
    //         'read_status'       => $result->read_status,
    //         'user_id'           => $result->user_id,
    //         'user_name'         => $result->user->name,
    //         'picture'           => Storage::disk('public')->url($result->user->picture),

    //         /**Default timestamp */
    //         'created_at'        => ($result->created_at == null) ? null : $result->created_at,
    //         'updated_at'        => ($result->updated_at == null) ? null : $result->updated_at,
    //     ];
    // }

    // public function amqpCheckConnection(){
    //     try {
    //         $connection = new AMQPStreamConnection(config('amqp.properties.production.host'), config('amqp.properties.production.port'), config('amqp.properties.production.username'), config('amqp.properties.production.password'));
    //         $channel = $connection->channel();

    //         return true;
    //     } catch (Exception $e) {
    //         return false;
    //     }
    // }
}
