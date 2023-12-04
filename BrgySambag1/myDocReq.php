<?php
    require 'connection.php';
    include 'checkuser.php';

    //ignoring warnings for session
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
<!-- <?php include 'topnavs/topnavLoggedIn.html'?> -->
<section>
<div class="off-back">
    <div class="off-title mt-3">
        <h1 class="mt-3 text-secondary font-xxl">My Requests</h1>
        </div>
    <section class="dtbCont">
        <div class="note">
            <p class="m-2">Note: If document <u>STATUS</u> is <u class="text-green-dark-3">APPROVED</u>, kindly proceed to the barangay and bring any <u>VALID ID</u> for validation purposes and claiming of the documents</p>
            <?php
                $sql = "SELECT * FROM docreq dr JOIN tbldocument d ON dr.docID = d.docID WHERE (`status` = 'approved' OR `status` = 'pending') AND UserID = $id AND dr.archive = 0";
                $query = mysqli_query($conn, $sql);
                while($row = mysqli_fetch_array($query)){
                    $price = $row['price'];
                    $total += $price;
                }
            ?>
        </div>
    <div class="table">
        <table>
            <thead class="thead">
                <tr>
                    <th class="font-poppins-regular" scope="col">DOCUMENT</th>
                    <th class="font-poppins-regular" scope="col">PRICE</th>
                    <th class="font-poppins-regular" scope="col">REQUESTDATE</th>
                    <th class="font-poppins-regular" scope="col">REFERENCE NO.</th>
                    <th class="font-poppins-regular" scope="col">STATUS</th>
                    <th class="font-poppins-regular" scope="col"></th>
                </tr>
            </thead>
            <tbody class="tbl-data">
                <?php 
                    $sql_query = "SELECT u.userID, CONCAT(u.firstname, ' ', u.lastname) AS name, u.sitio, u.houseNo, d.docreqID, d.requestDate, d.reference, d.status, td.docName, td.price
                    FROM users u
                    INNER JOIN docreq d ON u.userID = d.userID 
                    INNER JOIN tbldocument td ON d.docID = td.docID
                    WHERE (d.Archive = 0 AND u.userID = '$id')
                    ORDER BY d.requestDate DESC;";
                    if ($result = $conn ->query($sql_query)) {
                        while ($row = $result -> fetch_assoc()) { 
                            $DocreqID = $row['docreqID'];
                            $name = $row['docName'];
                            $price = $row['price'];
                            $RequestDate = $row['requestDate'];
                            $Reference = $row['reference'];
                            $status = $row['status'];
                            $row_class = ($row_count % 2 == 0) ? 'even-row' : 'odd-row';
                ?>
                
                <tr class="<?php echo $row_class; ?>">
                    <td class="font-poppins-semibold"><?php echo $name; ?></td>
                    <td><?php echo $price; ?></td>
                    <td><?php echo $RequestDate; ?></td>
                    <td><?php echo $Reference; ?></td>
                    <td 
                        <?php if ($status == 'approved') {
                                echo "class='font-poppins-semibold text-green-dark-3'";
                            } else if ($status == 'rejected') {
                                echo "class='font-poppins-semibold text-red-dark-3'";
                            } else {echo "class='font-poppins-semibold'";}?>><?php echo $status; ?></td>

                    <td class="tbl-actions"><a onclick="javascript: return confirm('This action will delete the document request from the database, Proceed?');" href="deleteMyDocReq.php?id=<?php echo $DocreqID; ?>" class="btn-red">
                        <img src="drawable/delete.png" alt="Cancel">
                    </a></td>
                </tr>

                <?php
                            $row_count++;
                        } 
                    } 
                ?>
            </tbody>
        </table>
    </div>
    <div class="mb-3 mt-1"><p class="font-lg text-gray">To be Paid: <a id="price2"><?php if($total == 0){echo "0";}else{echo $total;} ?></a>php</p><div>
</div>
</section>
<?php include 'nav/footer.php'; ?>
</body>
</html>