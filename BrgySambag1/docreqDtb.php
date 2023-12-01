<?php
    require 'connection.php';

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
<div class="off-back">
<div class="off-title mt-3">
        <h1 class="mt-3 text-secondary font-xxl">Document Requests</h1>
        </div>
    <section class="dtbCont">
    <div class="table">
        <table>
            <thead class="thead">
                <tr>
                    <th class="font-poppins-regular" scope="col">ID</th>
                    <th class="font-poppins-regular" scope="col">NAME</th>
                    <th class="font-poppins-regular" scope="col">HOUSE No.</th>
                    <th class="font-poppins-regular" scope="col">SITIO</th>
                    <th class="font-poppins-regular" scope="col">TOTAL</th>
                    <th class="font-poppins-regular" scope="col">REFERENCE NO.</th>
                    <th class="font-poppins-regular" scope="col">REQUEST DATE</th>
                    <th></th>
                </tr>
            </thead>
            <tbody class="tbl-data">
                <?php 
                    $sql_query = "SELECT u.id, concat(u.firstname, ' ', u.middleName, ' ', u.lastname) AS name, u.sitio, u.houseNo, d.docreqID, d.requestDate, d.reference, d.status, td.docName, d.totalByRef
                    from users u 
                    INNER JOIN docreq d on u.id = d.requestId
                    INNER JOIN tbldocument td ON d.docID = td.docID
                    WHERE d.Archive = 0
                    GROUP BY reference
                    ORDER BY d.requestDate DESC;";
                    if ($result = $conn ->query($sql_query)) {
                        while ($row = $result -> fetch_assoc()) { 
                            $DocreqID = $row['docreqID'];
                            $Id = $row['userID'];
                            $Name = $row['name'];
                            $HouseNo = $row['houseNo'];
                            $Sitio = $row['sitio'];
                            $RequestDate = $row['requestDate'];
                            $total = $row['totalByRef'];
                            $Reference = $row['reference'];
                            $row_class = ($row_count % 2 == 0) ? 'even-row' : 'odd-row';
                ?>
                
                <tr class="<?php echo $row_class; ?>">
                    <td class="text-gray-dark-3"> <?php echo $Id; ?></td>
                    <td class="text-gray-dark-3 font-poppins-semibold"><?php echo $Name; ?></td>
                    <td class="text-gray-dark-3"><?php echo $HouseNo; ?></td>
                    <td class="text-gray-dark-3"><?php echo $Sitio; ?></td>
                    <td class="text-gray-dark-3"><?php echo $total; ?></td>
                    <td class="text-gray-dark-3"><?php echo $Reference; ?></td>
                    <td class="text-gray-dark-3"><?php echo $RequestDate; ?></td>
                    <td class="tbl-actions"><?php echo $status; ?>
                        <a href="docreqByRefDtb.php?id=<?php echo $Reference; ?>" class="btn-gray"><img src="drawable/more2.png" alt="more"></a>
                    </td>
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