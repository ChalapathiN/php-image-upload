<?php
	session_start();
	include 'manage-ad/config.php';
	date_default_timezone_set('Asia/Calcutta');
	
	function compress($source,$url,$quality)
	{
		$info= getimagesize($source);
		$image;
		if($info['mime']== 'image/jpeg')
			$image=imagecreatefromjpeg($source);
		elseif($info['mime']== 'image/gif')
			$image=imagecreatefromgif($source);
		elseif($info['mime']== 'image/png')
			$image=imagecreatefrompng($source);
			
		imagejpeg($image,$url,$quality);
		return $url;
	}
	
	if(isset($_POST['signup']))
	{
		$amount=$_POST['amount'];
		$months=$_POST['months'];
		$reason=$_POST['reason'];
		$special_category=$_POST['special_category'];
		
		$name=$_POST['name'];
		$email=$_POST['email'];
		$phone=$_POST['phone'];
		$password=$_POST['password'];
		$state=$_POST['state'];
		$city=$_POST['city'];
		$address=$_POST['message'];
		$gender=$_POST['gender'];
		$occupation=$_POST['occupation'];
		$age=$_POST['age'];
		
		$psd=md5($password);
		
		$date=date("Y-m-d");
		
		$qry=mysql_query("delete from tmp_borrower where email='$email'");
		
		$sql=mysql_query("INSERT INTO tmp_borrower (name,email,phone,password,state,city,address,gender,amount,months,reason,occupation,age,payment_status, active_status,paid_amount,date_joined,psd,spl_category) VALUES ('$name', '$email', '$phone', '$psd', '$state', '$city', '$address', '$gender', '$amount', '$months', '$reason', '$occupation', '$age', '0', '0', '0','$date','$password','$special_category')");
		
		if($amount <= 1000000)
		{
			$payment_fee=1500;
		}
		else if(($amount >=1000001) and ($amount <=5000000))
		{
			$payment_fee=2000;
		}
		else if(($amount >=5000001) and ($amount <=10000000))
		{
			$payment_fee=2500;
		}
		else
		{
			$payment_fee="000";
		}
		if($sql)
		{
				for($i=0;$i<count($_FILES["file"]["name"]);$i++)
				{
					if($_FILES["file"]["size"][$i]>1)
					{
						$random_digit=rand(10,100);
						$url="uploads/documents/".$random_digit.$_FILES["file"]["name"][$i];
						$img_path="uploads/documents/".$random_digit.$_FILES['file']['name'][$i];
						$filesize=$_FILES['file']['size'][$i];
						$size=$filesize;
									
						$filename=compress($_FILES['file']['tmp_name'][$i],$url,50);
						
						$qry1=mysql_query("INSERT INTO tmp_document(email,path,type) VALUES ('$email', '$img_path', '2')");
						
					}
				}
			$_SESSION['name']=$name;
			$_SESSION['email']=$email;
			$_SESSION['phone']=$phone;
			$_SESSION['amount']=$payment_fee;
			if($payment_fee=="00")
			{
				header("location:index.php#contact");	
			}
			else
			{
				header("location:borrower_instamojo.php");
			}
		}
		else
		{
			header("location:index.php");
		}
	}
	
?>
<!DOCTYPE HTML>
<html lang="en-US">

<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1"/>
	<meta name="description" content=""/>
	<meta name="keywords" content=""/>
	<meta name="robots" content=",index,follow" />
	<meta name='revisit-after' content='1 days' />
	<title>Indiaeasy Loans</title>
	<link href="https://fonts.googleapis.com/css?family=Poppins:300,400,700" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Pacifico" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="css/libs/font-awesome.min.css"/>
	<link rel="stylesheet" type="text/css" href="css/libs/ionicons.min.css"/>
	<link rel="stylesheet" type="text/css" href="css/libs/bootstrap.min.css"/>
	<link rel="stylesheet" type="text/css" href="css/libs/bootstrap-theme.min.css"/>
	<link rel="stylesheet" type="text/css" href="css/libs/jquery.fancybox.css"/>
	<link rel="stylesheet" type="text/css" href="css/libs/jquery-ui.min.css"/>
	<link rel="stylesheet" type="text/css" href="css/libs/owl.carousel.css"/>
	<link rel="stylesheet" type="text/css" href="css/libs/owl.transitions.css"/>
	<link rel="stylesheet" type="text/css" href="css/libs/jquery.mCustomScrollbar.css"/>
	<link rel="stylesheet" type="text/css" href="css/libs/owl.theme.css"/>
	<link rel="stylesheet" type="text/css" href="css/libs/slick.css"/>
	<link rel="stylesheet" type="text/css" href="css/libs/animate.css"/>
	<link rel="stylesheet" type="text/css" href="css/libs/hover.css"/>
	<link rel="stylesheet" type="text/css" href="css/color8.css" media="all"/>
	<link rel="stylesheet" type="text/css" href="css/theme.css" media="all"/>
	<link rel="stylesheet" type="text/css" href="css/responsive.css" media="all"/>
	<link rel="stylesheet" type="text/css" href="css/browser.css" media="all"/>
	<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Sunflower:300" rel="stylesheet">
	
	<link rel="stylesheet" href="css/easy-responsive-tabs.css">
<link href="css/jquerysctipttop.css" rel="stylesheet" type="text/css">
<style>
.demo{margin:150px auto;width:980px;}
.demo h1{margin:0 0 25px;}
.demo h3{margin:10px 0;}
pre{background-color:#FFF;}
@media only screen and (max-width:780px){
.demo{margin:5%;width:90%;}
.how-use{display:none;float:left;width:300px;}
}
#tabInfo{display:none;}
.resp-tab-active{color:#333 !important;}
</style>
	<style>
	@media (max-width: 767px) {
		#content{
			padding:211px 0 !important;
			}
		
		}
	
	</style>
	<!--Popup Start-->
	<script src="pop/jquery-loader.js"></script>
    <link rel="stylesheet" href="pop/qunit/qunit/qunit.css" media="screen">
    <script src="pop/qunit/qunit/qunit.js"></script>
	<link rel="stylesheet" href="pop/remodal.css">
    <link rel="stylesheet" href="pop/remodal-default-theme.css">
    <script src="pop/remodal.js"></script>
    <script src="popremodal_test.js"></script>
    <style>
      .remodal-overlay.without-animation.remodal-is-opening,
      .remodal-overlay.without-animation.remodal-is-closing,
      .remodal.without-animation.remodal-is-opening,
      .remodal.without-animation.remodal-is-closing,
      .remodal-bg.without-animation.remodal-is-opening,
      .remodal-bg.without-animation.remodal-is-closing {
        animation: none;
      }
    </style>
<!--Popup End-->
	<style>
	
	p {
    margin: 0 0 10px;
    font-family: 'Open Sans', sans-serif;
}
.h1, .h2, .h3, .h4, .h5, .h6, h1, h2, h3, h4, h5, h6{font-family: 'Sunflower', sans-serif;}
.main-nav.main-nav8 > ul > li > a:hover{color: #337ab7;}

	</style>
	<!-- <link rel="stylesheet" type="text/css" href="css/rtl.css" media="all"/> -->
	<script>
		function goto_step2()
		{
			amount=$("#amount").val();
			months=$("#months").val();
			
			reason=$("#reason").val();
			spl=$("#special_category").val();
			if((amount =="") || (months =="") || (reason =="") || (spl ==""))
			{
				$("#error_msg0").css("display","block");
			}
			else
			{
				document.getElementById('step1').click()
			}
		}
		
		function check_password()
		{
			psd=$("#password").val();
			c_psd=$("#con_password").val();
			if(c_psd=="")
			{
				return;
			}
			else
			{
				if(psd!=c_psd)
				{
					alert("Password Mismatched Try Again...!");
					$("#password").val("");
					$("#con_password").val("");
					$("#password").focus();
				}
			}
		}
		function get_city()
		{
			
			var state=$('#state').val();
				jQuery.ajax({
				type:"POST",
				url:"ajax.php?f=get_city",
				datatype:"text",
				data:{state:state},
				success:function(response)
				{
					
					$('#city').empty();
					$('#city').append(response);
				},
				error:function (xhr, ajaxOptions, thrownError){}
				});
			
		}
		function validate_email()
		{
			email=$("#email").val();
			jQuery.ajax({
				type:"POST",
				url:"ajax_validate.php?f=validate_borrower_email",
				datatype:"text",
				data:{email:email},
				success:function(response)
				{
					if(response ==1)
					{
						alert("Email ID Already Exists !");
						$("#email").val("");
						$("#email").focus();
					}
					save_student_details_temp()
				},
				error:function (xhr, ajaxOptions, thrownError){}
				});
		}			
	</script>
	<script>
			function isNumber(evt) 
			{
				evt = (evt) ? evt : window.event;
				var charCode = (evt.which) ? evt.which : evt.keyCode;
				if (charCode > 31 && (charCode < 48 || charCode > 57)) 
				{
					return false;
				}
				return true;
			}
			function calculate_payable_amountq()
			{
				amount=parseInt($("#amount").val());
				if(amount<=1000000)
				{
					payable="Rs. 1000";
					
				}
				else if(amount >=1000001 && amount <=5000000)
				{
					payable="Rs. 1000";
				}
				else if(amount >=5000001 && amount <=10000000)
				{
					payable="Rs. 1000";
				}
				else
				{
					payable="Contact Support Team";
				}
				$("#amount_display").css("display","block");
				$("#amount_payable").empty();
				$("#amount_payable").append(payable);
			}
			function display_payable_charge()
			{
				val=$("#loan_range").val();
				if(val !="")
				{
					$("#amount_display").css("display","block");
					$("#amount_payable").empty();
					$("#amount_payable").append("Rs. 1000");
					$("#apply").css("display","block");
				}
				else
				{
					$("#amount_display").css("display","block");
					$("#amount_payable").empty();
					$("#amount_payable").append("Contact Support Team");
					$("#apply").css("display","none");
				}
			}
	</script>
		<script>
		function save_student_details_temp()
		{

			name=$("#name").val();
			phone=$("#phone").val();
			email=$("#email").val();
			age=$("#age").val();
			type=3;

			if(name!=""){
				
				jQuery.ajax({
				type:"POST",
				url:"ajax_validate.php?f=save_student_details_temp",
				datatype:"text",
				data:{name:name,phone:phone,email:email,age:age,type:type},
				success:function(response)
				{
				
				
				},
				error:function (xhr, ajaxOptions, thrownError){}
				});
			}
		}
	</script>
	<style>
	@media (max-width: 767px) {
		#content{
			padding:211px 0 !important;
			}
		
		}
	
	</style>
		<script async src="https://www.googletagmanager.com/gtag/js?id=UA-124957503-1"></script>
		<script>
		  window.dataLayer = window.dataLayer || [];
		  function gtag(){dataLayer.push(arguments);}
		  gtag('js', new Date());

		  gtag('config', 'UA-124957503-1');
		</script>
</head>
<body style="background:#f9f9f9">
<div class="wrap">
	<?php include("menu.php");?>
	<!-- End Header -->
	<section id="content" style=" background-image:url(assets/financier2.jpg);background-repeat: no-repeat;
    -webkit-background-size: cover;
    -moz-background-size: cover;padding:123px 0;
    -o-background-size: cover;
    background-size: cover;
    background-position: center;">
			
			<div class="container">
				
				<div class="row">					
					<div class="col-md-6 col-sm-6 col-xs-12  wow fadeInUp" style="    background-color: #337ab77a;
    box-shadow: 7px 9px 8px #2d2c2ca3;
    padding: 2%;
    border: 1px dotted #fff;
    border-radius: 6px;">
						<div id="horizontalTab">
							<ul class="resp-tabs-list">
								<li style="color:#fff;" id="step0">Step 1</li>
								<li style="color:#fff;" id="step1">Step 2</li>
							</ul>
<div class="resp-tabs-container">	
		<div>
			<h2 style="padding-bottom: 2%;font-size: 24px;font-family: inherit;"> Please Enter The Details !</h2>
				<div class="form-contact">
					<form method="POST" action="" enctype="multipart/form-data">
						<div class="row">
							<div class="col-md-12 col-sm-4 col-xs-12">
								<input type="text"  placeholder="How much you want to take loan ?*" class="form-control" id="amount" name="amount" onkeypress="return isNumber(event)" onchange="calculate_payable_amount();" required="" style="margin-bottom: 30px;" autocomplete="off">
							</div>
							<div class="col-md-12 col-sm-4 col-xs-12">
								<input type="text"  placeholder="How many month tenure ?*" class="form-control" id="months" name="months" required="" style="margin-bottom: 30px;" onkeypress="return isNumber(event)" autocomplete="off">
							</div>
							<div class="col-md-12 col-sm-4 col-xs-12">
								<input type="text"  placeholder="Reason for taking loan ?*" class="form-control" id="reason" name="reason" required="" style="margin-bottom: 30px;" autocomplete="off">
							</div>
							<div class="col-md-12 col-sm-4 col-xs-12">
								<select required name="special_category" id="special_category" style="width:100%;display:block;border:1px solid #e5e5e5;border-radius:7px;height:40px;color:#999;padding: 0 15px;margin-bottom: 30px;">
									  <option value="">Special category for taking loan ?*</option>
									  <option value="Education">Education</option>
									  <option value="Helping to Others">Helping to Others</option>
									  <option value="Medicals">Medicals</option>
									  <option value="Vacation / Holidays">Vacation / Holidays</option>
									  <option value="Personal">Personal</option>
									  <option value="Construction">Construction</option>
									  <option value="Business">Business</option>
									  <option value="Start Up">Start Up</option>
									  <option value="Vehicle">Vehicle</option>
									  <option value="School Fees">School Fees</option>
									  <option value="Others">Others</option>
								</select>
							</div>
							<p id="error_msg0" style="color:red;margin-left: 3%;display:none">* Fill all mandatory fields</p>
							<div class="col-md-12 col-sm-12 col-xs-12">
								<input class="shop-button" value="Continue" type="button" onclick="goto_step2();">
							</div>
						</div>
				</div>
		</div>
		<div>
			<h2 style="padding-bottom: 2%;font-size: 24px;font-family: inherit;"> Please Enter Your Personal Details !</h2>
			<div class="form-contact" style="padding-top:2%;">
					<div class="row">
						<div class="col-md-6 col-sm-4 col-xs-12">
							<input name="name" placeholder="Name *" onchange="save_student_details_temp();" type="text" id="name" style="margin-bottom: 20px;" required autocomplete="off">
						</div>
						<div class="col-md-6 col-sm-4 col-xs-12">
							<select name="age" id="age" onchange="save_student_details_temp();" required style="width: 100%;display: block;border: 1px solid #e5e5e5;    border-radius: 7px;height: 40px;color: #999;padding: 0 15px;margin-bottom: 20px;">
							  <option value="">Age</option>
							  <?php 
								for($i=18;$i<=72;$i++)
								{
									echo '<option value="'.$i.'">'.$i.' years</option>';
								}
							  ?>
							</select>														
						</div>
						<div class="col-md-12 col-sm-4 col-xs-12" style="margin-left: 4px;">
							<label>Gender</label></br>
								<div style="padding-bottom:2%;">
									<label class="radio-inline">
										<input type="radio" id="gender" name="gender" value="1" required>Male
									</label>
									<label class="radio-inline">
										<input type="radio" id="gender" name="gender" value="2" required>Female
									</label>	
								</div>	
						</div>
						<div class="col-md-6 col-sm-4 col-xs-12">
							<input name="occupation" placeholder="Occupation *" type="text" id="occupation" style="margin-bottom: 20px;" required autocomplete="off">	
						</div>
						<div class="col-md-6 col-sm-4 col-xs-12">
							<input name="phone" id="phone" onchange="save_student_details_temp();" maxlength="10" required placeholder="Mobile no*" type="text" autocomplete="off">
						</div>					
						<div class="col-md-6 col-sm-4 col-xs-12">
							<select id="state" name="state" required style="width: 100%;display: block;border: 1px solid #e5e5e5;border-radius: 7px;height: 40px;color: #999;padding: 0 15px;margin-bottom: 20px;" onchange="get_city();">
								<option value="">State</option>
								<?php
									$sql=mysql_query("select * from state_list order by state ASC");
									while($row=mysql_fetch_array($sql))
									{
										echo '<option value="'.$row['id'].'">'.$row['state'].'</option>';
									}
								?>
							</select>								
						</div>
						<div class="col-md-6 col-sm-4 col-xs-12">
							<select id="city" name="city" required style="width: 100%;display: block;border: 1px solid #e5e5e5;border-radius: 7px;height: 40px;color: #999;padding: 0 15px;margin-bottom: 20px;">
							  <option value="">City</option> 
							</select>								
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12">
							<textarea name="message" placeholder="Address" cols="30" rows="4" style="border-radius: 7px;padding: 3px 15px;margin-bottom: 20px;"></textarea>
						</div>
						<div class="col-md-12 col-sm-4 col-xs-12">
							<input name="email" id="email" Placeholder="Email address*" onchange="validate_email();" type="email" class="form-control" style="margin-bottom: 20px;" required autocomplete="off">
						</div>	
						<div class="col-md-6 col-sm-4 col-xs-12" style="margin-bottom: 20px;">
							<input name="password" id="password" onchange="check_password();" class="form-control" placeholder="Password*" type="password" required>
						</div>
						<div class="col-md-6 col-sm-4 col-xs-12" style="margin-bottom: 20px;">
							<input name="con_password" id="con_password" onchange="check_password();" class="form-control" placeholder="Confirm Password*" type="password" required>
						</div>
						<div class="col-md-12 col-sm-4 col-xs-12" style="margin-left: 4px;margin-bottom: 20px;">
								<label>Upload (Government ID Proof in Image Format)</label></br>
								<input type="file" name="file[]" multiple id="file" required>
						</div>
						<div class="col-md-12 col-sm-4 col-xs-12">
								<select required name="loan_range" id="loan_range" style="width:100%;display:block;border:1px solid #e5e5e5;border-radius:7px;height:40px;color:#999;padding: 0 15px;margin-bottom: 30px;" onchange="display_payable_charge();">
									  <option value="" disabled selected>Loan Range ?*</option>
									  <option value="1500">Upto 10 lakhs</option>
									  <option value="2000">10 lakhs to 50 lakhs</option>
									  <option value="2500">50 lakhs to 1 Crore</option>
									  <option value="">Above 1 Crore</option>
								</select>
						</div>
						<div class="col-md-12 col-sm-4 col-xs-12" id="amount_display" style="margin-left: 4px;margin-bottom: 20px;display:none">
							<label>Amount Payable : <span id="amount_payable"> 1000</span></label>
						</div>
						<div class="col-md-12 col-sm-4 col-xs-12">
							<input ng-model="terms" type="checkbox" id="terms" name="terms" required="" class="ng-pristine ng-untouched ng-empty ng-invalid ng-invalid-required" style="float: left;">
							<p> &nbsp;I have read all <a href="terms.php" target="_blank" style="text-decoration: underline;color: #2424ca;">Terms & Conditions</a>.I agree to all its content.</p>
							<label>Note : <span id="note">BILL INVOICE WILL BE GENERATED AND SENT TO YOUR E-MAIL ID </span></label>
						</div>	
						
						<div class="col-md-12 col-sm-12 col-xs-12" style="margin-top:1%">
							<input class="shop-button" value="Apply" id="apply" type="submit" name="signup">
						</div>	
					</div>
			</div>
		</div>

	</form>	
</div>
</div>
					</div>
					
					
				</div>
			
			</div>
		
		
	</section>
	<!-- End Content 
				<div class="col-md-12 col-sm-4 col-xs-12">
					<div style="padding:  2%;background: #eae4e4;border: 1px solid #bbdcdb;">
						<p> ** Note</p>
						<p> Upto 10 lakhs - <i class="fa fa-inr"></i> 1500</p>
						<p> 10 lakhs to 50 lakhs - <i class="fa fa-inr"></i> 2000</p>
						<p> 50 lakhs to 1 Crore - <i class="fa fa-inr"></i> 2500</p>
						<p> Above 1 Crore - Contact Support Team</p>
					</div>
				</div>
	-->
<?php 
			
				include 'footer.php';
			
			?>
	
	
	<!-- End Wishlist Mask -->
	<a href="#" class="scroll-top round"><i class="fa fa-angle-double-up" aria-hidden="true"></i></a>
	<div id="loading">
		<div id="loading-center">
			<div id="loading-center-absolute">
				<div class="object" id="object_four"></div>
				<div class="object" id="object_three"></div>
				<div class="object" id="object_two"></div>
				<div class="object" id="object_one"></div>
			</div>
		</div>
	</div>
	<!-- End Preload -->
</div>
<script type="text/javascript" src="js/libs/jquery-3.2.1.min.js"></script>
<script>
	   $(document).ready(function () {
        
         $("#phone").keypress(function (e) {
        
         if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        
         
         	   return false;
         }
          });
		  
		   $("#name").keypress(function (e) 
				{
					if(e.which==32)
					{
						return true;
					}
						
				else if (e.which > 31 && (e.which < 65 || e.which > 90) && (e.which < 97 || e.which > 122) || e.which==13)
					{
						return false;
					}
				});
         });
		$(document).ready(function(){
			$("#phone").focusout(function()
			{
				var val=$("#phone").val();
				if(val!="")
				{
					var len=val.length;
					if(len!=10)
					{
						alert("Invalid Mobile Number!");
						$("#phone").val("");
						$("#phone").focus();
					}
					if(isNaN(val))
					{
						alert("Invalid Mobile Number!");
						$("#phone").val("");
						$("#phone").focus();
					}
					
				}
			});
		});
</script>
<script type="text/javascript" src="js/libs/bootstrap.min.js"></script>
<script type="text/javascript" src="js/libs/jquery.fancybox.js"></script>
<script type="text/javascript" src="js/libs/jquery-ui.min.js"></script>
<script type="text/javascript" src="js/libs/owl.carousel.min.js"></script>
<script type="text/javascript" src="js/libs/jquery.jcarousellite.min.js"></script>
<script type="text/javascript" src="js/libs/jquery.elevatezoom.js"></script>
<script type="text/javascript" src="js/libs/jquery.mCustomScrollbar.min.js"></script>
<script type="text/javascript" src="js/libs/slick.js"></script>
<script type="text/javascript" src="js/libs/popup.js"></script>
<script type="text/javascript" src="js/libs/timecircles.js"></script>
<script type="text/javascript" src="js/libs/wow.js"></script>
<script type="text/javascript" src="js/theme.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="js/easy-responsive-tabs.js"></script>

<script>
$(document).ready(function () {
$('#horizontalTab').easyResponsiveTabs({
type: 'default', //Types: default, vertical, accordion           
width: 'auto', //auto or any width like 600px
fit: true,   // 100% fit in a container
closed: '', // Start closed if in accordion view //accordion
activate: function(event) { // Callback function if tab is switched
var $tab = $(this);
var $info = $('#tabInfo');
var $name = $('span', $info);
$name.text($tab.text());
$info.show();
}
});
$('#verticalTab').easyResponsiveTabs({
type: 'vertical',
width: 'auto',
fit: true
});
});
</script>
</body>

</html>
