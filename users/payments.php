<?php 
include_once '../config/db.php';

// 1. Sanitize input
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
    /**
     * OPTIMIZED QUERY:
     * We select the repayment ID and Reg_id, 
     * then use a subquery to calculate the SUM of history in one trip.
     */
    $sql = "SELECT 
                id, 
                Reg_id,
                (SELECT COALESCE(SUM(Amount), 0) 
                 FROM history 
                 WHERE Register_id = r.Reg_id AND Status = 'Paid') AS total_paid
            FROM repayments r
            WHERE id = ? 
            LIMIT 1";

    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        $id = $row['id'];
        $reg_id = $row['Reg_id'];
        $pmt = $row['total_paid']; // Calculated by the DB automatically
    } else {
        $pmt = 0;
    }
    
    mysqli_stmt_close($stmt);
} else {
    $pmt = 0;
}
?>
<!-- Payment history start -->
<div>
<b>
<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M2 5C2 4.44772 2.44772 4 3 4H8.66667H21C21.5523 4 22 4.44772 22 5V8H15.3333H8.66667H2V5Z" fill="currentColor" stroke="currentColor" />
<path d="M6 8H2V11M6 8V20M6 8H14M6 20H3C2.44772 20 2 19.5523 2 19V11M6 20H14M14 8H22V11M14 8V20M14 20H21C21.5523 20 22 19.5523 22 19V11M2 11H22M2 14H22M2 17H22M10 8V20M18 8V20" stroke="currentColor" />
</svg>
CLIENT PAYMENT HISTORY
</b>
<br><br>
<div class="container">
<?php 
echo 'Total:'. number_format($pmt,2);
?><br><br>
<div class="table-container" style="overflow: auto; height:330px">
<table style="font-size:7px">
    <thead>
        <tr>
            <th>PRINCIPAL</th>
            <th>INTEREST</th>
            <th>REPAYMENT</th>
            <th>EXP AMT</th>
            <th>TYPES</th>
            <th>POSTING TYPE</th>
            <th>DATE</th>
            <th>RECEIPTS</th>
        </tr>
    </thead>
    <tbody>
    <?php 
    include '../config/db.php';

    // 1. Prepared Statement for security and speed
    // Fetch ONLY the columns you actually use in the HTML
    $sql = "SELECT id, Loan_Amount, Interest_Amt, Amount, Expected_Amount, 
                   Payment_Method, Post_Method, Date_Paid, Reciept_No 
            FROM history 
            WHERE Register_id = ? AND Status = 'Paid' 
            ORDER BY id ASC";

    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "s", $reg_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // 2. Efficient streaming of results
    if (mysqli_num_rows($result) > 0) {
        while ($rows = mysqli_fetch_assoc($result)) {
            $h_id = $rows['id'];
            $la   = $rows['Loan_Amount'];
            $am   = $rows['Amount'];
            $int  = $rows['Interest_Amt'];
            $exp  = $rows['Expected_Amount'];
            $pm   = $rows['Payment_Method'];
            $po   = $rows['Post_Method'];
            $dp   = $rows['Date_Paid'];
            ?>
            <tr>
                <td><?php echo number_format($la, 2); ?></td>
                <td><?php echo number_format($int, 2); ?></td>
                <td><?php echo number_format($am, 2); ?></td>
                <td><?php echo number_format($exp, 2); ?></td>
                <td><?php echo htmlspecialchars($pm); ?></td>
                <td><?php echo htmlspecialchars($po); ?></td>
                <td><?php echo $dp; ?></td>
                <td>
                    <?php if ($pm == 'Cash Payment'): ?>
                        <span class="text-muted">No Receipt</span>
                    <?php else: ?>
                        <a href="#" class="invk" data-toggle="modal" data-target="#recieptdata" id="<?php echo $h_id; ?>">View Receipt</a>
                    <?php endif; ?>
                </td>
            </tr>
            <?php
        }
    } else {
        echo "<tr><td colspan='8' style='text-align:center; color:red; padding:10px;'>No payment record found</td></tr>";
    }
    mysqli_stmt_close($stmt);
    ?>
    </tbody>
</table>
</div>
</div>



</div>



<script>
// to show data on a modal box
$(document).ready(function() {
$('.invk').on('click', function() {
var recID = $(this).attr('id');
if(recID) {
$("#recieptdata").modal('show');
$.ajax({
url: 'reci.php',
type: "POST",
data: {'id':recID},
dataType: "json",
success:function(data) {
$('#recp').val(data.recieptLocation);
$("#recp").attr("src",data.recieptLocation);
}
});
}else{

}
});
});
</script>
<!-- Payment history end -->

