<?php
//preventign warnings for unlogged in users
error_reporting(E_ERROR | E_PARSE);

require 'connection.php';

session_start();
require 'checkuser.php';

// Get officials and committees
$sql = "SELECT * FROM tblofficials";
$result = mysqli_query($conn, $sql);
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
    <div>
        <div class="off-title mt-3">
        <h1 class="mt-3 text-secondary font-xxl">Barangay Officials</h1>
        </div>

            <!-- for admin -->
            <div class="off-add">
                <?php
                if(!$privilege){}else{?>
                    <a href="addOfficials.php" class="btn-primary"><img class="btn-icon" src="drawable/addPerson.png" alt="+"> ADD OFFICIALS</a>
                    <?php }
                ?>
            </div>

            <div class="off-filter">
                <?php while ($row = mysqli_fetch_assoc($result)) { 
                    $profilePic = $row['OfficialPic']
                    ?>
                    <div class="p-2 officials">
                        <div class="off-info">
                            <h1 class="font-poppins-medium font-lg text-gray"><?php echo $row['Position']; ?></h1>
                        </div>
                    <?php    
                        if(!empty($profilePic)){?>
                            <img class="off-profile" src="uploads/<?php echo $profilePic ?>" alt="Post Image">
                            <!-- <img class="off-profile" src="uploads/357338869_3340412222877876_985818292748140079_n.jpg; ?>" alt="Post Image"> -->
                        <?php }else{?>
                                <img class="off-profile" src="drawable/noprofile2.png" alt="Post Image">
                        <?php }?>
                        <div class="off-info">
                            <a href="viewofficial.php?id=<?php echo $row['OfficialID']?>">
                                <h2><?php echo $row['Name']; ?></h2>
                            </a>
                            <p class="text-gray font-poppins-regular"><?php echo $row['Term']; ?></p>
                            <p><?php $offName ?></p>
                            <?php
                                if(!$privilege){
                                    
                                }else{
                            ?>
                                <div class="actions">
                                    <a href="viewOfficial.php?id=<?php echo $row['OfficialID']; ?>" class="btn-edit">
                                        <img src="drawable/more.png" alt="edit">
                                    </a>
                                    <a href="updateOfficial.php?id=<?php echo $row['OfficialID']; ?>" class="btn-edit">
                                        <img src="drawable/edit.png" alt="edit">
                                    </a>
                                    <?php
                                        if($row['Position'] != 'Barangay Captain')
                                        {?>
                                            <a onclick="javascript: return confirm('Confirm deletion?');" 
                                                href="deleteOfficials.php?id=<?php echo $row['OfficialID']; ?>" class="btn-delete">
                                                <img src="drawable/delete.png" alt="delete">
                                            </a>
                                        <?php }else{} ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
<?php include 'nav/footer.php'; ?>

</body>
</html>