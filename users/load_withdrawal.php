
<small><b>Total:
<?php 
include '../config/db.php';
$result = mysqli_query($con, "SELECT COUNT(*) FROM withdraw WHERE Status = 'Waiting For Approval'");
$row = mysqli_fetch_array($result);
$total = $row[0];
echo $total;
mysqli_close($con);
?></b>
</small>
<br>
<br>
<?php 
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Origin: *");
include '../config/db.php';

$result = mysqli_query($con, "SELECT id, Saving_Account_No, Firstname, Middlename, Lastname, Unions, Amount_Withdraw, Date_Withdraw, Status, Officer_Name,
Loan_Account_No, Team_Name FROM withdraw WHERE Status = 'Waiting For Approval' ORDER BY Firstname ASC") or die("Bad Query.");

mysqli_close($con);

$results = array();
while($row = mysqli_fetch_assoc($result))
{
$results[] = $row; 
}
$fp = fopen('../data/risk_withdraw_saving.json', 'w'); 
fwrite($fp, json_encode($results)); 
fclose($fp);
//echo json_encode($results);
?>

<div class="table-container" style="height:320px;">
<table >
<thead>
<tr style="font-size:8px"> 
<th >SAVINGS ACCT NO</th>
<th >LOAN ACCT</th>
<th >ACCOUNT NAME</th>
<th >GROUPS</th>
<th >AMOUNT</th>
<th >INITATED BY</th>
<th >APPROVED BY BY</th>
<th >DATE REQUESTED</th>
<th >STATUS</th>
<th >ACTION</th>
</tr>
<tbody>
<?php
$url = '../data/risk_withdraw_saving.json';
$data = file_get_contents($url);
$json = json_decode($data);

// Check if there is any data
if (!empty($json)) {
    foreach($json as $member){
        ?>
        <tr style="font-size:8px; text-transform:capitalize">
            <td><?php echo $member->Saving_Account_No?></td>
            <td><?php echo $member->Loan_Account_No?></td>
            <td><?php echo $member->Firstname." ".$member->Middlename." ".$member->Lastname?></td>
            <td><?php echo $member->Unions?></td>
            <td><?php echo number_format($member->Amount_Withdraw,2)?></td>
            <td><?php echo $member->Officer_Name?></td>
            <td><?php echo $member->Team_Name?></td>
            <td><?php echo date("d-M-Y", strtotime($member->Date_Withdraw))?></td>
            <td><?php echo $member->Status?></td>
            <td>
                <a class="invk" href="#!" data-id="<?php echo $member->id?>" >
                    <button type="submit" class="btn btn-outline-primary btn-sm" style="font-size:8px">
                        Details
                    </button>
                </a>
            </td>
        </tr>
        <?php
    }
} else {
    // Display when no records are found
    ?>
    <tr>
        <td colspan="10" style="text-align:center; font-size:8px;">No record found</td>
    </tr>
    <?php
}
?>
</tbody>
</table>
</div>
</div>



<script>
// Display data in modal
$(document).ready(function() {
$('.invk').on('click', function(e) {e.preventDefault();
$("#updateModals").modal('hide');
$("#view").modal('show');
var id = $(this).data('id');
if(id) {
$.ajax({
url: 'client_final_withdrawal_page.php',
type: "GET",
data: {'id': id},
success: function(data) { 
setTimeout(function() {
$("#updateModals").modal('show');
$("#view").modal('hide');
$('#profiles').html(data);
}, 1000);
},
error: function(xhr, status, error) {
alert('Error loadingrequest page : ' + error);
$("#view").modal('hide');
}
});
} else {
alert('Invalid ID');
$("#view").modal('hide');
}
});
});
</script>


<script type="text/javascript">
function loads()  {
$.ajax({
method: "POST",
url: "load_withdrawal.php",
dataType: "html",
success:function(data){
setTimeout(function(){
$('#result').html(data);
}, 1000);
}
});
}
</script> 