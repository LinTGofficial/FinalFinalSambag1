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
            <h1 class="mt-3 text-secondary font-xxl">Barangay Committees</h1>
        </div>

        <!-- for admin -->
        <div class="off-add">
            <?php
                if (!$privilege) {
                } else { ?>
                    <a href="addcommittee.php" class="btn-primary"> +ADD Committee</a>
                    <?php }
                ?>
            </div>
            
        <div class="off-filter">
            <?php
            $sqlCom = "SELECT * FROM tblcomm";
            $resultCom = mysqli_query($conn, $sqlCom);

            while ($rowCom = mysqli_fetch_assoc($resultCom)) {
                $CommName = $rowCom['CommName'];
                $CommID = $rowCom['CommID'];
                $CommPic = $rowCom['CommPic'];

                $sqlOff = "SELECT o.Name, oc.comPosition FROM tblofficials o 
                                JOIN tblofficialcom oc ON o.OfficialID = oc.OfficialID WHERE oc.CommID = $CommID;";
                $resultOff = mysqli_query($conn, $sqlOff);
                ?>
                <div class="p-2 officials" id="committee"off>
                    <?php    
                        if(!empty($CommPic)){?>
                            <img class="off-profile" src="uploads/<?php echo $CommPic ?>" alt="Post Image">
                            <!-- <img class="off-profile" src="uploads/357338869_3340412222877876_985818292748140079_n.jpg; ?>" alt="Post Image"> -->
                        <?php }else{?>
                                <img class="off-profile" src="drawable/noprofile2.png" alt="Post Image">
                    <?php }?>
                    <div class="off-info">
                        <h1>
                            <a class="text-primary" href="viewCommittee.php?id=<?php echo $CommID ?>"><?php echo "$CommName" ?></a>
                        </h1>
                    </div>
                    <?php
                    if (!$privilege) {

                    } else {
                        ?>
                        <div class="actions">
                            <a href="viewCommittee.php?id=<?php echo $CommID; ?>" class="btn-edit">
                                        <img src="drawable/more.png" alt="edit">
                            <a href="updateComm.php?id=<?php echo $CommID; ?>" class="btn-edit">
                                <img src="drawable/edit.png" alt="edit">
                            </a>
                            <a onclick="javascript: return confirm('Confirm deletion?');"
                                href="deleteComm.php?id=<?php echo $CommID; ?>" class="btn-delete">
                                <img src="drawable/delete.png" alt="delete">
                            </a>
                        </div>
                    <?php }?>
                </div>
            <?php } ?>
        </div>
    </div>
    </div>
    <?php include 'nav/footer.php'; ?>

</body>

</html>