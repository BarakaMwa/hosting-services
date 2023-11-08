<?php
session_start();
require_once '../class.user.php';
$user = new User();

if(!$user->is_logged_in())
{
    $user->redirect('../home/index.php');
}

if($user->is_logged_in()!="")
{
    $user->logout();
    $user->redirect('../login/index.php');
}
?>