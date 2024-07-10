<?php
//todo validation
require_once '../../headers-api.php';
require_once '../../../Database/LocalDatabase.php';
require_once '../../../Responses/Responses.php';
require_once '../../../Services/DevicesService.php';

session_start();

$response = array();
$status = false;
$deviceService = new Services\DevicesService();
$responses = new Responses\Responses();


try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' || $_SERVER['REQUEST_METHOD'] = 'GET') {

//    todo encrypt
        /* foreach ($result as $row) {
             $encrypted = encrypt($row['vendorId'],$ciphering,$encryption_iv,$options);
             $row["vendorId"] = $encrypted;
             $row["0"] = $encrypted;
         }*/
        $result = $deviceService->getAllDevices();
        $responses->successDataRetrieved($response, $result, Entity);
    } else {

        $responses->errorInvalidRequest($response);
    }
} catch (JsonException $e) {
    $responses->warningInput("Error retrieving Devices");
}




