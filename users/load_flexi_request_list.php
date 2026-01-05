
<small><b>Total:
<?php 
include '../config/db.php';
$result = mysqli_query($con, "SELECT COUNT(*) FROM flexi_withdraw WHERE Status = 'Approved'");
$row = mysqli_fetch_array($result);
$total = $row[0];
echo $total;
mysqli_close($con);
?>

</b>
</small>
<br>

<?php 
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Origin: *");
include '../config/db.php';

$result = mysqli_query($con, "SELECT id, Flexi_Accounts, Name, Branch, Amount, Officer_Name, Status, Date_Withdraw, Approved_By
FROM flexi_withdraw WHERE Status = 'Approved' ORDER BY Name ASC") or die("Bad Query.");

mysqli_close($con);

$results = array();
while($row = mysqli_fetch_assoc($result))
{
$results[] = $row; 
}
$fp = fopen('../data/all_flexi_saving_request.json', 'w'); 
fwrite($fp, json_encode($results)); 
fclose($fp);
//echo json_encode($results);
?>
<div class="table-container" style="height:320px;">
<table>
<thead>
<tr> 
<th style="font-size:8px">FLEXI ACCOUNT</th>
<th style="font-size:8px">ACCOUNT NAME</th>
<th style="font-size:8px">BRANCH</th>
<th style="font-size:8px">AMOUNT</th>
<th style="font-size:8px">INITIATED BY</th>
<th style="font-size:8px">DATE INITIATED</th>
<th style="font-size:8px">LOAN OFFICER</th>
<th style="font-size:8px">APPROVED BY</th>
<th style="font-size:8px">STATUS</th>
<th style="font-size:8px">ACTION</th>
</tr>
</thead>

<tbody>
<?php
$url = '../data/all_flexi_saving_request.json';
$data = file_get_contents($url);
$json = json_decode($data);

if (!empty($json)) {
    foreach($json as $member){
        ?>
        <tr style="font-size:8px; text-transform:capitalize">
            <td><?php echo $member->Flexi_Accounts?></td>
            <td><?php echo $member->Name?></td>
            <td><?php echo $member->Branch?></td>
            <td><?php echo number_format($member->Amount,2)?></td>
            <td><?php echo $member->Officer_Name?></td>
            <td><?php echo date("d-M-Y", strtotime($member->Date_Withdraw))?></td>
            <td><?php echo $member->Officer_Name?></td>
            <td><?php echo $member->Approved_By?></td>
            <td><?php echo $member->Status?></td>
            <td>
                <a class="fle" href="#!" data-bs-toggle="modal" data-bs-target="#updateModal" data-id="<?php echo $member->id; ?>">
                <button type="button" class="btn btn-outline-primary btn-sm" style="font-size:7px">Details</button>
                </a>
            </td>
        </tr>
        <?php
    }
} else {
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




<script>
// Display data in modal
$(document).ready(function() {
$('.fle').on('click', function(e) {e.preventDefault();
$("#updateModal").modal('hide');
$("#updateModals").modal('hide');
$("#updatePage").modal('hide');
$("#please").show();
var id = $(this).data('id');
if(id) {
$.ajax({
url: 'final_flexi_approval.php',
type: "GET",
data: {'id': id},
success: function(data) { 
setTimeout(function() {
$("#please").hide();
$("#updatePage").modal('show');
$('#page').html(data);
}, 1000);
},
error: function(xhr, status, error) {
$("#please").hide();
alert('Error loadingrequest page : ' + error);
$("#updatePage").modal('hide');
}
});
} else {
$("#please").hide();
alert('Invalid ID');
$("#updatePage").modal('hide');
}
});
});
</script>


<script type="text/javascript">
function loads()  {
$.ajax({
method: "POST",
url: "load_flexi_request_list.php",
dataType: "html",
success:function(data){
setTimeout(function(){
$('#flexi').html(data);
}, 1000);
}
});
}
</script> 
