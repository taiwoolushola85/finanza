<?php 
$acct = $_GET['acct']; // account number
$code = $_GET['code']; // bank code

// API configuration
$apiUrl = "https://api.creditchek.africa/v1/identity/account-verification?account_number={$acct}&bank_code={$code}";
$token = "5Gy5jXFNPWLnBnVeGDxylnL5oqorcdC+nVrCZI31Kxt1z2DFqN4sCUvnuN0hBX8h";

// Prepare POST data
$postData = json_encode(['acct' => $acct]);

// Initialize cURL
$ch = curl_init($apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
'token: ' . $token,
'Content-Type: application/json'
]);

// Execute request
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

// Parse response
$data = json_decode($response, true);
$status = isset($data['status']) && $data['status'] ? 'success' : 'error';
$accountData = $data['data'] ?? [];
?>
<script>
$("#updateModal").modal('show');
$("#loaders").hide();
</script>


<br>
<br>

<div class="container">
<div class="header">
<h1>Account Information</h1>
<?php if ($status === 'success'): ?>
<span class="status-badge success">✓ Verified Successfully</span>
<?php else: ?>
<span class="status-badge error">✗ Verification Failed</span>
<?php endif; ?>
</div>
<?php if ($status === 'success' && !empty($accountData)): ?>
<table>
<tr>
<td>Account Number</td>
<td class="highlight"><?php echo htmlspecialchars($accountData['account_number'] ?? 'NA'); ?></td>
</tr>
<tr>
<td>Account Name</td>
<td><?php echo htmlspecialchars($accountData['account_name'] ?? 'NA'); ?></td>
</tr>
<tr>
<td>Account Status</td>
<td class="Tier <?php echo empty($accountData['account_status']) ? 'empty-value' : 'NA'; ?>">
Tier <?php echo !empty($accountData['account_status']) ? htmlspecialchars($accountData['account_status']) : '(empty)'; ?>
</td>
</tr>
<tr>
<td>Bank Code</td>
<td><?php echo htmlspecialchars($accountData['bank_code'] ?? 'NA'); ?></td>
</tr>
<tr>
<td>Bank Name</td>
<td><?php echo htmlspecialchars($accountData['bank_name'] ?? 'NA'); ?></td>
</tr>
<tr>
<td>BVN</td>
<td class="highlight"><?php echo htmlspecialchars($accountData['bvn'] ?? 'NA'); ?></td>
</tr>
</table>
<?php else: ?>
<table>
<tr>
<td>Error</td>
<td class="error"><?php echo htmlspecialchars($data['message'] ?? 'An error occurred during verification'); ?></td>
</tr>
<?php if (isset($data['error'])): ?>
<tr>
<td>Details</td>
<td><?php echo htmlspecialchars(is_array($data['error']) ? json_encode($data['error']) : $data['error']); ?></td>
</tr>
<?php endif; ?>
</table>
<?php endif; ?>
</div>