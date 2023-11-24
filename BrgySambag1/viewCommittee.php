<?php
    require 'connection.php';
    include 'checkuser.php';

    error_reporting(E_ERROR | E_PARSE);
    
    session_start();
    $currentuser = $_SESSION['username'];
    $Commid = $_GET['id'];

    $sql = "SELECT * FROM tblcomm WHERE CommID = $Commid";
    $result = mysqli_query($conn, $sql);
    $comm = mysqli_fetch_array($result, MYSQLI_ASSOC);

    $commName = $comm['CommName'];

    if (isset($_POST["submit"])) {
        $officialID = $_POST['committee'];
        $position = $_POST['position'];
    
        $insertSql = "INSERT INTO tblofficialcom VALUES ('', '$Commid', '$officialID', '$position')";
    
        if (mysqli_query($conn, $insertSql)) {
            echo"<script> alert('Successfully added into the committee');
                window.history.back();</script>";
        } else {
            echo"<script> alert('Something went wrong') </script>";
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Table Data</title>
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
</head>
<body>
    <!-- adding to committee -->
    <div class="newsbody" style="align-items:start;" id="newsbody"> 
        <div class="upload" style="margin-top:10%;" id="upload">
        <div class="close-button" id="close-button">X</div>
            <h1>Add to Committee</h1>
            <form method="Post">
                <label for="committee">Choose Official:</label>
                <select name="committee" required>
                    <?php
                    $checkComm = "SELECT o.Name, o.OfficialID 
                    FROM tblofficials o
                    WHERE NOT EXISTS (
                        SELECT 1
                        FROM tblofficialcom oc
                        WHERE oc.OfficialID = o.OfficialID
                        AND oc.CommID = $Commid
                    );";

                    $checkResult = mysqli_query($conn, $checkComm);  

                    if($checkResult){
                        $row_count = mysqli_num_rows($checkResult);

                        if($row_count == 0){
                            echo "<option disabled>No Available Committees</option>";
                        }else{
                            $committeeSql = "SELECT o.Name, o.OfficialID 
                            FROM tblofficials o
                            WHERE NOT EXISTS (
                                SELECT 1
                                FROM tblofficialcom oc
                                WHERE oc.OfficialID = o.OfficialID
                                AND oc.CommID = $Commid
                            );";
                            $committeeResult = mysqli_query($conn, $committeeSql);
                            while ($row = mysqli_fetch_assoc($committeeResult)) {
                                $officialId = $row['OfficialID'];
                                $name = $row['Name'];

                                echo "<option value='$officialId'>$name</option>";
                            }
                        }
                    }
                    ?>
                </select>
                <input type="text" name="position" placeholder="Position in Committee">
                <input type="submit" name="submit" class="btn_blue" value="ADD">
            </form>
        </div>
    </div>

<div class="off-back">
    <div class="off-title mt-3">
        <h1 class="mt-3 text-secondary font-xxl"><?php echo $commName;?></h1>
    </div>

    <a onclick="history.back()" class='backArrow'>
        <img src='drawable/backArrow.png' alt='back'>
    </a>
    <section class="dtbCont">
    <div class="table mb-2 t-s">
        <table>
            <thead class="thead">
                <tr>
                    <th>NAME</th>
                    <th>POSITION</th>
                    <?php
                    if(!$_SESSION['privilege']){
                     
                    } else {
                        echo "<th id='toggleAdd'><img src='drawable/add.png' alt='+'></th>";
                    }
                    ?>
                </tr>
            </thead>
            <tbody class="tbl-data">
                <?php 
                    require_once "connection.php";
                    $sql_query = "SELECT o.Name, oc.comPosition, o.OfficialID, oc.OfficialCommID FROM tblofficials o JOIN tblofficialcom oc ON o.OfficialID = oc.OfficialID WHERE oc.CommID = $Commid;";
                    if ($result = $conn ->query($sql_query)) {
                        $row_count = 0;
                        while ($row = $result -> fetch_assoc()) { 
                            $OffID = $row['OfficialID'];
                            $name = $row['Name'];
                            $position = $row['comPosition'];
                            $offCommId = $row['OfficialCommID'];
                            $row_class = ($row_count % 2 == 0) ? 'even-row' : 'odd-row';
                ?>
                
                <tr class="<?php echo $row_class; ?>">
                    <td><a href="viewOfficial.php?id=<?php echo $OffID; ?>"><?php echo $name; ?></a></td>
                    <td><?php echo $position; ?></td>
                    <?php
                    if(!$_SESSION['privilege']){
                     
                    } else {?>
                        <td class="tbl-actions">
                            <a onclick="javascript: return confirm('Confirm deletion?');"
                            href="deleteFromComm.php?offCommId=<?php echo $offCommId; ?>&id=<?php echo $id; ?>" class="btn-delete"><img src="drawable/delete.png" alt="more"></a>
                        </td><?php
                    }
                    ?>
                </tr>

                <?php
                            $row_count++;
                        } 
                    } 
                ?>
            </tbody>
        </table>
    </div>
</section>

</div>
<?php include 'nav/footer.php'; ?>

</body>

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

</html>