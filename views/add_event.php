<?php
include 'db.php';
session_start();
$name         = $_POST['name'];
$description  = $_POST['description'];
$date         = $_POST['date'];
$time         = $_POST['time'];
$max_capacity = $_POST['max_capacity'];
$user_id      = $_SESSION['user_id'];

$query = "INSERT INTO events (name, description, date, time, max_capacity, created_by) VALUES ('$name', '$description', '$date', '$time', '$max_capacity', '$user_id')";
$db->query($query);
