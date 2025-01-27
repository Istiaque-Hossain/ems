<?php
include 'db.php';
require_once '../classes/Event.php';

$name         = $_POST['name'];
$description  = $_POST['description'];
$date         = $_POST['date'];
$time         = $_POST['time'];
$max_capacity = $_POST['max_capacity'];

$event  = new Event($db);
$events = $event->create($name, $description, $date, $time, $max_capacity);
