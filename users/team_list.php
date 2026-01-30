<?php 
include '../config/db.php';
include '../config/user_session.php';

// Set Headers
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Origin: *");

/** * SINGLE OPTIMIZED QUERY
 * Fetches: Total Count, Member Data, Repayments, Savings, and Images
 * Using JOINs and Conditional Aggregation is faster than subqueries.
 */
$sql = "SELECT 
            m.Officer_Name, 
            m.Loan_Officer, 
            m.Branch,
            u.Location AS img,
            COALESCE(SUM(CASE WHEN h.Status = 'Waiting For Approval' THEN h.Amount ELSE 0 END), 0) AS rep,
            COALESCE(SUM(CASE WHEN h.Status = 'Waiting For Approval' AND h.Post_Method = 'Basic Posting' THEN h.Savings ELSE 0 END), 0) AS saving
        FROM mapping m
        LEFT JOIN users u ON m.Loan_Officer = u.Username
        LEFT JOIN history h ON m.Loan_Officer = h.User
        WHERE m.Team_Leader = ?
        GROUP BY m.Loan_Officer
        ORDER BY m.Officer_Name ASC";

$stmt = $con->prepare($sql);
$stmt->bind_param("s", $User);
$stmt->execute();
$result = $stmt->get_result();

$results = [];
while ($row = $result->fetch_assoc()) {
    $results[] = $row;
}

// Count total officers from the result set instead of a second query
$totalOfficers = count($results);

// Update JSON cache in the background (if needed for other parts of the app)
file_put_contents('../data/credit_officer.json', json_encode($results));
?>

<small><b>Total Credit Officer's: <?php echo $totalOfficers; ?></b><br><br></small>

<div id="table-container" style="overflow-y:auto; height:300px">
    <table>
        <thead>
            <tr style="font-size:9px;">
                <th>Name</th>
                <th>Branch</th>
                <th>Repayments</th>
                <th>Savings</th>
                <th>Total</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($results as $member): 
                $totalAmount = $member['rep'] + $member['saving'];
            ?>
            <tr style="font-size:9px;">
                <td><?php echo htmlspecialchars($member['Officer_Name']); ?></td>
                <td><?php echo htmlspecialchars($member['Branch']); ?></td>
                <td><?php echo number_format($member['rep'], 2); ?></td>
                <td><?php echo number_format($member['saving'], 2); ?></td>
                <td><b><?php echo number_format($totalAmount, 2); ?></b></td>
                <td>
                    <a class="invks" href="#!" data-bs-toggle="modal" data-bs-target="#updateModal" data-id="<?php echo $member['Loan_Officer']; ?>">
                        <button type="button" class="btn btn-outline-primary btn-sm" style="font-size:7px">Details</button>
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php 
$stmt->close();
$con->close(); 
?>


<script>
$(document).ready(function() {
    // 1. .off('click') removes any old listeners before adding the new one.
    // This stops the "Double Click" / "Multiple Request" bug caused by AJAX reloads.
    $(document).off('click', '.invks').on('click', '.invks', function(e) {
        e.preventDefault();
        e.stopImmediatePropagation(); // Prevents other scripts from interfering

        const id = $(this).data('id');
        const $modal = $("#updateModal");
        const $profileContainer = $('#result');

        // 2. Open the modal immediately
        $modal.modal('show');

        // 3. Set Loading State with min-height (Prevents the modal from "collapsing" and blinking)
        $profileContainer.html(`
            <div class="d-flex flex-column align-items-center justify-content-center p-5" style="min-height: 250px;">
                <div class="spinner-border text-primary mb-3" role="status"></div>
                <p class="text-muted">Loading repayment transactions...</p>
            </div>`);

        // 4. Optimized AJAX call
        $.ajax({
            url: 'transaction_list.php',
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
                        <b>Error:</b> Failed to load repayment transactions.
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
url: "team_list.php",
dataType: "html",
success:function(data){
setTimeout(function(){
$('#list').html(data);
}, 1000);
}
});
}
</script> 