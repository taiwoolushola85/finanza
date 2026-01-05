<?php 
include '../config/db.php';
include '../config/user_session.php';
$id = $_POST['id'];// reg id
//
$Query = "SELECT id, Firstname, Middlename, Lastname, BVN FROM register WHERE id = '$id'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$us_id = $row['id'];
$name = $row['Firstname'].' '.$row['Middlename'].' '.$row['Lastname'];
$bvn = $row['BVN'];
//
$d = date("Y-m-d");
$s = date("h:m:sa");
// reciept uploading
$Image_Name = addslashes($_FILES['Pic']['name']);
$Tmp_Name   = $_FILES['Pic']['tmp_name'];
$File_Size  = $_FILES['Pic']['size'];
$File_Type  = $_FILES['Pic']['type'];
$maxSize = 1895674; // ~1.8 MB
$allowedExt = "pdf";
// Get file extension
$ext = strtolower(pathinfo($Image_Name, PATHINFO_EXTENSION));
// Check file extension
if ($ext !== $allowedExt) {
echo "Only PDF files are allowed";
exit();
}

// Check MIME type (extra security)
if ($File_Type !== "application/pdf") {
echo "Invalid file type";
exit();
}

// Check file size
if ($File_Size > $maxSize) {
echo "File size exceeds 1.8MB";
exit();
}

// Upload path
$path = "../document/" . $id ."_" . $Image_Name;

// Move file
if (move_uploaded_file($Tmp_Name, $path)) {
//
$sql = "UPDATE register SET Status = 'Approved', Stage = '2' WHERE id = '$id' ";
$result= mysqli_query($con, $sql);
//uploading document path to document table
$sql = "INSERT INTO document (Reg_ID, Name, BVN, Type, Location, Uploaded_By, Date_Upload, Time_Upload) 
VALUES ('$id', '$name', '$bvn', 'CRC Report', '$path', '$na', '$d', '$s')";
$result= mysqli_query($con, $sql);
if($result == true){
echo 1;
}else{
echo("Error description: " . mysqli_error($con));
}

} else {
echo "CRC Document Uploading Failed";
}
?>