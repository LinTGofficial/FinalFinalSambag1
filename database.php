<?php
    //ignoring warnings for session
    error_reporting(E_ALL ^ E_NOTICE);
    require 'connection.php';
    session_start();
    $currentuser = $_SESSION['username'];

    if(!$_SESSION['privilege']){
        header("Location: login.php");
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
<div class="off-back">
<h1 class="off-title">DATABASE</h1>
    <section class="dtbCont">
            <div class="table">
                <table>
                    <thead  class="thead">
                      <tr>
                        <th scope="col">ID</th>
                        <th scope="col">NAME</th>
                        <th scope="col">Email</th>
                        <th scope="col">BIRTHDATE</th>
                        <th scope="col">AGE</th>
                        <th scope="col">SITIO</th>
                        <th scope="col">HOUSE NO</th>
                        <th scope="col">PRIVILEGE</th>
                        <th scope="col">ACTIONS</th>
                      </tr>
                    </thead>
                    <tbody class="tbl-data">
                        <?php 
                            require_once "connection.php";
                            $sql_query = "SELECT * FROM users";
                            if ($result = $conn ->query($sql_query)) {
                                $row_count = 0;
                                while ($row = $result -> fetch_assoc()) { 
                                    $Id = $row['id'];
                                    $Name = $row['firstname'] . " " . $row['lastname'];
                                    $Email = $row['email'];
                                    $Sitio = $row['sitio'];
                                    $HouseNo = $row['houseNo'];
                                    $Birth = $row['birthdate'];
                                    $Age = $row['age'];
                                    $IsAdmin = $row['isAdmin'];
                                    $row_class = ($row_count % 2 == 0) ? 'even-row' : 'odd-row';
                        ?>
                        
                        <tr class="<?php echo $row_class; ?>">
                            <td><?php echo $Id; ?></td>
                            <td><?php echo $Name; ?></td>
                            <td><?php echo $Email; ?></td>
                            <td><?php echo $Birth; ?></td>
                            <td><?php echo $Age; ?></td>
                            <td><?php echo $Sitio; ?></td>
                            <td><?php echo $HouseNo; ?></td>
                            <td><?php echo $IsAdmin; ?></td>
                            <td class="tbl-actions">
                                <a href="updatedata.php?id=<?php echo $Id; ?>" class="btn-green"><img src="drawable/edit.png" alt="edit"></a>
                                <a onclick="javascript: return confirm('Confirm document deletion?');" href="deletedata.php?id=<?php echo $Id; ?>" class="btn-red"><img src="drawable/delete.png" alt="delete"></a>
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
</html>