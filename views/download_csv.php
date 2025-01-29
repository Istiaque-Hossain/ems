<?php
include 'db.php';
require_once '../classes/Event.php';

$id = $_POST['eventId'];

$event  = new Event($db);
$events = $event->downloadCSV($id);
