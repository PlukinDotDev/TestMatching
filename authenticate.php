<?php
session_start();

include 'connectdb.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_email = $_POST["user_email"];
    $user_password = $_POST["user_password"];

    $sql = "SELECT * FROM users WHERE user_email = '$user_email' AND user_password = '$user_password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $_SESSION["user_id"] = $row["user_id"];
        $_SESSION["user_name"] = $row["user_name"];
        $_SESSION["user_last_name"] = $row["user_last_name"];
        $_SESSION["user_type"] = $row["user_type"];

        header("Location: index.php");
        exit();
    } else {
        header("Location: login.php?login_failed=true");
        exit();
    }
}

$conn->close();
?>
