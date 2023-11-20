<?php
include 'connection.php';
session_start();
$id = $_SESSION['id'];

//uploading post
if (isset($_POST['submit'])) {
    $img = $_FILES['image']['name'];
    $title = $_POST['title'];
    $description = $_POST['description'];

    // Move the uploaded file to a folder
    move_uploaded_file($_FILES['image']['tmp_name'], 'uploads/' . $img);

    // Insert the post into the database
    $sql = "INSERT INTO uploads VALUES ('$id', '$img', '$title', '$description')";
    mysqli_query($conn, $sql);
}

// Retrieve all the posts from the database
$sql = "SELECT * FROM uploads";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Upload</h1>
    <form method="POST" enctype="multipart/form-data">
        <label>Title:</label>
        <input type="text" name="title" required><br>
        <label>Description:</label>
        <textarea name="description" required></textarea><br>
        <label>Image:</label>
        <input type="file" name="image" required><br>
        <input type="submit" name="submit" value="Post">
    </form>
    <!-- Display all the posted posts -->
    <h2>Posted Posts:</h2>
    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <div>
            <h3><?php echo $row['title']; ?></h3>
            <p><?php echo $row['description']; ?></p>
            <img src="uploads/<?php echo $row['img']; ?>" alt="Post Image" width="200px">
        </div>
    <?php } ?>
<?php include 'nav/footer.php'; ?>

</body>
</html>