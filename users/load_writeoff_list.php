
<small><b>Total:
<?php 
include '../config/db.php';
$result = mysqli_query($con, "SELECT COUNT(*) FROM other_request WHERE Status = 'Waiting For Approval' AND Request_Type = 'Close Loan Account'");
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
// 
$result = mysqli_query($con, "SELECT id, Firstname, Middlename, Lastname, Branch, Officer_Name, Team_Name, Sender, Date_Request, Request_Type, Status
FROM other_request WHERE Status = 'Waiting For Approval' AND Request_Type = 'Close Loan Account' ORDER BY Firstname ASC") or die("Bad Query.");

mysqli_close($con);

$results = array();
while($row = mysqli_fetch_assoc($result))
{
$results[] = $row; 
}
$fp = fopen('../data/other_request_list.json', 'w'); 
fwrite($fp, json_encode($results)); 
fclose($fp);
//echo json_encode($results);
?>

<div class="table-container" style="height:320px;">
<table>
<thead>
<tr style="font-size:8px"> 
<th >CLIENT NAME</th>
<th >BRANCH</th>
<th >LOAN OFFICER</th>
<th >TEAM LEADER</th>
<th >INITIATED BY</th>
<th >DATE REQUESTED</th>
<th >REQUEST TYPE</th>
<th >STATUS</th>
<th >ACTION</th>
</tr>
<tbody>
<?php
$url = '../data/other_request_list.json';
$data = file_get_contents($url);
$json = json_decode($data);

if (!empty($json)) {
    foreach($json as $member){
        ?>
        <tr style="font-size:8px; text-transform:capitalize">
            <td><?php echo $member->Firstname." ".$member->Middlename." ".$member->Lastname?></td>
            <td><?php echo $member->Branch?></td>
            <td><?php echo $member->Officer_Name?></td>
            <td><?php echo $member->Team_Name?></td>
            <td><?php echo $member->Sender?></td>
            <td><?php echo date("d-M-Y", strtotime($member->Date_Request))?></td>
            <td><?php echo ($member->Request_Type == 'Close Loan Account') ? "Loan Write Off" : $member->Request_Type; ?></td>
            <td><?php echo $member->Status?></td>
            <td>
                <a class="invk" href="#!" data-id="<?php echo $member->id?>">
                    <button type="submit" class="btn btn-outline-primary btn-sm" style="font-size:8px">Details</button>
                </a>
            </td>
        </tr>
        <?php
    }
} else {
    // Display this row if there are no records
    ?>
    <tr>
        <td colspan="9" style="text-align:center; font-size:8px;">No record found</td>
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
url: 'client_final_writeoff_page.php',
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
url: "load_writeoff_list.php",
dataType: "html",
success:function(data){
setTimeout(function(){
$('#writeoff').html(data);
}, 1000);
}
});
}
</script> 
