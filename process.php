<?php
session_start();

require_once 'config/config.php';
require_once 'classes/Database.php';
require_once 'classes/User.php';
require_once 'classes/Event.php';

$db    = (new Database(require 'config/config.php'))->getConnection();
$user  = new User($db);
$event = new Event($db);

if (isset($_POST['register']))
{
    $res = $user->register($_POST['username'], $_POST['email'], $_POST['password']);

    // var_dump('hi');
    // dead_db(  )
    $_SESSION['reg_message'] =   $res;
    header('Location: views/login.php');
}
elseif (isset($_POST['login']))
{
    if ($user->login($_POST['email'], $_POST['password']))
    {
        header('Location: views/dashboard.php');
    }
    else
    {
        $_SESSION['login_message'] = 'Invalid login!';
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }
}
