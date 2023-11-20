<?php
    require 'connection.php';
    include 'checkuser.php';

    //for ignoring warning about session
    error_reporting(E_ERROR | E_PARSE);
    
    session_start();
    $currentuser = $_SESSION['username'];
    $id = $_SESSION['id'];
    if(!$_SESSION['privilege']){
        header("Location: index.php");
        die;
    }else{
        include 'checkuser.php';
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Table Data</title>
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
</head>
<body>
<!-- <?php include 'topnavs/topnavLoggedIn.html'?> -->
<section>
<a href="addBrgyInfo.php" class="btn-add">+ ADD Info</a>
        <div class="table">
            <table>
                <thead>
                  <tr>
                    <th scope="col">Info ID</th>
                    <th scope="col">Barangay Name</th>
                    <th scope="col">GEOGRAPHIC DISTRICT</th>
                    <th scope="col">LEGISLATIVE DISTRICT</th>
                    <th scope="col">POPULATION</th>
                    <th scope="col">BARANGAY CAPTAIN</th>
                    <th scope="col">PSGC CODE</th>
                    <th scope="col">PSGC CLASS</th>
                    <th scope="col">ACTIONS</th>
                  </tr>
                </thead>
                <tbody>
                    <?php 
                        require_once "connection.php";
                        $sql_query = "SELECT * FROM tblbrgyinfo b INNER JOIN tblpopulation p on b.InfoID = p.InfoID";
                        if ($result = $conn ->query($sql_query)) {
                            while ($info = $result -> fetch_assoc()) { 
                                $id = $info['InfoID'];
                                $popId = $info['PopID'];
                                $brgyName = $info['Name'];
                                $geographic = $info['Geographic District'];
                                $legislative = $info['Legislative District'];
                                $population = $info['Population'];
                                $year = $info['YEAR'];
                                $captain = $info['BrgyCaptain'];
                                $psgcCode = $info['PSGC CODE'];
                                $psgcClass = $info['PSGC Class'];
                    ?>
                    
                    <tr>
                        <td><?php echo $id; ?></td>
                        <td><?php echo $brgyName; ?></td>
                        <td><?php echo $geographic; ?></td>
                        <td><?php echo $legislative; ?></td>
                        <td><?php echo $population; ?></td>
                        <td><?php echo $year; ?></td>
                        <td><?php echo $captain; ?></td>
                        <td><?php echo $psgcCode; ?></td>
                        <td><?php echo $psgcClass; ?></td>
                        <td><a href="updateBrgyInfo.php?id=<?php echo $popId; ?>" class="btn-green">Update</a></td>
                        <td><a onclick="javascript: return confirm('Confirm document request rejection');" href="deleteBrgyInfo.php?id=<?php echo $popId; ?>" class="btn-red">Delete</a></td>
                    </tr>

                    <?php
                            } 
                        } 
                    ?>
                </tbody>
              </table>
        </div>
    </section>
<?php include 'nav/footer.php'; ?>

</body>
</html>