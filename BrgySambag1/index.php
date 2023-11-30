<?php
require 'connection.php';
require 'checkuser.php';
error_reporting(E_ERROR | E_PARSE);
session_start();

$sql = "SELECT * FROM article ORDER BY uploadId DESC LIMIT 4";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <!-- <link rel="stylesheet" type="text/css" href="style.css"> -->
    <title>Document</title>
</head>
<body>
    <section class="section">
        <h1 class="header" id="one">CHANGE HAS COME TO<br></h1>
        <h1 class="header2">BARANGAY SAMBAG 1</h1>
    </section>
    <section class="section2" id="news">
        <h1 class="mb-2 font-xl home_news">LATEST NEWS, ANNOUNCEMENTS AND ACTIVITIES</h1>
        <div class="ln_bg">
        <?php
            while($row = mysqli_fetch_assoc($result)){?>
                <a href="viewNews.php?id=<?php echo $row['uploadId'] ?>" class="news_card">
                    <img src="uploads/<?php echo $row['img'] ?>" alt="img">
                    <div class="desc">
                        <h1 class="text-primary"><?php echo $row['title'] ?></h1>
                        <p class="date"><?php echo $row['uploadDate'] ?></p>
                        <p><?php echo $row['description'] ?></p>
                    </div>
                </a>
        <?php } ?>
            
        </div>
        <a href="news.php" class="btn-primary text-white font-md" id="vm">View more →</a>
    </section>
<?php include 'nav/footer.php'; ?>
</body>
</html>