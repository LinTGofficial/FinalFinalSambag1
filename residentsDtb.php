<?php
    //ignoring warnings for session
    error_reporting(E_ALL ^ E_NOTICE);
    require 'connection.php';
    include 'checkuser.php';

    $currentuser = $_SESSION['username'];

    if(!$_SESSION['privilege']){
        header("Location: login.php");
        die;
    }else{

    }

$id = $_SESSION['id'];

if(isset($_POST['submit'])){
    $vin = $_POST['vin'];
    $lastname = $_POST['lname'];
    $middlename = $_POST['mname'];
    $firstname = $_POST['fname'];
    $status = $_POST['status'];
    $sitio = $_POST['sitio'];
    $houseNo = $_POST['houseNo'];
    
    $sql = "INSERT INTO tblresidents VALUES('', '$vin', '$lastname', '$middlename', '$firstname', '$status', '$sitio', '$houseNo', 0)";
    if($query = mysqli_query($conn, $sql)){
        echo "<script> alert('Resident successfully added!');
        history.go(-1)</script>";
    } else {
        echo "<script> alert('Something went wrong...');
        history.go(-1)</script>";
    }
        
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Table Data</title>
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="newsbody" style="align-items:start;" id="newsbody"> 
        <div class="upload" style="margin-top:10%;" id="upload">
        <div class="close-button" id="close-button">X</div>
            <h1>Add an Admin</h1>
            <form method="Post">
                <label>VIN:</label>
                    <input type="text" name="vin" class="mb-2" required>
                <label>Name:</label>
                    <input type="text" name="fname" placeholder="First Name" required>
                    <input type="text" name="mname" placeholder="Middle Name (optional)">
                    <input type="text" name="lname" class="mb-2" placeholder="Last Name" required>
                <label>Civil Status:</label>
                    <select name="status" class="mb-2">
                        <option value="Single">Single</option>
                        <option value="Married">Married</option>
                        <option value="Divorced">Divorced</option>
                        <option value="Widowed">Widowed</option>
                    </select>
                <label>Address:</label>
                    <input type="text" name="sitio" placeholder="Sitio" required>
                    <input type="text" name="houseNo" placeholder="House No. & Street" class="mb-2" required>
                <input type="submit" name="submit" class="btn-primary" value="ADD RESIDENT">
            </form>
        </div>
    </div>


<div class="off-back">
<div class="off-title mt-3">
    <h1 class="mt-3 text-secondary font-xxl">RESIDENTS</h1>
</div>
    <section class="dtbCont">
            <div class="table mb-3">
                <table>
                    <thead  class="thead">
                      <tr>
                        <th scope="col">VIN</th>
                        <th scope="col">NAME</th>
                        <th scope="col">CIVIL STATUS</th>
                        <th scope="col">ADDRESS</th>
                        <th id='toggleAdd'><img src='drawable/add.png' alt='+'></th>
                      </tr>
                    </thead>
                    <tbody class="tbl-data">
                        <?php 
                            require_once "connection.php";
                            $sql_query = "SELECT * FROM tblresidents WHERE Archive = 0";
                            if ($result = $conn ->query($sql_query)) {
                                $row_count = 0;
                                while ($row = $result -> fetch_assoc()) {
                                    $resId = $row['residentID'];
                                    $VIN = $row['VIN'];
                                    $name = $row['fName'] . " " .$row['mName']. " " . $row['lName'];
                                    $civilStatus = $row['civilStatus'];
                                    $address = $row['sitio']. ", " . $row['houseNo_Street'];
                                    $row_class = ($row_count % 2 == 0) ? 'even-row' : 'odd-row';
                        ?>
                        
                        <tr class="<?php echo $row_class; ?>">
                            <td><?php echo $VIN; ?></td>
                            <td><?php echo $name; ?></td>
                            <td><?php echo $civilStatus; ?></td>
                            <td><?php echo $address; ?></td>
                            <td class="tbl-actions">
                                <a href="updateResident.php?id=<?php echo $resId; ?>" class="btn-green"><img src="drawable/edit.png" alt="edit"></a>
                                <a onclick="javascript: return confirm('Confirm deletion?');" href="deleteResident.php?id=<?php echo $resId; ?>" class="btn-red"><img src="drawable/delete.png" alt="delete"></a>
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
    </section>
</div>
<?php include 'nav/footer.php'; ?>

</body>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const toggleButton = document.getElementById("toggleAdd");
        const elementToToggle = document.getElementById("newsbody");
        const closeButton = document.getElementById("close-button");

        toggleButton.addEventListener("click", function () {
            if (elementToToggle.style.display === "none" || elementToToggle.style.display === "") {
                elementToToggle.style.display = "flex";
            } else {
                elementToToggle.style.display = "none";
            }
        });

        closeButton.addEventListener("click", function () {
            elementToToggle.style.display = "none";
        });
    });
</script>

</html>