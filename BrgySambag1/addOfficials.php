<?php
require 'connection.php';
include 'checkuser.php';

//uploading post
if (isset($_POST['submit'])) {
    $img = $_FILES['image']['name'];
    $name = $_POST['name'];
    $position = $_POST['position'];
    $term = $_POST['term'];
    // $committee = $_POST['comm'];
    // $comPosition = $_POST['comPosition'];

    //get commid from selected committee
    // $sql0 = "SELECT * FROM tblcomm WHERE CommName = '$committee'";
    // $commResult = mysqli_query($conn, $sql0);
    // $result = mysqli_fetch_array($commResult, MYSQLI_ASSOC);
    // $commid = $result['CommID'];

    // Move the uploaded file to a folder
    move_uploaded_file($_FILES['image']['tmp_name'], 'uploads/' . $img);

    // Insert the post into the database
    $sql1 = "INSERT INTO tblofficials VALUES ('', '$name', '$term', '$position', '$img');";
    if(mysqli_query($conn, $sql1)){
        $officialId = $conn->insert_id;
        ?> 
            <script> alert("Added Successfully") </script>
            <script>window.location.href = "officials.php"</script>
        <?php
        // $sql2 = "INSERT INTO tblofficialcom VALUES ('', '$commid', '$officialId', '$comPosition');";
    }
    else{echo '<script>alert("Something went wrong")<script>';}

    // if(mysqli_query($conn, $sql2)){
    //     header('location: officials.php');
    // }
    // else{echo '<script>alert("Something went wrong")<script>';}
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
        <h2 class="text-primary mb-1 font-xl">Add Official</h2>
            <form method="POST" enctype="multipart/form-data">
                <label>Name:</label>
                    <input type="text" name="name" required><br>
                <label>Position:</label>
                    <input type="text" name="position" required><br>
                <label>Term:</label>
                    <input type="text" name="term" required><br>
                <label>Profile Picture:</label>
                    <input type="file" name="image"><br>
                <input type="submit" name="submit" value="ADD"><br>
                    <a href="officials.php" class="back">BACK</a>
                </form>
            </div>
        </div>
<?php include 'nav/footer.php'; ?>

</body>
</html>