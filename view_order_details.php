<?php
include('session_m.php');

if(!isset($login_session)){
header('Location: managerlogin.php'); 
}

?>
<!DOCTYPE html>
<html>

  <head>
    <title> Manager Login | Student Canteen </title>
  </head>

  <link rel="stylesheet" type = "text/css" href ="css/view_order_details.css">
  <link rel="stylesheet" type = "text/css" href ="css/bootstrap.min.css">
  <script type="text/javascript" src="js/jquery.min.js"></script>
  <script type="text/javascript" src="js/bootstrap.min.js"></script>

  <body style="padding-top: 50px;background-image: url('images/headerimg2.jpg');
  background-repeat: repeat;
  background-size: 100%;">

  
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

          <ul class="nav navbar-nav navbar-right">
            <li><a href="#"><span class="glyphicon glyphicon-user"></span> Welcome <?php echo $login_session; ?> </a></li>
            <li class="active"> <a href="managerlogin.php">MANAGER CONTROL PANEL</a></li>
            <li><a href="logout_m.php"><span class="glyphicon glyphicon-log-out"></span> Log Out </a></li>
          </ul>
        </div>

      </div>
    </nav>




<div class="container">
    <div class="jumbotron">
    	<h1 style="margin-bottom: 25px; text-align: center; font-size: 30px;color:crimson;font-weight: bold;">
          <?php
          $user_check=$_SESSION['login_user1'];
$sql1 = "SELECT * FROM canteens WHERE M_ID='$user_check'";
$result1 = mysqli_query($conn, $sql1);
$row1 = mysqli_fetch_assoc($result1);
echo $row1["name"]."<br>".$row1["college"];

         ?>
           
         </h1>
     <h1>Hello Manager! </h1>
     <p>Manage all your restaurant from here</p>

    </div>
    </div>

<div class="container">
    <div class="container">
    	<div class="col">
    		
    	</div>
    </div>

    
    	<div class="col-xs-3" style="text-align: center;">

    	<div class="list-group">
    		<a href="mycanteen.php" class="list-group-item ">My Canteen</a>
    		<a href="view_food_items.php" class="list-group-item">View Food Items</a>
    		<a href="add_food_items.php" class="list-group-item ">Add Food Items</a>
    		<a href="edit_food_items.php" class="list-group-item ">Edit Food Items</a>
    		<a href="delete_food_items.php" class="list-group-item ">Delete Food Items</a>
        <a href="view_order_details.php" class="list-group-item active">View Order Details</a>
        <a href="custlist.php" class="list-group-item ">View Customers</a>
       
    </div>
    </div>
    <div class="col-xs-9">
      <div class="form-area" style="padding: 0px 100px 100px 100px;">
        <br style="clear: both">
          <h3 style="margin-bottom: 25px; text-align: center; font-size: 30px;"> YOUR FOOD ORDER LIST </h3>
           <center>
      <img id="loader" src="images/loading.gif" width="50px" height="50px" style="display:none;" />
      </center>


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
$user_check=$_SESSION['login_user1'];
$sql = "SELECT o.*,c.fullname,c.contact FROM orders o,Customer c WHERE o.R_ID IN (SELECT r.R_ID FROM CANTEENS r WHERE r.M_ID='$user_check') and o.username=c.username ORDER BY order_date desc";
$result = mysqli_query($conn, $sql);


if (mysqli_num_rows($result) > 0)
{

  ?>

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
        <th> Customer </th>
        <th> Contact No </th>
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
      <td><?php echo $row["fullname"]; ?></td>
      <td><?php echo $row["contact"]; ?></td>
    </tr>
    <tr>
      <td colspan="8">
        <table style="width: 100%;"><tr><td style="color:blue;">Amount:&nbsp;</td><td style="font-weight: bold;">&#8377;<?php echo $row["price"]*$row["quantity"]."/-"; ?></td><td style="color:blue;">Status:&nbsp;</td><td><?php echo $row["status"]; ?></td><td align="right">
  
  <?php
  if($row["status"]=="Placed")
  {
?>
 <a href="view_order_details.php?btn=Preparing&<?php echo $qs;?>"><button class="btn btn-warning"><span class="glyphicon glyphicon glyphicon-pencil"></span> Preparing</button></a>
  
<?php
  }
  else if($row["status"]=="Preparing")
  {
?>
  <a href="view_order_details.php?btn=Prepared&<?php echo $qs;?>"><button class="btn btn-success"><span class="glyphicon glyphicon glyphicon-pencil"></span> Prepared</button></a>
 
<?php
  }
  else if($row["status"]=="Prepared")
  {
    ?>
  <a href="view_order_details.php?btn=Delivered&<?php echo $qs;?>"><button class="btn btn-success"><span class="glyphicon glyphicon glyphicon-pencil"></span> Delivered</button></a>
    <?php
  } 
  else if($row["status"]=="Delivered" or $row["status"]=="Cancelled" )
  {
   ?>
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
    <tr><td colspan="9"><br></td></tr>
  </tbody>
  
  <?php } ?>
  </table>
    <br>


  <?php } else { ?>

  <h4><center>0 RESULTS</center> </h4>

  <?php } ?>

      
        
        </div>
      
    </div>


    
    
</div>
<br>
<br>
<br>
<br>
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