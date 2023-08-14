<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
    <link rel="stylesheet" type="test/css" href="css/styles.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>
<body>
    <?php
    session_start();
    include 'connectdb.php';

    if (isset($_GET["logout"])) {
        session_destroy();
        header("Location: login.php");
        exit();
    }

    if (!isset($_SESSION["user_id"])) {
        header("Location: login.php");
        exit();
    }

    $role = $_SESSION["user_type"];
    ?>

    
    
<header class="p-3 mb-3 border-bottom">
    <div class="container">
      <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
        <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 link-body-emphasis text-decoration-none">
        <img src="images/logo-pg-sidebar.png" alt="mdo" width="200" height="32" >
          <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap"><use xlink:href="#bootstrap"></use></svg>
        </a>
              <!--- แนบ ---> 
        <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
          <li><a href="#" class="nav-link px-2 link-secondary">ภาพรวม</a></li>
          <li><a href="#" class="nav-link px-2 link-body-emphasis">นโยบาย</a></li>
          <li><a href="#" class="nav-link px-2 link-body-emphasis">ช่วยเหลือ</a></li>
        </ul>
    
        <?php if ($role == "admin"): ?>
            <p class="text-uppercase">ส่วนจัดการระบบสำหรับ admin&nbsp;&nbsp;&nbsp;</p>
        <?php endif; ?>
        <?php if ($role == "user"): ?>
            <p class="text-uppercase">ส่วนจัดการระบบสำหรับ user&nbsp;&nbsp;&nbsp;</p>
        <?php endif; ?>

                    <!--- ค้นหา 
        <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3" role="search">
          <input type="search" class="form-control" placeholder="Search..." aria-label="Search">
        </form>--->
                    <!--- รูปในดรอปดาว --->
        <div class="dropdown text-end">
          <a href="#" class="d-block link-body-emphasis text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="images/testsimson.png" alt="mdo" width="40" height="32" class="rounded-circle">
          </a>
          <!--- ดรอปดาวขวาบน --->
          <ul class="dropdown-menu text-small" >
            <li><a class="dropdown-item" href="#"><?php echo $_SESSION["user_name"] . " " . $_SESSION["user_last_name"]; ?></a></li>
            <li><a class="dropdown-item" href="#">Settings</a></li>
            <li><a class="dropdown-item" href="#">Profile</a></li>
            <li><a class="dropdown-item" href="permition.php"><?php if ($role == "admin"): ?>
            <p class="text-uppercase">กำหนดสิทธ์การใช้งาน</p>

        <?php endif; ?> </a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="index.php?logout=true">Sign out</a></li>
          </ul>
        </div>
      </div>
    </div>
  </header>
    <div class="container">
        <h1>Welcome,คุณ <?php echo $_SESSION["user_name"] . " " . $_SESSION["user_last_name"]; ?></h1>
        <a href="bordupload.php">upload file</a>
    </div>
</body>
</html>
