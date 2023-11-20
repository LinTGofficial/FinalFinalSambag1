<?php
    include 'connection.php';
    include 'checkuser.php';

    //get id of the article
    $id = $_GET['id'];
    

    // Retrieve all the posts from the database
    $sql = "SELECT * FROM uploads WHERE uploadId = ". $id;
    $result = mysqli_query($conn, $sql);
    $info = mysqli_fetch_array($result, MYSQLI_ASSOC);

    $category = $info['category'];
    $title = $info['title'];
    $date = $info['uploadDate'];
    $img = $info['img'];
    $description = $info['description'];
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
    <div class="view_news">
        <h2 style=color:<?php switch($category){
            case 'News': echo '#7295BD;'; break;
            case 'Activities': echo '#BD7272;'; break;
            case 'Announcements': echo '#72BD90;'; break;
        } ?>><?php echo $category ?></h2>
        <h1 class="text-primary"><?php echo $title ?></h1>
        <p class="date"><?php echo $date ?></p>
        <img src="uploads/<?php echo $img ?>" alt="img">
        <p class="view-desc"><?php echo $description ?></p>
        <a href="news.php" style="backgorund:black;" class="btn-primary text-white m-2">← Back</a>

        <!-- actions of Admins -->
        <?php
            if(isset($privilege) && $privilege){?>
            <div class="actions-news">
                <a href="updateNews.php?id=<?php echo $id ?>" class="btn-edit">
                    <img src="drawable/edit.png" alt="edit">
                </a>
                <a onclick="javascript: return confirm('Confirm deletion?');" 
                    href="deletenews.php?id=<?php echo $id ?>" class="btn-delete">
                    <img src="drawable/delete.png" alt="delete">
                </a>
            </div>
            <?php }
        ?>
    </div>
<?php include 'nav/footer.php'; ?>

</body>
</html>