<?php

namespace App\Http\Traits;

trait HttpResponse
{
    public static function success($message): \Illuminate\Http\Response
    {
        return response([
            'success' => true,
            'message' => $message,
        ], 200);
    }

    public static function failure($message, $status): \Illuminate\Http\Response
    {
        return response([
            'success' => false,
            'message' => $message,
        ], $status);
    }

    public static function returnData($key, $value, $pagination = null, $message = ""): \Illuminate\Http\Response
    {

        $response = [
            'success' => true,
            'message' => $message,
        ];

        if(is_array($key) && is_array($value)){
            for($i=0;$i<sizeof($key);$i++){
                $response[$key[$i]] = $value[$i];
            }
        }else{
            $response[$key] = $value ;
        }

        if ($pagination != null) {
            $response['pagination'] = [
                'current_page' => $pagination->currentPage(),
                'next_page_url' => $pagination->nextPageUrl(),
                'prev_page_url' => $pagination->previousPageUrl(),
                'first_page_url' => $pagination->url(1),
                'last_page_url' => $pagination->url($pagination->lastPage()),
                'per_page' => $pagination->perPage(),
                'total' => $pagination->total(),
            ];;
        }

        return response($response, 200);
    }
}
