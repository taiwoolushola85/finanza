<?php
// Set headers
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Origin: *");
header("Content-Type: text/html; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

$d = date('Y-m-d');
include '../config/db.php';
include '../config/user_session.php';

// Secure ID parameter
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    die("Invalid guarantor ID");
}

// Get guarantor details using prepared statement
$stmt = mysqli_prepare($con, "SELECT * FROM gaurantors WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_array($result);

if (!$row) {
    die("Guarantor not found");
}

$idd = $row['id'];
$pic = htmlspecialchars($row['Location'] ?? '', ENT_QUOTES, 'UTF-8');
$frst = htmlspecialchars($row['Firstname'] ?? '', ENT_QUOTES, 'UTF-8');
$mid = htmlspecialchars($row['Middlename'] ?? '', ENT_QUOTES, 'UTF-8');
$las = htmlspecialchars($row['Lastname'] ?? '', ENT_QUOTES, 'UTF-8');
$ful = trim("$frst $mid $las");
$gn = htmlspecialchars($row['Gender'] ?? '', ENT_QUOTES, 'UTF-8');
$reg_id = (int)($row['Regis_id'] ?? 0);
$ph = htmlspecialchars($row['Phone'] ?? '', ENT_QUOTES, 'UTF-8');
$ad = htmlspecialchars($row['Address'] ?? '', ENT_QUOTES, 'UTF-8');
$re = htmlspecialchars($row['Relationship'] ?? '', ENT_QUOTES, 'UTF-8');
$idn = htmlspecialchars($row['ID_No'] ?? '', ENT_QUOTES, 'UTF-8');
$idt = htmlspecialchars($row['ID_Type'] ?? '', ENT_QUOTES, 'UTF-8');
$cl_bvn = htmlspecialchars($row['Client_BVN'] ?? '', ENT_QUOTES, 'UTF-8');
$st = htmlspecialchars($row['Status'] ?? '', ENT_QUOTES, 'UTF-8');
$gb = htmlspecialchars($row['Gaurantor_BVN'] ?? '', ENT_QUOTES, 'UTF-8');

// Get register info
$stmt = mysqli_prepare($con, "SELECT * FROM register WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $reg_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_array($result);

$fnn = htmlspecialchars($row['Firstname'] ?? '', ENT_QUOTES, 'UTF-8');
$mnn = htmlspecialchars($row['Middlename'] ?? '', ENT_QUOTES, 'UTF-8');
$lnn_pic = htmlspecialchars($row['Location'] ?? '', ENT_QUOTES, 'UTF-8');
$lnnn = htmlspecialchars($row['Lastname'] ?? '', ENT_QUOTES, 'UTF-8');
$ott = "$mnn $lnnn";
$un = htmlspecialchars($row['Unions'] ?? '', ENT_QUOTES, 'UTF-8');
$prin = (float)($row['Loan_Amount'] ?? 0);
$p = htmlspecialchars($row['Phone'] ?? '', ENT_QUOTES, 'UTF-8');
$br = htmlspecialchars($row['Branch'] ?? '', ENT_QUOTES, 'UTF-8');
$pr = htmlspecialchars($row['Product'] ?? '', ENT_QUOTES, 'UTF-8');
$ten = htmlspecialchars($row['Tenure'] ?? '', ENT_QUOTES, 'UTF-8');
$bvn = htmlspecialchars($row['BVN'] ?? '', ENT_QUOTES, 'UTF-8');
$rt = (float)($row['Rate'] ?? 0);
$du = htmlspecialchars($row['Frequency'] ?? '', ENT_QUOTES, 'UTF-8');
$bn = htmlspecialchars($row['Bank'] ?? '', ENT_QUOTES, 'UTF-8');
$acc = htmlspecialchars($row['Account_No'] ?? '', ENT_QUOTES, 'UTF-8');
$acn = htmlspecialchars($row['Account_Name'] ?? '', ENT_QUOTES, 'UTF-8');
$bi = htmlspecialchars($row['Business'] ?? '', ENT_QUOTES, 'UTF-8');
$cah = (float)($row['Cash_Flow'] ?? 0);
$ofn = htmlspecialchars($row['Officer_Name'] ?? '', ENT_QUOTES, 'UTF-8');
$tn = htmlspecialchars($row['Team_Name'] ?? '', ENT_QUOTES, 'UTF-8');
$drg = htmlspecialchars($row['Date_Reg'] ?? '', ENT_QUOTES, 'UTF-8');
$dra = htmlspecialchars($row['Date_Reg'] ?? '', ENT_QUOTES, 'UTF-8');
$aps = htmlspecialchars($row['Application_Status'] ?? '', ENT_QUOTES, 'UTF-8');

// Get repayment info
$stmt = mysqli_prepare($con, "SELECT * FROM repayments WHERE Reg_id = ?");
mysqli_stmt_bind_param($stmt, "i", $reg_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_array($result);

$tlon = (float)($row['Total_Loan'] ?? 0);
$pd = (float)($row['Paid'] ?? 0);
$tbl = (float)($row['Total_Bal'] ?? 0);
$sb = (float)($row['Savings_Bal'] ?? 0);

mysqli_close($con);
?>

<style>
.info-card {
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    margin-bottom: 15px;
}

.info-row {
    padding: 8px 0;
    border-bottom: 1px solid #f0f0f0;
}

.info-row:last-child {
    border-bottom: none;
}

.info-label {
    font-weight: 600;
    color: #555;
    font-size: 11px;
}

.info-value {
    color: #333;
    font-size: 11px;
}

.status-badge {
    padding: 4px 10px;
    border-radius: 12px;
    font-size: 10px;
    font-weight: 600;
    display: inline-block;
}

.status-active {
    background: #d4edda;
    color: #155724;
}

.status-closed {
    background: #f8d7da;
    color: #721c24;
}

.btn-action {
    margin-top: 10px;
    font-size: 12px;
    border-radius: 6px;
}



.collapsible-section {
    display: none;
    animation: slideDown 0.3s ease;
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.id-card-table {
    font-size: 10px;
}

.id-card-table th {
    background: #f8f9fa;
    font-weight: 600;
    padding: 10px;
}

.id-card-link {
    color: #667eea;
    text-decoration: none;
    font-weight: 600;
}

.id-card-link:hover {
    color: #764ba2;
    text-decoration: underline;
}

.balance-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 8px;
    padding: 15px;
    margin-bottom: 10px;
}

.balance-label {
    font-size: 10px;
    opacity: 0.9;
    margin-bottom: 5px;
}

.balance-amount {
    font-size: 16px;
    font-weight: 700;
}
</style>
<center>
<img src="<?php echo $pic; ?>" style="height:100px; width:100px" class="img-fluid rounded-pill avatar-100" loading="lazy">
</center>
<div class="col-12">

            <div class="row" style="font-size:11px;">
                <!-- Guarantor Basic Info -->
                <div class="col-12 col-md-6">
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="info-row">
                                <div class="row">
                                    <div class="col-6">
                                        <span class="info-label">Surname:</span><br>
                                        <span class="info-value" style="text-transform:capitalize"><?php echo $frst; ?></span>
                                    </div>
                                    <div class="col-6">
                                        <span class="info-label">Other Names:</span><br>
                                        <span class="info-value" style="text-transform:capitalize"><?php echo "$mid $las"; ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="info-row">
                                <div class="row">
                                    <div class="col-6">
                                        <span class="info-label">Phone No:</span><br>
                                        <span class="info-value"><?php echo $ph; ?></span>
                                    </div>
                                    <div class="col-6">
                                        <span class="info-label">Gender:</span><br>
                                        <span class="info-value"><?php echo $gn; ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Address:</span><br>
                                <span class="info-value" style="text-transform:capitalize"><?php echo $ad; ?></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Guarantor Additional Info -->
                <div class="col-12 col-md-6">
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="info-row">
                                <div class="row">
                                    <div class="col-6">
                                        <span class="info-label">Relationship:</span><br>
                                        <span class="info-value"><?php echo $re; ?></span>
                                    </div>
                                    <div class="col-6">
                                        <span class="info-label">ID Card No:</span><br>
                                        <span class="info-value"><?php echo $idn; ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="info-row">
                                <div class="row">
                                    <div class="col-6">
                                        <span class="info-label">ID Type:</span><br>
                                        <span class="info-value"><?php echo $idt; ?></span>
                                    </div>
                                    <div class="col-6">
                                        <span class="info-label">Client BVN:</span><br>
                                        <span class="info-value"><?php echo $cl_bvn; ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="info-row">
                                <div class="row">
                                    <div class="col-6">
                                        <span class="info-label">Status:</span><br>
                                        <span class="status-badge <?php echo $st == 'Active' ? 'status-active' : 'status-closed'; ?>">
                                            <?php echo $st; ?>
                                        </span>
                                    </div>
                                    <div class="col-6">
                                        <span class="info-label">Guarantor BVN:</span><br>
                                        <span class="info-value"><?php echo $gb; ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-12">
                    <span class="info-label">Application Status:</span>
                    <span class="status-badge <?php echo $aps == 'Approved' ? 'status-active' : 'status-closed'; ?>">
                        <?php echo $aps; ?>
                    </span>
                </div>
            </div>

            <!-- ID Cards Table -->
            <div class="table-responsive">
                <table class="table table-sm table-bordered id-card-table">
                    <thead>
                        <tr>
                            <th>SN</th>
                            <th>ID TYPE</th>
                            <th>ID NO</th>
                        
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                    include '../config/db.php';
                    $stmt = mysqli_prepare($con, "SELECT * FROM gaurantors WHERE Regis_id = ?");
                    mysqli_stmt_bind_param($stmt, "i", $reg_id);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    $Count = mysqli_num_rows($result);
                    
                    if ($Count > 0) {
                        while($rows = mysqli_fetch_array($result)){
                            $l = $rows['id'];
                            $lmm = htmlspecialchars($rows['ID_No'] ?? '', ENT_QUOTES, 'UTF-8');
                            $cf = htmlspecialchars($rows['ID_Type'] ?? '', ENT_QUOTES, 'UTF-8');
                    ?>
                        <tr>
                            <td><?php echo $l; ?></td>
                            <td><?php echo $cf; ?></td>
                            <td><?php echo $lmm; ?></td>
                        
                        </tr>
                    <?php
                        } 
                    } else {
                        echo '<tr><td colspan="4" style="text-align:center; color:#999;">No ID cards found</td></tr>';
                    }
                    mysqli_close($con);
                    ?>
                    </tbody>
                </table>
            </div>
