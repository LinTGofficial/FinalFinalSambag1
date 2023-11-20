<?php
    require 'connection.php';
    include 'checkuser.php';

    //for ignoring warning about session
    error_reporting(E_ERROR | E_PARSE);
    
    session_start();
    $currentuser = $_SESSION['username'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Table Data</title>
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="off-back">
    <h1 class="off-title">BARANGAY OFFICIALS</h1>
    <section class="dtbCont">
    <div class="table">
        <table>
            <thead class="thead">
                <tr>
                    <th>COMMITTEE NAME</th>
                    <?php
                        if($_SESSION['privilege']){
                    ?>
                    <th><a href="addcommittee.php"><img src="drawable/add.png" alt="add"></a></th>
                    <?php }?>
                </tr>
            </thead>
            <tbody class="tbl-data">
                <?php 
                    require_once "connection.php";
                    $sql_query = "SELECT * FROM tblcomm ORDER BY `CommId` ASC;";
                    if ($result = $conn ->query($sql_query)) {
                        $row_count = 0;
                        while ($row = $result -> fetch_assoc()) { 
                            $id = $row['CommID'];
                            $name = $row['CommName'];
                            $row_class = ($row_count % 2 == 0) ? 'even-row' : 'odd-row';
                ?>
                
                <tr class="<?php echo $row_class; ?>">
                    <td><a href="committee.php?id=<?php echo $id; ?>"><?php echo $name; ?></a></td>
                    <?php
                        if($_SESSION['privilege']){
                    ?>
                    <td class="tbl-actions">
                        <a href="updateComm.php?id=<?php echo $id; ?>" class="btn-green"><img src="drawable/edit.png" alt="edit"></a>
                        <a onclick="javascript: return confirm('Confirm document deletion?');" href="deleteComm.php?id=<?php echo $id; ?>" class="btn-red"><img src="drawable/delete.png" alt="delete"></a>
                    </td>
                    <?php }?>
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