<?php
    require 'connection.php';
    require 'checkuser.php';
    $id = $_GET["id"];

    $sql = "SELECT * FROM tblofficials WHERE OfficialID = $id;";
    $result = mysqli_query($conn, $sql);
    $off = mysqli_fetch_array($result, MYSQLI_ASSOC);

    $name = $off["Name"];
    $position = $off["Position"];
    $term = $off["Term"];

    
    if(isset($_POST["submit"])){
        $newname = $_POST['name'];
        $newposition = $_POST['position'];
        $newterm = $_POST['term'];
        
        //check if theres an img
        if (empty($_FILES['image']['name'])){
            $sql = "UPDATE tblofficials SET `Name`= '$newname', `Term`= '$newterm', `Position`= '$newposition' WHERE OfficialID =".$id;
            
            if($result = mysqli_query($conn, $sql)){
                echo "<script> alert('Official Updated(Image not changed)');
                    history.go(-2);</script>";
            }else {
                echo "Something went wrong. Please try again later.";
            }
            
        }else{
            $img = $_FILES['image']['name'];
            move_uploaded_file($_FILES['image']['tmp_name'], 'uploads/' . $img);
            $sql = "UPDATE tblofficials SET `Name`= '$newname', `Term`= '$newterm', `Position`= '$newposition', `OfficialPic`= '$img' WHERE OfficialID =".$id;

            if($result = mysqli_query($conn, $sql)){
                echo "<script> alert('Official Updated');
                    history.back();</script>";
            }else {
                echo "Something went wrong. Please try again later.";
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
<div class="regContainer">
    <div class="register">
      <h1>EDIT</h1>
        <form method="POST" enctype="multipart/form-data">
        <label> Name:</label>
          <input type="text" name="name" value="<?php echo $name;?>" required><br>
        <label>Position:</label>
            <input type="text" name="position" value="<?php echo $position;?>" required><br>
        <label>Term:</label>
            <input type="text" name="term" value="<?php echo $term;?>" required><br>
        <label>Profile Picture:</label>
            <input type="file" name="image" id="image"><br>
        <button type="submit" name="submit"> UPDATE </button><br>
        <a onclick="history.back()"> Back </a>
    </div>
</div>
<?php include 'nav/footer.php'; ?>

</body>
</html>