

<div class="container">
<?php 
echo '<b>Total:</b>'. number_format($pmt,2);
?><br>
<br>
<div class="table-container" style="overflow: auto; height:415px">
<table style="font-size:8px">
<thead>
<tr>
<th>PRINCIPAL</th>
<th>INTEREST</th>
<th>AMT PAID</th>
<th>EXP AMT</th>
<th>BALANCE BEFORE</th>
<th>TYPES</th>
<th>POSTING TYPE</th>
<th>ACTION</th>
<th>DATE</th>
</tr>
</thead>
<?php 
$reg_id = $_GET['id'];
include '../config/db.php';
//Get Transactions Details
$Query = "SELECT * FROM history WHERE Register_id='$reg_id' AND Status='Paid' ORDER BY id ASC";
$result = mysqli_query($con, $Query);
$Count = mysqli_num_rows($result);
if ($Count > 0) {
$Available = true;
for ($j=0 ; $j < $Count; $j++){
$rows = mysqli_fetch_array($result);
$h_id = $rows['id'];
$fn = $rows['Firstname']." ".$rows['Middlename']." ".$rows['Lastname'];
$dis = $rows['Disbursement_No'];
$lon = $rows['Loan_Account_No'];
$uns = $rows['Unions'];
$pr = $rows['Loan_Type'];
$la = $rows['Loan_Amount'];
$am = $rows['Amount'];
$int = $rows['Interest_Amt'];
$exp = $rows['Expected_Amount'];
$of = $rows['Officer_Name'];
$dp = $rows['Date_Paid'];
$bb = $rows['Balance'];
$img = $rows['Location'];
$pm = $rows['Payment_Method'];
$po = $rows['Post_Method'];
?>
<tr>
<td><?php echo number_format($la,2); ?></td>
<td><?php echo number_format($int,2); ?></td>
<td><?php echo number_format($am,2); ?></td>
<td><?php echo number_format($exp,2); ?></td>
<td><?php echo number_format($bb,2); ?></td>
<td><?php echo $pm; ?></td>
<td><?php echo $po; ?></td>
<td> 
<?php 
if ($pm == 'Wema Bank'){
?>  
<span>No Reciept</span></td>
<?php 
}else{
?>  
<td  style="font-size:9px"><a href="#!" class = "invk" data-toggle="modal" data-target="#recieptdata" id="<?php echo $h_id; ?>">
<i class="fa fa-eye"></i> View Reciept</a>
<?php 
}
?> 
</td>
<td><?php echo $dp; ?></td>
</tr>
<?php
} 
}else {
//No Transaction History for the account
$Available = false; 
///echo" <small style='color:red'>No payment record </small> ";       
}
?>
</tr>
</table>
</div>