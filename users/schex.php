<?php 
include '../config/db.php';
$id = $_GET['id']; // repayment id
$d = date('Y-m-d');
$Query = "SELECT id,Reg_id
FROM repayments WHERE id = '$id'  ORDER BY id ASC LIMIT 1";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$id = $row['id'];
$reg_id = $row['Reg_id'];
// getting last payment expected date
$Query = "SELECT Expected_Date FROM schedule WHERE Regs_id = '$reg_id'  ORDER BY id DESC LIMIT 1";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$ex = $row['Expected_Date'];
// updating maturity date
$Query = "UPDATE repayments SET Maturity_Date = '$ex' WHERE Reg_id = '$reg_id' ";
$result= mysqli_query($con, $Query);
?>
<!-- Schedule start -->
<div >
<b>
<svg width="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<path opacity="0.4" d="M16.191 2H7.81C4.77 2 3 3.78 3 6.83V17.16C3 20.26 4.77 22 7.81 22H16.191C19.28 22 21 20.26 21 17.16V6.83C21 3.78 19.28 2 16.191 2Z" fill="currentColor"></path>
<path fill-rule="evenodd" clip-rule="evenodd" d="M8.07996 6.6499V6.6599C7.64896 6.6599 7.29996 7.0099 7.29996 7.4399C7.29996 7.8699 7.64896 8.2199 8.07996 8.2199H11.069C11.5 8.2199 11.85 7.8699 11.85 7.4289C11.85 6.9999 11.5 6.6499 11.069 6.6499H8.07996ZM15.92 12.7399H8.07996C7.64896 12.7399 7.29996 12.3899 7.29996 11.9599C7.29996 11.5299 7.64896 11.1789 8.07996 11.1789H15.92C16.35 11.1789 16.7 11.5299 16.7 11.9599C16.7 12.3899 16.35 12.7399 15.92 12.7399ZM15.92 17.3099H8.07996C7.77996 17.3499 7.48996 17.1999 7.32996 16.9499C7.16996 16.6899 7.16996 16.3599 7.32996 16.1099C7.48996 15.8499 7.77996 15.7099 8.07996 15.7399H15.92C16.319 15.7799 16.62 16.1199 16.62 16.5299C16.62 16.9289 16.319 17.2699 15.92 17.3099Z" fill="currentColor"></path>
</svg>
PAYMENT SCHEDULE
</b>
<hr> 
<span style="margin-left:7px">Total Installment No:
<?php 
include_once '../config/db.php';
$d = date('Y-m-d');
$sql = "SELECT COUNT(*) AS lm FROM schedule WHERE Regs_id = '$reg_id'";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$lm = $data['lm'];
echo $lm;
?>
</span>
<br>
<div class="container">
<div class="table-container" style="overflow: auto; height:330px">
<table style="font-size:8px">
<thead>
<tr>
<th>PRINCIPAL</th>
<th>INTEREST</th>
<th>EXPECTED</th>
<th>AMOUNT PAID</th>
<th>STATUS</th>
<th>PAYMENT METHOD</th>
<th>DATE EXPECTED</th>
<th>DATE PAID</th>
</tr>
</thead>
<?php 
include '../config/db.php';
//Get Transactions Details
$Query = "SELECT Regs_id,Loan_Amount,Amount_Paid,Interest,Expecting_Amount,Expected_Date,Date_Paid,Payment_Status,Payment_Method FROM
schedule WHERE Regs_id='$reg_id' ORDER BY id ASC";
$result = mysqli_query($con, $Query);
$Count = mysqli_num_rows($result);
if ($Count > 0) {
$Available = true;
for ($j=0 ; $j < $Count; $j++){
$rows = mysqli_fetch_array($result);
$cl_id = $rows['Regs_id'];
$la = $rows['Loan_Amount'];
$am = $rows['Amount_Paid'];
$int = $rows['Interest'];
$exp = $rows['Expecting_Amount'];
$ed = $rows['Expected_Date'];
$dp = $rows['Date_Paid'];
$ps = $rows['Payment_Status'];
$pm = $rows['Payment_Method'];
?>
<tr style="font-size:8px">
<td><?php echo number_format($la,2); ?></td>
<td><?php echo number_format($int,2); ?></td>
<td><?php echo number_format($exp,2); ?></td>
<td ><?php
if(empty($am)){
  echo '0.00';
  }else{
  echo number_format($am,2);
  }; ?>
  </td>
<td><?php 
  if($am == 0){
  echo "<small style='color:red; font-size:8px'>No Payment Yet</small>";
  }else{
  echo "<small style='color:green; font-size:8px'>Paid</small>";
  }
 ?></td>
<td><?php echo "<small style='font-size:8px'>$pm</small>"; ?></td>
<td><?php echo $ed; ?></td>
<td><?php echo $dp; ?></td>
</tr>
<?php
} 
}else {
//No Transaction History for the account
$Available = false; 
//echo" No Record Found  <br/> ";       
}
?>
</tr>
</table>
</div>

</div>