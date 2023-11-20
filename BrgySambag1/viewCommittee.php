<?php
    require 'connection.php';
    include 'checkuser.php';

    //for ignoring warning about session
    error_reporting(E_ERROR | E_PARSE);
    
    session_start();
    $currentuser = $_SESSION['username'];

    // if(!$_SESSION['privilege']){
    //     header("Location: index.php");
    //     die;
    // }else{
    //     include 'checkuser.php';
    // }

    $id = $_GET['id'];

    // Retrieve all the officials from the database
    $sql = "SELECT * FROM tblcomm WHERE CommID = $id";
    $result = mysqli_query($conn, $sql);
    $comm = mysqli_fetch_array($result, MYSQLI_ASSOC);

    //setting variables
    $commName = $comm['CommName']
?>

<!DOCTYPE html>
<html>
<head>
    <title>Table Data</title>
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
</head>
<body>
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
                </tr>
            </thead>
            <tbody class="tbl-data">
                <?php 
                    require_once "connection.php";
                    $sql_query = "SELECT o.Name, oc.comPosition, o.OfficialID FROM tblofficials o JOIN tblofficialcom oc ON o.OfficialID = oc.OfficialID WHERE oc.CommID = $id;";
                    if ($result = $conn ->query($sql_query)) {
                        $row_count = 0;
                        while ($row = $result -> fetch_assoc()) { 
                            $OffID = $row['OfficialID'];
                            $name = $row['Name'];
                            $position = $row['comPosition'];
                            $row_class = ($row_count % 2 == 0) ? 'even-row' : 'odd-row';
                ?>
                
                <tr class="<?php echo $row_class; ?>">
                    <td><a href="viewOfficial.php?id=<?php echo $OffID; ?>"><?php echo $name; ?></a></td>
                    <td class="tbl-actions"><?php echo $position; ?></td>
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
</html>