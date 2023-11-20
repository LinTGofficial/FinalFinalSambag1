<?php 
//checking database connection
require 'connection.php';
include 'checkuser.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';
require 'PHPMailer-master/src/Exception.php';

//For emailing
$mail = new PHPMailer\PHPMailer\PHPMailer();
include 'PHPMailer-master/mailer.php';

if(isset($_POST["submitToken"])){
    $email = $_POST['email'];

    $sql = "SELECT * FROM users WHERE email = '$email'";
    $query = mysqli_query($conn, $sql);

    if(mysqli_num_rows($query) != 1){
        echo"<script>alert('Theres no account with this email')</script>";
    }else{
        $result = mysqli_fetch_assoc($query);
        $userID = $result['id'];
        $token = md5(generateToken());
        $dateTime = new DateTime();
        $dateTime->modify('+90 seconds');
        $expiration = $dateTime->format('Y-m-d H:i:s');

        $mail->addAddress($email, $email);
        $mail->Body = "Click this link to renew your password: <a href='localhost/brgysambag1/resetPass.php?token=$token'>CLICK HERE</a>";
    
        $tokenSql = "INSERT INTO tbltoken values('', '$userID', '$token', '$expiration')";
        if (mysqli_query($conn, $tokenSql) && $mail->send()) {
            echo "<script>alert('Email sent, Please check your email');
              window.location.href='login.php'</script>";
        } else {
            echo 'Email sending failed: ' . $mail->ErrorInfo;
        }
    }
}

function generateToken(){
    $genToken = bin2hex(random_bytes(16));
    return $genToken;
}

?>
<!DOCTYPE html>
<html>
<head>
  <title>User Registration</title>
  <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
  <!-- <link rel="stylesheet" type="text/css" hresf="style.css"> -->
</head>
<body>
  <div class="regContainer mt-3">
  <a href="login.php" class='backArrow mt-3'>
    <img src='drawable/backArrow.png' alt='back'>
  </a>
    <div class="register">
        <form method="POST">
          <div class="reg-inputs">
            <label for="email">Enter your email:</label>
            <input type="text" name="email" required><br>
            <button type="submit" name="submitToken" class="btn-primary text-white"> SEND EMAIL </button><br>
          </div>
        </form>
    </div>
</div>

<?php include 'nav/footer.php'; ?>

</body>
</html>