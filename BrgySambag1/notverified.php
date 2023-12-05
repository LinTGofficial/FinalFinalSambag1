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

$userID = $_GET['id'];

//delete all the tokens thats xpired
$DateTime = new DateTime();
$modified = $DateTime->modify('-90 seconds');
$time = $DateTime->format('Y-m-d H:i:s');

$deletesql = "DELETE FROM tbltoken WHERE expiration < '$time'";
$deletequery = mysqli_query($conn, $deletesql);

  if(isset($_POST["submitToken"])){
    $email = $_SESSION['email'];

    $sql = "SELECT * FROM users WHERE email = '$email'";
    $query = mysqli_query($conn, $sql);

    if(mysqli_num_rows($query) != 1){
        echo"<script>alert('Theres no account with this email')</script>";
    }else{
      $result = mysqli_fetch_assoc($query);
      $userID = $result['userID'];
      $token = md5(generateToken());
      $dateTime = new DateTime();
      $dateTime->modify('+90 seconds');
      $expiration = $dateTime->format('Y-m-d H:i:s');

      $mail->addAddress($email, $email);
      $mail->Body = "Click this link to verify your account: <a href='localhost/brgysambag1/verify.php?token=$token'>CLICK HERE</a>";
  
      $tokenSql = "INSERT INTO tbltoken values('', '$userID', '$token', '$expiration')";
      if (mysqli_query($conn, $tokenSql) && $mail->send()) {
          echo "<script>alert('Email sent, Please check your email');
            window.location.href='index.php'</script>";
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
  <div class="regContainer">
    <div class="register">
      <a href="index.php" class='backArrow'>
        <img src='drawable/backArrow.png' alt='back'>
      </a>
      <form method="POST">
        <h1>You account is not yet verified</h1>
        <div class="verify">
          <label for="submitToken">Did not recieve an email?</label>
          <button type="submit" name="submitToken" class="btn_primary"> RESEND EMAIL </button><br>
        </div>
      </form>
    </div>
  </div>
  
<?php include 'nav/footer.php'; ?>

</body>
</html>