<?php 
include '../config/db.php';

// 1. Sanitize Input
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
    // 2. CONSOLIDATED QUERY: Fetches repayment info + calculations in 1 trip
    $Query = "SELECT r.*, 
        (SELECT COUNT(*) FROM schedule WHERE Regs_id = r.Reg_id AND Payment_Status = 'Outstanding') AS nxt_count,
        (SELECT COALESCE(SUM(Amount), 0) FROM history WHERE Register_id = r.Reg_id AND Status = 'Paid') AS total_pmt,
        (SELECT COUNT(*) FROM schedule WHERE Regs_id = r.Reg_id AND Payment_Status = 'Outstanding' AND Expected_Date < CURDATE()) AS overdue_count
        FROM repayments r 
        WHERE r.id = ? LIMIT 1";

    $stmt = mysqli_prepare($con, $Query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        $reg_id = $row['Reg_id'];
        $loc = $row['Location'];
        $pd = $row['Paid'];
        $un = $row['Unions'];
        $bv = $row['BVN'];
        $nam = $row['Firstname']." ".$row['Middlename'];
        $la = $row['Loan_Amount'];
        $tb = $row['Total_Bal'];
        $int = $row['Interest_Amt'];
        $vrt = $row['Account_Number'];
        
        // Results from subqueries
        $nxt = $row['nxt_count'];
        $pmt = $row['total_pmt'];
        $totalov = $row['overdue_count'];

        // 3. Optimized Sync Logic (Update only if data differs)
        if (floatval($pd) !== floatval($pmt)) {
            // Note: $sku wasn't defined in your snippet; ensure it exists or replace with logic
            $virtualAcct = "614" . ($sku ?? ''); 
            $updateSql = "UPDATE repayments SET Account_Number = ?, Paid = ?, Total_Bal = Total_Loan - ? WHERE Reg_id = ?";
            $upStmt = mysqli_prepare($con, $updateSql);
            mysqli_stmt_bind_param($upStmt, "sddi", $virtualAcct, $pmt, $pmt, $reg_id);
            mysqli_stmt_execute($upStmt);
            
            // Sync local variable for display
            $pd = $pmt;
        }
    }
}
?>


<style>
    #result-wrapper { position: relative; min-height: 200px; }
    #overlays {
        display: none;
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(255, 255, 255, 0.8);
  backdrop-filter: blur(6px); /* optional but 🔥 */
        z-index: 10;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .spinner {
        width: 40px;
        height: 40px;
        border: 4px solid #f3f3f3;
        border-top: 4px solid #3498db;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }
    @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
</style>

<div class="row">
<div class="col-sm-3">
<div class="d-flex flex-column align-items-center text-center">
<?php
$img = $loc ?? '';
$defaultImage = '../assets/no-image.png';
if (!empty($img)) {
// Check if path starts with ../
if (strpos($img, '../') === 0) {
$imgPath = $img;
} else {
$imgPath = '../' . $img;
}
} else {
$imgPath = $defaultImage;
}
?>
<img src="<?php echo htmlspecialchars($imgPath); ?>" class="rounded-circle" width="150" height="150px" style="object-fit: cover;" onerror="this.src='../assets/no-image.png';">
<div class="mt-3">
<h4><b style="text-transform:capitalize"><?php echo htmlspecialchars($nam); ?></b></h4>
<p class="text-secondary mb-1">[ <?php echo htmlspecialchars($un); ?> ] Group</p>
<button class="btn btn-primary btn-sm" id="pay">Payment History</button>
<button class="btn btn-warning btn-sm" id="sched">Payment Schedule</button>
</div>
</div>
<div class="mt-3">
<button class="btn btn-outline-info btn-sm w-100 mb-1" id="dash">Dashboard</button>
<button class="btn btn-outline-success btn-sm w-100 mb-1" id="over">Loan Overview</button>
<button class="btn btn-outline-primary btn-sm w-100 mb-1" id="cli">Client Overview</button>
<button class="btn btn-outline-warning btn-sm w-100 mb-1" id="hist">Business Gallery</button>
<button class="btn btn-outline-info btn-sm w-100" id="sav">CRC Record</button>
</div>
</div>

<div class="col-sm-9">
<div id="result-wrapper">
<div id="overlays" style="display:none;">
<div class="text-center">
<div class="spinner mb-2"></div>
<small class="text-secondary">Loading...</small>
</div>
</div>


<div id="output"> 
<div class="row">
<div class="col-sm-8">
<b>
<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M2 4C2 2.89543 2.89543 2 4 2H9C10.1046 2 11 2.89543 11 4V20C11 21.1046 10.1046 22 9 22H4C2.89543 22 2 21.1046 2 20V4Z" fill="currentColor" />
<path d="M13 4C13 2.89543 13.8954 2 15 2H20C21.1046 2 22 2.89543 22 4V9C22 10.1046 21.1046 11 20 11H15C13.8954 11 13 10.1046 13 9V4Z" fill="currentColor" />
<path d="M13 15C13 13.8954 13.8954 13 15 13H20C21.1046 13 22 13.8954 22 15V20C22 21.1046 21.1046 22 20 22H15C13.8954 22 13 21.1046 13 20V15Z" fill="currentColor" />
</svg>  
DASHBOARD
</b>
</div>
<div class="col-sm-4">
<?php 
if($rec_status == 'Yes'){
echo "<b>Recovery Status:</b> Loan Moved To Recovery";
}else{

}
?>
</div>
</div>


<br>
<div class="row">
<div class="col-sm-4" style="margin-top:8px">
<b>Virtual Account No: <?php echo $vrt; ?></b>
</div>
<div class="col-sm-8">
<div class="row">
<div class="col-sm-6" style="margin-top:8px">
<button class="btn btn-lightbtn-block btn-sm w-100" hidden>Blacklist Client</button>
</div>
<div class="col-sm-6" style="margin-top:8px">
<button class="btn btn-light w-100 btn-sm"hidden id="write">Write Off / Cancel Loan</button>
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
$("#dash").click(function() { loadSection("client_dashboard.php"); });
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
$("#upwriteoff").on('submit',(function(e){ e.preventDefault();
WRN_PROFILE_DELETE = "You are about to submit this request.?";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
$("#pls").show();
$.ajax({
url: "rek.php",
type: "POST",
data: new FormData(this),
contentType: false, 
cache: false, 
processData:false,
success: function(data){
if (data == 1){
$("#pls").hide();
alert(" 🚫 Request has been sent already");
}else if(data == 2){
setTimeout(function(){
$("#pls").hide();
$("#done").show();
$('#upwriteoff')[0].reset();
}, 3000);
setTimeout(function(){
$("#pls").hide();
$("#done").hide();
}, 6000);
}else{
$("#pls").hide();
alert(" 🚫 " + data);
}
},
error: function(){
}
});
}
}));
});
</script>
