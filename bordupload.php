<!DOCTYPE html>
<html>
<head>
    <title>Upload File</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>

</head>
<body>
    <?php
    session_start();
    include 'connectdb.php';

    if (!isset($_SESSION["user_id"])) {
        header("Location: login.php");
        exit();
    }

    // ตรวจสอบคำสั่ง Logout
    if (isset($_GET["logout"])) {
        session_destroy();
        header("Location: login.php");
        exit();
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $user_id = $_SESSION["user_id"];
        $user_name = $_SESSION["user_name"];
        $user_last_name = $_SESSION["user_last_name"];

        $file_name = $_FILES["file"]["name"];
        $file_size = $_FILES["file"]["size"];
        $file_tmp = $_FILES["file"]["tmp_name"];
        $file_type = $_FILES["file"]["type"];
        $file_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        // กำหนดตำแหน่งที่จะบันทึกไฟล์
        $upload_dir = "uploads/";

        // ถ้ามีไฟล์ที่มีชื่อเดียวกันแล้ว สร้างชื่อใหม่โดยเพิ่มเลขนับ
        $counter = 1;
        $new_file_name = $file_name;
        while (file_exists($upload_dir . $new_file_name)) {
            $new_file_name = pathinfo($file_name, PATHINFO_FILENAME) . "_$counter.$file_extension";
            $counter++;
        }

        $target_file = $upload_dir . $new_file_name;

        // ตรวจสอบนามสกุลไฟล์ที่อัปโหลด
        $allowed_extensions = array("pdf", "docx", "jpeg", "jpg", "png", "xlsx");

        if (!in_array($file_extension, $allowed_extensions)) {
            echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'เกิดข้อผิดพลาด!',
                        text: 'ไม่สามารถอัปโหลดไฟล์นี้ได้ เนื่องจากนามสกุลไม่ถูกต้อง',
                    }).then(() => {
                        window.location.href = 'bordupload.php';
                    });
                  </script>";
            exit;
        }

        // บันทึกข้อมูลลงในฐานข้อมูล
        $sql = "INSERT INTO files (user_id, user_name, user_last_name, file_name, file_path, file_size, file_type, upload_date)
                VALUES ('$user_id', '$user_name', '$user_last_name', '$new_file_name', '$target_file', '$file_size', '$file_type', NOW())";

        if (move_uploaded_file($file_tmp, $target_file) && $conn->query($sql) === TRUE) {
            echo "<script>
                    Swal.fire({
                        icon: 'success',
                        title: 'อัปโหลดไฟล์สำเร็จ!',
                        text: 'ไฟล์ถูกอัปโหลดและข้อมูลถูกบันทึกลงในฐานข้อมูล',
                    }).then(() => {
                        window.location.href = 'index.php';
                    });
                  </script>";
        } else {
            echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'เกิดข้อผิดพลาด!',
                        text: 'ไม่สามารถอัปโหลดไฟล์ได้',
                    }).then(() => {
                        window.location.href = 'bordupload.php';
                    });
                  </script>";
        }

        $conn->close();
    }
    ?>

    <h1>Upload File</h1>

    <form action="" method="post" enctype="multipart/form-data">
        <label for="file">เลือกไฟล์:</label>
        <input class="form-control" type="file" id="file" name="file" required><br>

        <button class="btn btn-outline-success" type="submit">อัปโหลด</button>
    </form>

    <br>
    <a class="btn btn-outline-danger" href="index.php">กลับหน้าหลัก</a>
    
    <script>
        // ตรวจสอบกรณีที่กรอกข้อมูลไม่ครบ
        const form = document.querySelector("form");
        form.addEventListener("submit", function (event) {
            const fileInput = document.getElementById("file");
            if (fileInput.files.length === 0) {
                event.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'กรุณาเลือกไฟล์',
                    text: 'โปรดเลือกไฟล์ที่ต้องการอัปโหลด',
                });
            }
        });
    </script>
</body>
</html>
