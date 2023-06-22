<?php


class Responses
{

    /**
     * @param array $response
     * @param array $result
     * @return void
     * @throws JsonException
     */
    public function successDataRetrieved(array $response, array $result): void
    {
        $response["message"] = "Data Retrieval Success";
        $response["success"] = true;
        $response["status"] = "success";
        $response["data"] = $result;
        echo json_encode($response, JSON_THROW_ON_ERROR);
        exit();
    }

    /**
     * @param array $response
     * @param Exception $e
     * @return void
     * @throws JsonException
     */
    public function errorUpDating(array $response, Exception $e): void
    {
        $response["message"] = "Error Updating Data";
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

    /**
     * @param array $response
     * @param array $result
     * @return void
     * @throws JsonException
     */
    public function successDataDeactivated(array $response, array $result): void
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
     * @param Exception $e
     * @return void
     * @throws JsonException
     */
    public function errorInsertingData(array $response, Exception $e): void
    {
        $response["message"] = "Error Inserting Data";
        $response["success"] = false;
        $response["status"] = "error";
        $response["data"] = $e->getMessage();
        echo json_encode($response, JSON_THROW_ON_ERROR);
        exit();
    }

}