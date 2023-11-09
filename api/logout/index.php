<?php
session_start();
require_once '../class.user.php';
$user = new UserService();

if(!$user->is_logged_in())
{
    $user->redirect('../home-page/index.php');
}

if($user->is_logged_in()!="")
{
    $user->logout();
    $user->redirect('../login/index.php');
}
?>