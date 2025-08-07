<?php

namespace App\Libraries;

class ResponseJSONCollection
{
    protected $response = [
        'status' => 200,
        'message' => 'Success',
        'data' => null,
    ];

    public function success($data = null, $message = 'Success', $status = 200)
    {
        $this->response['status'] = $status;
        $this->response['message'] = $message;
        $this->response['data'] = $data;

        return response()->setStatusCode($status)->setJSON($this->response);
    }
    
    public function error($data = null, $message = 'Error', $status = 400)
    {
        $this->response['status'] = $status;
        $this->response['message'] = $message;
        $this->response['data'] = $data;
        
        return response()->setStatusCode($status)->setJSON($this->response);
    }




}
