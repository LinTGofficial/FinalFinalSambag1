<?php
    require 'connection.php';
    include 'checkuser.php';
    $userId = $_GET["id"];

    $sql = "SELECT * FROM users WHERE id = '$userId'";
    $result = mysqli_query($conn, $sql);
    $acc = mysqli_fetch_array($result, MYSQLI_ASSOC);

    $lastname = $acc["lastname"];
    $middlename = $acc["middleName"];
    $firstname = $acc["firstname"];
    $email = $acc["email"];
    $password = $acc["password"];

    if(isset($_POST["submit"])){
        $newlastname = $_POST["lname"];
        $newmiddlename = $_POST["mname"];
        $newfirstname = $_POST["fname"];
        $newemail = $_POST["email"];
        $newpass = $_POST['pass'];

        if($newpass == ""){
            //without password reset
            $sql = "UPDATE users SET lastname= '$newlastname',firstname= '$newfirstname', `middleName`= '$newmiddlename', `email` = '$newemail' WHERE id =" .$userId;
            if($result = mysqli_query($conn, $sql)){
                echo "<script> alert('Admin Updated');
                    window.location.href='adminDtb.php';</script>";
            }else {
                echo "Something went wrong. Please try again later.";
           }
        } else {
            if($newpass == $_POST['conPass']){
                if(strlen($newpass) >= 8){
                    //with password reset
                    $sql = "UPDATE users SET lastname= '$newlastname',firstname= '$newfirstname', `middleName`= '$newmiddlename', `email` = '$newemail', `password` = md5('$newpass') WHERE id =" .$userId;
                    if($result = mysqli_query($conn, $sql)){
                        echo "<script> alert('Admin Updated');
                            window.location.href='adminDtb.php';</script>";
                    }else {
                        echo "<script> alert('Something went wrong...');
                            history.go(-1);</script>";
                    }
                } else {
                    echo "<script> alert('Password must be at least 8 characters long');
                        history.go(-1)</script>";
                }
            } else {
                echo "<script> alert('Password didnt match');
                    history.go(-1);</script>";
            }
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
<div class="regContainer mt-4">
    <div class="register">
      <h1>EDIT</h1>
        <form method="POST">
        <label> Name:</label>
            <input type="text" name="fname" value="<?php echo $firstname?>" placeholder="First Name" required><br>
            <input type="text" name="mname" value="<?php echo $middlename?>" placeholder="Middle Name" required><br>
          <input type="text" name="lname" value="<?php echo $lastname?>" placeholder="Last Name" required><br>
          <label> Email:</label>
          <input type="text" name="email" value="<?php echo $email?>" placeholder="Last Name" class="mb-2" required><br>
        <label>Change Password(optional):</label>
          <input type="password" name="pass" id="password" placeholder="Password must be at least 8 characters long"><br>
          <input type="checkbox" onclick="myFunction()" id="showpass"> Show Password </input><br>
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
        <label>Confirm Password:</label>
          <input type="password" name="conPass" id="address"><br>
          <button type="submit" name="submit" class="btn-primary"> UPDATE </button><br>
          <a href="adminDtb.php"> Cancel </a>
        </form>
    </div>
</div>
<?php include 'nav/footer.php'; ?>

</body>
</html>