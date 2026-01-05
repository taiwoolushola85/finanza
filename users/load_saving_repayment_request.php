<small><b>Total:
<?php 
include '../config/db.php';
$result = mysqli_query($con, "SELECT COUNT(*) FROM saving_rep WHERE Status = 'Waiting For Approval'");
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

$result = mysqli_query($con, "SELECT id, Reg_id, Saving_Account_No, Loan_Account_No, Reciever_Loan_No, Firstname, Middlename, Lastname, Unions, Amount, Date_Sent, 
Status, Officer_Name FROM saving_rep WHERE Status = 'Waiting For Approval' ORDER BY Firstname ASC") or die("Bad Query.");

mysqli_close($con);

$results = array();
while($row = mysqli_fetch_assoc($result))
{
    $results[] = $row; 
}
$fp = fopen('../data/risk_rep_saving.json', 'w'); 
fwrite($fp, json_encode($results)); 
fclose($fp);
//echo json_encode($results);
?>

<div class="table-container" style="height:320px;">
<table>
<thead>
<tr style="font-size:8px"> 
<th >SENDER SAVINGS ACCT</th>
<th >SENDER LOAN ACCT</th>
<th >ACCOUNT NAME</th>
<th >GROUPS</th>
<th >AMOUNT</th>
<th >RECIEVER LOAN ACCT</th>
<th >DATE REQUESTED</th>
<th >INITIATED BY</th>
<th >STATUS</th>
<th >ACTION</th>
</tr>
<tbody>
<?php
$url = '../data/risk_rep_saving.json';
$data = file_get_contents($url);
$json = json_decode($data);

if (!empty($json)) {
    foreach($json as $member){
        ?>
        <tr style="font-size:8px; text-transform:capitalize">
            <td><?php echo $member->Saving_Account_No?></td>
            <td><?php echo $member->Loan_Account_No?></td>
            <td><?php echo $member->Firstname." ".$member->Middlename." ".$member->Lastname?></td>
            <td><?php echo $member->Unions?></td>
            <td><?php echo number_format($member->Amount,2)?></td>
            <td><?php echo $member->Reciever_Loan_No?></td>
            <td><?php echo date("d-M-Y", strtotime($member->Date_Sent))?></td>
            <td><?php echo $member->Officer_Name?></td>
            <td><?php echo $member->Status?></td>
            <td>
                <a class="invks" href="#!"  data-id="<?php echo $member->id?>">
                    <button type="submit" class="btn btn-outline-primary btn-sm" style="font-size:8px">
                        Details
                    </button>
                </a>
            </td>
        </tr>
        <?php
    }
} else {
    // Display this row if there are no records
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
</div> 
</div>




<script>
// Display data in modal
$(document).ready(function() {
$('.invks').on('click', function(e) {e.preventDefault();
$("#updateModal").modal('hide');
$("#view").modal('show');
var id = $(this).data('id');
if(id) {
$.ajax({
url: 'final_repayment_request.php',
type: "GET",
data: {'id': id},
success: function(data) { 
setTimeout(function() {
$("#updateModal").modal('show');
$("#view").modal('hide');
$('#profile').html(data);
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
function loadRep()  {
$.ajax({
method: "POST",
url: "load_saving_repayment_request.php",
dataType: "html",
success:function(data){
setTimeout(function(){
$('#results').html(data);
}, 1000);
}
});
}
</script> 