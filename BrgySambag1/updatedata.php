<?php
    require 'connection.php';
    include 'checkuser.php';
    $id = $_GET["id"];

    $sql = "SELECT * FROM users WHERE id = '$id'";
    $result = mysqli_query($conn, $sql);
    $acc = mysqli_fetch_array($result, MYSQLI_ASSOC);

    //setting variables
    $lastname = $acc["lastname"];
    $firstname = $acc["firstname"];
    $sitio = $acc["sitio"];
    $houseNo = $acc["houseNo"];
    $birth = $acc["birthdate"];

    //update function
    if(isset($_POST["submit"])){
        //updated data
        $newlastname = $_POST["lastname"];
        $newfirstname = $_POST["firstname"];
        $newhouseNo = $_POST["houseNo"];
        $newsitio = $_POST["sitio"];
        $newbirthdate = $_POST["birthdate"];
        $date = DateTime::createFromFormat('Y-m-d', $newbirthdate);
        
        // calculate age
        $currentDate = new DateTime();
        $age = $date->diff($currentDate)->y;

        $sql = "UPDATE users SET lastname= '$newlastname',firstname= '$newfirstname', `houseNo`= '$newhouseNo', `sitio`= '$newsitio', birthdate= '$newbirthdate', age= $age WHERE id =" .$id;
        if($result = mysqli_query($conn, $sql)){
            header("Location: database.php");
            die;
        }else {
            echo "Something went wrong. Please try again later.";
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
      <h1>EDIT</h1>
        <form method="POST">
        <label for="lastname"> Name:</label>
          <input type="text" name="lastname" value="<?php echo $lastname?>" placeholder="Last Name" required><br>
          <input type="text" name="firstname" value="<?php echo $firstname?>" placeholder="First Name" required><br>
          <label for="lastname"> Address:</label>
          <input type="text" name="sitio" id="address" value="<?php echo $sitio?>" placeholder="Sitio" required><br>
          <input type="text" name="houseNo" id="address" value="<?php echo $houseNo?>" placeholder="House No." required><br>
          <label for="birthdate"> Birthdate:</label>
          <input type="date" name="birthdate" value="<?php echo $birth?>"required><br>
          <button type="submit" name="submit"> UPDATE </button><br>
          <a href="database.php"> Cancel </a>
        </form>
    </div>
</div>
<?php include 'nav/footer.php'; ?>

</body>
</html>