<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

include "connectdb.php";

$user_type = $_SESSION["user_type"];

$select_sql = "SELECT * FROM files";
if ($user_type !== "admin") {
    $select_sql .= " WHERE user_id = " . $_SESSION["user_id"];
}

$result = $conn->query($select_sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Files</title>
</head>
<body>
    <div class="container">
        <h2>Files</h2>
        <table>
            <tr>
                <th>File Name</th>
                <th>File Path</th>
                <th>User Name</th>
                <th>Date Uploaded</th>
                <?php if ($user_type === "admin"): ?>
                    <th>Action</th>
                <?php endif; ?>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row["file_name"]; ?></td>
                    <td><?php echo $row["file_path"]; ?></td>
                    <td><?php echo $row["user_name"]; ?></td>
                    <td><?php echo $row["upload_date"]; ?></td>
                    <?php if ($user_type === "admin"): ?>
                        <td>
                            <a href="edit_file.php?file_id=<?php echo $row["file_id"]; ?>">Edit</a>
                            <a href="delete_file.php?file_id=<?php echo $row["file_id"]; ?>">Delete</a>
                        </td>
                    <?php endif; ?>
                </tr>
            <?php endwhile; ?>
        </table>
        <a href="upload_file.php">Upload New File</a>
        <br>
        <a href="logout.php">Logout</a>
    </div>
</body>
</html>
