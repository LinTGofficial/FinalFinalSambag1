<?php
    require 'connection.php';
    include 'checkuser.php';
    $id = $_GET["id"];

    $sql = "SELECT * FROM users WHERE userID = '$id'";
    $result = mysqli_query($conn, $sql);
    $acc = mysqli_fetch_array($result, MYSQLI_ASSOC);

    //setting variables
    $pass = $acc["password"];
    
    //update function
    if(isset($_POST["submit"])){
      $currentpass = $_POST["currentpass"];
      $newpass = $_POST["newpass"];
      $confirmpass = $_POST["confirmpass"];

      if($pass == md5($currentpass) && $newpass == $confirmpass){
        $sql = "UPDATE users SET `password`= MD5('$newpass') WHERE userID =".$id;
        $result = mysqli_query($conn, $sql);
        echo "<script> alert('Password Changed')
          window.location.href='profile.php'</script>";
      }else{
        echo "<script> alert('Current password incorrect or Password didnt match') </script>";
      }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <title>Document</title>
</head>
<body>
<div class="regContainer">
    <div class="register">
      <h1>CHANGE PASSWORD</h1>
        <form method="POST">
        <label for="lastname"> Current Password:</label>
          <input type="password" name="currentpass" required><br>

        <label for="pass"> New Password:</label>
        <input type="password" name="newpass" placeholder="Password" id="password" required><br>
          <input type="checkbox" onclick="myFunction()" id="showpass"> Show Password </input>
          <script>
            function myFunction() {
              var x = document.getElementById("password");
              if (x.type === "password") {
                x.type = "text";
              } else {
                x.type = "password";
              }
            }
          </script>
          <label for="confirmpass"> Confirm Password: </label>
          <input type="password" name="confirmpass" placeholder="Re-enter Password" required><br>

        <button type="submit" name="submit"> UPDATE </button><br>
        <a href="profile.php"> Cancel </a>
    </div>
</div>
<?php include 'nav/footer.php'; ?>

</body>
</html>