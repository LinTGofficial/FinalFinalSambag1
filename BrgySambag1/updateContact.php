<?php
    require 'connection.php';
    require 'checkuser.php';
    $id = $_GET["id"];

    $sql = "SELECT * FROM tblbrgycontact WHERE BrgyContactID = $id";
    $result = mysqli_query($conn, $sql);
    $doc = mysqli_fetch_array($result, MYSQLI_ASSOC);

    $name = $doc["ContactName"];
    $contact = $doc["ContactInfo"];

    if(isset($_POST["submit"])){
        $newName = $_POST["name"];
        $newContact = $_POST["contact"];

        $sql = "UPDATE tblbrgycontact SET `ContactName`= '$newName', `ContactInfo` = '$newContact' WHERE BrgyContactID =".$id;
        if($result = mysqli_query($conn, $sql)){
            echo "<script> alert('Contact Updated')
                history.go(-2)</script>";
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
      <h1>EDIT CONTACT</h1>
        <form method="POST">
            <label for="lastname"> Name:</label>
            <input type="text" name="name" value="<?php echo $name?>"required><br>
            <label for="sitio"> Contact No./Info.:</label>
            <input type="text" name="contact" value="<?php echo $contact?>"required><br>
            <button type="submit" name="submit"> UPDATE </button><br>
        </form>
        <a href="contactDtb.php"> Back </a>
    </div>
</div>
<?php include 'nav/footer.php'; ?>

</body>
</html>