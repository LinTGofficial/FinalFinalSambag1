<?php
    require 'connection.php';

    //for ignoring warning about session
    error_reporting(E_ERROR | E_PARSE);
    $ref = $_GET["id"];

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
<div class="off-back">
<div>
    <div class="off-title mt-3">
    <h1 class="mt-3 text-secondary font-xxl">Document Requests</h1>
    </div>
    <a href="docreqDtb.php" class='backArrow'>
        <img src='drawable/backArrow.png' alt='back'>
    </a>
    <section class="dtbCont">
    <div class="table mb-2 t-s">
        <table>
            <thead class="thead">
                <tr>
                    <th class="font-poppins-regular" scope="col">DOCUMENT</th>
                    <th class="font-poppins-regular" scope="col">PRICE</th>
                    <th class="ta-l font-poppins-regular" scope="col">STATUS</th>
                    <th></th>
                </tr>
            </thead>
            <tbody class="tbl-data">
                <?php 
                    $sql_query = "SELECT u.id, concat(u.firstname, ' ', u.lastname) AS name, u.sitio, u.houseNo, d.docreqID, d.requestDate, d.reference, d.status, td.docName, td.price
                    from users u 
                    INNER JOIN docreq d on u.id = d.requestId
                    INNER JOIN tbldocument td ON d.docID = td.docID
                    WHERE d.reference = $ref
                    ORDER BY d.requestDate DESC;";
                    if ($result = $conn ->query($sql_query)) {
                        while ($row = $result -> fetch_assoc()) { 
                            $DocreqID = $row['docreqID'];
                            $Id = $row['userID'];
                            $Name = $row['name'];
                            $price = $row['price'];
                            $docName = $row['docName'];
                            $Sitio = $row['sitio'];
                            $RequestDate = $row['requestDate'];
                            $HouseNo = $row['houseNo'];
                            $Reference = $row['reference'];
                            $status = $row['status'];
                            $row_class = ($row_count % 2 == 0) ? 'even-row' : 'odd-row';
                ?>
                
                <tr class="<?php echo $row_class; ?>">
                    <td class="text-gray-dark-3 font-poppins-semibold"><?php echo $docName; ?></td>
                    <td class="text-gray-dark-3"><?php echo $price; ?></td>
                    <td class="text-gray-dark-3"><?php echo $status; ?></td>
                    <td class="tbl-actions">
                        <a onclick="javascript: return confirm('Confirm Approval');" href="approveDoc.php?id=<?php echo $DocreqID; ?>&ref=<?php echo $Reference; ?>"><img src="drawable/check.png" alt="Approve"></a>
                        <a onclick="javascript: return confirm('Confirm document request rejection');" href="rejectDoc.php?id=<?php echo $DocreqID; ?>&ref=<?php echo $Reference; ?>"><img src="drawable/cancel.png" alt="Reject"></a>
                        <a onclick="javascript: return confirm('This action will delete the document request from the database, Proceed?');" href="deleteDocReq.php?id=<?php echo $DocreqID; ?>&ref=<?php echo $Reference; ?>" class="btn-red"><img src="drawable/delete.png" alt="Delete"></a></td>
                </tr>
                <?php
                            $row_count++;
                        } 
                    } 
                ?>
            </tbody>
        </table>
    </div>
</div>


<?php include 'nav/footer.php'; ?>

</body>
</html>