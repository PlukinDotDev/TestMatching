<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="body">
    <?php
    session_start();
    include 'connectdb.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $user_email = $_POST["user_email"];
        $user_password = $_POST["user_password"];

        $sql = "SELECT * FROM users WHERE user_email = '$user_email' AND user_password = '$user_password'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $_SESSION["user_id"] = $row["user_id"];
            $_SESSION["user_name"] = $row["user_name"];
            $_SESSION["user_last_name"] = $row["user_last_name"];
            $_SESSION["user_type"] = $row["user_type"];
            header("Location: index.php");
            exit();
        } else {
            echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'เกิดข้อผิดพลาด!',
                        text: 'อีเมลหรือรหัสผ่านไม่ถูกต้อง',
                    });
                  </script>";
        }

        $conn->close();
    }
    ?>       
</body>
<body>
<form action="" method="post">

    <!----------------------- Main Container -------------------------->

     <div class="container d-flex justify-content-center align-items-center min-vh-100">

    <!----------------------- Login Container -------------------------->

       <div class="row border rounded-5 p-3 bg-white shadow box-area">

    <!--------------------------- Left Box ----------------------------->

       <div class="col-md-6 rounded-4 d-flex justify-content-center align-items-center flex-column left-box" style="background: #CFD8F2;">
           <div class="featured-image mb-3">
            <img src="images/PG.png" class="img-fluid" style="width: 250px;">
           </div>
           <p class="text-white fs-2" style="font-family: 'Courier New', Courier, monospace; font-weight: 600;"></p>
           <small class="text-white text-wrap text-center" style="width: 17rem;font-family: 'Courier New', Courier, monospace;"></small>
       </div> 

    <!-------------------- ------ Right Box ---------------------------->
        
       <div class="col-md-6 right-box">
          <div class="row align-items-center">
                <div class="header-text mb-4">
                     <h2>ระบบหลังบ้าน PG </h2>
                     <p>PG Estated Development Company Limited</p>
                </div>
                <div class="input-group mb-3">
                    <input type="email" class="form-control form-control-lg bg-light fs-6" id="user_email" name="user_email"placeholder="Email address" required><br>
                </div>
                <div class="input-group mb-1">
                    <input type="password" class="form-control form-control-lg bg-light fs-6" placeholder="Password" id="user_password" name="user_password" required><br>
                </div>
                <div class="input-group mb-5 d-flex justify-content-between">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="formCheck">
                        <label for="formCheck" class="form-check-label text-secondary"><small>Remember Me</small></label>
                    </div>
                    <!--<div class="forgot">
                       <small><a href="#">Forgot Password?</a></small>
                    </div> --->
                </div>
                <div class="input-group mb-3">
                    <button type="submit" class="btn btn-lg btn-primary w-100 fs-6">Login</button>
                </div>
                
                
          </div>
       </div> 

      </div>
    </div>
</form>
</body>
</html>


