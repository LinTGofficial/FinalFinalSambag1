<?php
    require 'connection.php';
    include 'checkuser.php';

    $userid = $_GET["id"];

    $sql = "SELECT * FROM users WHERE userID = '$userid'";
    $result = mysqli_query($conn, $sql);
    $acc = mysqli_fetch_array($result, MYSQLI_ASSOC);

    //setting variables
    $email = $acc["email"];

    //update function
    if(isset($_POST["submit"])){
        //updated data
        $newemail = $_POST["email"];

        $sql = "UPDATE users SET email = '$newemail' WHERE userID = " .$userid;
        if($result = mysqli_query($conn, $sql)){
            $_SESSION['username'] = $acc['username'];
            $_SESSION['name'] = $newfirstname . ' ' . $newlastname;
            echo"<script> alert('Email Updated');
              window.location.href='profile.php'; </script>";
            die;
        }else {
            echo "Something went wrong. Please try again later.";
       }}
        
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
      <h1>EDIT</h1>
        <form method="POST">
        <label for="birthdate"> Email:</label>
          <input type="text" name="email" value="<?php echo $email?>" class="address" required><br>
        <button type="submit" name="submit"> UPDATE </button><br>
        <a href="profile.php"> Cancel </a>
    </div>
</div>
<?php include 'nav/footer.php'; ?>

</body>
</html>