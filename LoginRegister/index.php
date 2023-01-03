<?php
include('../Assets/config/config.php');

error_reporting(0);

if (isset($_SESSION["user_id"])) {
    header("Location:" . SITEURL . "index.php");
}


if (isset($_POST["register"])) {

    $username = mysqli_real_escape_string($conn, $_POST['register_username']);
	$email = mysqli_real_escape_string($conn, $_POST['register_email']);
	$telepon = mysqli_real_escape_string($conn, $_POST['register_telepon']);
	$password = mysqli_real_escape_string($conn, sha1($_POST['register_password']));
	$cpassword = mysqli_real_escape_string($conn, sha1($_POST['register_cpassword']));

    $check_email = mysqli_num_rows(mysqli_query($conn, "SELECT email FROM users WHERE email='$email'"));
    $check_telepon = mysqli_num_rows(mysqli_query($conn, "SELECT phone FROM users WHERE phone='$telepon'"));

    if($password !== $cpassword){
        echo "<script>alert('Password Tidak Sama.');</script>";
    } elseif ($check_email > 0) {
        echo "<script>alert('Email Telah Digunakan.');</script>";
    } elseif ($check_telepon > 0) {
        echo "<script>alert('No Handphone Telah Digunakan.');</script>";
    } else {
        $sql = "INSERT INTO users (username, email, phone, password) VALUES ('$username', '$email', '$telepon', '$password')";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            $_POST["register_username"] = "";
            $_POST["register_email"] = "";
            $_POST["register_telepon"] = "";
            $_POST["register_password"] = "";
            $_POST["register_cpassword"] = "";
            echo "<script>alert('Registrasi Berhasil.');</script>";
        } else {
            echo "<script>alert('Registrasi Tidak Berhasil.');</script>";
        }
    }
}

if (isset($_POST["login"])) {

    $email = mysqli_real_escape_string($conn, $_POST["login_email"]);   
    $password = mysqli_real_escape_string($conn, md5($_POST["login_password"]));

    $check_email = mysqli_query($conn, "SELECT id, email, username FROM users WHERE email='$email' AND password='$password'");

    if (mysqli_num_rows($check_email) > 0) {
        $row = mysqli_fetch_assoc($check_email);
        $_SESSION['id'] = $row['id'];
		$_SESSION['email'] = $row['email'];
		$_SESSION['username'] = $row['username'];
        header("Location: Welcome.php");
    } else {
        echo "<script>alert('Login Tidak Berhasil. Pastikan Email Dan Password Benar.');</script>";
    }
}

?>



<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login & Register</title>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
            integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w=="
            crossorigin="anonymous" referrerpolicy="no-referrer">

        <link rel="icon" href="Gambar/Logo.png">
        <link rel="stylesheet" href="style.css">
    </head>

    <body>

        <!----------< LOGIN >----------> 

            <div class="container">
                <div class="forms-container">
                    <div class="signin-signup">
                        <form action="" method="post" class="sign-in-form">
                            <h2 class="title">Login</h2>
                            <div class="input-field">
                                <i class="fas fa-user"></i>
                                <input type="email" placeholder="Email" name="login_email" value="<?php echo $_POST['login_email']; ?>" required>
                            </div>

                            <div class="input-field">
                                <i class="fas fa-lock"></i>
                                <input type="password" placeholder="Password" name="login_password" value="<?php echo $_POST['login_password']; ?>" minlength="8" required>
                            </div>
                                <input type="submit" value="Login" class="btn solid" name="login">
                                <p style="display: flex;justify-content: center;align-items: center;margin-top: 20px;"><a href="forgot-password.php" style="color: darkred;">Lupa Password?</a></p>
                        </form>

        <!----------< LOGIN >----------> 





        <!----------< REGISTER >----------> 

                        <form action="" class="sign-up-form" method="post">
                            <h2 class="title">Register</h2>
                            <div class="input-field">
                                <i class="fas fa-user"></i>
                                <input type="text" placeholder="Username" name="register_username" value="<?php echo $_POST["register_username"]; ?>" required>
                            </div>

                            <div class="input-field">
                                <i class="fas fa-envelope"></i>
                                <input type="email" placeholder="Email" name="register_email" value="<?php echo $_POST["register_email"]; ?>" required>
                            </div>

                            <div class="input-field">
                                <i class="fas fa-phone-alt"></i>
                                <input type="tel" placeholder="No Handphone" name="register_telepon" value="<?php echo $_POST["register_telepon"]; ?>"minlength="9" maxlength="14" required>
                            </div>

                            <div class="input-field">
                                <i class="fas fa-lock"></i>
                                <input type="password" placeholder="Password" name="register_password" value="<?php echo $_POST["register_password"]; ?>" minlength="8" required>
                            </div>

                            <div class="input-field">
                                <i class="fas fa-lock"></i>
                                <input type="password" placeholder="Confirm Password" name="register_cpassword" value="<?php echo $_POST["register_cpassword"]; ?>" minlength="8" required>
                            </div>

                                <input type="submit" class="btn solid" value="Register" name="register">
                        </form>
                    </div>
                </div>
        <!----------< REGISTER >----------> 





        <!----------< lOGIN & REGISTER PANEL >---------->

                <div class="panels-container">
                    <div class="panel left-panel">
                        <div class="content">
                            <h3>Belum Mempunyai Akun?</h3>
                            <p>Ayo buat akun sekarang! agar tidak tertinggal info terbaru dari kami.</p>
                            <button class="btn transparent" id="sign-up-btn">Register</button>
                        </div>
                    <img src="Gambar/login.png" class="image" alt="">
                    </div>

                    <div class="panel right-panel">
                        <div class="content">
                            <h3>Sudah Mempunyai Akun?</h3>
                            <p>Ayo login sekarang! dan jangan beritahu siapa siapa password anda 
                            hati hati banyak penipuan.</p>
                            <button class="btn transparent" id="sign-in-btn">Login</button>
                        </div>
                    <img src="Gambar/register.png" class="image" alt="">
                    </div>
                </div>
            </div>

        <!----------< lOGIN & REGISTER PANEL >---------->


        <script src="script.js"></script>

    </body>
</html>