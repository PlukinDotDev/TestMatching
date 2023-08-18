<?php
session_start();
include 'connectdb.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$role = $_SESSION["user_type"];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>
<body>
    <?php include 'nav.php'; ?>
    
    <div class="container">
        <h1>Welcome, <?php echo $_SESSION["user_name"] . " " . $_SESSION["user_last_name"]; ?></h1>
        <a class="btn btn-primary" href="upload.php">Upload File</a>
        
        <?php if ($role == "admin"): ?>
            <a class="btn btn-primary" href="view_files.php">View</a>
        <?php endif; ?>
    </div>
</body>
</html>
