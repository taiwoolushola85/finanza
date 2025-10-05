<div class="card" style="overflow: auto; height: 330px;">
<div class="card-body">
<?php 
$role_title= $_POST['lv']; // role title
include '../config/db.php';
$Query = "SELECT Name, Categorys FROM role WHERE Name ='$role_title'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$ct = $row['Categorys']; // role category
?>


<?php 
if ($ct == 'Managements'){
?>

<legend><h6><b>MANAGEMENTS ROLES</b></h6></legend><br><br>

<form action="" method="POST" enctype="multipart/form-data" id="uploadForm">
<input class="form-control" id="exampleInputEmail1"  name="gr" required="required" hidden = "hidden" value = "<?php echo $lv; ?>">
<input class="form-control" id="exampleInputEmail1"  name="ct" required="required" hidden = "hidden" value = "<?php echo $ct; ?>">
<span><i style="color:red">*</i> <b>ACCOUNTS</b> <input type="checkbox" name="ta[]" value="Accounts" style="margin-left:20px" id="tab"></span><br>
<div class="row" style="margin-left:1px;">
<div class="col-md-3" style="margin-top:12px">
<div class="card">
<div class="card-body">
Loan Accounts <input type="checkbox" name="na[]" value="Loan_Accounts">
</div>
</div>
</div>
<div class="col-md-3" style="margin-top:12px">
<div class="card">
<div class="card-body">
Saving Accounts <input type="checkbox" name="na[]" value="Saving_Accounts">
</div>
</div>
</div>
</div>
<br>
<span><i style="color:red">*</i> <b>BANK</b> <input type="checkbox" name="ta[]" value="BANK" style="margin-left:20px" id="tab"></span><br>
<div class="row" style="margin-left:1px;">
<div class="col-md-3" style="margin-top:12px">
<div class="card">
<div class="card-body">
Account Managements <input type="checkbox" name="na[]" value="Account_Managements">
</div>
</div>
</div>
<div class="col-md-3" style="margin-top:12px">
<div class="card">
<div class="card-body">
Account Statements <input type="checkbox" name="na[]" value="Account Statements">
</div>
</div>
</div>
<div class="col-md-3" style="margin-top:12px">
<div class="card">
<div class="card-body">
Inward Transactions <input type="checkbox" name="na[]" value="Inward_Transactions">
</div>
</div>
</div>
<div class="col-md-3" style="margin-top:12px">
<div class="card">
<div class="card-body">
Outward Transactions <input type="checkbox" name="na[]" value="Outward_Transactions">
</div>
</div>
</div>
<div class="col-md-3" style="margin-top:12px">
<div class="card">
<div class="card-body">
Virtual Account <input type="checkbox" name="na[]" value="Virtual_Account">
</div>
</div>
</div>
</div>
<br>
<span><i style="color:red">*</i> <b>CUSTOMER</b> <input type="checkbox" name="ta[]" value="CUSTOMER" style="margin-left:20px" id="tab"></span><br>
<div class="row" style="margin-left:1px;">
<div class="col-md-3" style="margin-top:12px">
<div class="card">
<div class="card-body">
All Customers <input type="checkbox" name="na[]"  value="All_Customers">
</div>
</div>
</div>
<div class="col-md-3" style="margin-top:12px">
<div class="card">
<div class="card-body">
Guarantors <input type="checkbox" name="na[]"  value="Guarantors">
</div>
</div>
</div>
</div>
<br>
<span><i style="color:red">*</i> <b>CRMS</b> <input type="checkbox" name="ta[]" value="C.R.M.S" style="margin-left:20px" id="tab"></span><br>
<div class="row" style="margin-left:1px;">
<div class="col-md-3" style="margin-top:12px">
<div class="card">
<div class="card-body">
Customer Record <input type="checkbox" name="na[]" value="Customer_Record">
</div>
</div>
</div>
<div class="col-md-3" style="margin-top:12px">
<div class="card">
<div class="card-body">
Birthday <input type="checkbox" name="na[]" value="Birthday">
</div>
</div>
</div>
</div>
<br>
<span><i style="color:red">*</i> <b>DIRECTORY</b> <input type="checkbox" name="ta[]" value="DIRECTORY" style="margin-left:20px" id="tab"></span><br>
<div class="row" style="margin-left:1px;">
<div class="col-md-3" style="margin-top:12px">
<div class="card">
<div class="card-body">
Staff Directory <input type="checkbox" name="na[]" value="Staff_Directory">
</div>
</div>
</div>
<div class="col-md-3" style="margin-top:12px">
<div class="card">
<div class="card-body">
File Directory <input type="checkbox" name="na[]" value="File_Directory">
</div>
</div>
</div>
</div>
<br>
<span><i style="color:red">*</i> <b>DISBURSEMENT</b> <input type="checkbox" name="ta[]" value="DISBURSEMENT" style="margin-left:20px" id="tab"></span><br>
<div class="row" style="margin-left:1px;">
<div class="col-md-3" style="margin-top:12px">
<div class="card">
<div class="card-body">
Pending Disbursement <input type="checkbox" name="na[]" value="Pending_Disbursement">
</div>
</div>
</div>
</div>
<br>
<span><i style="color:red">*</i> <b>DATABASE</b> <input type="checkbox" name="ta[]" value="DATABASE" style="margin-left:20px" id="tab"></span><br>
<div class="row" style="margin-left:1px;">
<div class="col-md-3" style="margin-top:12px">
<div class="card">
<div class="card-body">
Manage Record <input type="checkbox" name="na[]" value="Manage_Record">
</div>
</div>
</div>
<div class="col-md-3" style="margin-top:12px">
<div class="card">
<div class="card-body">
Loan Manager <input type="checkbox" name="na[]" value="Loan_Manager">
</div>
</div>
</div>
<div class="col-md-3" style="margin-top:12px">
<div class="card">
<div class="card-body">
Account Manager <input type="checkbox" name="na[]" value="Account_Manager">
</div>
</div>
</div>
</div>
<br>
<span><i style="color:red">*</i> <b>MAPPING</b> <input type="checkbox" name="ta[]" value="MAPPING" style="margin-left:20px" id="tab"></span><br>
<div class="row" style="margin-left:1px;">
<div class="col-md-3" style="margin-top:12px">
<div class="card">
<div class="card-body">
Users Mapping <input type="checkbox" name="na[]" value="Users_Mapping">
</div>
</div>
</div>
<div class="col-md-3" style="margin-top:12px">
<div class="card">
<div class="card-body">
Unmapping Users <input type="checkbox" name="na[]"  value="Unmapping_Users">
</div>
</div>
</div>
<div class="col-md-3" style="margin-top:12px">
<div class="card">
<div class="card-body">
Users Switching <input type="checkbox" name="na[]"  value="Users_Switching">
</div>
</div>
</div>
</div>
<br>
<span><i style="color:red">*</i> <b>GROUP</b> <input type="checkbox" name="ta[]" value="GROUP" style="margin-left:20px" id="tab"></span><br>
<div class="row" style="margin-left:1px;">
<div class="col-md-3" style="margin-top:12px">
<div class="card">
<div class="card-body">
All Groups <input type="checkbox" name="na[]"  value="All_Groups">
</div>
</div>
</div>
</div>
<br>
<span><i style="color:red">*</i> <b>TRANSFER</b> <input type="checkbox" name="ta[]" value="TRANSFER" style="margin-left:20px" id="tab"></span><br>
<div class="row" style="margin-left:1px;">
<div class="col-md-3" style="margin-top:12px">
<div class="card">
<div class="card-body">
Clients <input type="checkbox" name="na[]" value="Clients">
</div>
</div>
</div>
<div class="col-md-3" style="margin-top:12px">
<div class="card">
<div class="card-body">
Group <input type="checkbox" name="na[]"  value="Group">
</div>
</div>
</div>
<div class="col-md-3" style="margin-top:12px">
<div class="card">
<div class="card-body">
Loan Officer <input type="checkbox" name="na[]"  value="Loan_Officers">
</div>
</div>
</div>
<div class="col-md-3" style="margin-top:12px">
<div class="card">
<div class="card-body">
Application <input type="checkbox" name="na[]"  value="Applications">
</div>
</div>
</div>
<div class="col-md-3" style="margin-top:12px">
<div class="card">
<div class="card-body">
Portfolio <input type="checkbox" name="na[]"  value="Portfolio">
</div>
</div>
</div>
</div>
<br>
<span><i style="color:red">*</i> <b>LOAN</b> <input type="checkbox" name="ta[]" value="LOANS" style="margin-left:20px" id="tab"></span><br>
<div class="row" style="margin-left:1px;">
<div class="col-md-3" style="margin-top:12px">
<div class="card">
<div class="card-body">
Loan Book <input type="checkbox" name="na[]" value="Loan_Book">
</div>
</div>
</div>
<div class="col-md-3" style="margin-top:12px">
<div class="card">
<div class="card-body">
Expired Loans <input type="checkbox" name="na[]" value="Expired_Loans">
</div>
</div>
</div>
<div class="col-md-3" style="margin-top:12px">
<div class="card">
<div class="card-body">
Overdue Loans <input type="checkbox" name="na[]" value="Overdue_Loans">
</div>
</div>
</div>
<div class="col-md-3" style="margin-top:12px">
<div class="card">
<div class="card-body">
Loan Monitor <input type="checkbox" name="na[]" value="Loan_Monitor">
</div>
</div>
</div>
</div>
<br>
<span><i style="color:red">*</i> <b>UNDERWRITING</b> <input type="checkbox" name="ta[]" value="UNDERWRITING" style="margin-left:20px" id="tab"></span><br>
<div class="row" style="margin-left:1px;">
<div class="col-md-3" style="margin-top:12px">
<div class="card">
<div class="card-body">
Loan Underwriting <input type="checkbox" name="na[]"  value="Loan_Underwriting">
</div>
</div>
</div>
</div>
<br>
<span><i style="color:red">*</i> <b>REPORT</b> <input type="checkbox" name="ta[]" value="REPORT" style="margin-left:20px" id="tab"></span><br>
<div class="row" style="margin-left:1px;">
<div class="col-md-3" style="margin-top:12px">
<div class="card">
<div class="card-body">
Customer Reports <input type="checkbox" name="na[]"  value="Customer_Report">
</div>
</div>
</div>
<div class="col-md-3" style="margin-top:12px">
<div class="card">
<div class="card-body">
Loan Reports <input type="checkbox" name="na[]"  value="Loan_Reports">
</div>
</div>
</div>
<div class="col-md-3" style="margin-top:12px">
<div class="card">
<div class="card-body">
Saving Reports<input type="checkbox" name="na[]"  value="Saving_Reports">
</div>
</div>
</div>
<div class="col-md-3" style="margin-top:12px">
<div class="card">
<div class="card-body">
Performance Reports <input type="checkbox"  name="na[]"  value="Performance_Reports">
</div>
</div>
</div>
<div class="col-md-3" style="margin-top:12px">
<div class="card">
<div class="card-body">
Balance Print Out <input type="checkbox" name="na[]"  value="Balance_Print_Out">
</div>
</div>
</div>
<div class="col-md-3" style="margin-top:12px">
<div class="card">
<div class="card-body">
Transaction Monitor Report <input type="checkbox" name="na[]"  value="Transaction_Monitor_Report">
</div>
</div>
</div>
</div>
<br>
<span><i style="color:red">*</i> <b>REQUEST</b> <input type="checkbox" name="ta[]" value="REQUEST" style="margin-left:20px" id="tab"></span><br>
<div class="row" style="margin-left:1px;">
<div class="col-md-3" style="margin-top:12px">
<div class="card">
<div class="card-body">
Blacklist Request <input type="checkbox" name="na[]" value="Blacklist_Requests">
</div>
</div>
</div>
<div class="col-md-3" style="margin-top:12px">
<div class="card">
<div class="card-body">
Savings Request <input type="checkbox" name="na[]" value="Savings_Request">
</div>
</div>
</div>
<div class="col-md-3" style="margin-top:12px">
<div class="card">
<div class="card-body">
Withdrawal List <input type="checkbox" name="na[]" value="Withdrawal_List">
</div>
</div>
</div>
<div class="col-md-3" style="margin-top:12px">
<div class="card">
<div class="card-body">
Manage Request <input type="checkbox" name="na[]" value="Manage_Request">
</div>
</div>
</div>
<div class="col-md-3" style="margin-top:12px">
<div class="card">
<div class="card-body">
Other Request <input type="checkbox" name="na[]" value="Other_Requests">
</div>
</div>
</div>
</div>
<br>
<span><i style="color:red">*</i> <b>ZONE</b> <input type="checkbox" name="ta[]" value="ZONE" style="margin-left:20px" id="tab"></span><br>
<div class="row" style="margin-left:1px;">
<div class="col-md-3" style="margin-top:12px">
<div class="card">
<div class="card-body">
Zone Mapping <input type="checkbox" name="na[]" value="Zone_Mapping">
</div>
</div>
</div>
<div class="col-md-3" style="margin-top:12px">
<div class="card">
<div class="card-body">
Zone Switching <input type="checkbox" name="na[]" value="Zone_Switching">
</div>
</div>
</div>
<div class="col-md-3" style="margin-top:12px">
<div class="card">
<div class="card-body">
Zone Table <input type="checkbox" name="na[]" value="Zone_Table">
</div>
</div>
</div>
</div>
<br>
<br>
<button type="submit" class="btn btn-outline-success btn-sm" name="access" onclick="data()">Grant Access</button>
</form>






<?php 
} else if ($ct == 'Branch Operations'){
?>
<form action="" method="POST" enctype="multipart/form-data" id="uploadForm">
<input class="form-control" id="exampleInputEmail1"  name="gr" required="required" hidden = "hidden" value = "<?php echo $lv; ?>">
<input class="form-control" id="exampleInputEmail1"  name="ct" required="required" hidden = "hidden" value = "<?php echo $ct; ?>">
<h5>TEAM LEADER ROLE</h5><br><br>
<h6><i style="color:red">*</i> <b>ACCOUNTS</b> <input type="checkbox" name="ta[]" value="ACCOUNTS"></h6><br>
<div class="row" style="margin-left:12px;">
<div class="col-md-3" style="margin-top:12px">
<div class="card">
<div class="card-body">
Loan Accounts <input type="checkbox" name="na[]" value="Loan_Accounts">
</div>
</div>
</div>
<div class="col-md-3" style="margin-top:12px">
<div class="card">
<div class="card-body">
Saving Accounts <input type="checkbox" name="na[]" value="Saving_Accounts">
</div>
</div>
</div>
</div>
<br>
<h6><i style="color:red">*</i> <b>COLLECTION</b> <input type="checkbox" name="ta[]" value="COLLECTIONS"></h6>
<div class="row" style="margin-left:12px;">
<div class="col-md-3" style="margin-top:12px">
<div class="card">
<div class="card-body">
Repayment Collection <input type="checkbox" name="na[]" value="Repayment_Collection">
</div>
</div>
</div>
</div>
<br>
<span><i style="color:red">*</i> <b>REPORT</b> <input type="checkbox" name="ta[]" value="REPORT" style="margin-left:20px" id="tab"></span><br>
<div class="row" style="margin-left:12px;">
<div class="col-md-3" style="margin-top:12px">
<div class="card">
<div class="card-body">
Customer Reports <input type="checkbox" name="na[]"  value="Customer_Report">
</div>
</div>
</div>
<div class="col-md-3" style="margin-top:12px">
<div class="card">
<div class="card-body">
Loan Reports <input type="checkbox" name="na[]"  value="Loan_Reports">
</div>
</div>
</div>
<div class="col-md-3" style="margin-top:12px">
<div class="card">
<div class="card-body">
Saving Reports<input type="checkbox" name="na[]"  value="Saving_Reports">
</div>
</div>
</div>
<div class="col-md-3" style="margin-top:12px">
<div class="card">
<div class="card-body">
Performance Reports <input type="checkbox"  name="na[]"  value="Performance_Reports">
</div>
</div>
</div>
<div class="col-md-3" style="margin-top:12px">
<div class="card">
<div class="card-body">
Balance Print Out <input type="checkbox" name="na[]"  value="Balance_Print_Out">
</div>
</div>
</div>
<div class="col-md-3" style="margin-top:12px">
<div class="card">
<div class="card-body">
Transaction Monitor Report <input type="checkbox" name="na[]"  value="Transaction_Monitor_Report">
</div>
</div>
</div>
</div>
<br>
<h6><i style="color:red">*</i> <b> LOANS</b> <input type="checkbox" name="ta[]" value="LOANS"></h6>
<div class="row" style="margin-left:12px;">
<div class="col-md-3" style="margin-top:12px">
<div class="card">
<div class="card-body">
Loan Book <input type="checkbox" name="na[]" value="Loan_Book">
</div>
</div>
</div>
</div>
<br>
<h6><i style="color:red">*</i><b> GROUPS</b> <input type="checkbox" name="ta[]" value="GROUPS"></h6>
<div class="row" style="margin-left:12px;">
<div class="col-md-3" style="margin-top:12px">
<div class="card">
<div class="card-body">
Groups <input type="checkbox" name="na[]" value="Groups">
</div>
</div>
</div>
</div>
<br>
<h6><i style="color:red">*</i> <b> REQUESTS</b> <input type="checkbox" name="ta[]" value="REQUESTS"></h6>
<div class="row" style="margin-left:12px;">
<div class="col-md-3" style="margin-top:12px">
<div class="card">
<div class="card-body">
Savings Request <input type="checkbox" name="na[]" value="Savings_Request">
</div>
</div>
</div>
</div>
<br>
<br>
<h5>VERIFICATION ROLE</h5><br>
<h6><i style="color:red">*</i> <b>VERIFICATION</b> <input type="checkbox" name="ta[]" value="VERIFICATION"></h6>
<div class="row" style="margin-left:1px;">
<div class="col-md-3" style="margin-top:12px">
<div class="card">
<div class="card-body">
Pending Verification <input type="checkbox" name="na[]" value="Pending_Verification">
</div>
</div>
</div>
<div class="col-md-3" style="margin-top:12px">
<div class="card">
<div class="card-body">
Approved Verification <input type="checkbox" name="na[]" value="Approved_Verification">
</div>
</div>
</div>
</div>
<br>
<br>
<h5>HEAD OF RECOVERY ROLE</h5><br>
<h6><i style="color:red">*</i> <b>TRANSACTIONS</b> <input type="checkbox" name="ta[]" value="TRANSACTIONS"></h6>
<div class="row" style="margin-left:1px;">
<div class="col-md-3" style="margin-top:12px">
<div class="card">
<div class="card-body">
Posting Transactions <input type="checkbox" name="na[]" value="Posting_Transactions">
</div>
</div>
</div>
</div>
<br>
<h6><i style="color:red">*</i><b> ACCOUNT</b> <input type="checkbox" name="ta[]" value="ACCOUNT"></h6>
<div class="row" style="margin-left:1px;">
<div class="col-md-3" style="margin-top:12px">
<div class="card">
<div class="card-body">
Loan Accounts <input type="checkbox" name="na[]" value="Loan_Accounts">
</div>
</div>
</div>
<div class="col-md-3" style="margin-top:12px">
<div class="card">
<div class="card-body">
Saving Accounts <input type="checkbox" name="na[]" value="Saving_Accounts">
</div>
</div>
</div>
</div>
<br>
<h6><i style="color:red">*</i><b> REQUEST</b> <input type="checkbox" name="ta[]" value="REQUESTS"></h6>
<div class="row" style="margin-left:1px;">
<div class="col-md-3" style="margin-top:12px">
<div class="card">
<div class="card-body">
Transportation Request <input type="checkbox" name="na[]" value="Transportation_Request">
</div>
</div>
</div>
</div>
<br>
<h6><i style="color:red">*</i><b> REMITTANCE</b> <input type="checkbox" name="ta[]" value="REMITTANCE"></h6>
<div class="row" style="margin-left:1px;">
<div class="col-md-3" style="margin-top:12px">
<div class="card">
<div class="card-body">
Remittance <input type="checkbox" name="na[]" value="Money_Remitted">
</div>
</div>
</div>
</div>
<br>
<span><i style="color:red">*</i> <b>REPORT</b> <input type="checkbox" name="ta[]" value="REPORT" style="margin-left:20px" id="tab"></span><br>
<div class="row" style="margin-left:1px;">
<div class="col-md-3" style="margin-top:12px">
<div class="card">
<div class="card-body">
Customer Reports <input type="checkbox" name="na[]"  value="Customer_Report">
</div>
</div>
</div>
<div class="col-md-3" style="margin-top:12px">
<div class="card">
<div class="card-body">
Loan Reports <input type="checkbox" name="na[]"  value="Loan_Reports">
</div>
</div>
</div>
<div class="col-md-3" style="margin-top:12px">
<div class="card">
<div class="card-body">
Saving Reports<input type="checkbox" name="na[]"  value="Saving_Reports">
</div>
</div>
</div>
<div class="col-md-3" style="margin-top:12px">
<div class="card">
<div class="card-body">
Performance Reports <input type="checkbox"  name="na[]"  value="Performance_Reports">
</div>
</div>
</div>
<div class="col-md-3" style="margin-top:12px">
<div class="card">
<div class="card-body">
Balance Print Out <input type="checkbox" name="na[]"  value="Balance_Print_Out">
</div>
</div>
</div>
<div class="col-md-3" style="margin-top:12px">
<div class="card">
<div class="card-body">
Transaction Monitor Report <input type="checkbox" name="na[]"  value="Transaction_Monitor_Report">
</div>
</div>
</div>
</div>
</fieldset>
<br>
<br>
<button type="submit" class="btn btn-outline-success btn-sm" name="access" onclick="data()">Grant Access</button>
</form>
<br>

<?php 
} else if ($ct == 'Field Operations'){
?>

<form action="" method="POST" enctype="multipart/form-data" id="uploadForm">
<input class="form-control" id="exampleInputEmail1"  name="gr" required="required" hidden = "hidden" value = "<?php echo $lv; ?>">
<input class="form-control" id="exampleInputEmail1"  name="ct" required="required" hidden = "hidden" value = "<?php echo $ct; ?>">
<div class="col-md-4">
<form  method="GET" action="">
<input class="form-control" id="exampleInputEmail1"  name="gr" required="required" hidden = "hidden" value = "<?php echo $lv; ?>">
<input class="form-control" id="exampleInputEmail1"  name="ct" required="required" hidden = "hidden" value = "<?php echo $ct; ?>">
</div>
<fieldset>
<legend><h6><b>FIELD OPERATION ROLES</b></h6></legend><br><br>
<h6><i style="color:red">*</i> <b>ACCOUNTS</b> <input type="checkbox" name="ta[]" value="ACCOUNTS"></h6>
<div class="row" style="margin-left:1px;">
<div class="col-md-3" style="margin-top:12px">
<div class="card">
<div class="card-body">
Loan Accounts <input type="checkbox" name="na[]" value="Loan_Accounts">
</div>
</div>
</div>
<div class="col-md-3" style="margin-top:12px">
<div class="card">
<div class="card-body">
Saving Accounts <input type="checkbox" name="na[]" value="Saving_Accounts">
</div>
</div>
</div>
</div>
<br>
<h6><i style="color:red">*</i> <b style="margin-left:1px;"> POSTING</b> <input type="checkbox" name="ta[]" value="POSTING"></h6>
<div class="row" style="margin-left:1px;">
<div class="col-md-3" style="margin-top:12px">
<div class="card">
<div class="card-body">
Repayment Posting <input type="checkbox" name="na[]" value="Repayment_Posting">
</div>
</div>
</div>
<div class="col-md-3" style="margin-top:12px">
<div class="card">
<div class="card-body">
Savings Posting <input type="checkbox" name="na[]" value="Savings_Posting">
</div>
</div>
</div>
<div class="col-md-3" style="margin-top:12px">
<div class="card">
<div class="card-body">
Flexi_Saving Posting <input type="checkbox" name="na[]" value="Flexi_Saving_Posting">
</div>
</div>
</div>
</div>
<br>
<h6><i style="color:red">*</i> <b>GROUPS</b> <input type="checkbox" name="ta[]" value="GROUPS"></h6>
<div class="row" style="margin-left:1px;">
<div class="col-md-3" style="margin-top:12px">
<div class="card">
<div class="card-body">
Add Group <input type="checkbox" name="na[]" value="Add_Group">
</div>
</div>
</div>
<div class="col-md-3" style="margin-top:12px">
<div class="card">
<div class="card-body">
Group List <input type="checkbox" name="na[]" value="Group_List">
</div>
</div>
</div>
</div>
<br>
<h6><i style="color:red">*</i> <b>FLEXI</b> <input type="checkbox" name="ta[]" value="FLEXI"></h6>
<div class="row" style="margin-left:1px;">
<div class="col-md-3" style="margin-top:12px">
<div class="card">
<div class="card-body">
Flexi Registration Form <input type="checkbox"  name="na[]" value="Flexi_Registration_Form">
</div>
</div>
</div>
<div class="col-md-3" style="margin-top:12px">
<div class="card">
<div class="card-body">
Flexi Applications List <input type="checkbox" name="na[]" value="Flexi_Applications_List">
</div>
</div>
</div>
</div>
<br>
<h6><i style="color:red">*</i> <b>REGISTERATIONS</b> <input type="checkbox" name="ta[]" value="REGISTRATIONS"></h6>
<div class="row" style="margin-left:1px;">
<div class="col-md-3" style="margin-top:12px">
<div class="card">
<div class="card-body">
Loan Registration Form <input type="checkbox" name="na[]" value="Loan_Registration_Form">
</div>
</div>
</div>
<div class="col-md-3" style="margin-top:12px">
<div class="card">
<div class="card-body">
Loan Applications List <input type="checkbox" name="na[]" value="Loan_Applications_List">
</div>
</div>
</div>
</div>
<br>
<span><i style="color:red">*</i> <b>REMITTANCE</b><input type="checkbox" name="ta[]" value="REMITTANCE" style="margin-left:20px"></span><br><br>
<div class="row" style="margin-left:1px;">
<div class="col-md-3" style="margin-top:12px">
<div class="card">
<div class="card-body">
Remittance <input type="checkbox" name="na[]" value="Remittance">
</div>
</div>
</div>
<div class="col-md-3" style="margin-top:12px">
<div class="card">
<div class="card-body">
Remittance Checker <input type="checkbox" name="na[]" value="Remittance_Checker">
</div>
</div>
</div>
</div>
<br>
<h6><i style="color:red">*</i> <b>REQUEST</b> <input type="checkbox" name="ta[]" value="REQUESTS"></h6>
<div class="row" style="margin-left:1px;">
<div class="col-md-3" style="margin-top:12px">
<div class="card">
<div class="card-body">
Savings Request <input type="checkbox" name="na[]" value="Savings_Request">
</div>
</div>
</div>
<div class="col-md-3" style="margin-top:12px">
<div class="card">
<div class="card-body">
Transportation Request <input type="checkbox" name="na[]" value="Transportation_Request">
</div>
</div>
</div>
</div>
<br>
<br>
<br>
<h5>VERIFICATION ROLE</h5><br>
<h6><i style="color:red">*</i> <b>VERIFICATION</b> <input type="checkbox" name="ta[]" value="VERIFICATION"></h6>
<div class="row" style="margin-left:1px;">
<div class="col-md-3" style="margin-top:12px">
<div class="card">
<div class="card-body">
Pending Verification <input type="checkbox" name="na[]" value="Pending_Verification">
</div>
</div>
</div>
<div class="col-md-3" style="margin-top:12px">
<div class="card">
<div class="card-body">
Approved Verification <input type="checkbox" name="na[]" value="Approved_Verification">
</div>
</div>
</div>
</div>
<br>
<br>
<br>
<h5>RECOVERY ROLE</h5><br><br>
<span><i style="color:red">*</i> <b>ACCOUNTS</b> <input type="checkbox" name="ta[]" value="Accounts" style="margin-left:20px" id="tab"></span><br>
<div class="row" style="margin-left:1px;">
<div class="col-md-3" style="margin-top:12px">
<div class="card">
<div class="card-body">
Loans Account <input type="checkbox" name="na[]" value="Expired_Loans_Account">
</div>
</div>
</div>
<div class="col-md-3" style="margin-top:12px">
<div class="card">
<div class="card-body">
Saving Accounts <input type="checkbox" name="na[]" value="Express_Saving_Accounts">
</div>
</div>
</div>
<div class="col-md-3" style="margin-top:12px">
<div class="card">
<div class="card-body">
Flexi Saving Accounts <input type="checkbox" name="na[]" value="Flexi_Saving_Accounts" >
</div>
</div>
</div>
</div>
<br>
<span><i style="color:red">*</i> <b>POSTING</b><input type="checkbox" name="ta[]" value="POSTING" style="margin-left:20px"></span><br><br>
<div class="row" style="margin-left:1px;">
<div class="col-md-3" style="margin-top:12px">
<div class="card">
<div class="card-body">
Repayment Posting <input type="checkbox" name="na[]" value="Repayment_Posting">
</div>
</div>
</div>
</div>
<br>
<span><i style="color:red">*</i> <b>REMITTANCE</b><input type="checkbox" name="ta[]" value="REMITTANCE" style="margin-left:20px"></span><br><br>
<div class="row" style="margin-left:1px;">
<div class="col-md-3" style="margin-top:12px">
<div class="card">
<div class="card-body">
Remittance <input type="checkbox" name="na[]" value="Money_Remittance">
</div>
</div>
</div>
<div class="col-md-3" style="margin-top:12px">
<div class="card">
<div class="card-body">
Remittance Checker <input type="checkbox" name="na[]" value="Remittance_Checker">
</div>
</div>
</div>
</div>
<br>
<h6><i style="color:red">*</i><b> LOANS</b> <input type="checkbox" name="ta[]" value="LOANS"></h6>
<div class="row" style="margin-left:1px;">
<div class="col-md-3" style="margin-top:12px">
<div class="card">
<div class="card-body">
Expired Loan <input type="checkbox" name="na[]" value="Expired_Loan">
</div>
</div>
</div>
<div class="col-md-3" style="margin-top:12px">
<div class="card">
<div class="card-body">
Loan Book <input type="checkbox" name="na[]" value="Loan_Book">
</div>
</div>
</div>
<div class="col-md-3" style="margin-top:12px">
<div class="card">
<div class="card-body">
Loan Monitor <input type="checkbox" name="na[]" value="Loan_Monitor">
</div>
</div>
</div>
</div>
<br>
<h6><i style="color:red">*</i> <b>REQUEST</b> <input type="checkbox" name="ta[]" value="REQUESTS"></h6>
<div class="row" style="margin-left:1px;">
<div class="col-md-3" style="margin-top:12px">
<div class="card">
<div class="card-body">  
Transportation Request <input type="checkbox" name="na[]" value="Transportation_Request">
</div>
</div>
</div>
</div>
<br>
<br>
</fieldset>
<button type="submit" class="btn btn-success btn-sm" name="access" onclick="data()">Grant Access</button>
</form>


<?php 
}else{
echo "No Menu List Available";
}
?>



</div>
</div>





<script type="text/javascript">
$(document).ready(function (e){
$("#uploadForm").on('submit',(function(e){ e.preventDefault();
WRN_PROFILE_DELETE = "You are about to activate this user role.?";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
$("#butsave").attr("disabled", "disabled");
$("#menu").hide();
$("#please").show();
$.ajax({
url: "roles.php",
type: "POST",
data: new FormData(this),
contentType: false, 
cache: false, 
processData:false,
success: function(data){
setTimeout(function(){
$("#please").hide();
$("#alert").show();
}, 4000);
setTimeout(function(){
$("#uploadForm")[0].reset();
$("#please").hide();
$("#alert").hide();
$("#menu").show();
}, 6000);
},
error: function(){
}
});
}
}));
});
</script>