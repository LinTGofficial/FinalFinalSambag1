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
    <div class="off-title mt-3">
    <h1 class="mt-3 text-secondary font-xxl">Contact Information</h1>
    </div>
    <section class="dtbCont">
    <div class="table mb-2">
        <table>
            <thead class="thead">
                <tr>
                    <th class="font-poppins-regular" scope="col">NAME</th>
                    <th class="font-poppins-regular" scope="col">CONTACT</th>
                    <?php
                        if($_SESSION['privilege']){
                    ?>
                    <th><a href="addContact.php"><img src="drawable/add.png" alt="add"></a></th>
                    <?php } ?>
                </tr>
            </thead>
            <tbody class="tbl-data">
                <?php 
                    $sql_query = "SELECT * FROM tblbrgycontact ORDER BY `ContactName` ASC;";
                    if ($result = $conn ->query($sql_query)) {
                        while ($row = $result -> fetch_assoc()) { 
                            $id = $row['BrgyContactID'];
                            $name = $row['ContactName'];
                            $contact = $row['ContactInfo'];
                            $displayed = $row['displayed'];
                            $row_class = ($row_count % 2 == 0) ? 'even-row' : 'odd-row';
                ?>
                
                <tr class="<?php echo $row_class; ?>">
                    <td class="text-gray-dark-3"><?php echo $name; ?></td>
                    <td class="text-gray-dark-3 font-poppins-semibold"><?php echo $contact; ?></td>
                    <?php
                        if($_SESSION['privilege']){
                    ?>
                    <td class="tbl-actions">
                        <a href="updateContact.php?id=<?php echo $id; ?>" class="btn-green"><img src="drawable/edit.png" alt="edit"></a>
                        <a onclick="javascript: return confirm('Confirm document deletion?');" href="deleteContact.php?id=<?php echo $id; ?>" class="btn-red"><img src="drawable/delete.png" alt="delete"></a>
                    </td>
                    <?php } ?>
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