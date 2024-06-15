<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

trait ApiResponse
{
    /**
     * @param $data
     * @param string|null $message
     * @param int $statusCode
     * @return JsonResponse
     */
    public function sendResponse($data = null, string $message = null, int $statusCode = Response::HTTP_OK): JsonResponse
    {
        $res = [
            'status' => true,
            'data' => $data,
            'message' => $message,
        ];
        return response()->json($res, $statusCode);
    }

    /**
     * @param $pagination
     * @param $records
     * @return JsonResponse
     */
    public function sendPaginationResponse($pagination, $records): JsonResponse
    {
        $data = [
            'records' => $records,
            'limit' => $pagination->perPage(),
            'total' => $pagination->total(),
            'page' => $pagination->currentPage()
        ];

        return $this->sendResponse($data, __('common.get_data_success'));
    }

    public function sendError(string $message = null, int $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR, array $errors = []): JsonResponse
    {
        $res = [
            'status' => false,
        ];

        if ($message) {
            $res['message'] = $message;
        }

        if (!empty($errors)) {
            $res['errors'] = $errors;
        }

        return response()->json($res, $statusCode);
    }

    /**
     * @param \Exception $e
     * @return JsonResponse
     */
    protected function sendExceptionError(\Exception $e): JsonResponse
    {
        Log::error(
            'Error: ',
            [
                'line' => __LINE__,
                'method' => __METHOD__,
                'error_message' => $e->getMessage(),
            ]
        );

        if ($e instanceof \HttpException && $e?->getStatusCode() === Response::HTTP_FORBIDDEN) {
            return $this->sendError(__('common.access_denied'), Response::HTTP_FORBIDDEN);
        }

        return $this->sendError(__('common.server_error'));
    }
}
