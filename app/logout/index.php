<?php
session_start();
require_once '../services/class.userService.php';
$user = new UserService();

$user->logout();
$user->redirect('../login/index.php');



