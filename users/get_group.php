<?php 
include '../config/db.php';
$id = $_POST['usid'];
$Query = "SELECT id, Name FROM groups WHERE Officer_id = '$id' AND Status = 'Activated' ORDER BY id ASC";
$result = mysqli_query($con, $Query);
$Count = mysqli_num_rows($result);
if ($Count > 0) {
?>
<label style="font-size:13px">Select Group</label>
<select type="text" class="form-control form-control-md" name="gr"  id="hey">
<option value="">Select Group</option>
<?php
for ($j=0 ; $j < $Count; $j++){
$rows = mysqli_fetch_array($result);
$grid = $rows['id'];
$name = $rows['Name'];
?>
<option value="<?php echo $grid; ?>"><?php echo $name; ?></option>
<?php
}
}
?>
</select>
