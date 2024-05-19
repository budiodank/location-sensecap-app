<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DynamicRouterHandler extends Controller
{
    public function getAPI($url, Request $request)
    {
        if ($url != 'auth/login') {
            $session = session()->get('auth_session');

            $response = HTTP::withOptions([
                'timeout' => 0
            ])->withHeaders([
                'Authorization' => 'Bearer ' . $session['token']
            ])->get(config('custom.TARGET_API') . $url, $request->all());
        } else {
            $response = HTTP::withOptions([
                'timeout' => 0
            ])->get(config('custom.TARGET_API') . $url);
        }

        $statusCode = $response->getStatusCode();

        if ($statusCode == 204) {
            return [
                "code" => 200,
                "message" => 'No Content',
                "status" => true,
                "result" => []
            ];
        } else if ($statusCode == 429) {
            return [
                "code" => 429,
                "message" => 'Too Many Request. Mohon Refresh secara berkala setiap 30 detik',
                "status" => true,
                "result" => []
            ];
        }

        if ($statusCode != 200) {
            return response()->json(\json_decode($response->getBody()->getContents()), $statusCode);
        }

        if ($response->getHeader('content-type')[0] == 'application/pdf') {
            return \json_encode("data:" . $response->getHeader('content-type')[0] . ";base64," . \base64_encode($response), true);
        } else if ($response->getHeader('content-type')[0] == 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet') {
            return response($response)->header('Content-Type', $response->getHeader('content-type')[0]);
        }

        $result = \json_decode($response, true);

        return $result;
    }

    public function postAPI($url, Request $request)
    {
        if ($url != 'auth/login') {
            $session = session()->get('auth_session');

            if ($request->has('file')) {
                $file = $request->file('file');
                $response = HTTP::withOptions([
                    'timeout' => 0
                ])->withHeaders([
                    'Authorization' => 'Bearer ' . $session['token']
                ])->attach('file', file_get_contents($file), $file->getClientOriginalName())
                    ->post(config('custom.TARGET_API') . $url);
            } else {
                $response = HTTP::withOptions([
                    'timeout' => 0
                ])->withHeaders([
                    'Authorization' => 'Bearer ' . $session['token']
                ])->post(config('custom.TARGET_API') . $url, $request);
            }
        } else {
            $response = HTTP::withOptions([
                'timeout' => 0
            ])->post(config('custom.TARGET_API') . $url, $request);
        }

        $statusCode = $response->getStatusCode();

        if ($url == 'auth/logout') {
            $request->session()->remove('auth_session');
            return $response;
        }

        if ($statusCode != 200) {
            return response()->json(\json_decode($response->getBody()->getContents()), $statusCode);
        };

        if ($url == 'auth/login') {
            $result = \json_decode($response->getBody()->getContents(), true);
            $request->session()->put('auth_session', $result['result']);
        }

        return $response;
    }

    public function putAPI($url, Request $request)
    {
        if ($url != 'auth/login') {
            $session = session()->get('auth_session');
            $response = HTTP::withOptions([
                'timeout' => 0
            ])->withHeaders([
                'Authorization' => 'Bearer ' . $session['token']
            ])->put(config('custom.TARGET_API') . $url, $request);
        } else {
            $response = HTTP::withOptions([
                'timeout' => 0
            ])->put(config('custom.TARGET_API') . $url, $request);
        }

        $statusCode = $response->getStatusCode();
        if ($statusCode != 200) {
            return response()->json(\json_decode($response->getBody()->getContents()), $statusCode);
        }

        return $response;
    }

    public function deleteAPI($url, Request $request)
    {
        if ($url != 'auth/login') {
            $session = session()->get('auth_session');

            $response = HTTP::withOptions([
                'timeout' => 0
            ])->withHeaders([
                'Authorization' => 'Bearer ' . $session['token']
            ])->delete(config('custom.TARGET_API') . $url, $request->all());
        } else {
            $response = HTTP::withOptions([
                'timeout' => 0
            ])->delete(config('custom.TARGET_API') . $url);
        }

        $statusCode = $response->getStatusCode();

        if ($statusCode != 200) {
            return response()->json(\json_decode($response->getBody()->getContents()), $statusCode);
        }

        return $response;
    }
}
