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
foreach($json as $member){
?>
<tr style="font-size:8px; text-transform:capitalize">
<td ><?php echo $member->Saving_Account_No?></td>
<td ><?php echo $member->Loan_Account_No?></td>
<td><?php echo $member->Firstname." ".$member->Middlename." ".$member->Lastname?></td>
<td ><?php echo $member->Unions?></td>
<td ><?php echo number_format($member->Amount,2)?></td>
<td ><?php echo $member->Reciever_Loan_No?></td>
<td ><?php echo date("d-M-Y", strtotime($member->Date_Sent))?></td>
<td ><?php echo $member->Officer_Name?></td>
<td><?php echo $member->Status?></td>
<td>
<a class="invks" href="#!"  data-id="<?php echo $member->id?>">
<button type="submit" class="btn btn-outline-primary btn-sm" style="font-size:8px">
<svg class="icon-10" width="5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<path opacity="0.4" fill-rule="evenodd" clip-rule="evenodd" d="M17.7366 6.04606C19.4439 7.36388 20.8976 9.29455 21.9415 11.7091C22.0195 11.8924 22.0195 12.1067 21.9415 12.2812C19.8537 17.1103 16.1366 20 12 20H11.9902C7.86341 20 4.14634 17.1103 2.05854 12.2812C1.98049 12.1067 1.98049 11.8924 2.05854 11.7091C4.14634 6.87903 7.86341 4 11.9902 4H12C14.0683 4 16.0293 4.71758 17.7366 6.04606ZM8.09756 12C8.09756 14.1333 9.8439 15.8691 12 15.8691C14.1463 15.8691 15.8927 14.1333 15.8927 12C15.8927 9.85697 14.1463 8.12121 12 8.12121C9.8439 8.12121 8.09756 9.85697 8.09756 12Z" fill="currentColor"></path>
<path d="M14.4308 11.997C14.4308 13.3255 13.3381 14.4115 12.0015 14.4115C10.6552 14.4115 9.5625 13.3255 9.5625 11.997C9.5625 11.8321 9.58201 11.678 9.61128 11.5228H9.66006C10.743 11.5228 11.621 10.6695 11.6601 9.60184C11.7674 9.58342 11.8845 9.57275 12.0015 9.57275C13.3381 9.57275 14.4308 10.6588 14.4308 11.997Z" fill="currentColor"></path>
</svg>
Details</button>
</a>
</td>
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