<?php
require 'connection.php';
require 'checkuser.php';

$sql = "SELECT * FROM tblbrgyinfo;";
$result = mysqli_query($conn, $sql);
$info = mysqli_fetch_array($result, MYSQLI_ASSOC);

$id = $info['InfoID'];
$popId = $info['PopID'];
$brgyName = $info['Name'];
$geographic = $info['Geographic District'];
$legislative = $info['Legislative District'];
$population = $info['population'];
$year = $info['popYear'];
$captain = $info['BrgyCaptain'];
$psgcCode = $info['PSGC CODE'];
$psgcClass = $info['PSGC Class'];
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
    <h1 class="abt-header">ABOUT THE BARANGAY</h1>
    <div class="about-brgy">
            <div <?php
                    if(isset($_SESSION['privilege']) && $_SESSION['privilege']){
                        echo "class='mt-5 about-ins'";
                    } else {
                        echo "class='mt-1 about-ins'";
                    }
                ?>>
                <div>
                    <p>BARANGAY NAME:</p>
                    <p>GEOGRAPHIC DISTRICT:</p>
                    <p>LEGISLATIVE DISTRICT:</p>
                    <p>POPULATION:</p>
                    <p>BARANGAY CAPTAIN:</p>
                    <p>PSGC CODE:</p>
                    <p>PSGC CLASS:</p>
                </div>
                <div>
                    <p><?php echo "$brgyName"?></p>
                    <p><?php echo "$geographic"?></p>
                    <p><?php echo "$legislative"?></p>
                    <p><?php echo "$population ($year)"?></p>
                    <p><?php echo "$captain"?></p>
                    <p><?php echo "$psgcCode"?></p>
                    <p><?php echo "$psgcClass"?></p>
                </div>
            </div>
            <?php if(isset($privilege) && $privilege){?>
                <div>
                    <a href="updateBrgyInfo.php?id=<?php echo $popId; ?>" class="btn_primary"> Edit Barangay Information </a><br>
                </div>
            <?php } ?>
    </div>
</div>
<?php include 'nav/footer.php'; ?>

</body>
</html>