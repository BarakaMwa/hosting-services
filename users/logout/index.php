<?php
session_start();
require_once '../class.user.php';
$user = new USER();

if(!$user->is_logged_in())
{
    $user->redirect('../home-page');
}

if($user->is_logged_in()!="")
{
    $user->logout();
    $user->redirect('../login');
}
?>