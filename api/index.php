<?php

if ($_SERVER["REQUEST_METHOD"] == "POST" OR $_SERVER["REQUEST_METHOD"] == "GET"){
    $data = array();
    $data["status"]=false;
    $data["message"]="Invalid Request";
    echo json_encode($data);
    exit();
}

