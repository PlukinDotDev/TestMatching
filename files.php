<?php
session_start();
require_once 'connectdb.php';

// เช็คสถานะการเข้าสู่ระบบ
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];
$user_type = $_SESSION["user_type"];

// ดึงข้อมูลไฟล์จากฐานข้อมูล
$order_by = "user_id";
if (isset($_GET["sort"])) {
    $sort = $_GET["sort"];
    if ($sort === "upload_date") {
        $order_by = "upload_date";
    }
}

$select_sql = "SELECT * FROM files";
if ($user_type !== "admin") {
    $select_sql .= " WHERE user_id = $user_id";
}
$select_sql .= " ORDER BY $order_by";

$result = $conn->query($select_sql);

// Pagination
$items_per_page = 10; // จำนวนรายการต่อหน้า
$total_rows = $result->num_rows;
$total_pages = ceil($total_rows / $items_per_page);

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$start = ($page - 1) * $items_per_page;

$select_sql .= " LIMIT $start, $items_per_page";
$result = $conn->query($select_sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>File List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <h1>File List</h1>

    <!-- ส่วนเลือกเรียงลำดับ -->
   

    <table class="table table-bordered">
        <tr>
            <th><a href="?sort=user_id">User ID</a></th>
            <th>User Name</th>
            <th>User Last Name</th>
            <th>File Name</th>
            <th>File Path</th>
            <th><a href="?sort=upload_date">Upload Date</a></th>
            <?php if ($user_type === "admin"): ?>
                <th>Action</th>
            <?php endif; ?>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row["user_id"]; ?></td>
                <td><?php echo $row["user_name"]; ?></td>
                <td><?php echo $row["user_last_name"]; ?></td>
                <td><?php echo $row["file_name"]; ?></td>
                <td><?php echo $row["file_path"]; ?></td>
                <td><?php echo $row["upload_date"]; ?></td>
                <?php if ($user_type === "admin"): ?>
                    <td>
                        <a href="edit_file.php?file_id=<?php echo $row["file_id"]; ?>">Edit</a>
                        <a href="view_file.php?file_id=<?php echo $row["file_id"]; ?>">View</a>
                        <a href="files.php?delete_id=<?php echo $row["file_id"]; ?>">Delete</a>
                    </td>
                <?php endif; ?>
            </tr>
        <?php endwhile; ?>
    </table>

    <!-- ส่วน Pagination -->
    <nav aria-label="Page navigation example">
        <ul class="pagination">
            <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                <li class="page-item"><a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
            <?php endfor; ?>
        </ul>
    </nav>

    <a href="index.php">กลับหน้าหลัก</a>
</body>
</html>
