<?php

namespace App\Exceptions;

use App\Traits\MainTrait;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Support\Str;

class Handler extends ExceptionHandler
{
    use MainTrait;
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            // Logika untuk melaporkan exception. Bisa menggunakan library logging disini jika diperlukan.
        });

        // Penyesuaian output error untuk request API
        $this->renderable(function (AuthenticationException $e, $request) {
            if ($request->is('api/*')) {
                if (empty($request->headers->get('Authorization'))) {
                    return response()->json([
                        'code' => 401,
                        'message' => 'Token tidak ditemukan', // Token tidak ada
                        'status' => false,
                        'result' => null
                    ], 401);
                }
                return response()->json([
                    'code' => 401,
                    'message' => 'Tidak terautentikasi', // Token salah
                    'status' => false,
                    'result' => null
                ], 401);
            }
        });

        // Penyesuaian output error secara umum
        $this->renderable(function (Throwable $e) {
            if (Str::contains($e->getMessage(), ['could not connect to server:', 'Connection timed out']) && get_class($e) == 'Illuminate\\Database\\QueryException') {
                return $this->sendResponseData(500, 'Connection Time out.', false, null);
            }
            if (Str::contains($e->getMessage(), ['could not connect to server:', 'Connection timed out']) && get_class($e) == 'PDOException') {
                return $this->sendResponseData(500, 'Connection Time out.', false, null);
            }
            // return $this->sendResponseData(500, ['An Error Occured', $e->getMessage(), get_class($e)], false, null);
        });
    }
}
