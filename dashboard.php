<?php
session_start();
require_once 'config/config.php';
require_once 'classes/Database.php';
require_once 'classes/Event.php';

// Check if user is authenticated
if (!isset($_SESSION['user_id']))
{
    header('Location: views/login.php');
    exit;
}

// Initialize database and event class
$db = (new Database(require 'config/config.php'))->getConnection();
$event = new Event($db);

// Fetch all events
$events = $event->getAll();

// Include the view
include 'views/dashboard.php';
