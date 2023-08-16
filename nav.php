<!-- nav.php -->
<header class="p-3 mb-3 border-bottom">
    <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
            <a href="index.php" class="d-flex align-items-center mb-2 mb-lg-0 link-body-emphasis text-decoration-none">
                <img src="images/logo-pg-sidebar.png" alt="mdo" width="200" height="32">
                <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap"><use xlink:href="#bootstrap"></use></svg>
            </a>
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
            <div class="dropdown text-end">
                <a href="#" class="d-block link-body-emphasis text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="images/testsimson.png" alt="mdo" width="40" height="32" class="rounded-circle">
                </a>
                <ul class="dropdown-menu text-small">
                    <li><a class="dropdown-item" href="#"><?php echo $_SESSION["user_name"] . " " . $_SESSION["user_last_name"]; ?></a></li>
                    <li><a class="dropdown-item" href="#">Settings</a></li>
                    <li><a class="dropdown-item" href="#">Profile</a></li>
                    <li><a class="dropdown-item" href="permition.php">
                        <?php if ($role == "admin"): ?>
                            <p class="text-uppercase">กำหนดสิทธ์การใช้งาน</p>
                        <?php endif; ?>
                    </a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="index.php?logout=true">Sign out</a></li>
                </ul>
            </div>
        </div>
    </div>
</header>
