<small><b>Total Credit Officer's:
<?php 
include '../config/db.php';
include '../config/user_session.php';
$result = mysqli_query($con, "SELECT COUNT(*) FROM mapping WHERE Team_Leader = '$User'");
$row = mysqli_fetch_array($result);
$total = $row[0];
echo $total;
mysqli_close($con);
?></b>
<br><br>
</small>

<?php 
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Origin: *");
include '../config/db.php';
$result = mysqli_query($con, "SELECT id, Officer_Name, Loan_Officer, Branch, Status,
(SELECT COALESCE(SUM(Savings), 0) FROM save WHERE User = Loan_Officer AND Status = 'Waiting For Approval' AND Posting_Method = 'Basic Posting') AS `saving`,
(SELECT Location FROM users WHERE Username = Loan_Officer) AS `img`
FROM mapping WHERE Team_Leader = '$User' ORDER BY Officer_Name ASC") or die("Bad Query.");
mysqli_close($con);
$results = array();
while($row = mysqli_fetch_assoc($result))
{
$results[] = $row; 
}
$fp = fopen('../data/flexi_credit_officer.json', 'w'); 
fwrite($fp, json_encode($results)); 
fclose($fp);
//echo json_encode($results);
?>

<div id="table-container" style="overflow-y:auto; height:300px">
<table>
<thead>
<tr>
<th style="font-size:9px;">Mapping ID</th>
<th style="font-size:9px;">Name</th>
<th style="font-size:9px;">Branch</th>
<th style="font-size:9px;">Savings</th>
<th style="font-size:9px;">Status</th>
<th style="font-size:9px;">Action</th>
</tr>
</thead>
<tbody>
<?php
$url = '../data/flexi_credit_officer.json';
$data = file_get_contents($url);
$json = json_decode($data);
foreach($json as $member){
?>
<tr>
<td style="font-size:9px;"><?php echo $member->id?></td>
<td style="font-size:9px;"><?php echo $member->Officer_Name?></td>
<td style="font-size:9px;"><?php echo $member->Branch?></td>
<td style="font-size:9px;"><?php echo number_format($member->saving,2)?></td>
<td style="font-size:9px;"><?php echo $member->Status?></td>
<td>
<a class="invks" href="#!" data-bs-toggle="modal" data-bs-target="#updateModal" data-id="<?php echo $member->Loan_Officer; ?>">
<button type="button" class="btn btn-outline-primary btn-sm" style="font-size:7px">Details</button>
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





<script>
$(document).ready(function() {
    // 1. .off('click') "cleans the slate" before adding the listener.
    // This stops the "One Click = 5 Requests" bug.
    $(document).off('click', '.invks').on('click', '.invks', function(e) {
        e.preventDefault();
        e.stopImmediatePropagation(); // Prevents conflict with other click listeners

        const id = $(this).data('id');
        const $modal = $("#updateModal");
        const $profileContainer = $('#result');

        // 2. Open the modal immediately
        $modal.modal('show');

        // 3. Set a Loading State with min-height (Prevents the modal from "collapsing/blinking")
        $profileContainer.html(`
            <div class="d-flex flex-column align-items-center justify-content-center p-5" style="min-height: 250px;">
                <div class="spinner-border text-primary mb-3" role="status"></div>
                <p class="text-muted">Loading repayment transactions...</p>
            </div>`);

        // 4. Optimized AJAX call
        $.ajax({
            url: 'express_transaction_list.php',
            type: "GET",
            data: {'id': id},
            cache: true, 
            success: function(data) { 
                // 5. Inject content instantly. 
                // .stop(true, true) cancels any active animation queues for a snappy feel.
                $profileContainer.stop(true, true).hide().html(data).fadeIn(200);
            },
            error: function() {
                $profileContainer.html(`
                    <div class="alert alert-danger m-3 text-center">
                        <b>Error:</b> Could not retrieve express transactions.
                    </div>`);
            }
        });
    });
});
</script>


<script type="text/javascript">
function load()  {
$.ajax({
method: "POST",
url: "express_team_list.php",
dataType: "html",
success:function(data){
setTimeout(function(){
$('#list').html(data);
}, 1000);
}
});
}
</script> 