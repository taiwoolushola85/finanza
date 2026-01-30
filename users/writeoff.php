<?php 
include '../config/db.php';

// 1. Sanitize and Get Initial Data
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$bv = "";

if ($id > 0) {
    // We only need BVN to pull the history
    $stmt = mysqli_prepare($con, "SELECT BVN FROM repayments WHERE id = ? LIMIT 1");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    if($row = mysqli_fetch_assoc($res)) {
        $bv = $row['BVN'];
    }
    mysqli_stmt_close($stmt);
}
?>

<h5 style="font-size:11px;"><b>CANCELLED LOAN HISTORY</b></h5><hr>
<div class="table-container" style="overflow: auto; height:180px;">
    <table style="font-size:8px; width: 100%;">
        <thead>
            <tr>
                <th>LOAN ACCOUNT</th>
                <th>BVN</th>
                <th>PRINCIPAL AMT</th>
                <th>OUTSTANDING</th>
                <th>STATUS</th>
                <th>DATE DISBURSED</th>
                <th>CANCELLED BY</th>
                <th>DATE CANCELLED</th>
            </tr>
        </thead>
        <tbody>
        <?php 
        if (!empty($bv)) {
            // 2. Fetch History using the BVN found above
            $hQuery = "SELECT Loan_Account_No, BVN, Loan_Amount, Total_Bal, Status, 
                              Date_Disbursed, Cancelled_By, Date_Cancelled 
                       FROM repayments 
                       WHERE BVN = ? AND Status = 'Cancelled' 
                       ORDER BY id DESC";
            
            $hStmt = mysqli_prepare($con, $hQuery);
            mysqli_stmt_bind_param($hStmt, "s", $bv);
            mysqli_stmt_execute($hStmt);
            $historyRes = mysqli_stmt_get_result($hStmt);

            if (mysqli_num_rows($historyRes) > 0) {
                while ($rows = mysqli_fetch_assoc($historyRes)) {
                    ?>
                    <tr>
                        <td><?php echo htmlspecialchars($rows['Loan_Account_No']); ?></td>
                        <td><?php echo htmlspecialchars($rows['BVN']); ?></td>
                        <td><?php echo number_format($rows['Loan_Amount'], 2); ?></td>
                        <td><?php echo number_format($rows['Total_Bal'], 2); ?></td>
                        <td><span class="text-danger"><?php echo $rows['Status']; ?></span></td>
                        <td><?php echo $rows['Date_Disbursed']; ?></td>
                        <td><?php echo htmlspecialchars($rows['Cancelled_By']); ?></td>
                        <td><?php echo $rows['Date_Cancelled']; ?></td>
                    </tr>
                    <?php
                }
            } else {
                echo "<tr><td colspan='8' class='text-center p-3'>No Cancelled History Found.</td></tr>";
            }
            mysqli_stmt_close($hStmt);
        }
        ?>
        </tbody>
    </table>
</div>
<hr>

<h6><b>Loan Write Off Form</b></h6>
<form action="" method="POST" id="upwriteoff">
    <input type="hidden" name="id" value="<?php echo $id; ?>">
    
    <div class="form-group">
        <textarea class="form-control" name="re" placeholder="Reason for write-off/cancellation..." required cols="5" rows="4"></textarea>
    </div>
    
    <div class="row mt-3">
        <div class="col-sm-4">
            <button type="submit" class="btn btn-outline-primary btn-sm w-100" id="butsave">Send Request</button>
        </div>
        <div class="col-sm-8 d-flex align-items-center">
            <div id="pls" style="display:none">
                <img src="../loader/loader.gif" style="height:15px"> 
                <small class="ms-2 text-primary">Sending Request! Please wait...</small>
            </div>
            <div id="done" style="display:none; color:green">
                <small><i class="fa fa-check"></i> Request sent successfully for approval.</small>
            </div>
        </div>
    </div>
</form>

<script>
// Simple toggle for perceived speed
function data() {
    document.getElementById('butsave').disabled = true;
    document.getElementById('pls').style.display = 'block';
}
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
