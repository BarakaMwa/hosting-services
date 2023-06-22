<?php


class Responses{

    /**
     * @param array $response
     * @param $result
     * @return void
     * @throws JsonException
     */
    public function successDataRetrieved(array $response, $result): void
    {
        $response["message"] = "Data Removal Success";
        $response["success"] = true;
        $response["status"] = "success";
        $response["data"] = $result;
        echo json_encode($response, JSON_THROW_ON_ERROR);
        exit();
    }
    /**
     * @param array $response
     * @param $e
     * @return void
     * @throws JsonException
     */
    public function errorUpDating(array $response, $e): void
    {
        $response["message"] = "Error Updating";
        $response["success"] = false;
        $response["status"] = "error";
        $response["data"] = $e->getMessage();
        echo json_encode($response, JSON_THROW_ON_ERROR);
        exit();
    }


    /**
     * @param array $response
     * @return void
     * @throws JsonException
     */
    public function errorInvalidRequest(array $response): void
    {
        $response["message"] = "Invalid Request";
        $response["success"] = false;
        $response["status"] = "error";
        echo json_encode($response, JSON_THROW_ON_ERROR);
        exit();
    }

}