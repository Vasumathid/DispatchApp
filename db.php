<?php
$host = 'localhost';
$port = '5432';
$dbname = 'dispatchdb'; // ✅ Make sure spelling is correct
$user = 'postgres';
$password = 'postgres';

$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

if (!$conn) {
    die("Connection failed: " . pg_last_error());
}
?>
