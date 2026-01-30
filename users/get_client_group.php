<?php 
include '../config/db.php';
$uzer = $_POST['us'];
$Query = "SELECT id, Name FROM groups WHERE User = '$uzer' AND Status = 'Activated' ORDER BY Name ASC";
$result = mysqli_query($con, $Query);
$Count = mysqli_num_rows($result);
if ($Count > 0) {
?>
<label style="font-size:13px">Select Group</label>
<select type="text" class="form-control form-control-md" name="gr" id="heys">
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
