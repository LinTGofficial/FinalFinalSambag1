<?php
    include 'connection.php';
    include 'checkuser.php';

    //get id of the article
    $id = $_GET['id'];
    

    // Retrieve all the posts from the database
    $sql = "SELECT * FROM tblofficials WHERE OfficialID = ". $id;
    $result = mysqli_query($conn, $sql);
    $info = mysqli_fetch_array($result, MYSQLI_ASSOC);

    $name = $info['Name'];
    $term = $info['Term'];
    $position = $info['Position'];
    $img = $info['OfficialPic'];

    if (isset($_POST["submit"])) {
        // Retrieve data from the form
        $committeeID = $_POST['committee'];
        $position = $_POST['position'];
    
        // Insert the official into the committee
        $insertSql = "INSERT INTO tblofficialcom (OfficialID, CommID, comPosition) 
                      VALUES ('$id', '$committeeID', '$position')";
    
        if (mysqli_query($conn, $insertSql)) {
            echo"<script> alert('Successfully added into the committee') </script>";
        } else {
            echo"<script> alert('Something went wrong') </script>";
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
    <!-- adding to committee -->
    <div class="newsbody" style="align-items:start;" id="newsbody"> 
        <div class="upload" style="margin-top:10%;" id="upload">
        <div class="close-button" id="close-button">X</div>
            <h1>Add to Committee</h1>
            <form method="Post">
                <select name="committee" required>
                    <?php
                    $checkComm = "SELECT c.CommID, c.CommName
                                FROM tblcomm c
                                LEFT JOIN tblofficialcom oc ON c.CommID = oc.CommID AND oc.OfficialID = $id
                                WHERE oc.OfficialID IS NULL";

                    $checkResult = mysqli_query($conn, $checkComm);  

                    if($checkResult){
                        $row_count = mysqli_num_rows($checkResult);

                        if($row_count == 0){
                            echo "<option disabled>No Available Committees</option>";
                        }else{
                            // Fetch a list of committees from the database and populate the dropdown
                            $committeeSql = "SELECT c.CommID, c.CommName
                                        FROM tblcomm c
                                        LEFT JOIN tblofficialcom oc ON c.CommID = oc.CommID AND oc.OfficialID = $id
                                        WHERE oc.OfficialID IS NULL";
                            $committeeResult = mysqli_query($conn, $committeeSql);
                            while ($row = mysqli_fetch_assoc($committeeResult)) {
                                echo "<option value='{$row['CommID']}'>{$row['CommName']}</option>";
                            }
                        }
                    }
                    ?>
                </select>
                <input type="text" name="position" placeholder="Position in Committee">
                <input type="hidden" name="official_id" value="<?php echo $id; ?>">
                <input type="submit" name="submit" class="btn_blue" value="ADD">
            </form>
        </div>
    </div>

    <a onclick="history.back()" class='backArrow'>
        <img src='drawable/backArrow.png' alt='back'>
    </a>
    <div class="view_off">
        <!-- display image -->
        <?php    
            if($img === null || $img === ""){?>
                <img class="off-profile" src="drawable/NoProf.png" alt="No Image">
            <?php }else{?>
                <img class="off-profile" src="uploads/<?php echo $img ?>" alt="Have Image">
            <?php }?>
        <div>
            <h1><?php echo $name ?></h1>
            <p class="position"><?php echo $position ?></p>
            <p class="term"><?php echo $term ?></p>
        <?php
            if(isset($privilege) && $privilege){?>
                <a href="updateOfficial.php?id=<?php echo $id ?>" class="btn_primary">
                    <img src="drawable/edit.png" alt="edit"> edit info
                </a>
            <?php }
        ?>
        </div>
        
    </div>
    <div class="flex-center">
        <img src="drawable/line.png" alt="line">
    </div>

    <!-- Display all the committee that the Official belongs to -->
    <div class="view_comm">
    <h1>Committees</h1>
    <table>
        <thead>
            <th></th>
            <th></th>
            <?php if (isset($_SESSION['privilege']) && $_SESSION['privilege']) : ?>
                <th></th>
            <?php endif; ?>
        </thead>
        <tbody>
        <?php
            $sql = "SELECT c.CommName, oc.comPosition, oc.OfficialCommID FROM tblcomm c
                    JOIN tblofficialcom oc ON c.CommID = oc.CommID
                    WHERE oc.OfficialID = $id";
            $result = mysqli_query($conn, $sql);
            while ($row = mysqli_fetch_assoc($result)) {
                $commName = $row['CommName'];
                $comPosition = $row['comPosition'];
                $offCommId = $row['OfficialCommID'];
        ?>
            <tr>
                <td><?php echo $commName ?></td>
                <td class="position"><?php echo $comPosition ?></td>
                <?php if (isset($_SESSION['privilege']) && $_SESSION['privilege']) : ?>
                    <td>
                        <a onclick="javascript: return confirm('Confirm deletion?');" 
                            href="deleteFromComm.php?offCommId=<?php echo $offCommId; ?>&id=<?php echo $id; ?>" class="btn-delete">
                            <img src="drawable/delete.png" alt="delete">
                        </a>
                    </td>
                <?php endif; ?>
            </tr>
        <?php } ?>
        </tbody>
    </table>


        <!-- actions of Admins -->
        <?php
            if(isset($privilege) && $privilege){
        ?>
            <div class="filter-add">
                <input type="checkbox" id="toggleAdd">
                <label for="toggleAdd">+ADD TO COMMITTEE</label>
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
<?php include 'nav/footer.php'; ?>

</body>
</html>