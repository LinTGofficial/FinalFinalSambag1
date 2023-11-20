<?php
    require 'connection.php';
    include 'checkuser.php';

    $id = $_GET["id"];

    $sql = "SELECT * FROM users WHERE id = '$id'";
    $result = mysqli_query($conn, $sql);
    $acc = mysqli_fetch_array($result, MYSQLI_ASSOC);

    //setting variables
    $lastname = $acc["lastname"];
    $middlename = $acc["middleName"];
    $firstname = $acc["firstname"];
    $age = $acc["age"];
    $city = $acc["city"];
    $barangay = $acc["barangay"];
    $sitio = $acc["sitio"];
    $houseNo = $acc["houseNo"];
    $street = $acc["street"];
    $email = $acc["email"];

    //update function
    if(isset($_POST["submit"])){
        //updated data
        $newlastname = $_POST["lastname"];
        $newmiddlename = $_POST["middlename"];
        $newfirstname = $_POST["firstname"];
        $newcity = $_POST["city"];
        $newbarangay = $_POST["barangay"];
        $newsitio = $_POST["sitio"];
        $newhouseNo = $_POST["houseNo"];
        $newstreet = $_POST["street"];
        $newage = $_POST["age"];

        $sql = "UPDATE users SET 
          lastname= '$newlastname', 
          middleName= '$newmiddlename', 
          firstname= '$newfirstname', 
          city= '$newcity', 
          barangay= '$newbarangay', 
          sitio= '$newsitio', 
          houseNo= '$newhouseNo', 
          street= '$newstreet', 
          age= $age WHERE id =" .$id;
        if($result = mysqli_query($conn, $sql)){
            $_SESSION['username'] = $acc['username'];
            $_SESSION['name'] = $newfirstname . ' ' . $newlastname;
            header("Location: profile.php");
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
<div class="regContainer cont-l">
    <div class="register">
      <h1>EDIT</h1>
        <form method="POST">
        <label for="lastname"> Name:</label>
          <input type="text" name="lastname" value="<?php echo $lastname?>" placeholder="Last Name" required><br>
          <input type="text" name="middlename" value="<?php echo $middlename?>" placeholder="Middle Name" required><br>
          <input type="text" name="firstname" value="<?php echo $firstname?>" placeholder="First Name" required><br>
        <label for="lastname"> Age:</label>
          <input type="text" name="age" value="<?php echo $age?>" placeholder="Age" required><br>
        <label for="sitio"> Address:</label>
          <input type="text" name="city" value="<?php echo $city?>" placeholder="City" class="address" required><br>
          <input type="text" name="barangay" value="<?php echo $barangay?>" placeholder="Barangay" class="address" required><br>
          <input type="text" name="sitio" value="<?php echo $sitio?>" placeholder="Sitio" class="address" required><br>
          <input type="text" name="houseNo" value="<?php echo $houseNo?>" placeholder="House No." class="address" required><br>
          <input type="text" name="street" value="<?php echo $street?>" placeholder="Street" class="address" required><br>
        <label for="birthdate"> Email:</label>
          <input type="text" name="email" value="<?php echo $email?>" class="address" required><br>
        <button type="submit" name="submit"> UPDATE </button><br>
        <a href="profile.php"> Cancel </a>
    </div>
</div>
<?php include 'nav/footer.php'; ?>

</body>
</html>