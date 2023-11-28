<?php
    require 'connection.php';
    require 'checkuser.php';
    $popId = $_GET["id"];

    $sql = "SELECT * FROM tblbrgyinfo b INNER JOIN tblpopulation p on b.InfoID = p.InfoID WHERE p.PopID = $popId;";
    $result = mysqli_query($conn, $sql);
    $info = mysqli_fetch_array($result, MYSQLI_ASSOC);

    //setting variables
    $id = $info['InfoID'];
    $brgyName = $info['Name'];
    $geographic = $info['Geographic District'];
    $legislative = $info['Legislative District'];
    $population = $info['Population'];
    $year = $info['YEAR'];
    $captain = $info['BrgyCaptain'];
    $psgcCode = $info['PSGC CODE'];
    $psgcClass = $info['PSGC Class'];
    
    //update function
    if(isset($_POST["submit"])){
        //updated data
        $newbrgyName = $_POST['name'];
        $newgeographic = $_POST['geographic'];
        $newlegislative = $_POST['legislative'];
        $newpopulation = $_POST['population'];
        $newyear = $_POST['year'];
        $newcaptain = $_POST['captain'];
        $newpsgcCode = $_POST['psgcCode'];
        $newpsgcClass = $_POST['psgcClass'];

        $sql1 = "UPDATE tblbrgyinfo SET `Name`= '$newbrgyName', `Geographic District`= '$newgeographic', `Legislative District`= '$newlegislative', `BrgyCaptain`= '$newcaptain', `PSGC CODE`= '$newpsgcCode', `PSGC Class`= '$newpsgcClass' WHERE InfoID = $id";
        $sql2 = "UPDATE tblpopulation SET `Population`= '$newpopulation', `YEAR`= '$newyear' WHERE PopID = $popId";
        if($result = mysqli_query($conn, $sql1) && $result2 = mysqli_query($conn, $sql2)){
            header("Location: brgyInfoDtb.php");
            die;
        }else {
            echo "Something went wrong. Please try again later.";
       }}
        
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <title>Document</title>
</head>
<body>
<div class="mt-3 regContainer">
    <div class="register">
      <h1>EDIT</h1>
        <form method="POST">
        <label> Barangay Name:</label>
          <input type="text" name="name" value="<?php echo $brgyName?>"required><br>
        <label> Geographic District:</label>
          <input type="text" name="geographic" value="<?php echo $geographic?>"required><br>
        <label> Legislative District:</label>
          <input type="text" name="legislative" value="<?php echo $legislative?>"required><br>
        <label> Population:</label>
          <input type="text" name="population" value="<?php echo $population?>"required><br>
        <label> Year when population was recorded:</label>
          <input type="text" name="year" value="<?php echo $year?> "required><br>
        <label> Barangay Captain:</label>
          <input type="text" name="captain" value="<?php echo $captain?>"required><br>
        <label> PSGC CODE:</label>
          <input type="text" name="psgcCode" value="<?php echo $psgcCode?>"required><br>
        <label> PSGC CLASS:</label>
          <input type="text" name="psgcClass" value="<?php echo $psgcClass?>"required><br>
        <button type="submit" name="submit"> UPDATE </button><br>
        <a href="javascript:history.back()"> << Back </a>
    </div>
</div>
<?php include 'nav/footer.php'; ?>

</body>
</html>