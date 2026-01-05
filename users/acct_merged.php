<?php
include('../config/db.php');
include('../config/user_session.php');

$old = trim($_POST['old']); // other saving account id
$new = trim($_POST['new']); // active saving acct id
$bvn = trim($_POST['bvn']);

$d = date('Y-m-d');
$s = date('H:i:s'); // FIXED time format

// prevent same account merge
if ($old === $new) {
echo 3;
exit;
}

// ================= OLD SAVINGS =================
$result = mysqli_query($con, "SELECT * FROM savings WHERE id = '$old'");
if (!$result || mysqli_num_rows($result) === 0) {
echo "Old account not found";
exit;
}
$row = mysqli_fetch_assoc($result);

$old_id  = $row['id'];
$old_bal = $row['Balance'];
$old_ln  = $row['Loan_Account_No'];
$old_sv  = $row['Savings_Account_No'];
$old_reg = $row['Reg_id'];
$old_bv  = $row['Client_BVN'];

// ================= NEW SAVINGS =================
$result = mysqli_query($con, "SELECT * FROM savings WHERE id = '$new'");
if (!$result || mysqli_num_rows($result) === 0) {
echo "New account not found";
exit;
}
$rows = mysqli_fetch_assoc($result);

$new_id     = $rows['id'];
$new_sv     = $rows['Savings_Account_No'];
$new_ln     = $rows['Loan_Account_No'];
$new_tr     = $rows['Transaction_id'];
$new_dn     = $rows['Disbursement_No'];
$new_rep    = $rows['Repayments_id'];
$new_reg    = $rows['Reg_id'];
$new_us     = $rows['User'];
$new_us_id  = $rows['User_id'];
$new_ofn    = $rows['Officer_Name'];
$new_tm     = $rows['Team_Name'];
$new_tl     = $rows['Team_Leader'];
$new_tm_id  = $rows['Team_id'];
$new_br     = $rows['Branch'];
$new_br_id  = $rows['Branch_id'];
$new_pr     = $rows['Product'];
$new_pr_id  = $rows['Product_id'];
$new_un     = $rows['Unions'];
$new_un_id  = $rows['Union_id'];
$new_bal    = $rows['Balance'];

// ================= CHECK MERGE EXISTS =================
$chk = mysqli_query($con, "SELECT id FROM saving_merge WHERE Old = '$old_ln' AND Status = 'Account Merged'");
if (mysqli_num_rows($chk) > 0) {
echo 2;
exit;
}

// ================= GET REPAYMENT ID =================
$result = mysqli_query($con, "SELECT id FROM repayments WHERE Reg_id = '$new_reg'");
$row = mysqli_fetch_assoc($result);
$rep_id = $row['id'] ?? 0;

// ================= UPDATE HISTORY TABLES =================
$queries = [

"UPDATE save SET Reps_id='$rep_id', Register_id='$new_reg', Loan_Account_No='$new_ln', Transaction_id='$new_tr', Saving_Account='$new_sv', Disbursement_No='$new_dn',
Repayment_id='$new_rep', User='$new_us', User_id='$new_us_id', Branch='$new_br', Branch_Code='$new_br_id', Loan_Type='$new_pr', Product_id='$new_pr_id',
Officer_Name='$new_ofn', Team_Leader='$new_tl', Team_Name='$new_tm', Team_id='$new_tm_id', Unions='$new_un', Union_Code='$new_un_id' WHERE Saving_Account='$old_sv'",

"UPDATE transfers SET Reg_id='$new_reg', Loan_Account_No='$new_ln', Transaction_id='$new_tr', Saving_Account_No='$new_sv', User='$new_us', User_id='$new_us_id',
Branch='$new_br', Branch_id='$new_br_id', Officer_Name='$new_ofn', Team_Leader='$new_tl', Team_Name='$new_tm', Unions='$new_un', Union_id='$new_un_id', 
Product='$new_pr', Product_id='$new_pr_id', Team_id='$new_tm_id' WHERE Saving_Account_N o= '$old_sv'",

"UPDATE saving_upfront SET Reg_id='$new_reg', Loan_Account_No='$new_ln', Transaction_id='$new_tr', Saving_Account_No='$new_sv', User='$new_us',
User_id='$new_us_id', Branch='$new_br', Branch_id='$new_br_id', Officer_Name='$new_ofn', Team_Leader='$new_tl', Team_Name='$new_tm', Unions='$new_un', 
Union_id='$new_un_id', Product='$new_pr', Product_id='$new_pr_id', Team_id='$new_tm_id' WHERE Saving_Account_No = '$old_sv'",

"UPDATE saving_rep SET Reg_id='$new_reg', Loan_Account_No='$new_ln', Transaction_id='$new_tr', Saving_Account_No='$new_sv', Repayment_id='$new_rep', User='$new_us',
User_id='$new_us_id', Branch='$new_br', Branch_id='$new_br_id', Officer_Name='$new_ofn', Team_Leader='$new_tl', Team_Name='$new_tm', Unions='$new_un', 
Union_id='$new_un_id', Product='$new_pr', Product_id='$new_pr_id', Team_id='$new_tm_id' WHERE Saving_Account_No = '$old_sv'",

"UPDATE withdraw SET Reg_id='$new_reg', Loan_Account_No='$new_ln', Transaction_id='$new_tr', Saving_Account_No='$new_sv', User='$new_us', User_id='$new_us_id',
Branch='$new_br', Branch_id='$new_br_id', Officer_Name='$new_ofn', Team_Leader='$new_tl', Team_Name='$new_tm', Unions='$new_un', Union_id='$new_un_id', 
Product='$new_pr', Product_id='$new_pr_id', Team_id='$new_tm_id' WHERE Saving_Account_No='$old_sv'"
];

foreach ($queries as $q) {
if (!mysqli_query($con, $q)) {
echo mysqli_error($con);
exit;
}
}

// ================= CLOSE OTHER ACCOUNT =================
mysqli_query($con, "UPDATE savings SET Status='Closed', Balance = 0, Savings_Paid = 0, Closed_By = '$na', Date_Closed = '$d' WHERE id = '$old_id'");

// ================= MERGE LOG =================
mysqli_query($con, "INSERT INTO saving_merge (Old, New, BVN, First_Balance, Secound_Balance, Status, Date_Merged, Time_Merged, Merged_By)
VALUES ('$old_ln','$new_ln','$bvn','$old_bal','$new_bal','Account Merged','$d','$s','$na')");

// ================= RECALCULATE BALANCE =================
function sumPaid($con, $table, $col, $acct) {
$r = mysqli_query($con, "SELECT SUM($col) AS total FROM $table WHERE Status='Paid' AND Saving_Account_No='$acct'");
$d = mysqli_fetch_assoc($r);
return (float)($d['total'] ?? 0);
}

$pmd  = sumPaid($con,'save','Savings',$new_sv);
$pmw  = sumPaid($con,'withdraw','Amount_Withdraw',$new_sv);
$pmtr = sumPaid($con,'transfers','Amount',$new_sv);
$pmr  = sumPaid($con,'saving_rep','Amount',$new_sv);
$pmu  = sumPaid($con,'saving_upfront','Amount',$new_sv);

$pmcQ = mysqli_query($con,"SELECT SUM(Amount) AS total FROM credit WHERE Status='Paid' AND Reciever_Account='$new_sv'");
$pmcD = mysqli_fetch_assoc($pmcQ);
$pmc  = (float)($pmcD['total'] ?? 0);

$bal = ($pmd - $pmw - $pmtr - $pmr - $pmu) + $pmc;

mysqli_query($con,"UPDATE repayments SET Savings_Bal='$bal' WHERE Savings_Account_No='$new_sv'");
mysqli_query($con,"UPDATE savings SET Balance='$bal' WHERE Savings_Account_No='$new_sv'");

echo 1;
?>
