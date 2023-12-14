<?php
require 'connection.php';
require 'checkuser.php';
$id = $_SESSION['id'];

if(isset($_POST["submit"])){
  $brgyName = $_POST['name'];
  $geographic = $_POST['geographic'];
  $legislative = $_POST['legislative'];
  $population = $_POST['population'];
  $year = $_POST['year'];
  $captain = $_POST['captain'];
  $psgcCode = $_POST['psgcCode'];
  $psgcClass = $_POST['psgcClass'];

  $sql1 = "INSERT INTO tblbrgyinfo VALUES('', '$brgyName', '$geographic', '$legislative', '$captain', '$psgcCode', '$psgcClass')";
  mysqli_query($conn, $sql1);
  $primaryId = mysqli_insert_id($conn);

  $sql2 = "INSERT INTO tblpopulation VALUES('$primaryId', '', '$year', '$population')";
  if($result = mysqli_query($conn, $sql2)){
    echo"<script> alert('Information Added'); </script>";
}else {
    echo "Something went wrong. Please try again later.";
}}
?>

<!DOCTYPE html>
<html>
<head>
  <title>User Registration</title>
  <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
  <!-- <link rel="stylesheet" type="text/css" hresf="style.css"> -->
</head>
<body>
  <!-- <?php include 'topnavs/topnavDefault.html'?> -->
  <div class="regContainer">
    <div class="register">
    <h2 class="text-primary mb-1 font-xl">Edit Barangay Info</h2>
        <form method="POST">
        <label> Barangay Name:</label>
          <input type="text" name="name"required><br>
        <label> Geographic District:</label>
          <input type="text" name="geographic"required><br>
        <label> Legislative District:</label>
          <input type="text" name="legislative"required><br>
        <label> Population:</label>
          <input type="text" name="population"required><br>
        <label> Year when population was recorded:</label>
          <input type="text" name="year"required><br>
        <label> Barangay Captain:</label>
          <input type="text" name="captain"required><br>
        <label> PSGC CODE:</label>
          <input type="text" name="psgcCode"required><br>
        <label> PSGC CLASS:</label>
          <input type="text" name="psgcClass"required><br>
        <button type="submit" name="submit"> ADD </button><br>
        <a href="brgyInfoDtb.php"> << Back </a>
    </div>
</div>
<?php include 'nav/footer.php'; ?>

</body>
</html>
