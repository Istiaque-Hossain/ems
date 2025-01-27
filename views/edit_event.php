<?php
include 'db.php';
$id = $_POST['id'];
$name = $_POST['name'];
$description = $_POST['description'];
$date = $_POST['date'];
$time = $_POST['time'];
$max_capacity = $_POST['max_capacity'];

$query = "UPDATE events SET name='$name', description='$description', date='$date', time='$time', max_capacity='$max_capacity' WHERE id=$id";
$db->query($query);
