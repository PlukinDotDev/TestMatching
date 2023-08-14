<!DOCTYPE html>
<html>
<head>
    <title>Add User</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <?php
    session_start();
    include 'connectdb.php';

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

    <div class="container">
        <h1>Add User</h1>

        <form action="" method="post">
            <label for="user_name">ชื่อ:</label>
            <input type="text" id="user_name" name="user_name" required><br>

            <label for="user_last_name">นามสกุล:</label>
            <input type="text" id="user_last_name" name="user_last_name" required><br>

            <label for="user_email">อีเมล:</label>
            <input type="email" id="user_email" name="user_email" required><br>

            <label for="user_password">รหัสผ่าน:</label>
            <input type="password" id="user_password" name="user_password" required><br>

            <label for="user_type">ประเภทผู้ใช้งาน:</label>
            <select id="user_type" name="user_type" required>
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select><br>

            <button type="submit">เพิ่มผู้ใช้งาน</button>
        </form>
    </div>
</body>
</html>
