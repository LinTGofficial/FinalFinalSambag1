<?php
// error_reporting(E_ERROR | E_PARSE);

include 'connection.php';
include 'checkuser.php';

$currentDate = new DateTime();
$date = $currentDate->format('Y-m-d H:i:s');

//uploading post
if (isset($_POST['submit'])) {
    $img = $_FILES['image']['name'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $category = $_POST['category'];

    move_uploaded_file($_FILES['image']['tmp_name'], 'uploads/' . $img);

    $sql = "INSERT INTO uploads VALUES ('', '$id', '$date', '$img', '$title', '$description', '$category')";
    mysqli_query($conn, $sql);
}

$selectedCategory = '';

if (isset($_POST['submit2'])) {
    $selectedCategory = $_POST['categoryFilter'];

    $sql2 = "SELECT * FROM uploads";
    if (!empty($selectedCategory)) {
        $sql2 .= " WHERE category = '$selectedCategory' ";
    }
    $sql2 .= " ORDER BY uploadId DESC";

    $result2 = mysqli_query($conn, $sql2);
} else {
    $sql2 = "SELECT * FROM uploads ORDER BY uploadId DESC";
    $result2 = mysqli_query($conn, $sql2);
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
    <?php
        if(isset($privilege) && $privilege){
            ?>
            <!-- admin actions -->
            
            <div class="newsbody" id="newsbody">
                <div class="upload" id="upload">
                    <div class="m-1 close-button" id="close-button"><img src="drawable/x.png"></div>
                    <h1 class="m-1 text-primary">Add Article</h1>
                    <form class="m-2" method="POST" enctype="multipart/form-data">
                        <label>Title:</label>
                        <input type="text" name="title" id="title" required>
                        <label class="mt-1" for="category">Category:</label>
                        <select name="category" require>
                            <option value="News">News</option>
                            <option value="News">Activities</option>
                            <option value="Announcements">Announcements</option>
                        </select>
                        <label class="mt-1">Description:</label>
                        <textarea name="description" id="desc" required></textarea>
                        <label class="mt-1">Image:</label>
                        <input type="file" name="image" required>
                        <input class="btn-primary text-white" type="submit" name="submit" value="Submit">
                    </form>
                </div>

            <?php
                }else{}
            ?>
        </div>

        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const toggleButton = document.getElementById("toggleAdd");
                const elementToToggle = document.getElementById("newsbody");
                const closeButton = document.getElementById("close-button");

                toggleButton.addEventListener("click", function () {
                    if (elementToToggle.style.display === "none" || elementToToggle.style.display === "") {
                        elementToToggle.style.display = "flex";
                    } else {
                        elementToToggle.style.display = "none";
                    }
                });

                closeButton.addEventListener("click", function () {
                    elementToToggle.style.display = "none";
                });
            });
        </script>


        <!-- the posts -->
        <div class="off-title mt-3">
        <h1 class="mt-3 text-secondary font-xxl">News and Announcements</h1>
        </div>
    <div class="filter">
        <img class="pt-1" src="drawable/filter.png" alt="Filter">
            <label class="p-1 font-poppins-medium">Filter</label>
            <form class="w-flex" method="POST" enctype="multipart/form-data">
            <select class="dropdown" name="categoryFilter">
                 <option value="">All</option>
                 <option value="News">News</option>
                 <option value="Activities">Activities</option>
                 <option value="Announcements">Announcements</option>
                </select>
                <button class="btn-primary ml-1 font-poppins-medium text-white" type="submit" name="submit2">Apply</button>
        </form>
        <?php
            if(isset($privilege) && $privilege){
        ?>
            <div class="btn-primary ml-1 font-poppins-medium filter-add">
                <input type="checkbox" id="toggleAdd">
                <label for="toggleAdd">+ Add Article</label>
            </div>
        <?php
            }else{}
        ?>
    </div>

    <div class="news">
        <?php while ($row = mysqli_fetch_assoc($result2)) { ?>
            <div class="news_card2">
                <a href="viewNews.php?id=<?php echo $row['uploadId'] ?>" class="view">Read Article  <img src="drawable/view.png" alt="Read Article"></a>
                <img src="uploads/<?php echo $row['img']; ?>" alt="Post Image">
                <div class="desc2">
                    <h2><?php echo $row['title']; ?></h2>
                    <p class="date"><?php echo $row['uploadDate'] ?></p>
                    <div class="description">
                        <p><?php echo $row['description']; ?></p>
                    </div>
                    <p style=width:fit-content;padding:5px;margin-top:5px;color:white;border-radius:5%;background:<?php switch($row['category']){
                            case 'News': echo '#7295BD;'; break;
                            case 'Activities': echo '#BD7272;'; break;
                            case 'Announcements': echo '#72BD90;'; break;
                        } ?>><?php echo $row['category'] ?>
                    </p>
                </div>
            </div>
        <?php } ?>
    </div>
<?php include 'nav/footer.php'; ?>

</body>
</html>