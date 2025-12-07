<?php 
include '../config/db.php';
$regid = $_POST['regid'];// reg id
$document_type = $_POST['document_type'];
$Query = "SELECT Location FROM document WHERE Reg_ID = '$regid' AND Type = '$document_type'";
$result = mysqli_query($con, $Query);
$Count = mysqli_num_rows($result);
if ($Count > 0) {
for ($j=0 ; $j < $Count; $j++){
$rows = mysqli_fetch_array($result);
?>
<div style="margin:auto;">
<center>
<img src="<?php echo $rows['Location']; ?>" class="img-fluid d-block" style="height:60vh">
</center>
</div>
<?php
}
}else{
echo "<span style='color:red'>No $document_type Document Image Uploaded</i>";
}
?>
