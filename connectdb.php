<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "filesave";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("การเชื่อมต่อฐานข้อมูลล้มเหลว: " . $conn->connect_error);
}
// เข้ารหัสรหัสผ่านก่อนเป็นการบันทึกลงในฐานข้อมูล
function hashPassword($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}
?>
