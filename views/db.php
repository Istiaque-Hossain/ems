<?php
require_once '../config/config.php';
require_once '../classes/Database.php';

$db    = (new Database(require '../config/config.php'))->getConnection();
