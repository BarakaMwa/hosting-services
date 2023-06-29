<?php


class Responses
{

    /**
     * @param array $response
     * @param array $result
     * @param string $entity
     * @return void
     * @throws JsonException
     */
    public function successDataRetrieved(array $response, array $result, string $entity): void
    {
        $response["message"] = $entity." Data Retrieved Successfully.";
        $response["success"] = true;
        $response["status"] = "success";
        $response["data"] = $result;
        echo json_encode($response, JSON_THROW_ON_ERROR);
        exit();
    }

    /**
     * @param array $response
     * @param string $entity
     * @param Exception $e
     * @return void
     * @throws JsonException
     */
    public function errorUpDating(array $response, Exception $e, string $entity): void
    {
        $response["message"] = "Error Updating ".$entity." Data";
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
     * @param string $entity
     * @return void
     * @throws JsonException
     */
    public function successDataDeactivated(array $response, array $result, string  $entity): void
    {
        $response["message"] = $entity." Data Removal/ Deactivation Successful";
        $response["success"] = true;
        $response["status"] = "success";
        $response["data"] = $result;
        echo json_encode($response, JSON_THROW_ON_ERROR);
        exit();
    }

    /**
     * @param array $response
     * @param Exception $e
     * @param string $entity
     * @return void
     * @throws JsonException
     */
    public function errorInsertingData(array $response, Exception $e, string  $entity): void
    {
        $response["message"] = "Error Inserting ".$entity." Data";
        $response["success"] = false;
        $response["status"] = "error";
        $response["data"] = $e->getMessage();
        echo json_encode($response, JSON_THROW_ON_ERROR);
        exit();
    }

    /**
     * @param string $string
     * @return void
     * @throws JsonException
     */
    public function warningInput(string $string): void
    {
        $response["message"] = $string;
        $response["success"] = false;
        $response["status"] = "warning";
        $response["data"] = null;
        echo json_encode($response, JSON_THROW_ON_ERROR);
        exit();
    }

    /**
     * @param array $response
     * @param array $result
     * @param string $entity
     * @return void
     * @throws JsonException
     */
    public function successDataInsert(array $response, array $result, string $entity): void
    {
        $response["message"] = $entity." Data Inserted Successfully";
        $response["success"] = true;
        $response["status"] = "success";
        $response["data"] = $result;
        echo json_encode($response, JSON_THROW_ON_ERROR);
        exit();
    }

    /**
     * @param array $response
     * @param array $result
     * @param string $entity
     * @return void
     * @throws JsonException
     */
    public function warningAlreadyDeleted(array $response, array $result, string $entity): void
    {
        $response["message"] = $entity." Data Already Deleted/ Deactivated";
        $response["success"] = false;
        $response["status"] = "warning";
        $response["data"] = $result;
        echo json_encode($response, JSON_THROW_ON_ERROR);
        exit();
    }

    /**
     * @param array $response
     * @param array $result
     * @param string $entity
     * @return void
     * @throws JsonException
     */
    public function successDataUpdated(array $response, array $result, string $entity): void
    {
        $response["message"] = $entity." Data Updated Successfully";
        $response["success"] = true;
        $response["status"] = "success";
        $response["data"] = $result;
        echo json_encode($response, JSON_THROW_ON_ERROR);
        exit();
    }

    /**
     * @return void
     * @throws JsonException
     */
    public function warningNoResults(): void
    {
        $response = array();
        $response["message"] = "Data Not Found";
        $response["success"] = false;
        $response["status"] = "warning";
        $response["data"] = null;
        echo json_encode($response, JSON_THROW_ON_ERROR);
        exit();
    }

}