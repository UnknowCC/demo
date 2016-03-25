<?php

$mysqli = new mysqli('localhost', 'root', '', 'test');
if ($mysqli->errno) {
    die('Connect database error:'.$mysqli->error);
} else {
    $mysqli->set_charset('utf8');
}
