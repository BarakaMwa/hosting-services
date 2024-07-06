<?php
session_start();
require_once '../../services/UserService.php';
use Services\UserService;
$user = new UserService();

$user->logout();
$user->redirect('../login/index.php');



