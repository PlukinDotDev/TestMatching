<!DOCTYPE html>
<html>
<head>
    <title>Permission Settings</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <?php
    session_start();
    include 'connectdb.php';

    // ตรวจสอบสิทธิ์ของผู้ใช้ว่าเป็น Admin หรือไม่
    if ($_SESSION["user_type"] !== "admin") {
        header("Location: index.php");
        exit();
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // รับข้อมูลจากฟอร์มและอัพเดตสิทธิ์ในฐานข้อมูล
        $user_id = $_POST["user_id"];
        $user_type = $_POST["user_type"];

        $sql = "UPDATE users SET user_type = '$user_type' WHERE user_id = $user_id";

        if ($conn->query($sql) === TRUE) {
            echo "<script>
                    Swal.fire({
                        icon: 'success',
                        title: 'อัพเดตสิทธิ์เรียบร้อยแล้ว!',
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
                        text: 'ไม่สามารถอัพเดตสิทธิ์ได้',
                    });
                  </script>";
        }

        $conn->close();
    }
    ?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <h1 class="text-center mb-4">กำหนดสิทธิ์ผู้ใช้งาน</h1>

                <form action="" method="post">
                    <div class="mb-3">
                        <label for="user_id" class="form-label">เลือกผู้ใช้งาน:</label>
                        <select class="form-select" id="user_id" name="user_id" required>
                            <?php
                            $sql = "SELECT user_id, user_name, user_last_name FROM users WHERE user_type = 'user'";
                            $result = $conn->query($sql);

                            while ($row = $result->fetch_assoc()) {
                                echo "<option value='" . $row["user_id"] . "'>" . $row["user_name"] . " " . $row["user_last_name"] . "</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="user_type" class="form-label">ประเภทผู้ใช้งาน:</label>
                        <select class="form-select" id="user_type" name="user_type" required>
                            <option value="user">User</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">อัพเดตสิทธิ์</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
