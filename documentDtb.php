<?php
    require 'connection.php';
    include 'checkuser.php';

    //for ignoring warning about session
    error_reporting(E_ERROR | E_PARSE);
    
    session_start();
    $currentuser = $_SESSION['username'];
    $id = $_SESSION['id'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Table Data</title>
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="off-back">
<div>
        <div class="off-title mt-3">
        <h1 class="mt-3 text-secondary font-xxl">Documents</h1>
        </div>
    <section class="dtbCont">
    <div class="table mb-2">
        <table>
            <thead class="thead">
                <tr>
                    <th class="font-poppins-regular">DOCUMENT NAME</th>
                    <th class="font-poppins-regular">PRICE</th>
                    <?php
                        if($_SESSION['privilege']){
                    ?>
                    <th><a href="addDocument.php"><img src="drawable/add.png" alt="add"></a></th>
                    <?php
                        }
                    ?>
                </tr>
            </thead>
            <tbody class="tbl-data">
                <?php 
                    $sql_query = "SELECT * FROM tbldocument WHERE `Archive` = 0 ORDER BY `docName`;";
                    if ($result = $conn ->query($sql_query)) {
                        while ($row = $result -> fetch_assoc()) { 
                            $id = $row['docID'];
                            $docName = $row['docName'];
                            $price = $row['price'];
                            $row_class = ($row_count % 2 == 0) ? 'even-row' : 'odd-row';
                ?>
                
                <tr class="<?php echo $row_class; ?>">
                    <td class="text-gray-dark-3 font-poppins-semibold"><?php echo $docName; ?></td>
                    <td class="text-gray-dark-3"><?php echo $price; ?>php</td>
                    <?php
                        if($_SESSION['privilege']){
                    ?>
                    <td class="tbl-actions">
                        <a href="updateDocument.php?id=<?php echo $id; ?>" class="btn-gray"><img class="btn-icon" src="drawable/edit.png" alt="edit"></a>
                        <a onclick="javascript: return confirm('Confirm document deletion?');" href="deleteDocument.php?id=<?php echo $id; ?>" class="btn-red"><img class="btn-icon" src="drawable/delete.png" alt="delete"></a>
                    </td>
                    <?php
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
<?php include 'nav/footer.php'; ?>

</body>
</html>