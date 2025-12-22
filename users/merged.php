<?php
include('../config/db.php') ;
include '../config/user_session.php';
$old = trim($_POST['old']); // closed loan acct
$new = trim($_POST['new']);// active loan acct
$d = date('Y-m-d');
$s = date('h:m:sa');
// old savings
$result = mysqli_query($con, "SELECT * FROM repayments WHERE Savings_Account_No = '$old'");
$row= mysqli_fetch_array($result);
$old_id = $row['id'];
$old_ln = $row['Loan_Account_No'];
$old_sv = $row['Savings_Account_No'];
$old_reg = $row['Reg_id'];
$old_bv = $row['BVN'];
//new savings
$result = mysqli_query($con, "SELECT * FROM repayments WHERE Savings_Account_No = '$new'");
$rows= mysqli_fetch_array($result);
$new_id = $rows['id'];
$new_vrt = $rows['Account_Number'];
$new_bv = $rows['BVN'];
$new_sv = $rows['Savings_Account_No'];
$new_ln = $rows['Loan_Account_No'];
$new_tr = $rows['Transaction_id'];
$new_dn = $rows['Disbursement_No'];
$new_reg = $rows['Reg_id'];
$new_us = $rows['User'];
$new_us_id = $rows['User_id'];
$new_ofn = $rows['Officer_Name'];
$new_tm = $rows['Team_Name'];
$new_tl = $rows['Team_Leader'];
$new_tm_id = $rows['Team_id'];
$new_br = $rows['Branch'];
$new_br_id = $rows['Branch_id'];
$new_pr = $rows['Product'];
$new_pr_id = $rows['Product_id'];
$new_un = $rows['Unions'];
$new_un_id = $rows['Union_id'];
$new_mp_id = $rows['Map_id'];
// error if loan account are the same
if($old == $new){
echo 1;
exit();
}
// check if bvn is the same
if($old_bv != $new_bv){
echo "Customer old bvn: $old_bv not the same as the new: $new_bv, please update the bvn record before you proceed";
exit();
}

// updating saving history
$Query = "UPDATE save SET Virtual_Acct = '$new_vrt', Reps_id = '$rep_id', Register_id = '$new_reg', Loan_Account_No = '$new_ln', Transaction_id = '$new_tr',
Saving_Account  = '$new_sv', Disbursement_No = '$new_dn', Repayment_id = '$new_rep', User = '$new_us', User_id = '$new_us_id', Branch = '$new_br', 
Branch_Code = '$new_br_id', Loan_Type ='$new_pr', Product_id = '$new_pr_id', Officer_Name = '$new_ofn', Team_Leader = '$new_tl', Team_Name = '$new_tm',
Team_id = '$new_tm_id', Unions = '$new_un', Union_Code = '$new_un_id' WHERE Saving_Account = '$old'";
$result = mysqli_query($con, $Query);

// updating transfer history
$Query = "UPDATE transfers SET Reg_id = '$new_reg', Loan_Account_No = '$new_ln', Transaction_id = '$new_tr', Saving_Account_No  = '$new_sv',
User = '$new_us', User_id = '$new_us_id', Branch = '$new_br', Branch_id = '$new_br_id', Officer_Name = '$new_ofn', Team_Leader = '$new_tl', Team_Name = '$new_tm',
Unions = '$new_un', Union_id = '$new_un_id', Product ='$new_pr', Product_id = '$new_pr_id', Team_id = '$new_tm_id' WHERE Saving_Account_No = '$old'";
$result = mysqli_query($con, $Query);

//saving for repayment history
$Query = "UPDATE saving_rep SET Reg_id = '$new_reg', Loan_Account_No = '$new_ln', Transaction_id = '$new_tr', Saving_Account_No  = '$new_sv',
Repayment_id = '$new_rep', User = '$new_us', User_id = '$new_us_id', Branch = '$new_br', Branch_id = '$new_br_id', Officer_Name = '$new_ofn', 
Team_Leader = '$new_tl', Team_Name = '$new_tm', Unions = '$new_un', Union_id = '$new_un_id', Product ='$new_pr', Product_id = '$new_pr_id', 
Team_id = '$new_tm_id' WHERE Saving_Account_No = '$old'";
$result = mysqli_query($con, $Query);

//savings withdraw history
$Query = "UPDATE withdraw SET Reg_id = '$new_reg', Loan_Account_No = '$new_ln', Transaction_id = '$new_tr', Saving_Account_No  = '$new_sv',
User = '$new_us', User_id = '$new_us_id', Branch = '$new_br', Branch_id = '$new_br_id', Officer_Name = '$new_ofn', Team_Leader = '$new_tl', 
Team_Name = '$new_tm', Unions = '$new_un', Union_id = '$new_un_id', Product ='$new_pr', Product_id = '$new_pr_id', Team_id = '$new_tm_id'
WHERE Saving_Account_No = '$old'";
$result = mysqli_query($con, $Query);

// saving for upfront history
$Query = "UPDATE saving_upfront SET Reg_id = '$new_reg', Loan_Account_No = '$new_ln', Transaction_id = '$new_tr', Saving_Account_No  = '$new_sv',
User = '$new_us', User_id = '$new_us_id', Branch = '$new_br', Branch_id = '$new_br_id', Officer_Name = '$new_ofn', Team_Leader = '$new_tl', 
Team_Name = '$new_tm', Unions = '$new_un', Union_id = '$new_un_id', Product ='$new_pr', Product_id = '$new_pr_id', Team_id = '$new_tm_id' 
WHERE Saving_Account_No = '$old'";
$result = mysqli_query($con, $Query);

//saving credit history
$Query = "UPDATE credit SET Reciever_Reg_id = '$new_reg',  Reciever_Account  = '$new_sv', User = '$new_us', User_id = '$new_us_id', Branch = '$new_br', 
Branch_id = '$new_br_id', Officer_Name = '$new_ofn', Team_Leader = '$new_tl', Team_Name = '$new_tm', Unions = '$new_un', Union_id = '$new_un_id', 
Team_id = '$new_tm_id', Reciever_Loan_Acct = '$new_ln' WHERE Reciever_Account = '$old'";
$result = mysqli_query($con, $Query);

// closing previous account
$Query = "UPDATE savings SET Status = 'Closed', Balance = '0', Savings_Paid = '0', Closed_By = '$na', Date_Closed = '$d' WHERE id = '$old_id'";
$result = mysqli_query($con, $Query);

// merging history
$sql = "INSERT INTO saving_merge (Old, New, BVN, First_Balance, Secound_Balance, Status, Date_Merged, Time_Merged, Merged_By) 
VALUES ('$old', '$new', '$close_bvn', '$bal', 'NA', 'Account Merged', '$d', '$s', '$na')";
$result= mysqli_query($con, $sql);
//
if($result == true){
echo 2;
}else{
echo("Error description: " . mysqli_error($con));
}
?>