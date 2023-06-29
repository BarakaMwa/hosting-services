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
const Entity = "Image";

if ($_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'GET') {

    $database = new Database();
    $db = $database->dbConnection();
    $image = $database -> image;
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $image_id = 0;

    try {
        if (isset($_POST['id']) && !empty($_POST['id'])) {
            $image_id = $_POST['id'];
        } else if (isset($_GET['id']) && !empty($_GET['id'])) {
            $image_id = $_GET['id'];
        } else {
            $responses->errorInvalidRequest($response);
        }

        $sql = $image->getById($image_id);

        if (isset($_POST["active"]) && !empty($_POST["active"])) {

            (int)$active = $_POST["active"];

            $sql = $image->getByIdAndActive($active, $image_id);
        } else if (isset($_GET["active"]) && !empty($_GET["active"])) {

            (int)$active = $_GET["active"];

            $sql = $image->getByIdAndActive($active, $image_id);
        }

        $result = $database->runSelectOneQuery($sql, $db);

        /* foreach ($result as $row) {
             $encrypted = encrypt($row['image_id'],$ciphering,$encryption_iv,$options);
             $row["image_id"] = $encrypted;
             $row["0"] = $encrypted;
         }*/

        $responses->successDataRetrieved($response, $result, Entity );
    } catch (JsonException $e) {
        $responses->errorInsertingData($response, $e, Entity);
    }

} else {

        $responses->errorInvalidRequest($response);
}


