<?php
    require 'connection.php';
    include 'checkuser.php';
    $residentID = $_GET["id"];

    $sql = "SELECT * FROM tblresidents WHERE residentID = '$residentID'";
    $result = mysqli_query($conn, $sql);
    $acc = mysqli_fetch_array($result, MYSQLI_ASSOC);

    $vin = $acc["VIN"];
    $lastname = $acc["lName"];
    $middlename = $acc["mName"];
    $firstname = $acc["fName"];
    $status = $acc['civilStatus'];
    $sitio = $acc['sitio'];
    $houseNo = $acc['houseNo_Street'];

    if(isset($_POST["submit"])){
        $newvin = $_POST["vin"];
        $newlastname = $_POST["lname"];
        $newmiddlename = $_POST["mname"];
        $newfirstname = $_POST["fname"];
        $newstatus = $_POST['status'];
        $newsitio = $_POST['sitio'];
        $newhouseNo = $_POST['houseNo'];

        $sql = "UPDATE tblresidents SET VIN = '$newvin', lName= '$newlastname',fName= '$newfirstname', `mName`= '$newmiddlename', `civilStatus` = '$newstatus', `sitio` = '$newsitio', `houseNo_Street` = '$newhouseNo' WHERE residentID =" .$residentID;
        if($result = mysqli_query($conn, $sql)){
            echo "<script> alert('Resident Updated');
                window.location.href='residentsDtb.php';</script>";
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
<div class="regContainer mt-4">
    <div class="register mt-2 mb-2">
      <h1>EDIT</h1>
        <form method="POST">
        <label>VIN:</label>
            <input type="text" name="vin" class="mb-1" value="<?php echo $vin?>" required>
        <label> Name:</label>
            <input type="text" name="fname" value="<?php echo $firstname?>" placeholder="First Name" required><br>
            <input type="text" name="mname" value="<?php echo $middlename?>" placeholder="Middle Name (optional)"><br>
            <input type="text" name="lname" value="<?php echo $lastname?>" class="mb-1" placeholder="Last Name" required><br>
        <label>Civil Status:</label>
            <select name="status" class="mb-2" style="font-size:18px;">
                <option selected value="<?php echo $status?>" style="display:none;"><?php echo $status?></option>
                <option value="Single">Single</option>
                <option value="Married">Married</option>
                <option value="Divorced">Divorced</option>
                <option value="Widowed">Widowed</option>
            </select>
        <label>Address:</label>
                <input type="text" name="sitio" value="<?php echo $sitio?>" placeholder="Sitio" required><br>
                <input type="text" name="houseNo" value="<?php echo $houseNo?>" placeholder="House No. & Street" class="mb-2" required>
        <button type="submit" name="submit" class="btn-primary"> UPDATE </button><br>
        <a href="residentsDtb.php"> Cancel </a>
        </form>
    </div>
</div>
<?php include 'nav/footer.php'; ?>

</body>
</html>
