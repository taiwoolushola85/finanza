<?php 
include '../config/db.php';
$id = $_GET['id']; // repayment id
$d = date('Y-m-d');
$Query = "SELECT id, Location, Account_Number, Firstname, Lastname, Reg_id, Paid, Unions, Loan_Amount, Total_Bal, Interest_Amt FROM repayments 
WHERE id = '$id' ORDER BY id ASC LIMIT 1";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$id = $row['id'];
$reg_id = $row['Reg_id'];
$loc = $row['Location'];
$pd = $row['Paid'];
$un = $row['Unions'];
$nam = $row['Firstname']." ".$row['Lastname'];
$la = $row['Loan_Amount'];
$tb = $row['Total_Bal'];
$int = $row['Interest_Amt'];
$vrt = $row['Account_Number'];
// payment schedule
$sql = "SELECT count(*)  AS overs FROM schedule WHERE Regs_id = '$reg_id' AND Payment_Status = 'Outstanding'";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$nxt = $data['overs'];
// getting total sum of payment history
$sql = "SELECT SUM(Amount) AS lm FROM history WHERE Status ='Paid' AND Register_id = '$reg_id' ";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$pmt = $data['lm'];

if($pd == $pmt){
// do nothing
}else{
$Query = "UPDATE repayments SET Paid ='$pmt', Total_Bal = Total_Loan - $pmt WHERE Reg_id = '$reg_id' ";
$result= mysqli_query($con, $Query);
}
?>


<div class="row">
<div class="col-sm-3">
<div class="d-flex flex-column align-items-center text-center">
<img src="<?php echo $loc; ?>"  class="rounded-circle" width="120" height="120px">
<div class="mt-3">
<h4><b><?php echo $nam; ?></b></h4>
<p class="text-secondary mb-1"><?php echo $un; ?> Group</p>
<p class="text-muted" style="font-size: 12px;">Account: <?php echo $vrt; ?></p>
</div>
</div>
<button type="button" class="btn btn-outline-info btn-sm w-100 mb-2" onclick="clientDash()">
<i class="fa fa-dashboard"></i> Dashboard
</button>
<button type="button" class="btn btn-outline-success btn-sm w-100 mb-2" onclick="clientLoan()">
<i class="fa fa-money"></i> Loan Overview
</button>
<button type="button" class="btn btn-outline-primary btn-sm w-100 mb-2" onclick="clientOver()">
<i class="fa fa-user"></i> Client Overview
</button>
<button type="button" class="btn btn-outline-warning btn-sm w-100 mb-2" onclick="clientBiz()">
<i class="fa fa-image"></i> Business Gallery
</button>
<button type="button" class="btn btn-outline-danger btn-sm w-100 mb-2" onclick="clientAssign()">
<i class="fa fa-exclamation-triangle"></i> Assign For Recovery
</button>
</div>

<div class="col-sm-9">
<!-- Dashboard Section -->
<div id="dash" style="display:block;">
<br>
<h4 class="mb-4"><b>Dashboard</b></h4>
<br>
<div class="row">
<div class="col-sm-6 col-lg-6 col-xl-6">
<div class="card">
<div class="card-body iq-box-relative">
<div class="iq-service d-flex align-items-center justify-content-between" style="position: relative;">
<div class="service-data">
<svg fill="none" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
<path fill-rule="evenodd" clip-rule="evenodd" d="M17.7689 8.3818H22C22 4.98459 19.9644 3 16.5156 3H7.48444C4.03556 3 2 4.98459 2 8.33847V15.6615C2 19.0154 4.03556 21 7.48444 21H16.5156C19.9644 21 22 19.0154 22 15.6615V15.3495H17.7689C15.8052 15.3495 14.2133 13.7975 14.2133 11.883C14.2133 9.96849 15.8052 8.41647 17.7689 8.41647V8.3818ZM17.7689 9.87241H21.2533C21.6657 9.87241 22 10.1983 22 10.6004V13.131C21.9952 13.5311 21.6637 13.8543 21.2533 13.8589H17.8489C16.8548 13.872 15.9855 13.2084 15.76 12.2643C15.6471 11.6783 15.8056 11.0736 16.1931 10.6122C16.5805 10.1509 17.1573 9.88007 17.7689 9.87241ZM17.92 12.533H18.2489C18.6711 12.533 19.0133 12.1993 19.0133 11.7877C19.0133 11.3761 18.6711 11.0424 18.2489 11.0424H17.92C17.7181 11.0401 17.5236 11.1166 17.38 11.255C17.2364 11.3934 17.1555 11.5821 17.1556 11.779C17.1555 12.1921 17.4964 12.5282 17.92 12.533ZM6.73778 8.3818H12.3822C12.8044 8.3818 13.1467 8.04812 13.1467 7.63649C13.1467 7.22487 12.8044 6.89119 12.3822 6.89119H6.73778C6.31903 6.89116 5.9782 7.2196 5.97333 7.62783C5.97331 8.04087 6.31415 8.37705 6.73778 8.3818Z" fill="currentColor" />
</svg>
<h3 style="visibility: visible;"><?php echo number_format($la,2); ?></h3>
<p class="mb-0">Principal Amount</p>
</div>
</div>
</div>
</div>
</div>

<div class="col-sm-6 col-lg-6 col-xl-6">
<div class="card">
<div class="card-body iq-box-relative">
<div class="iq-service d-flex align-items-center justify-content-between" style="position: relative;">
<div class="service-data">
<svg fill="none" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
<path fill-rule="evenodd" clip-rule="evenodd" d="M17.7689 8.3818H22C22 4.98459 19.9644 3 16.5156 3H7.48444C4.03556 3 2 4.98459 2 8.33847V15.6615C2 19.0154 4.03556 21 7.48444 21H16.5156C19.9644 21 22 19.0154 22 15.6615V15.3495H17.7689C15.8052 15.3495 14.2133 13.7975 14.2133 11.883C14.2133 9.96849 15.8052 8.41647 17.7689 8.41647V8.3818ZM17.7689 9.87241H21.2533C21.6657 9.87241 22 10.1983 22 10.6004V13.131C21.9952 13.5311 21.6637 13.8543 21.2533 13.8589H17.8489C16.8548 13.872 15.9855 13.2084 15.76 12.2643C15.6471 11.6783 15.8056 11.0736 16.1931 10.6122C16.5805 10.1509 17.1573 9.88007 17.7689 9.87241ZM17.92 12.533H18.2489C18.6711 12.533 19.0133 12.1993 19.0133 11.7877C19.0133 11.3761 18.6711 11.0424 18.2489 11.0424H17.92C17.7181 11.0401 17.5236 11.1166 17.38 11.255C17.2364 11.3934 17.1555 11.5821 17.1556 11.779C17.1555 12.1921 17.4964 12.5282 17.92 12.533ZM6.73778 8.3818H12.3822C12.8044 8.3818 13.1467 8.04812 13.1467 7.63649C13.1467 7.22487 12.8044 6.89119 12.3822 6.89119H6.73778C6.31903 6.89116 5.9782 7.2196 5.97333 7.62783C5.97331 8.04087 6.31415 8.37705 6.73778 8.3818Z" fill="currentColor" />
</svg>
<h3 ><?php echo number_format($tb,2); ?></h3>
<p class="mb-0">Outstanding</p>
</div>
</div>
</div>
</div>
</div>

            
      

</div>




<div class="row">
<div class="col-sm-6 col-lg-6 col-xl-6">
<div class="card">
<div class="card-body iq-box-relative">
<div class="iq-service d-flex align-items-center justify-content-between" style="position: relative;">
<div class="service-data">
<svg fill="none" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
<path fill-rule="evenodd" clip-rule="evenodd" d="M17.7689 8.3818H22C22 4.98459 19.9644 3 16.5156 3H7.48444C4.03556 3 2 4.98459 2 8.33847V15.6615C2 19.0154 4.03556 21 7.48444 21H16.5156C19.9644 21 22 19.0154 22 15.6615V15.3495H17.7689C15.8052 15.3495 14.2133 13.7975 14.2133 11.883C14.2133 9.96849 15.8052 8.41647 17.7689 8.41647V8.3818ZM17.7689 9.87241H21.2533C21.6657 9.87241 22 10.1983 22 10.6004V13.131C21.9952 13.5311 21.6637 13.8543 21.2533 13.8589H17.8489C16.8548 13.872 15.9855 13.2084 15.76 12.2643C15.6471 11.6783 15.8056 11.0736 16.1931 10.6122C16.5805 10.1509 17.1573 9.88007 17.7689 9.87241ZM17.92 12.533H18.2489C18.6711 12.533 19.0133 12.1993 19.0133 11.7877C19.0133 11.3761 18.6711 11.0424 18.2489 11.0424H17.92C17.7181 11.0401 17.5236 11.1166 17.38 11.255C17.2364 11.3934 17.1555 11.5821 17.1556 11.779C17.1555 12.1921 17.4964 12.5282 17.92 12.533ZM6.73778 8.3818H12.3822C12.8044 8.3818 13.1467 8.04812 13.1467 7.63649C13.1467 7.22487 12.8044 6.89119 12.3822 6.89119H6.73778C6.31903 6.89116 5.9782 7.2196 5.97333 7.62783C5.97331 8.04087 6.31415 8.37705 6.73778 8.3818Z" fill="currentColor" />
</svg>
<h3 ><?php echo number_format($pd,2); ?></h3>
<p class="mb-0">Amount Paid</p>
</div>
</div>
</div>
</div>
</div>


<div class="col-sm-6 col-lg-6 col-xl-6">
<div class="card">
<div class="card-body iq-box-relative">
<div class="iq-service d-flex align-items-center justify-content-between" style="position: relative;">
<div class="service-data">
<svg fill="none" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
<path fill-rule="evenodd" clip-rule="evenodd" d="M17.7689 8.3818H22C22 4.98459 19.9644 3 16.5156 3H7.48444C4.03556 3 2 4.98459 2 8.33847V15.6615C2 19.0154 4.03556 21 7.48444 21H16.5156C19.9644 21 22 19.0154 22 15.6615V15.3495H17.7689C15.8052 15.3495 14.2133 13.7975 14.2133 11.883C14.2133 9.96849 15.8052 8.41647 17.7689 8.41647V8.3818ZM17.7689 9.87241H21.2533C21.6657 9.87241 22 10.1983 22 10.6004V13.131C21.9952 13.5311 21.6637 13.8543 21.2533 13.8589H17.8489C16.8548 13.872 15.9855 13.2084 15.76 12.2643C15.6471 11.6783 15.8056 11.0736 16.1931 10.6122C16.5805 10.1509 17.1573 9.88007 17.7689 9.87241ZM17.92 12.533H18.2489C18.6711 12.533 19.0133 12.1993 19.0133 11.7877C19.0133 11.3761 18.6711 11.0424 18.2489 11.0424H17.92C17.7181 11.0401 17.5236 11.1166 17.38 11.255C17.2364 11.3934 17.1555 11.5821 17.1556 11.779C17.1555 12.1921 17.4964 12.5282 17.92 12.533ZM6.73778 8.3818H12.3822C12.8044 8.3818 13.1467 8.04812 13.1467 7.63649C13.1467 7.22487 12.8044 6.89119 12.3822 6.89119H6.73778C6.31903 6.89116 5.9782 7.2196 5.97333 7.62783C5.97331 8.04087 6.31415 8.37705 6.73778 8.3818Z" fill="currentColor" />
</svg>
<h3 ><?php echo number_format($int,2); ?></h3>
<p class="mb-0">Interest Amount</p>
</div>
</div>
</div>
</div>
</div>

</div>
    

</div>

<!-- Loan Overview Section -->
<div id="loan" style="display:none;">
<h4 class="mb-4"><b>Loan Overview</b></h4><br>
<?php include 'client_overview.php'; ?>
</div>


<!-- Client Overview Section -->
<div id="overview" style="display:none;">
<h4 class="mb-4"><b>Client Overview</b></h4>
<br>
<?php include 'clients_overview.php'; ?>
</div>


<!-- Business Gallery Section -->
<div id="gallery" style="display:none;">
<h4 class="mb-4"><b>Business Gallery</b></h4>
<?php 
include '../config/db.php';
$id = $_GET['id']; // repayment id
$d = date('Y-m-d');
$Query = "SELECT id,Reg_id,BVN
FROM repayments WHERE id = '$id'  ORDER BY id ASC LIMIT 1";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$id = $row['id'];
$reg_id = $row['Reg_id'];
$bv = $row['BVN'];
?>

<div style="overflow-y:auto; height:380px">
<?php 
include '../config/db.php';
//Get Transactions Details
$Query = "SELECT * FROM verify WHERE Reg_id ='$reg_id' ORDER BY id ASC ";
$result = mysqli_query($con, $Query);
$Count = mysqli_num_rows($result);
if ($Count > 0) {
$Available = true;
for ($j=0 ; $j < $Count; $j++){
$rows = mysqli_fetch_array($result);
$img = $rows['F_Image'];
?>
<div style="display:inline-block; margin:10px;">
<img src="<?php echo $img?>" class="img-thumbnail" style="height:350px; width:270px">
</div>
<?php
}
}else {
//No Transaction History for the account
$Available = false; 
echo" No Image Record Found  <br/> ";       
}
?>

</div>



</div>

<!-- Assign Recovery Section -->
<div id="assign" style="display:none;">
<h4 class="mb-4"><b>Assign Loan For Recovery</b></h4>
<div class="info-card">
<div class="alert alert-warning">
<strong>Warning!</strong> This action will assign the loan to the recovery department.
</div>

<form action="" method="POST" enctype="multipart/form-data" id="move">
<input type="text" hidden class="form-control form-control-sm" placeholder="repayment id" name="id" required = "required" value="<?php echo $id; ?>">
<div class="form-group">
<label>Client Name</label>
<input type="text" class="form-control" value="<?php echo $nam; ?>" readonly>
</div>
<div class="form-group">
<label>Outstanding Balance</label>
<input type="text" class="form-control" value="₦<?php echo number_format($tb, 2); ?>" readonly>
</div>
<div class="form-group">
<label>Recovery Officer</label>
<select  class="form-control form-control-sm" required = "required" name="of">
<option value="">Select Option</option>
<?php 
include '../config/db.php';
$Query = "SELECT  * FROM users WHERE User_Group = 'Recovery' ORDER BY id ASC";
$result = mysqli_query($con, $Query);
$Count = mysqli_num_rows($result);
if ($Count > 0) {
for ($j=0 ; $j < $Count; $j++){
$rows = mysqli_fetch_array($result);
$nx= $rows['id']; // union id
$name= $rows['Name'];
?>
<option value="<?php echo $nx; ?>"><?php echo $name; ?></option>
<?php
}
}
?>
</select>
</div>
<br>
<button type="submit" class="btn btn-outline-success">Assign to Recovery</button>
<button type="button" class="btn btn-outline-secondary" onclick="clientDash()">Cancel</button>
</form>
</div>


</div>
</div>
</div>

<script>
function clientDash() {
    hideAllSections();
    document.getElementById('dash').style.display = 'block';
}

function clientLoan() {
    hideAllSections();
    document.getElementById('loan').style.display = 'block';
}

function clientOver() {
    hideAllSections();
    document.getElementById('overview').style.display = 'block';
}

function clientBiz() {
    hideAllSections();
    document.getElementById('gallery').style.display = 'block';
}

function clientAssign() {
    hideAllSections();
    document.getElementById('assign').style.display = 'block';
}

function hideAllSections() {
    document.getElementById('dash').style.display = 'none';
    document.getElementById('loan').style.display = 'none';
    document.getElementById('overview').style.display = 'none';
    document.getElementById('gallery').style.display = 'none';
    document.getElementById('assign').style.display = 'none';
}
</script>


<script type="text/javascript">
$(document).ready(function (e){
$("#move").on('submit',(function(e){ e.preventDefault();
WRN_PROFILE_DELETE = "You are about assign this loan to a recovery officer.?";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
$("#updateModal").modal('hide');
$("#please").show();
$.ajax({
url: "assign_loan.php",
type: "POST",
data: new FormData(this),
contentType: false, 
cache: false, 
processData:false,
success: function(data){
if(data == 1){
$("#please").hide();
alert("Loan has already been assigned to the loan officer ");
$("#updateModal").modal('show');
}else if(data == 2){
setTimeout(function(){
$("#please").hide();
$("#toast").css("display", "block");
$("#toast").show();
}, 3000);
setTimeout(function(){
$("#please").hide();
$("#toast").hide();
}, 6000);
}else{
$("#please").hide();
alert(data);
}
},
error: function(){
}
});
}
}));
});
</script>