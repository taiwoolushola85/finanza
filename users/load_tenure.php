<?php 
include '../config/db.php';
$pr = $_POST['pr'];
$Query = "SELECT id, Tenure FROM product_list WHERE Product_id = '$pr'";
$result = mysqli_query($con, $Query);
$Count = mysqli_num_rows($result);
if ($Count > 0) {
?>
<label style="font-size:13px">Product</label>
<select type="text" class="form-control form-control-md" name="ln"  id="hey">
<option value="">Select Option</option>
<?php
for ($j=0 ; $j < $Count; $j++){
$rows = mysqli_fetch_array($result);
$namez= $rows['id'];
$uzer= $rows['Tenure'];
?>
<option value="<?php echo $uzer; ?>"><?php echo $uzer; ?></option>
<?php
}
}
?>
</select>
