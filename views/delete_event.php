<?php
include 'db.php';
$id = $_POST['id'];

$query = "DELETE FROM events WHERE id=$id";
$db->query($query);
