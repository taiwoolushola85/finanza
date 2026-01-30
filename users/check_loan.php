<?php 
include '../config/db.php';
$d = date('Y-m-d');
$loan = $_GET['loan'];// loan account
$Query = "SELECT * FROM repayments WHERE Loan_Account_No = '$loan'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$id = $row['id'];
$reg_id = $row['Reg_id'];
$la = $row['Loan_Amount'];
$tr = $row['Transaction_id'];
$pr = $row['Product'];
$pd = $row['Paid'];
$pr_id = $row['Product_id'];
$du = $row['Duration'];
///
$Query = "SELECT Expected_Date FROM schedule WHERE Regs_id = '$reg_id' AND Status = 'Disbursed' ORDER BY id DESC LIMIT 1";
$result = mysqli_query($con, $Query);
$rows = mysqli_fetch_array($result);
$expected = $rows['Expected_Date'];
//
$Query = "UPDATE repayments SET Maturity_Date = '$expected' WHERE id = '$id'";
$result= mysqli_query($con, $Query);
?>
<br>
<div class="bd-example">
<nav>
<div class="mb-3 nav nav-tabs nav-iconly gap-3" id="nav-tab" role="tablist">
<button class="nav-link active" id="pro-nav-home-tab" data-bs-toggle="tab" data-bs-target="#pro-nav-home" type="button" role="tab" aria-controls="pro-nav-home" aria-selected="true">
<svg width="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<path opacity="0.4" d="M16.191 2H7.81C4.77 2 3 3.78 3 6.83V17.16C3 20.26 4.77 22 7.81 22H16.191C19.28 22 21 20.26 21 17.16V6.83C21 3.78 19.28 2 16.191 2Z" fill="currentColor"></path>
<path fill-rule="evenodd" clip-rule="evenodd" d="M8.07996 6.6499V6.6599C7.64896 6.6599 7.29996 7.0099 7.29996 7.4399C7.29996 7.8699 7.64896 8.2199 8.07996 8.2199H11.069C11.5 8.2199 11.85 7.8699 11.85 7.4289C11.85 6.9999 11.5 6.6499 11.069 6.6499H8.07996ZM15.92 12.7399H8.07996C7.64896 12.7399 7.29996 12.3899 7.29996 11.9599C7.29996 11.5299 7.64896 11.1789 8.07996 11.1789H15.92C16.35 11.1789 16.7 11.5299 16.7 11.9599C16.7 12.3899 16.35 12.7399 15.92 12.7399ZM15.92 17.3099H8.07996C7.77996 17.3499 7.48996 17.1999 7.32996 16.9499C7.16996 16.6899 7.16996 16.3599 7.32996 16.1099C7.48996 15.8499 7.77996 15.7099 8.07996 15.7399H15.92C16.319 15.7799 16.62 16.1199 16.62 16.5299C16.62 16.9289 16.319 17.2699 15.92 17.3099Z" fill="currentColor"></path>
</svg>
Loan Re-Sechedule
</button>
<button class="nav-link" id="pro-nav-profile-tab" data-bs-toggle="tab" data-bs-target="#pro-nav-profile" type="button" role="tab" aria-controls="pro-nav-profile" aria-selected="false">
<svg width="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<path opacity="0.4" d="M16.6643 21.9897H7.33488C5.88835 22.0796 4.46781 21.5781 3.3989 20.6011C2.4219 19.5312 1.92041 18.1107 2.01032 16.6652V7.33482C1.92041 5.88932 2.4209 4.46878 3.3979 3.39889C4.46781 2.42189 5.88835 1.92041 7.33488 2.01032H16.6643C18.1089 1.92041 19.5284 2.4209 20.5973 3.39789C21.5733 4.46878 22.0758 5.88832 21.9899 7.33482V16.6652C22.0788 18.1107 21.5783 19.5312 20.6013 20.6011C19.5314 21.5781 18.1109 22.0796 16.6643 21.9897Z" fill="currentColor"></path>
<path d="M17.0545 10.3976L10.5018 16.9829C10.161 17.3146 9.7131 17.5 9.24574 17.5H6.95762C6.83105 17.5 6.71421 17.4512 6.62658 17.3634C6.53895 17.2756 6.5 17.1585 6.5 17.0317L6.55842 14.7195C6.56816 14.261 6.75315 13.8317 7.07446 13.5098L11.7189 8.8561C11.7967 8.77805 11.9331 8.77805 12.011 8.8561L13.6399 10.4785C13.747 10.5849 13.9028 10.6541 14.0683 10.6541C14.4286 10.6541 14.7109 10.3615 14.7109 10.0102C14.7109 9.83463 14.6428 9.67854 14.5357 9.56146C14.5065 9.52244 12.9554 7.97805 12.9554 7.97805C12.858 7.88049 12.858 7.71463 12.9554 7.61707L13.6078 6.95366C14.2114 6.34878 15.1851 6.34878 15.7888 6.95366L17.0545 8.22195C17.6485 8.81707 17.6485 9.79268 17.0545 10.3976Z" fill="currentColor"></path>
</svg>
Repayment Schedule
</button>
<button class="nav-link" id="pro-nav-profiles-tab" data-bs-toggle="tab" data-bs-target="#pro-nav-profiles" type="button" role="tab" aria-controls="pro-nav-profiles" aria-selected="false">
<svg fill="none" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
<path fill-rule="evenodd" clip-rule="evenodd" d="M11.7281 21.9137C11.8388 21.9715 11.9627 22.0009 12.0865 22C12.2103 21.999 12.3331 21.9686 12.4449 21.9097L16.0128 20.0025C17.0245 19.4631 17.8168 18.8601 18.435 18.1579C19.779 16.6282 20.5129 14.6758 20.4998 12.6626L20.4575 6.02198C20.4535 5.25711 19.9511 4.57461 19.2082 4.32652L12.5707 2.09956C12.1711 1.96424 11.7331 1.96718 11.3405 2.10643L4.72824 4.41281C3.9893 4.67071 3.496 5.35811 3.50002 6.12397L3.54231 12.7597C3.5554 14.7758 4.31448 16.7194 5.68062 18.2335C6.3048 18.9258 7.10415 19.52 8.12699 20.0505L11.7281 21.9137ZM10.7836 14.1089C10.9326 14.2521 11.1259 14.3227 11.3192 14.3207C11.5125 14.3198 11.7047 14.2472 11.8517 14.1021L15.7508 10.2581C16.0438 9.96882 16.0408 9.50401 15.7448 9.21866C15.4478 8.9333 14.9696 8.93526 14.6766 9.22454L11.3081 12.5449L9.92885 11.2191C9.63186 10.9337 9.15467 10.9367 8.8607 11.226C8.56774 11.5152 8.57076 11.98 8.86775 12.2654L10.7836 14.1089Z" fill="currentColor" />
</svg>
Adjust Repayment Schedule
</button>
</div>
</nav>
<div class="tab-content iq-tab-fade-up" id="simple-tab-content">
<div class="tab-pane show active" id="pro-nav-home" role="tabpanel" aria-labelledby="pro-nav-home-tab">
<div>
<div>
<form action="" method="POST" enctype="multipart/form-data" id="product">
<b>Loan Product Information</b><br><br>
<div class="row">
<div class="col-sm-4">
<input type="text" hidden="hidden" class="form-control form-control-sm" name="id" placeholder="id" required="required" value="<?php echo $id; ?>">
<input type="text" hidden="hidden" class="form-control form-control-sm" name="pd" placeholder="Amount Paid" required="required" value="<?php echo $pd; ?>">
<input type="text" hidden="hidden" class="form-control form-control-sm" name="reg" placeholder="Reg ID" required="required" value="<?php echo $reg_id; ?>">
<label style="font-size:13px"><i style="color:red">*</i> Loan Products</label><br>
<select type="text" class="form-control form-control-md" name="pr" id="pr" oninput="getProduct()" required = "required">
<option value="">Select Loan Product</option>
<?php 
include '../config/db.php';
$Query = "SELECT  * FROM product WHERE Status = 'Activated' ORDER BY id ASC";
$result = mysqli_query($con, $Query);
$Count = mysqli_num_rows($result);
if ($Count > 0) {
for ($j=0 ; $j < $Count; $j++){
$rows = mysqli_fetch_array($result);
$pp= $rows['id']; // product id
$name= $rows['Product_Name'];
?>
<option value="<?php echo $pp; ?>"><?php echo $name; ?></option>
<?php
}
}
?>
</select>
</div>
<div class="col-sm-4">
<label style="font-size:13px"><i style="color:red">*</i> Tenure</label>
<select type="text" class="form-control form-control-md" name="ten" id="hey" required="required">
<option value="">Select Option</option>
</select>
</div>
<div class="col-sm-4">
<label style="font-size:13px"><i style="color:red">*</i> Principal Amount</label>
<input type="number" class="form-control form-control-md" placeholder="Principal Amount" name="lum" required = "required" value="<?php echo $la; ?>">
</div>
</div>
<br>
<button type="submit" class="btn btn-outline-primary btn-sm"  onclick="data()" id="cli">Change Product</button>
<hr>
</form>

</div>
</div>
</div>

<div class="tab-pane" id="pro-nav-profile" role="tabpanel" aria-labelledby="pro-nav-profile-tab">
<div >
<div>

<div id="heylist"></div>




<script type="text/javascript">
$(document).ready(function(){
//setInterval(function(){
// ajax function start here to load table data
$.ajax({
method: "POST",
url: "sch_load.php?id=<?php echo $reg_id; ?>",
dataType: "html",
success:function(data){
$("#heylist").html(data);
}
});
//}, 1000);
// ajax function ends here
});
</script>

 
</div>
</div>

</div>
<div class="tab-pane" id="pro-nav-profiles" role="tabpanel" aria-labelledby="pro-nav-profiles-tab">
<br>
<br>
<br>

<div>
<div>
<form action="" method="post" id="findDate">
<div class="row">
<div class="col-sm-6">
<small>No Of Installments</small>
<input type="number"class="form-control form-control-md"  placeholder="Number of days" required="required" hidden name="no" value="<?php echo $du; ?>">
<input type="number"class="form-control form-control-md"  placeholder="Number of days" required="required" disabled value="<?php echo $du; ?>">
</div>
<div class="col-sm-6">
<small>Start Date</small>
<input type="text" class="form-control form-control-md" hidden required="required" name="id" value="<?php echo $id; ?>">
<input type="text" class="form-control form-control-md" hidden required="required" name="reg" value="<?php echo $reg_id; ?>">
<input type="date" class="form-control form-control-md" required="required" name="ft">
</div>
</div><br>
<div class="row">
<div class="col-sm-4" style="margin-top:10px">
<button type="submit" class="btn btn-light btn-block btn-sm" name="calculate" onclick="data()">Calculate Date</button>
</form>
</div>
</div>
<br>
<div id="output"></div>
</div>
</div>

</div>
</div>
</div>



<script>
$(document).ready(function () {
//change selectboxes to selectize mode to be searchable
   $("select").select2();
});
</script>



<script type="text/javascript">
function getProduct()  {
var pr = document.getElementById("pr").value;
// ajax function start here
$.ajax({
method: "POST",
url: "tenure_list.php",
dataType: "html",  
data: {'pr': pr},
success:function(data){
setTimeout(function(){
$("#hey").html(data);
}, 100);
}
});
// ajax function ends here
}
</script>




<script type="text/javascript">
$(document).ready(function (e){
$("#product").on('submit',(function(e){ e.preventDefault();
WRN_PROFILE_DELETE = "You are about to re-schedule this loan..!! ?";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
$("#please").show();
$.ajax({
url: "change_product_bck.php",
type: "POST",
data: new FormData(this),
contentType: false, 
cache: false, 
processData:false,
success: function(data){
if(data == 1){
setTimeout(function(){
$("#please").hide();
$("#toast").show();
}, 4000);
setTimeout(function(){
$("#please").hide();
$("#toast").hide();
}, 5000);
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



<script src="js/jquery-2.2.0.min.js"></script>
<script type="text/javascript">
$(document).ready(function (e){
$("#findDate").on('submit',(function(e){ e.preventDefault();
$("#please").show();
$.ajax({
url: "add_schedule.php",
type: "POST",
data: new FormData(this),
contentType: false, 
cache: false, 
processData:false,
success: function(data){
$("#please").show();
setTimeout(function(){
$("#please").hide();
$('#output').html(data);
}, 2000);
},
error: function(){
}
});
}));
});
</script>

