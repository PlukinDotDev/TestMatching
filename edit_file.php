<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

include "connectdb.php";

if ($_SESSION["user_type"] !== "admin") {
    header("Location: files.php");
    exit();
}

if (isset($_GET["file_id"])) {
    $file_id = $_GET["file_id"];

    // ดึงข้อมูลไฟล์จากฐานข้อมูล
    $select_sql = "SELECT * FROM files WHERE file_id = $file_id";
    $result = $conn->query($select_sql);
    $row = $result->fetch_assoc();

    if (!$row) {
        header("Location: files.php");
        exit();
    }

    // อัพเดทข้อมูลไฟล์
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $new_file_name = $_POST["file_name"];
        $update_sql = "UPDATE files SET file_name = '$new_file_name' WHERE file_id = $file_id";
        if ($conn->query($update_sql)) {
            header("Location: files.php");
            exit();
        }
    }
} else {
    header("Location: files.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit File</title>
</head>
<body>
    <div class="container">
        <h2>Edit File</h2>
        <form method="post">
            <label for="file_name">File Name:</label>
            <input type="text" id="file_name" name="file_name" value="<?php echo $row["file_name"]; ?>">
            <br>
            <button type="submit">Save</button>
        </form>
        <a href="files.php">Back to Files</a>
    </div>
</body>
</html>
