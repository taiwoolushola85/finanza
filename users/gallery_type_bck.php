<div style="overflow-x: auto; height:350px">
<?php 
include '../config/db.php';
$regid = $_POST['regid'];// reg id
$document_type = $_POST['document_type'];
if($document_type == 'Document'){
$Query = "SELECT Location FROM document WHERE Reg_ID = '$regid'";
$result = mysqli_query($con, $Query);
$Count = mysqli_num_rows($result);
if ($Count > 0) {
for ($j=0 ; $j < $Count; $j++){
$rows = mysqli_fetch_array($result);
?>
<div style="display:inline-block; margin:10px;">
<img src="<?php echo $rows['Location']?>" class="img-thumbnail" style="height:400px; width:400px">
</div>
<?php
}
}else{
echo "<span style='color:red'>No $document_type Document Image Uploaded</i>";
}
}else if($document_type == "Business"){

include '../config/db.php';
//Get Transactions Details
$Query = "SELECT * FROM verify WHERE Reg_id ='$regid' ORDER BY id ASC ";
$result = mysqli_query($con, $Query);
$Count = mysqli_num_rows($result);
if ($Count > 0) {
$Available = true;
for ($j=0 ; $j < $Count; $j++){
$rows = mysqli_fetch_array($result);
$img = $rows['F_Image'];
?>
<div style="display:inline-block; margin:10px;">
<img src="<?php echo $img?>" class="img-thumbnail" style="height:400px; width:400px">
</div>
<?php
}
}else {
//No Transaction History for the account
$Available = false; 
echo" No Image Record Found  <br/> ";       
}
?>
<?php
}else{
echo "<span style='color:red'>Invalid $document_type type selected.</i>";
}

?>
</div>