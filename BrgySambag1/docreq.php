<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

//requirements
require 'connection.php';
require 'checkuser.php';

if($_SESSION['loggedin']){
  $id = $_SESSION['id'];
  $verifysql = "SELECT * FROM users WHERE `userID` = '$id'";
  $verifyresult = mysqli_query($conn, $verifysql);
  $result = mysqli_fetch_array($verifyresult);
  if($result["verified"] == "1"){
    if(isset($_SESSION['privilege']) && $_SESSION['privilege']){
      echo "<script>window.location.href='index.php';</script>";
    }else{

    }
  }else{
    echo "<script>window.location.href='notverified.php?id=$id';</script>";
  }
}else{ 
  header('Location: login.php');
}


// add to cart 
if(isset($_POST['add'])){
  $document = $_POST['documents'];

  $sql = "INSERT INTO tbldocreqcart VALUES('', '$id', '$document')";
  if($query = mysqli_query($conn, $sql)){
    echo"<script>window.location.href = 'docreq.php'</script>";
  }else{
    echo"<script> alert('Something went wrong')";
  }
}

//query for the the docreq
if(isset($_POST['submit'])){
  $total = 0;
  $priceSql = "SELECT * FROM tbldocreqCart c JOIN tbldocument d ON c.docID = d.docID WHERE userID = $id";
  $priceQuery = mysqli_query($conn, $priceSql);
  while ($row = mysqli_fetch_array($priceQuery)) {
    $price = $row['price'];
    $total += $price;}

  $reference = generateReference();

  $cartsql = "SELECT * FROM tbldocreqcart WHERE userID = '$id'";
  $cartquery = mysqli_query($conn,$cartsql);

  while($cartRow = mysqli_fetch_assoc($cartquery)){
    $document = $cartRow['docID'];
    $purpose = $cartRow['purpose'];
    $status = 'pending';
    $currentDate = new DateTime();
    $date = $currentDate->format('Y-m-d H:i:s');
  
    $sql = "INSERT INTO docreq VALUES('' ,'$id', '$document', '$date', '$total', '$reference','$status', 0)";
    $result = mysqli_query($conn, $sql);
  }
      $clearCartsql = "DELETE FROM tbldocreqcart WHERE userID = '$id'";
      mysqli_query($conn, $clearCartsql);
      echo"<script> alert('Document request sent, please wait for approval');
          window.location.href = 'myDocReq.php';
          </script>";
}

function generateReference(){

  $id = $_SESSION['id'];
  $random = mt_rand(1000, 9999);
  $generatedReference = $id.$random;

  return $generatedReference;
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>User Registration</title>
  <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
  <!-- <link rel="stylesheet" type="text/css" hresf="style.css"> -->
</head>
<body>
  <div class="off-title mt-3">
        <h1 class="mt-3 text-secondary font-xxl">Request Document</h1>
        </div>
  <div class="cart-container">
    <div class="cart mt-3">
      <div class="ml-3 mr-3 cart-top font-md">
        <div id="items">
          <form action="" method="POST">
            <h2 class="text-primary">Choose a Document/Documents to Request</h2>
            <div class="p-1">
              <select name="documents" require>
              <?php 
                  require_once "connection.php";
                  $sql_query = "SELECT * from tbldocument;";
                  if ($result = $conn ->query($sql_query)) {
                      while ($row = $result -> fetch_assoc()) { 
                          $name = $row['docName'];
                          $docId = $row['docID'];
                          $price = $row['price'];
                ?>
                <option value= "<?php echo $docId; ?>"><?php echo $name; ?>= ₱ <?php echo $price; ?>.00</option>
              <?php
                      } 
                  } 
                ?>
              </select>
            </div>
              <button type="submit" name="add"><img src="drawable/add-black.png" alt="add">ADD DOCUMENT </button>
          </form>
        </div>
      </div>

      <h2 class="text-primary mt-3">Document Requests</h2>
  
      
      <div class="table">
        <table>
          <thead class="thead">
            <tr>
              <th class="font-poppins-medium" scope="col">DOCUMENT</th>
              <th class="font-poppins-medium" scope="col">PRICE</th>
              <th class="font-poppins-medium" scope="col">
                <a onclick="javascript: return confirm('Delete all document request?');" href="deleteCart.php?id=<?php echo $id; ?>" class="font-poppins-medium p text-white btn-error"><img src="drawable/delete.png" alt="delete"> Delete All</a>
              </th>
            </tr>
          </thead>
          <tbody class="tbl-data">
            <?php
              $sql = "SELECT * FROM tbldocreqCart c JOIN tbldocument d ON c.docID = d.docID WHERE userID = $id";
              $query = mysqli_query($conn, $sql);
              $row_count = 0;
              while($result = mysqli_fetch_assoc($query)){
                $name = $result['docName'];
                $docId = $result['docID'];
                $price = $result['price'];
                $cartId = $result['cartID'];
                $row_class = ($row_count % 2 == 0) ? 'even-row' : 'odd-row';
            ?>
            <tr class="<?php echo $row_class; ?>">
              <td class="font-poppins-semibold"><?php echo $name; ?></td>
              <td><?php echo $price; ?></td>
              <td>                                                                                                  <!-- i try daw ang btn-red if ok ba, if dili kay btn-error nlng-->
                <a onclick="javascript: return confirm('Confirm deletion?');" href="deleteFromCart.php?id=<?php echo $cartId; ?>" class="btn-error"><img src="drawable/delete.png" alt="delete"></a>
              </td>
            </tr>
            <?php $row_count++; }?>
          </tbody>
        </table>
      </div>
        <form action="" method="POST">
          <button type="submit" name="submit" class="m-2 font-md font-poppins-semibold text-white btn-primary">Send Document Request</button>
        </form>
        <?php
              $total = 0;
              $priceSql = "SELECT * FROM tbldocreqCart c JOIN tbldocument d ON c.docID = d.docID WHERE userID = $id";
              $priceQuery = mysqli_query($conn, $priceSql);
              while ($row = mysqli_fetch_array($priceQuery)) {
                $price = $row['price'];
                $total += $price;
              }
            ?>
            
            <p class="font-poppins-semibold font-l text-gray" id="total">Total: ₱<a id="price2"><?php if($total == 0){echo "0";}else{echo $total;} ?></a>php</p>
    </div>
  </div>
<?php include 'nav/footer.php'; ?>

</body>
</html>
