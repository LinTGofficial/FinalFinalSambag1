<?php
    require 'connection.php';
    require 'checkuser.php';
    $id = $_GET["id"];
    $back = '';

    $sql = "SELECT * FROM uploads WHERE uploadId = $id;";
    $result = mysqli_query($conn, $sql);
    $news = mysqli_fetch_array($result, MYSQLI_ASSOC);

    $title = $news["title"];
    $img = $news["img"];
    $desc = $news["description"];
    $category = $news["category"];

    
    if(isset($_POST["submit"])){
        $newTitle = $_POST['title'];
        $newDesc = $_POST['description'];
        $newCategory = $_POST['category'];
        
        
        //check if theres an img
        if (empty($_FILES['image']['name'])){
            $sql = "UPDATE uploads SET `Title`= '$newTitle', `description`= '$newDesc', `category`= '$newCategory' WHERE uploadId =".$id;
            
            if($result = mysqli_query($conn, $sql)){
                echo "<script> alert('Document Updated(Image not changed)'); window.location.href = 'news.php' </script>";
            }else {
                echo "Something went wrong. Please try again later.";
            }
            
        }else{
            $newImg = $_FILES['image']['name'];
            move_uploaded_file($_FILES['image']['tmp_name'], 'uploads/' . $img);
            $sql = "UPDATE uploads SET `Title`= '$newTitle', `description`= '$newDesc', `category`= '$newCategory', `img`= '$newImg' WHERE uploadId =".$id;

            if($result = mysqli_query($conn, $sql)){
                echo "<script> alert('Document Updated; window.location.href = 'news.php' </script>";
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
<div class="regContainer mt-2">
    <a onclick=history.back() class='backArrow mt-5'>
        <img src='drawable/backArrow.png' alt='back'>
    </a>
    <div class="newsbody mt-1" id="newsbody2">
        <div class="upload" id="upload">
        <a href="view.php?id=<?php echo $id?>"><div class="close-button" id="close-button">X</div></a>
        <h1>Edit Article</h1>
        <form method="POST" enctype="multipart/form-data">
            <label>Title:</label>
            <input type="text" name="title" id="title" value="<?php echo $title ?>" required>
            <label for="category">Category:</label>
            <select name="category" require>
                <option selected value="<?php echo $category ?>" style="display:none;"><?php echo $category ?></option>
                <option value="News">News</option>
                <option value="Activities">Activities</option>
                <option value="Announcements">Announcements</option>
            </select>
            <label class="mt-1">Description:</label>
            <textarea name="description" id="desc" required><?php echo $desc ?></textarea>
            <label>Image:</label>
            <input type="file" name="image">
            <input type="submit" name="submit" value="Submit">
        </form>
    </div>
</div>

</body>
</html>