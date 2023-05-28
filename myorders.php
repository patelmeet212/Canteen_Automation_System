<?php
session_start();
require 'connection.php';
$conn = Connect();

if(!isset($_SESSION["rid"]))
{
header("location: canteenlist.php"); 
exit();
}

if(!isset($_SESSION['login_user2'])){
header("location: customerlogin.php"); 
}

?>

<html>

  <head>
    <title> Cart | Student Canteen </title>
    
  </head>

  <link rel="stylesheet" type = "text/css" href ="css/cart.css">
  <link rel="stylesheet" type = "text/css" href ="css/bootstrap.min.css">
  <script type="text/javascript" src="js/jquery.min.js"></script>
  <script type="text/javascript" src="js/bootstrap.min.js"></script>

  <body>

  
    <button onclick="topFunction()" id="myBtn" title="Go to top">
      <span class="glyphicon glyphicon-chevron-up"></span>
    </button>
  
    <script type="text/javascript">
      window.onscroll = function()
      {
        scrollFunction()
      };

      function scrollFunction(){
        if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
          document.getElementById("myBtn").style.display = "block";
        } else {
          document.getElementById("myBtn").style.display = "none";
        }
      }

      function topFunction() {
        document.body.scrollTop = 0;
        document.documentElement.scrollTop = 0;
      }
    </script>

    <nav class="navbar navbar-inverse navbar-fixed-top navigation-clean-search" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#myNavbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php">Student Canteen</a>
        </div>

        <div class="collapse navbar-collapse " id="myNavbar">
          <ul class="nav navbar-nav">
            <li><a href="index.php">Home</a></li>
            <li><a href="aboutus.php">About</a></li>
            <li><a href="contactus.php">Contact Us</a></li>

          </ul>

<?php
if(isset($_SESSION['login_user1'])){

?>


          <ul class="nav navbar-nav navbar-right">
            <li><a href="#"><span class="glyphicon glyphicon-user"></span> Welcome <?php echo $_SESSION['login_user1']; ?> </a></li>
            <li><a href="myrestaurant.php">MANAGER CONTROL PANEL</a></li>
            <li><a href="logout_m.php"><span class="glyphicon glyphicon-log-out"></span> Log Out </a></li>
          </ul>
<?php
}
else if (isset($_SESSION['login_user2'])) {
  ?>
           <ul class="nav navbar-nav navbar-right">
            <li><a href="#"><span class="glyphicon glyphicon-user"></span> Welcome <?php echo $_SESSION['login_user2']; ?> </a></li>
            <li><a href="foodlist.php"><span class="glyphicon glyphicon-cutlery"></span> Food Zone </a></li>
            <li class="active" ><a href="foodlist.php"><span class="glyphicon glyphicon-shopping-cart"></span> Cart
             (<?php
              if(isset($_SESSION["cart"])){
              $count = count($_SESSION["cart"]); 
              echo "$count"; 
            }
              else
                echo "0";
              ?>)
              </a></li>
               <li><a href="myorders.php"><span class="glyphicon glyphicon-gift"></span> My Orders </a></li>
           
            <li><a href="logout_u.php"><span class="glyphicon glyphicon-log-out"></span> Log Out </a></li>
          </ul>
  <?php        
}
else {

  ?>

<ul class="nav navbar-nav navbar-right">
            <li><a href="#" class="dropdown-toggle active" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-user"></span> Sign Up <span class="caret"></span> </a>
                <ul class="dropdown-menu">
              <li> <a href="customersignup.php"> User Sign-up</a></li>
              <li> <a href="managersignup.php"> Manager Sign-up</a></li>
              <li> <a href="#"> Admin Sign-up</a></li>
            </ul>
            </li>

            <li><a href="#" class="dropdown-toggle active" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-log-in"></span> Login <span class="caret"></span></a>
              <ul class="dropdown-menu">
              <li> <a href="customerlogin.php"> User Login</a></li>
              <li> <a href="managerlogin.php"> Manager Login</a></li>
              <li> <a href="#"> Admin Login</a></li>
            </ul>
            </li>
          </ul>

<?php
}
?>


        </div>

      </div>
    </nav>

    

<?php
if(isset($_REQUEST["btn"]))
{
  $sts=$_REQUEST["btn"];
  $oid=$_REQUEST["oid"];
  $fid=$_REQUEST["fid"];

   $query = mysqli_query($conn, "UPDATE orders set
    status='$sts' where F_ID='$fid' and order_id='$oid'");
 
}


// Storing Session
$user_check=$_SESSION['login_user2'];
$rid=$_SESSION["rid"];
$sql = "SELECT * FROM orders o WHERE o.username='$user_check' and o.R_ID='$rid' and o.status in ('Preparing','Prepared','Placed')  ORDER BY order_date desc";
$result = mysqli_query($conn, $sql);


if (mysqli_num_rows($result) > 0)
{

  ?>
<div class="container">
      <div class="jumbotron">
        <h1>Your Orders</h1>
        <p>Looks tasty...!!!</p>
        
      </div>
      
    </div>
    <div class="table-responsive" style="padding-left: 100px; padding-right: 100px;" >
      <center>
      <img id="loader" src="images/loading.gif" width="50px" height="50px" style="display:none;" />
      </center>
  <table class="table table-striped">
    <thead class="thead-dark">
      <tr>
        <th>  </th>
        <th> Order ID </th>
        <th> Food ID </th>
        <th> Order Date </th>
        <th> Food Name </th>
        <th> Price </th>
        <th> Quantity </th>
        
      </tr>
    </thead>

    <?PHP
      //OUTPUT DATA OF EACH ROW
      while($row = mysqli_fetch_assoc($result)){
        $qs="oid=".$row["order_ID"]."&fid=".$row["F_ID"];
    ?>

  <tbody>
    <tr>
      <td rowspan="2"> <span class="glyphicon glyphicon-menu-right"></span> </td>
      <td><?php echo $row["order_ID"]; ?></td>
      <td><?php echo $row["F_ID"]; ?></td>
      <td><?php echo $row["order_date"]; ?></td>
      <td><?php echo $row["foodname"]; ?></td>
      <td><?php echo $row["price"]; ?></td>
      <td><?php echo $row["quantity"]; ?></td>
      
    </tr>
    <tr>
      <td colspan="6">
        <table><tr><td style="color:blue;">Amount:&nbsp;&nbsp;</td><td style="font-weight: bold;">&#8377;<?php echo $row["price"]*$row["quantity"]."/-"; ?></td><td>&nbsp;&nbsp;</td><td style="color:blue;">Status:&nbsp;&nbsp;</td><td><?php echo $row["status"]; ?></td><td>&nbsp;&nbsp;</td><td align="right">
  
  <?php
  if($row["status"]=="Placed")
  {
?>
 <a href="myorders.php?btn=Cancelled&<?php echo $qs;?>"><button class="btn btn-warning"><span class="glyphicon glyphicon glyphicon-pencil"></span> Cancelled</button></a>
  
<?php
  }
  ?>

  <!-- <a href="status.php?btn=s1&<?php echo $qs;?>"><button class="btn btn-warning"><span class="glyphicon glyphicon glyphicon-pencil"></span> Preparing</button></a>
  <a href="status.php?btn=s2&<?php echo $qs;?>"><button class="btn btn-success"><span class="glyphicon glyphicon glyphicon-pencil"></span> Prepared</button></a>
  <a href="status.php?btn=s3&<?php echo $qs;?>"><button class="btn btn-success"><span class="glyphicon glyphicon glyphicon-pencil"></span> Delivered</button></a>
 -->

        </td></tr></table>
      </td>
    </tr>
    <tr><td colspan="7"><br></td></tr>
  </tbody>
  
  <?php } ?>
  </table>
</div>
    <br> <br><br><br><br><br><br><br>


  <?php } else { ?>

  <div class="container">
      <div class="jumbotron">
        <h1>Your Orders</h1>
        <p>Oops! We can't smell any food here. Go back and <a href="foodlist.php">order now.</a></p>
        
      </div>
      
    </div>
    <br><br><br><br><br><br><br><br><br><br><br><br><br><br>

  <?php } ?>


<script type="text/javascript">
      $(document).ready(function () {
      setTimeout(function () {
        if(loader.style.display=="inline")
        {
          loader.style.display="none";
        }
        else
        {
          loader.style.display="inline";
        }
        location.reload(true);
        
      }, 10000);
    });
    </script>


    </body>
</html>



