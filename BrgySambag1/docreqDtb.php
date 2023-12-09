<?php
    require 'connection.php';

    //for ignoring warning about session
    error_reporting(E_ERROR | E_PARSE);
    
    session_start();
    $currentuser = $_SESSION['username'];
    $id = $_SESSION['id'];
    $search = $_GET['search'];

    if(!$_SESSION['privilege']){
        header("Location: index.php");
        die;
    }else{
        include 'checkuser.php';
    }

    if(isset($_POST['search'])){
        $input = $_POST['input'];
        echo "<script>window.location.href='docreqDtb.php?search=$input'</script>";
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
    <div class="search" style="margin-top:-2%;">
        <form method="POST" class="">
            <a class="mr-1">Search by Reference:</a><nobr>
            <input class="mb-1 font-sl" type="text" name="input"><nobr>
            <button class="btn-primary ml-1" type="submit" name="search"><img src="drawable/search.png" style="height:20px;">SEARCH</button>
        </form>
    </div>
    <div class="table">
        <table>
            <thead class="thead">
                <tr>
                    <th class="font-poppins-regular" scope="col">ID</th>
                    <th class="font-poppins-regular" scope="col">NAME</th>
                    <th class="font-poppins-regular" scope="col">ADDRESS</th>
                    <th class="font-poppins-regular" scope="col">TOTAL</th>
                    <th class="font-poppins-regular" scope="col">REFERENCE NO.</th>
                    <th class="font-poppins-regular" scope="col">REQUEST DATE</th>
                    <th></th>
                </tr>
            </thead>
            <tbody class="tbl-data">
                <?php 
                    if(empty($search)){
                        $sql_query = "SELECT u.userID, concat(r.fName, ' ' , r.mName, ' ', r.lName) AS name, r.sitio, r.houseNo_Street, d.docreqID, d.userID, d.requestDate, d.reference, d.status, td.docName, td.price
                        from users u 
                        JOIN docreq d on u.userID = d.userID
                        JOIN tbldocument td ON d.docID = td.docID
                        JOIN tblresidents r ON u.residentID = r.residentID
                        WHERE d.Archive = 0
                        GROUP BY reference
                        ORDER BY d.requestDate DESC;";
                    } else {
                        $sql_query = "SELECT u.userID, concat(r.fName, ' ' , r.mName, ' ', r.lName) AS name, r.sitio, r.houseNo_Street, d.docreqID, d.userID, d.requestDate, d.reference, d.status, td.docName, td.price
                        from users u 
                        JOIN docreq d on u.userID = d.userID
                        JOIN tbldocument td ON d.docID = td.docID
                        JOIN tblresidents r ON u.residentID = r.residentID
                        WHERE d.Archive = 0 AND d.reference LIKE '$search%'
                        GROUP BY reference
                        ORDER BY d.requestDate DESC;";
                    }
                    if ($result = $conn ->query($sql_query)) {
                        while ($row = $result -> fetch_assoc()) { 
                            $DocreqID = $row['docreqID'];
                            $Id = $row['userID'];
                            $Name = $row['name'];
                            $HouseNo = $row['houseNo_Street'];
                            $Sitio = $row['sitio'];
                            $RequestDate = $row['requestDate'];
                            $total = $row['totalByRef'];
                            $Reference = $row['reference'];
                            $row_class = ($row_count % 2 == 0) ? 'even-row' : 'odd-row';
                ?>
                
                <tr class="<?php echo $row_class; ?>">
                    <td class="text-gray-dark-3"> <?php echo $Id; ?></td>
                    <td class="text-gray-dark-3 font-poppins-semibold"><?php echo $Name; ?></td>
                    <td class="text-gray-dark-3"><?php echo $Sitio; ?>, <?php echo $HouseNo; ?></td>
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