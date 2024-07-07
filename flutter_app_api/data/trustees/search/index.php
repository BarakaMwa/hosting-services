<?php

require_once '../../../headers-api.php';
require_once '../../../../Database/LocalDatabase.php';
require_once '../../../../Responses/DatatablesResponse.php';
require_once '../../../../Responses/Responses.php';
session_start();

use Database\LocalDatabase;
use Responses\Responses;
use Responses\DatatablesResponse;

$response = array();
$status = false;
$responses = new Responses();
$dataTable = new DatatablesResponse();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    try {

        $database = new LocalDatabase();
        $db = $database->dbConnection();
        $trustees = $database->trustee;

        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $trustees->getByUserId($_SESSION['userSessionId']);

        $data = $database->runSelectAllQuery($sql, $db);

        $countAll = count($data);
        if ($_POST['search'] != null && $_POST['search']['value'] != "") {
            $sql = $trustees->searchBy($sql, $_POST['search']);
        }
        $sql = $trustees->getPage($sql, $_POST['start'], $_POST['length']);

        $data = $database->runSelectAllQuery($sql, $db);

        //    todo encrypt
        /* foreach ($result as $row) {
             $encrypted = encrypt($row['vendorId'],$ciphering,$encryption_iv,$options);
             $row["vendorId"] = $encrypted;
             $row["0"] = $encrypted;
         }*/

        $dataTable->data = $data;
        $dataTable->draw = $_POST['draw'];
        $dataTable->recordsTotal = $countAll;
        $dataTable->recordsFiltered = count($data);

        $responses->dataTableResponse($response, $dataTable);


    } catch (Exception $ex) {
        $responses->failedOperation($ex);
    }


} else {

    $responses->errorInvalidRequest($response);
}