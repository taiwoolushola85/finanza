<br>
<br>
<i id="wait" style="display:none"><img src="../loader/loader.gif" style="height:20px"> Waiting For Response ! Please wait...</i>
<i id="done" style="color:green; display:none"><i class="fa fa-check"></i> Request was successfull...</i>
<br>
<br>
<?php 
include '../config/db.php';
$bvn = $_GET['bv'];
$Query = "SELECT * FROM repayments WHERE BVN = '$bvn'";
$result = mysqli_query($con, $Query);
$row = mysqli_num_rows($result);
if($row == 0){
echo "BVN record not found in the database..";
exit();
}else{
?>
<div class="bd-example">
<nav>
<div class="mb-3 nav nav-tabs nav-iconly gap-3" id="nav-tab" role="tablist">
<button class="nav-link active" id="pro-nav-home-tab" data-bs-toggle="tab" data-bs-target="#pro-nav-home" type="button" role="tab" aria-controls="pro-nav-home" aria-selected="true">
<svg fill="none" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
<path fill-rule="evenodd" clip-rule="evenodd" d="M8.87774 6.37856C8.87774 8.24523 7.33886 9.75821 5.43887 9.75821C3.53999 9.75821 2 8.24523 2 6.37856C2 4.51298 3.53999 3 5.43887 3C7.33886 3 8.87774 4.51298 8.87774 6.37856ZM20.4933 4.89833C21.3244 4.89833 22 5.56203 22 6.37856C22 7.19618 21.3244 7.85989 20.4933 7.85989H13.9178C13.0856 7.85989 12.4101 7.19618 12.4101 6.37856C12.4101 5.56203 13.0856 4.89833 13.9178 4.89833H20.4933ZM3.50777 15.958H10.0833C10.9155 15.958 11.5911 16.6217 11.5911 17.4393C11.5911 18.2558 10.9155 18.9206 10.0833 18.9206H3.50777C2.67555 18.9206 2 18.2558 2 17.4393C2 16.6217 2.67555 15.958 3.50777 15.958ZM18.5611 20.7778C20.4611 20.7778 22 19.2648 22 17.3992C22 15.5325 20.4611 14.0196 18.5611 14.0196C16.6623 14.0196 15.1223 15.5325 15.1223 17.3992C15.1223 19.2648 16.6623 20.7778 18.5611 20.7778Z" fill="currentColor" />
</svg>
Account Switching
</button>
<button class="nav-link" id="pro-nav-profile-tab" data-bs-toggle="tab" data-bs-target="#pro-nav-profile" type="button" role="tab" aria-controls="pro-nav-profile" aria-selected="false">
<svg fill="none" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
<path fill-rule="evenodd" clip-rule="evenodd" d="M7.54618 3.27793C7.71236 3.39789 7.98037 3.67345 7.98037 3.67345C9.02079 4.64858 10.5879 7.07394 11.0911 8.30444C11.1016 8.30444 11.4001 9.03608 11.4118 9.38409V9.43041C11.4118 9.96371 11.1133 10.4626 10.6335 10.7179C10.4357 10.8232 9.95456 10.9211 9.72244 10.9683C9.64556 10.984 9.59599 10.9941 9.59308 10.997C8.90727 11.1016 7.85514 11.1704 6.70003 11.1704C5.48757 11.1704 4.38981 11.1016 3.71453 10.9733C3.70282 10.9733 3.08606 10.8462 2.88009 10.7642C2.58282 10.6372 2.3312 10.4044 2.17087 10.1145C2.05618 9.88294 2 9.63827 2 9.38409C2.01053 9.11685 2.18257 8.618 2.26215 8.42083C2.76539 7.12026 4.41204 4.6367 5.41852 3.68532C5.52307 3.57922 5.64206 3.46806 5.72485 3.39071C5.76902 3.34945 5.8029 3.3178 5.81877 3.30169C6.07039 3.10452 6.37936 3 6.71173 3C7.00783 3 7.30509 3.09264 7.54618 3.27793ZM18.2286 10.1618C18.2286 10.6856 17.8108 11.1096 17.2947 11.1096C16.7786 11.1096 16.3608 10.6856 16.3608 10.1618L16.1033 5.58295C16.1033 4.91543 16.637 4.375 17.2947 4.375C17.9524 4.375 18.4849 4.91543 18.4849 5.58295L18.2286 10.1618ZM21.1199 13.2356C21.4172 13.3639 21.6688 13.5955 21.8291 13.8853C21.9438 14.1169 22 14.3616 22 14.617C21.9895 14.883 21.8174 15.3831 21.7367 15.5802C21.2346 16.8797 19.5868 19.3633 18.5815 20.3158C18.4787 20.4194 18.3619 20.5284 18.2793 20.6055L18.2792 20.6055C18.2331 20.6486 18.1976 20.6817 18.1812 20.6983C17.9284 20.8955 17.6206 21 17.2894 21C16.991 21 16.6937 20.9074 16.4538 20.7209C16.2876 20.6021 16.0196 20.3265 16.0196 20.3265C14.978 19.3526 13.4121 16.926 12.9089 15.6954C12.8972 15.6954 12.5999 14.965 12.5882 14.617V14.5706C12.5882 14.0361 12.8855 13.5373 13.3665 13.2819C13.5639 13.1777 14.0435 13.0796 14.2762 13.0319L14.2762 13.0319C14.3539 13.016 14.404 13.0058 14.4069 13.0028C15.0927 12.8983 16.1449 12.8294 17.3 12.8294C18.5124 12.8294 19.6102 12.8983 20.2855 13.0265C20.296 13.0265 20.9139 13.1536 21.1199 13.2356ZM6.70553 12.8905C6.18942 12.8905 5.77161 13.3146 5.77161 13.8383L5.51414 18.4171C5.51414 19.0846 6.04781 19.625 6.70553 19.625C7.36325 19.625 7.89575 19.0846 7.89575 18.4171L7.63945 13.8383C7.63945 13.3146 7.22165 12.8905 6.70553 12.8905Z" fill="currentColor" />
</svg>
Payment Posting
</button>
<button class="nav-link" id="pro-nav-contact-tab" data-bs-toggle="tab" data-bs-target="#pro-nav-contact" type="button" role="tab" aria-controls="pro-nav-contact" aria-selected="false">
<svg width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<path opacity="0.4" d="M16.191 2H7.81C4.77 2 3 3.78 3 6.83V17.16C3 20.26 4.77 22 7.81 22H16.191C19.28 22 21 20.26 21 17.16V6.83C21 3.78 19.28 2 16.191 2Z" fill="currentColor"></path>
<path fill-rule="evenodd" clip-rule="evenodd" d="M8.07996 6.6499V6.6599C7.64896 6.6599 7.29996 7.0099 7.29996 7.4399C7.29996 7.8699 7.64896 8.2199 8.07996 8.2199H11.069C11.5 8.2199 11.85 7.8699 11.85 7.4289C11.85 6.9999 11.5 6.6499 11.069 6.6499H8.07996ZM15.92 12.7399H8.07996C7.64896 12.7399 7.29996 12.3899 7.29996 11.9599C7.29996 11.5299 7.64896 11.1789 8.07996 11.1789H15.92C16.35 11.1789 16.7 11.5299 16.7 11.9599C16.7 12.3899 16.35 12.7399 15.92 12.7399ZM15.92 17.3099H8.07996C7.77996 17.3499 7.48996 17.1999 7.32996 16.9499C7.16996 16.6899 7.16996 16.3599 7.32996 16.1099C7.48996 15.8499 7.77996 15.7099 8.07996 15.7399H15.92C16.319 15.7799 16.62 16.1199 16.62 16.5299C16.62 16.9289 16.319 17.2699 15.92 17.3099Z" fill="currentColor"></path>
</svg>
Transaction List
</button>
</div>
</nav>
<div class="tab-content iq-tab-fade-up" id="simple-tab-content">
<div class="tab-pane show active" id="pro-nav-home" role="tabpanel" aria-labelledby="pro-nav-home-tab">
<br>
<div>
<div>
<div class="row">
<div class="col-sm-8">
<div class="row">
<div class="col-sm-9">
<b>Customer Account Record</b><hr>
<input type="text" class="form-control search-input search form-control-sm" style="width:200px" placeholder="Search..." >
</div>
<div class="col-sm-3">
<?php 
$sku = mt_rand(1000000,9999999);// virtual account number
?>
<br>
<div id="acct" style="display:none">
<center>
<i>
<img src="loader.gif" style="height:15px"> Creating Virtual Account ! Please wait...
</i>
</center>
</div>
<div id="success" style="display:none">
<center>
<i style="color:green">
Virtual Account Successfuly Created !..
</i>
</center>
</div>
<br>
<form action="" method="POST" enctype="multipart/form-data" id="createVirtual">
<input type="text" class="form-control search-input search form-control-sm" name="bvn" value="<?php echo $bvn; ?>" hidden  >
<input type="text" class="form-control search-input search form-control-sm" name="vrt" value="<?php echo '614'."".$sku; ?>" hidden  >
<?php 
$invalid_no = "7380000000";
$sub1 = substr($invalid_no, 0, 3); // 
include '../config/db.php';
$Query = "SELECT Account_Number FROM repayments WHERE BVN = '$bvn' AND Status = 'Active'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$acct_vrt = $row['Account_Number'];
$sub2 = substr($acct_vrt, 0, 3);//
if($acct_vrt === 'In Processing'){
//echo $acct_vrt;
?>
<button type="submit" class="btn btn-soft-primary btn-sm btn-block">Create Virtual Account</button>
<?php 
}else if($sub2 == $sub1){
//echo $sub2;
?>
<button type="submit" class="btn btn-soft-primary btn-sm btn-block">Create Virtual Account</button>
<?php 
}else{
//echo $sub2;
?>
<button type="submit" disabled  class="btn btn-soft-primary btn-sm btn-block">Create Virtual Account</button>
<?php 
}
?>
</form>
</div>
</div>

<br>
<div class="row">
<div class="col-sm-4">
<small><b>Total Record:
<?php 
include '../config/db.php';
$result = mysqli_query($con, "SELECT COUNT(*) FROM repayments WHERE BVN = '$bvn'");
$row = mysqli_fetch_array($result);
$total = $row[0];
echo $total;
mysqli_close($con);
?>
</b>
</small>
</div>
<div class="col-sm-4">
<small><b>Total Active Balance:
<?php 
include '../config/db.php';
$result = mysqli_query($con, "SELECT COUNT(*) FROM repayments WHERE BVN = '$bvn' AND Status = 'Active'");
$row = mysqli_fetch_array($result);
$totalbal = $row[0];
echo $totalbal;
mysqli_close($con);
?>
</b>
</small>
</div>
<div class="col-sm-4">
<small><b>Total Closed Acct Record:
<?php 
include '../config/db.php';
$result = mysqli_query($con, "SELECT COUNT(*) FROM repayments WHERE BVN = '$bvn' AND Status = 'Closed'");
$row = mysqli_fetch_array($result);
$total = $row[0];
echo $total;
mysqli_close($con);
?>
</b>
</small>
</div>
</div>
<hr>
<?php 
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Origin: *");
include '../config/db.php';
$result = mysqli_query($con, "SELECT id, Reg_id, Account_Number, Loan_Account_No, BVN, Firstname, Middlename, Lastname, Officer_Name,
Status, Total_Loan FROM repayments WHERE BVN = '$bvn' ORDER BY id ASC") or die("Bad Query.");

mysqli_close($con);

$results = array();
while($row = mysqli_fetch_assoc($result)){
$results[] = $row; 
}
$fp = fopen('../data/virtual_account.json', 'w'); 
fwrite($fp, json_encode($results)); 
fclose($fp);
//echo json_encode($results);
?>

<div id="table-container" style="height:150px">
<table>
<thead>
<tr>
<th style="font-size:7px;">VIRTUAL ACCT</th>
<th style="font-size:7px;">LOAN ACCT</th>
<th style="font-size:7px;">BVN NO</th>
<th style="font-size:7px;">NAME</th>
<th style="font-size:7px;">LOAN AMT </th>
<th style="font-size:7px;">CREDIT OFFICER </th>
<th style="font-size:7px;">STATUS</th>
<th style="font-size:7px;">ACTION</th>
</tr>
<tbody>
<?php
$url = '../data/virtual_account.json';
$data = file_get_contents($url);
$json = json_decode($data);
foreach($json as $member){
?>
<tr>
<td style="font-size:7px;"><?php echo $member->Account_Number?></td>
<td style="font-size:7px;"><?php echo $member->Loan_Account_No?></td>
<td style="font-size:7px;"><?php echo $member->BVN?></td>
<td style="font-size:7px;"><?php echo $member->Firstname." ".$member->Middlename." ".$member->Lastname?></td>
<td style="font-size:7px;"><?php echo number_format($member->Total_Loan,2)?></td>
<td style="font-size:7px;"><?php echo $member->Officer_Name?></td>
<td style="font-size:7px;"><?php echo $member->Status?></td>
<td style="font-size:7px;">
<?php 
if($member->Status == 'Active'){
?>

<?php
}else{
?>
<a class="invks" href="#!"  id="<?php echo $member->id?>"  style="font-size:8px; color:red">+ Switch Acct</a>
<?php
}
?>
</td>
</tr>
<?php
}
?>
</tbody>
</table>
</div>


</div>
<div class="col-sm-4">
<?php 
include '../config/db.php';
$bvn = $_GET['bv']; // bvn
$Query = "SELECT Location, Firstname, Lastname, Middlename, Branch FROM repayments WHERE BVN = '$bvn' AND Status = 'Active'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);

?>
<div class="d-flex flex-column align-items-center text-center">
<img src="<?php echo $row['Location']; ?>" class="rounded-circle" width="120" height="120px">
<div class="mt-3">
<h4><b style="text-transform:capitalize"><?php echo $row['Firstname']." ". $row['Middlename']." ". $row['Lastname']; ?></b></h4>
<p class="text-secondary mb-1">[ <?php echo $row['Branch']; ?> ] </p>
</div>
</div>

<?php 
$bvn = $_GET['bv'];
include '../config/db.php';
$Query = "SELECT id, Account_Number, Loan_Account_No, Savings_Account_No, BVN FROM repayments WHERE BVN = '$bvn' AND Status = 'Active'";
$result = mysqli_query($con, $Query);
$rows = mysqli_fetch_array($result);
if($rows == true){
$repid = $rows['id'];
$vrt = $rows['Account_Number'];
$bvn_no = $rows['BVN'];
$ll = $rows['Loan_Account_No'];
$sv = $rows['Savings_Account_No'];
?>

<marquee>
<b>Note:</b> <i style="color:red">You are to switch all acount owned by this customer to one live virtual account.</i>
</marquee>
<form action="" method="POST" enctype="multipart/form-data" id="uploadSwitch">
<div class="row">
<div class="col-sm-6">
<label>Active Virtual Acct No</lable>
<input type="text" class="form-control form-control-md" name="new" hidden value="<?php echo $vrt; ?>"  required>
<input type="text" class="form-control form-control-md" name="id" hidden value="<?php echo $repid; ?>" required>
<input type="text" class="form-control form-control-md" name="bvn" hidden value="<?php echo $bvn; ?>" required>
<input type="text" class="form-control form-control-md" value="<?php echo $vrt; ?>" disabled>
</div>
<div class="col-sm-6">
<label>Previous Virtual Acct No</lable>
<input type="text" class="form-control form-control-md" name="old" id="lnno" required>
</div>
</div>
<hr>
<button type="submit" class="btn btn-success btn-sm">Switch Account</button>
<button type="reset" class="btn btn-danger btn-sm" style="float:right">Reset Input Form</button>
</form>
<?php 
}else{ 
echo "<i style='color:red'>No active virtual account record found.!</i>";
}
?>




</div>
</div>




<br>




</div>
</div>

</div>

<div class="tab-pane" id="pro-nav-profile" role="tabpanel" aria-labelledby="pro-nav-profile-tab">
<hr>
<br>
<div >
<div >
<br>
<div id="notification"></div>
</div>
</div>

</div>
<div class="tab-pane" id="pro-nav-contact" role="tabpanel" aria-labelledby="pro-nav-contact-tab">
<br>
<div >
<div >           
<br>
<div id="upfront"></div>
</div>
</div>

</div>
</div>
</div>



<?php
}
?>


<script type="text/javascript">
$(document).ready(function(){
// ajax function start here
$.ajax({
method: "GET",
url: 'luxo.php?bvn=' + <?php echo $bvn; ?>,
dataType: "html",  
success:function(data){
$('#notification').html(data);
}
});
// ajax function ends here
});
</script>


<script type="text/javascript">
$(document).ready(function(){
// ajax function start here
$.ajax({
method: "GET",
url: 'up_luxo.php?bvn=' + <?php echo $bvn; ?>,
dataType: "html",  
success:function(data){
$('#upfront').html(data);
}
});
// ajax function ends here
});
</script>

<script>
// to show data on a modal box
$(document).ready(function() {
$('.invks').on('click', function() {
var id = $(this).attr('id');
if(id) {
$.ajax({
url: 'select_vrt.php',
type: "POST",
data: {'id':id},
dataType: "json",
success:function(data) { 
$('#lnno').val(data.vrtAcct);
}
});
}else{
alert ("🚫" + data)
}
});
});
</script>


<script type="text/javascript">
$(document).ready(function (e){
$("#createVirtual").on('submit',(function(e){ e.preventDefault();
WRN_PROFILE_DELETE = "You are about to create repayment virtual account for this customer.!!";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
$("#wait").show();
$.ajax({
url: "create_virtual.php",
type: "POST",
data: new FormData(this),
contentType: false, 
cache: false, 
processData:false,
success: function(data){  
if(data == 1){
$("#wait").hide();
alert("🚫 Virtual account alread taken ! please try again by reloading your page..");
}else if(data == 2){
setTimeout(function(){
$("#wait").hide();
$("#done").show();
}, 4000);
setTimeout(function(){
$("#done").hide();
loader();
loadUp();
loadPayment();
}, 5000);
}else{
$("#wait").hide();
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






<script type="text/javascript">
$(document).ready(function (e){
$("#uploadSwitch").on('submit',(function(e){ e.preventDefault();
WRN_PROFILE_DELETE = "You are about to switch this account to an active account.!!";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
$("#wait").show();
$.ajax({
url: "virtual_switching.php",
type: "POST",
data: new FormData(this),
contentType: false, 
cache: false, 
processData:false,
success: function(data){  
if(data == 1){
setTimeout(function(){
$("#wait").hide();
$("#done").show();
}, 4000);
setTimeout(function(){
$("#done").hide();
loader();
loadUp();
loadPayment();
}, 5000);
}else if(data == 2){
$("#wait").hide();
alert("🚫 Account has already been switched to an active account..");
}else if(data == 3){
$("#wait").hide();
alert("🚫 The same virtual account can not be switched..");
}else if(data == 4){
$("#wait").hide();
alert(data);
}else{
$("#wait").hide();
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


<script type="text/javascript">
function loadPayment()  {
$.ajax({
method: "GET",
url: 'luxo.php?bvn=' + <?php echo $bvn; ?>,
dataType: "html",
success:function(data){
setTimeout(function(){
$('#notification').html(data);
}, 1000);
}
});
}
</script> 



<script type="text/javascript">
function loadUp()  {
$.ajax({
method: "GET",
url: 'up_luxo.php?bvn=' + <?php echo $bvn; ?>,
dataType: "html",
success:function(data){
setTimeout(function(){
$('#upfront').html(data);
}, 1000);
}
});
}
</script> 


<script type="text/javascript">
function loader()  {
$.ajax({
method: "GET",
url: "load_account.php?bv=<?php echo $bvn; ?>",
dataType: "html",
success:function(data){
setTimeout(function(){
$('#result').html(data);
}, 1000);
}
});
}
</script> 
