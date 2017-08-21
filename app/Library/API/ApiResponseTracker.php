<?php
/*
|--------------------------------------------------------------------------
| ApiResponseTrackerker.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| This class is responsible for managing api success or error responses.  It
| will receive a
*/

namespace App\Library\API;


class ApiResponseTracker
{
    /**
     * was an error found
     *
     * @var bool
     */
    private $errorSet = false;

    /**
     * array containing the message and the api status code
     *
     * @var array
     */
    private $result = [
        'code' => '',
        'status' => ''
    ];

    /**
     * has an error been set
     *
     * @return bool
     */
    public function hasError()
    {
        return $this->errorSet;
    }

    /**
     * set the message and the api response code.
     * if it is an error then error set will be set to true and no more messages can be set
     *
     * @param integer $code
     * @param string $message
     * @param bool $error
     * @param array $data
     * @return void
     */
    public function setResult($code, $message, $error = false, $data = [])
    {
        if(!$this->errorSet)
        {
            $this->errorSet = ($error) ? true : false;
            $this->result = [
                'code'  => $code,
                'status' => $message
            ];
            $this->setData($data);
        }
    }

    /**
     * get status and the code
     *
     * @return array
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * if the user provided additional data to be included a message it will be in the data property
     *
     * @param $data
     * @return void
     */
    private function setData($data)
    {
        if(!empty($data))
        {
            $this->result['data'] = $data;
        }
    }
}