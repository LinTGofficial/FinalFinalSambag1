<?php
    require 'connection.php';
    if(!$_SESSION['privilege']){
      header("Location: index.php");
      die;
    }else{
        include 'checkuser.php';
    }
    $id = $_GET["id"];

    $sql = "SELECT * FROM tbldocument WHERE docID = ".$id;
    $result = mysqli_query($conn, $sql);
    $doc = mysqli_fetch_array($result, MYSQLI_ASSOC);

    //setting variables
    $docname = $doc["docName"];
    $price = $doc["price"];

    //update function
    if(isset($_POST["submit"])){
        //updated data
        $newDocName = $_POST["docName"];
        $newPrice = $_POST["price"];

        $sql = "UPDATE tbldocument SET `docName`= '$newDocName', price = '$newPrice' WHERE docID =".$id;
        if($result = mysqli_query($conn, $sql)){
            echo "<script> alert('Document Updated')
              window.location.href='documentDtb.php'</script>";
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
        <label for="lastname"> Name:</label>
          <input type="text" name="docName" value="<?php echo $docname?>" placeholder="Last Name" required><br>
        <label for="sitio"> Price:</label>
          <input type="number" name="price" id="address" value="<?php echo $price?>" placeholder="Sitio" required><br>
        <button class="btn-primary text-white font-poppins-semibold" type="submit" name="submit"> Update </button><br>
        <a href="documentDtb.php"> Back </a>
    </div>
</div>
<?php include 'nav/footer.php'; ?>

</body>
</html>