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
    if($_POST['pass'] == $_POST['conPass']){
        $password = $_POST['pass'];
        $email = $_POST['email'];

        if(strlen($password) >= 8 && $password == $_POST['conPass']){
            $sql = "INSERT INTO users VALUES('', '0', '$email' , MD5('$password'), 1, 0)";
            if($query = mysqli_query($conn, $sql)){
                echo "<script> alert('Admin successfully added!');
                history.go(-1)</script>";
            } else {
                echo "<script> alert('Something went wrong...');
                history.go(-1)</script>";
            }
        } else {
            echo "<script> alert('Password must be at least 8 characters long and must match');
            history.go(-1)</script>";
        }

    } else {
        echo "<script> alert('Password didnt match');
            history.go(-1);</script>";
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
                <label>Email:</label>
                    <input type="text" name="email" class="mb-2" required>
                <label>Password:</label>
                <input type="password" name="pass" id="password" required><br>
                <input type="checkbox" onclick="myFunction()" id="showpass"> Show Password </input>
                <script>
                    function myFunction() {
                    var x = document.getElementById("password");
                    if (x.type === "password") {
                        x.type = "text";
                    } else {
                        x.type = "password";
                    }
                    }
                </script>
                <label>Confirm Password:</label>
                    <input type="password" name="conPass" required>
                <input type="submit" name="submit" class="btn-primary" value="ADD ADMIN">
            </form>
        </div>
    </div>

<div class="off-back">
<div class="off-title mt-3">
    <h1 class="mt-3 text-secondary font-xxl">ADMINISTRATORS</h1>
</div>
    <section class="dtbCont">
            <div class="table mb-3">
                <table>
                    <thead  class="thead">
                      <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Email</th>
                        <th id='toggleAdd'><img src='drawable/add.png' alt='+'></th>
                      </tr>
                    </thead>
                    <tbody class="tbl-data">
                        <?php 
                            require_once "connection.php";
                            $sql_query = "SELECT * FROM users u 
                                JOIN tblresidents r ON u.residentID = r.residentID 
                                WHERE u.isAdmin = 1 AND u.Archive = 0 AND userID != $id";
                            if ($result = $conn ->query($sql_query)) {
                                $row_count = 0;
                                while ($row = $result -> fetch_assoc()) { 
                                    $userId = $row['userID'];
                                    $Email = $row['email'];
                                    $IsAdmin = $row['isAdmin'];
                                    $row_class = ($row_count % 2 == 0) ? 'even-row' : 'odd-row';
                        ?>
                        
                        <tr class="<?php echo $row_class; ?>">
                            <td><?php echo $userId; ?></td>
                            <td><?php echo $Email; ?></td>
                            <td class="tbl-actions">
                                <a href="updatedata.php?id=<?php echo $userId; ?>" class="btn-green"><img src="drawable/edit.png" alt="edit"></a>
                                <a onclick="javascript: return confirm('Confirm document deletion?');" href="deletedata.php?id=<?php echo $userId; ?>" class="btn-red"><img src="drawable/delete.png" alt="delete"></a>
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