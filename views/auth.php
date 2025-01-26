<?php

// In each script that includes views
session_start();

if (!isset($_SESSION['user_id']))
{
    header('Location: login.php');
    exit;
}
