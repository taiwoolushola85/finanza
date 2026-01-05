<?php 
include '../config/db.php';
$br = $_POST['br'];
$Query = "SELECT  * FROM users WHERE Branch_id = '$br' AND User_Group = 'Loan Officers' AND Status = 'Activate' ORDER BY id ASC";
$result = mysqli_query($con, $Query);
$Count = mysqli_num_rows($result);
if ($Count > 0) {
?>
<label style="font-size:13px">Loan Officer</label>
<select type="text" class="form-control form-control-md" name="ln"  id="hey">
<option value="">All</option>
<?php
for ($j=0 ; $j < $Count; $j++){
$rows = mysqli_fetch_array($result);
$namez= $rows['Name'];
$uzer= $rows['Username'];
?>
<option value="<?php echo $uzer; ?>"><?php echo $namez; ?></option>
<?php
}
}
?>
</select>
