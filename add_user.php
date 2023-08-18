<!DOCTYPE html>
<html>
<head>
    <title>Add User</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="styles.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <?php
    session_start();
    include 'connectdb.php';

    if (!isset($_SESSION["user_id"]) || $_SESSION["user_type"] !== "admin") {
        header("Location: index.php");
        exit();
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $user_name = $_POST["user_name"];
        $user_last_name = $_POST["user_last_name"];
        $user_email = $_POST["user_email"];
        $user_password = $_POST["user_password"];
        $user_type = $_POST["user_type"];

        // เข้ารหัสรหัสผ่านก่อนที่จะบันทึกลงในฐานข้อมูล
        $hashed_password = password_hash($user_password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (user_name, user_last_name, user_email, user_password, user_type)
                VALUES ('$user_name', '$user_last_name', '$user_email', '$hashed_password', '$user_type')";

        if ($conn->query($sql) === TRUE) {
            echo "<script>
                    Swal.fire({
                        icon: 'success',
                        title: 'เพิ่มผู้ใช้งานเรียบร้อยแล้ว!',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(function() {
                        window.location.href = 'index.php';
                    });
                  </script>";
        } else {
            echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'เกิดข้อผิดพลาด!',
                        text: 'ไม่สามารถเพิ่มผู้ใช้งานได้',
                    });
                  </script>";
        }

        $conn->close();
    }
    ?>

    <div class="container mt-5">
        <h1 class="mb-4">Add User</h1>

        <form action="" method="post">
            <div class="mb-3">
                <label for="user_name" class="form-label">ชื่อ:</label>
                <input type="text" class="form-control" id="user_name" name="user_name" required>
            </div>

            <div class="mb-3">
                <label for="user_last_name" class="form-label">นามสกุล:</label>
                <input type="text" class="form-control" id="user_last_name" name="user_last_name" required>
            </div>

            <div class="mb-3">
                <label for="user_email" class="form-label">อีเมล:</label>
                <input type="email" class="form-control" id="user_email" name="user_email" required>
            </div>

            <div class="mb-3">
                <label for="user_password" class="form-label">รหัสผ่าน:</label>
                <input type="password" class="form-control" id="user_password" name="user_password" required>
            </div>

            <div class="mb-3">
                <label for="user_type" class="form-label">ประเภทผู้ใช้งาน:</label>
                <select class="form-select" id="user_type" name="user_type" required>
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">เพิ่มผู้ใช้งาน</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
