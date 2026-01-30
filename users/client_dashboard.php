<?php 
include_once '../config/db.php';
include_once '../config/user_session.php';
$id = $_GET['id']; // repayment id
$d = date('Y-m-d');
$Query = "SELECT id,Account_Number,Location,Firstname,Lastname,Reg_id,Paid,Unions,Loan_Amount,Total_Bal,Interest_Amt 
FROM repayments WHERE id = '$id' ORDER BY id ASC LIMIT 1";
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
// getting total sum of payment history
$sql = "SELECT SUM(Amount) AS lm FROM history WHERE Status ='Paid' AND Register_id = '$reg_id' ";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$pmt = $data['lm'];
//
if($pd == $pmt){
// do nothing
}else{
$Query = "UPDATE repayments SET Paid ='$pmt', Total_Bal = Total_Loan - $pmt WHERE id = '$id' ";
$result= mysqli_query($con, $Query);
}
//checking if virtual account already exit
?>
<div id="dashboard" style="margin-top: 10px;">
<b>
<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M2 4C2 2.89543 2.89543 2 4 2H9C10.1046 2 11 2.89543 11 4V20C11 21.1046 10.1046 22 9 22H4C2.89543 22 2 21.1046 2 20V4Z" fill="currentColor" />
<path d="M13 4C13 2.89543 13.8954 2 15 2H20C21.1046 2 22 2.89543 22 4V9C22 10.1046 21.1046 11 20 11H15C13.8954 11 13 10.1046 13 9V4Z" fill="currentColor" />
<path d="M13 15C13 13.8954 13.8954 13 15 13H20C21.1046 13 22 13.8954 22 15V20C22 21.1046 21.1046 22 20 22H15C13.8954 22 13 21.1046 13 20V15Z" fill="currentColor" />
</svg>  
DASHBOARD
</b>
<br><br>

<div class="row">
<div class="col-sm-4" style="margin-top:8px">
<b>Virtual Account No: 
<?php 
// account no already exist
echo $vrt;
?>
</b>
</div>
<div class="col-sm-8">
<div class="row">
<div class="col-sm-6" style="margin-top:8px">
<button class="btn btn-light w-100 btn-sm" hidden >Blacklist Client</button>
</div>
<div class="col-sm-6" style="margin-top:8px">
<button class="btn btn-light w-100 btn-sm" hidden id="write">Write Off / Cancel Loan</button>
</div>
</div>
</div>
</div>
<br><br><br>
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





<script>
$(document).ready(function(){
// Simplified click handlers
function loadSection(url) {
// 1. Show overlay and dim the current content
$("#overlays").fadeIn(200);
$("#output").css("opacity", "0.5");
// 2. Load the content
$("#output").load(url + "?id=<?php echo $id; ?>", function(response, status, xhr) {
// 3. Hide overlay and restore brightness when done
$("#overlays").fadeOut(200);
$("#output").css("opacity", "1");
if (status == "error") {
$("#output").html("<div class='alert alert-danger'>Error loading page. Please try again.</div>");
}
});
}

// Navigation triggers
$("#dash").click(function() { loadSection("gen_dashboard.php"); });
$("#over").click(function() { loadSection("gen_over.php"); });
$("#cli").click(function() { loadSection("clks.php"); });
$("#hist").click(function() { loadSection("gallery.php"); });
$("#sav").click(function() { loadSection("crc.php"); });
$("#pay").click(function() { loadSection("payments.php"); });
$("#sched").click(function() { loadSection("schex.php"); });
$("#write").click(function() { loadSection("writeoff.php"); });
});
</script>





<script type="text/javascript">
$(document).ready(function (e){
$("#move").on('submit',(function(e){ e.preventDefault();
WRN_PROFILE_DELETE = "You are about move loan to recovery.?";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
$("#dece").show();
$.ajax({
url: "rc.php",
type: "POST",
data: new FormData(this),
contentType: false, 
cache: false, 
processData:false,
success: function(data){
if(data == 1){
$("#dece").hide();
alert("Loan has been moved to recovery already !!!")
}else{
setTimeout(function(){
$("#dece").hide();
Swal.fire({
icon: 'success',
title: '<small>Transfer Completed</small>',
showConfirmButton: false,
timer: 3500
})
$('#mydiv').load(' #mydiv')
}, 4000);
}
},
error: function(){
}
});
}
}));
});
</script>
