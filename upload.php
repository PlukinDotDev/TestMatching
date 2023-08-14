<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $upload_location = $_POST["upload_location"];
    
    $target_dir = $upload_location;
    $original_filename = basename($_FILES["file"]["name"]);
    $file_extension = pathinfo($original_filename, PATHINFO_EXTENSION);
    
    // ตรวจสอบชนิดของไฟล์ที่อัปโหลด
    $allowed_extensions = array("pdf", "docx", "jpg", "jpeg", "png", "xlsx");
    if (!in_array($file_extension, $allowed_extensions)) {
        echo "ไม่สามารถอัปโหลดไฟล์นี้ได้ เนื่องจากนามสกุลไม่ถูกต้อง";
        exit;
    }
    
    // สร้างชื่อไฟล์ใหม่เพื่อป้องกันชื่อซ้ำ
    $new_filename = uniqid() . '.' . $file_extension;
    $target_file = $target_dir . $new_filename;
    
    $uploadOk = 1;
    
    // จำกัดขนาดไฟล์
    if ($_FILES["file"]["size"] > 500000000) {
        echo "ไฟล์มีขนาดใหญ่เกินกว่าที่กำหนด (ไม่เกิน 5 MB)";
        $uploadOk = 0;
    }
    
    if ($uploadOk == 0) {
        echo "error";
    } else {
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
            // เชื่อมต่อฐานข้อมูล (เปลี่ยนเป็นข้อมูลที่ถูกต้อง)
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "filesave";
            
            $conn = new mysqli($servername, $username, $password, $dbname);
            
            if ($conn->connect_error) {
                die("การเชื่อมต่อล้มเหลว: " . $conn->connect_error);
            }
            
            // ระบุชื่อตารางที่จะบันทึกข้อมูล
            $table_name = "";
            switch ($file_extension) {
                case "pdf":
                    $table_name = "pdf_files";
                    break;
                case "docx":
                    $table_name = "docx_files";
                    break;
                case "jpg":
                case "jpeg":
                case "png":
                    $table_name = "image_files";
                    break;
                case "xlsx":
                    $table_name = "xlsx_files";
                    break;
                default:
                    echo "ไม่สามารถอัปโหลดไฟล์นี้ได้ เนื่องจากนามสกุลไม่ถูกต้อง";
                    exit;
            }
            
            // ระบุคำสั่ง SQL สำหรับบันทึกข้อมูลในฐานข้อมูล
            $uploaded_at = date("Y-m-d H:i:s");
            $uploaded_path = $target_file;
            $sql = "INSERT INTO $table_name (filename, path, uploaded_at) VALUES ('$new_filename', '$uploaded_path', '$uploaded_at')";
            
            if ($conn->query($sql) === TRUE) {
                header("Location: bordupload.php?upload_result=success");
            } else {
                header("Location: borduplocad.php?upload_result=error");
            }
            
            $conn->close();
        } else {
            header("Location: bordupload.php?upload_result=error");
        }
    }
}
?>