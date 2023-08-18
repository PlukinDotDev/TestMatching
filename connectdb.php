<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "filesave";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("การเชื่อมต่อฐานข้อมูลล้มเหลว: " . $conn->connect_error);
}

// ฟังก์ชันเข้ารหัสรหัสผ่านก่อนเพื่อบันทึกลงในฐานข้อมูล
function hashPassword($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}
?>
