<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

include "connectdb.php";

$file_id = $_GET["file_id"];
$user_id = $_SESSION["user_id"];
$user_type = $_SESSION["user_type"];

$select_sql = "SELECT * FROM files WHERE file_id = $file_id";
if ($user_type !== "admin") {
    $select_sql .= " AND user_id = $user_id";
}

$result = $conn->query($select_sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    echo "File not found.";
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>View File</title>
</head>
<body>
    <div class="container">
        <h2>File Details</h2>
        <ul>
            <li><strong>User ID:</strong> <?php echo $row["user_id"]; ?></li>
            <li><strong>User Name:</strong> <?php echo $row["user_name"]; ?></li>
            <li><strong>User Last Name:</strong> <?php echo $row["user_last_name"]; ?></li>
            <li><strong>File Name:</strong> <?php echo $row["file_name"]; ?></li>
            <li><strong>File Path:</strong> <?php echo $row["file_path"]; ?></li>
            <li><strong>File Type:</strong> <?php echo $row["file_type"]; ?></li>
            <li><strong>Upload Date:</strong> <?php echo $row["upload_date"]; ?></li>
        </ul>
        <?php if ($user_type === "admin" || $user_id == $row["user_id"]): ?>
            <a href="files.php">Back to Files</a>
        <?php else: ?>
            <a href="files.php">Back to My Files</a>
        <?php endif; ?>
        <br>
        <a href="logout.php">Logout</a>
    </div>
</body>
</html>
