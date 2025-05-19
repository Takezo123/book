<?php 
$host = 'localhost';
$dbname = 'book_cards';
$user= 'root';
$pass = '';

$conn = new mysqli($host,$user,$pass,$dbname);
if($conn->connect_error){
    die('Ошибка подлкючения:' . $conn->connect_error);
}