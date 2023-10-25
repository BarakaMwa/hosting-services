<?php
//todo validation
require_once '../../../headers-api.php';
session_start();
//require_once '../../../connection.php';
require_once '../../../connection-local.php';

require_once '../../../errors/Responses.php';

$response = array();
$status = false;
$responses = new Responses();
const Entity = "File";

if ($_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'GET') {

    $database = new Database();
    $db = $database->dbConnection();
    $file = $database -> file;
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $file_id = 0;

    try {
        if (isset($_POST['id']) && !empty($_POST['id'])) {
            $file_id = $_POST['id'];
        } else if (isset($_GET['id']) && !empty($_GET['id'])) {
            $file_id = $_GET['id'];
        } else {
            $responses->errorInvalidRequest($response);
        }

        $sql = $file->getById($file_id);

        if (isset($_POST["active"]) && !empty($_POST["active"])) {

            (int)$active = $_POST["active"];

            $sql = $file->getByIdAndActive($active, $file_id);
        } else if (isset($_GET["active"]) && !empty($_GET["active"])) {

            (int)$active = $_GET["active"];

            $sql = $file->getByIdAndActive($active, $file_id);
        }

        $result = $database->runSelectOneQuery($sql, $db);

        /* foreach ($result as $row) {
             $encrypted = encrypt($row['file_id'],$ciphering,$encryption_iv,$options);
             $row["file_id"] = $encrypted;
             $row["0"] = $encrypted;
         }*/

        $responses->successDataRetrieved($response, $result, Entity );
    } catch (JsonException $e) {
        $responses->errorInsertingData($response, $e, Entity);
    }

} else {

        $responses->errorInvalidRequest($response);
}


