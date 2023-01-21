<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
	{	
header('location:index.php');
}
else{ 

if(isset($_POST['update']))
{
$id=$_GET['bid'];
/*
$ttype=$_POST['txntype'];
$transactionno=$_POST['transactionno'];	
$message=$_POST['message'];
*/
#$query="update  tblcarwashbooking set adminRemark='$message',paymentMode='$ttype',txnNumber='$transactionno', status='Completed' where id=$id";

$query="update  tblcarwashbooking set status='Completed' where id=$id";

 if (mysqli_query($connect, $query)) {
	echo "<script>alert('Booking Details updated successfully');</script>";
	echo "<script>window.location.href ='all-bookings.php'</script>";
   } else {
	 echo "<script>alert('Something went wrong. Please try again.');</script>";
	 echo "Error: " . $sql . "<br>" . mysqli_error($conn);
   }

}




	?>
<!DOCTYPE HTML>
<html>
<head>
<title>CWMS | New Bookings</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<link href="css/bootstrap.min.css" rel='stylesheet' type='text/css' />
<link href="css/style.css" rel='stylesheet' type='text/css' />
<link rel="stylesheet" href="css/morris.css" type="text/css"/>
<link href="css/font-awesome.css" rel="stylesheet"> 
<script src="js/jquery-2.1.4.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/table-style.css" />
<link rel="stylesheet" type="text/css" href="css/basictable.css" />
<script type="text/javascript" src="js/jquery.basictable.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
      $('#table').basictable();

      $('#table-breakpoint').basictable({
        breakpoint: 768
      });

      $('#table-swap-axis').basictable({
        swapAxis: true
      });

      $('#table-force-off').basictable({
        forceResponsive: false
      });

      $('#table-no-resize').basictable({
        noResize: true
      });

      $('#table-two-axis').basictable();

      $('#table-max-height').basictable({
        tableWrapper: true
      });
    });
</script>
<link href='//fonts.googleapis.com/css?family=Roboto:700,500,300,100italic,100,400' rel='stylesheet' type='text/css'/>
<link href='//fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="css/icon-font.min.css" type='text/css' />
  <style>
		.errorWrap {
    padding: 10px;
    margin: 0 0 20px 0;
    background: #fff;
    border-left: 4px solid #dd3d36;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}
.succWrap{
    padding: 10px;
    margin: 0 0 20px 0;
    background: #fff;
    border-left: 4px solid #5cb85c;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}
		</style>
</head> 
<body>
   <div class="page-container">
   <!--/content-inner-->
<div class="left-content">
	   <div class="mother-grid-inner">
            <!--header start here-->
				<?php include('includes/header.php');?>
				     <div class="clearfix"> </div>	
				</div>
<!--heder end here-->
<ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="dashboard.php">Home</a><i class="fa fa-angle-right"></i>Manage New Bookings</li>
            </ol>
<div class="agile-grids">	
				<!-- tables -->

				<div class="agile-tables">
					<div class="w3l-table-info">
					  <h2>Bookings Details #<?php echo $_GET['bookingid'];?></h2>
					    <table id="table">
				
						</thead>
						<tbody>
<?php 
$bid=$_GET['bid'];
$query = "SELECT * from tblcarwashbooking
join tblwashingpoints on tblwashingpoints.id=tblcarwashbooking.carWashPoint
 where tblcarwashbooking.id='$bid'";
$response = mysqli_query($connect, $query);

while($i = mysqli_fetch_assoc($response)){
	echo "<tr><th width='200'>Booking Id#</th><td>".$i['bookingId']."</td>";
	echo "<th>Posting Date</th><td>".$i['postingDate']."</td></tr>";
	echo "<tr><th>Name</th><td width='300'>".$i['fullName']."</td>";
	echo "<th>Mobile No</th><td>".$i['mobileNumber']."</td></tr>";
	echo "<tr><th>Package Type</th><td>";
	
		$ptype=$i['packageType'];
		
		if($ptype==1): echo "BASIC CLEANING ($10.99)";endif;
		if($ptype==2): echo "PREMIUM CLEANING ($20.99)";endif;
		if($ptype==3): echo "COMPLEX CLEANING ($30.99)";endif;
	echo "</td>";
	echo "<th>Washing Point</th><td>".$i['washingPointName']."<br>".$i['washingPointAddress']."</td></tr>";
	echo "<tr><th>Washing Date</th><td>".$i['washDate']."</td><th>Washing Time</th><td>".$i['washTime']."</td></tr>";
	echo "<tr>	<th>Message (if Any)</th><td colspan='3'>".$i['message']."</td></tr>";
	echo "<tr>	<th>Status</th><td colspan='3'>".$i['status']."</td></tr>";

	if($i['status']=='New'){
		 echo "<tr><td colspan='3'>
		<button data-toggle='modal' data-target='#myModal' class='btn-primary btn'>Take Action</button>
		</td>
		</tr>";
	}
	else{
			
	}
}
?>

						
						</tbody>
					  </table>
					</div>
				  </table>

				
			</div>


<!--Model-->
 <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Update Booking #<?php echo $_GET['bookingid'];?></h4>
        </div>
        <div class="modal-body">
<form method="post">   
  <p>

            <p>If you want to complete, press "Complete", otherwise "Close"</p>
       
             <p><input type="submit" class="btn btn-custom" name="update" value="Complete!"></p>
      </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>









<!-- script-for sticky-nav -->
		<script>
		$(document).ready(function() {
			 var navoffeset=$(".header-main").offset().top;
			 $(window).scroll(function(){
				var scrollpos=$(window).scrollTop(); 
				if(scrollpos >=navoffeset){
					$(".header-main").addClass("fixed");
				}else{
					$(".header-main").removeClass("fixed");
				}
			 });
			 
		});
		</script>
		<!-- /script-for sticky-nav -->
<!--inner block start here-->
<div class="inner-block">

</div>
<!--inner block end here-->
<!--copy rights start here-->
<?php include('includes/footer.php');?>
<!--COPY rights end here-->
</div>
</div>
  <!--//content-inner-->
		<!--/sidebar-menu-->
						<?php include('includes/sidebarmenu.php');?>
							  <div class="clearfix"></div>		
							</div>
							<script>
							var toggle = true;
										
							$(".sidebar-icon").click(function() {                
							  if (toggle)
							  {
								$(".page-container").addClass("sidebar-collapsed").removeClass("sidebar-collapsed-back");
								$("#menu span").css({"position":"absolute"});
							  }
							  else
							  {
								$(".page-container").removeClass("sidebar-collapsed").addClass("sidebar-collapsed-back");
								setTimeout(function() {
								  $("#menu span").css({"position":"relative"});
								}, 400);
							  }
											
											toggle = !toggle;
										});
							</script>
<!--js -->
<script src="js/jquery.nicescroll.js"></script>
<script src="js/scripts.js"></script>
<!-- Bootstrap Core JavaScript -->
   <script src="js/bootstrap.min.js"></script>
   <!-- /Bootstrap Core JavaScript -->	   

</body>
</html>
<?php } ?>