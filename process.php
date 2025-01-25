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
    $user->register($_POST['username'], $_POST['email'], $_POST['password']);
}
elseif (isset($_POST['login']))
{
    if ($user->login($_POST['email'], $_POST['password']))
    {
        header('Location: /dashboard.php');
    }
    else
    {
        // echo 'Invalid login!';
        $_SESSION['error_message'] = 'Invalid login!'; // Store error message in session
        header('Location: ' . $_SERVER['HTTP_REFERER']); // Redirect to the previous page
        exit;
    }
}
