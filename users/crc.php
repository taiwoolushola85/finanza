<?php 
include_once '../config/db.php';
$id = $_GET['id']; // repayment id
$Query = "SELECT id, BVN FROM repayments WHERE id = '$id' ORDER BY id ASC";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$repid = $row['id'];
$bv = $row['BVN'];
?>


<b>
<svg width="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<path opacity="0.4" d="M16.191 2H7.81C4.77 2 3 3.78 3 6.83V17.16C3 20.26 4.77 22 7.81 22H16.191C19.28 22 21 20.26 21 17.16V6.83C21 3.78 19.28 2 16.191 2Z" fill="currentColor"></path>
<path fill-rule="evenodd" clip-rule="evenodd" d="M8.07996 6.6499V6.6599C7.64896 6.6599 7.29996 7.0099 7.29996 7.4399C7.29996 7.8699 7.64896 8.2199 8.07996 8.2199H11.069C11.5 8.2199 11.85 7.8699 11.85 7.4289C11.85 6.9999 11.5 6.6499 11.069 6.6499H8.07996ZM15.92 12.7399H8.07996C7.64896 12.7399 7.29996 12.3899 7.29996 11.9599C7.29996 11.5299 7.64896 11.1789 8.07996 11.1789H15.92C16.35 11.1789 16.7 11.5299 16.7 11.9599C16.7 12.3899 16.35 12.7399 15.92 12.7399ZM15.92 17.3099H8.07996C7.77996 17.3499 7.48996 17.1999 7.32996 16.9499C7.16996 16.6899 7.16996 16.3599 7.32996 16.1099C7.48996 15.8499 7.77996 15.7099 8.07996 15.7399H15.92C16.319 15.7799 16.62 16.1199 16.62 16.5299C16.62 16.9289 16.319 17.2699 15.92 17.3099Z" fill="currentColor"></path>
</svg>    
CRC Record List
</b>
<br>
<br>
<br>
<input type="text" class="form-control search-input search form-control-sm" name="nm" id="nm" placeholder="Search..." onkeydown="getGroup()" style="width:200px">
<br>

<?php 
include '../config/db.php';
$d = date('Y-m-d');
$sql = "SELECT COUNT(*) AS overs FROM document WHERE BVN = '$bv'";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$over = $data['overs'];
echo "<small><b>Total Record: $over</b></small>";
?><br><br>
<?php 
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Origin: *");
include '../config/db.php';

$result = mysqli_query($con, "SELECT id, BVN, Name, Location, Uploaded_By, Date_Upload FROM document WHERE BVN = '$bv' ORDER BY Date_Upload ASC") or die("Bad Query.");

mysqli_close($con);

$results = array();
while($row = mysqli_fetch_assoc($result))
{
    $results[] = $row; 
}
$fp = fopen('../data/crc_list.json', 'w'); 
fwrite($fp, json_encode($results)); 
fclose($fp);
//echo json_encode($results);
?>

<div class="table-container" style="overflow:auto; height:250px">
<table>
<thead>
<tr>
<th style="font-size:8px;">BVN</th>
<th style="font-size:8px;">NAME</th>
<th style="font-size:8px;">VALIDATE BY</th>
<th style="font-size:8px;">DATE VALIDATED</th>
<th style="font-size:8px;">DOCUMENT</th>
</tr>
<tbody>
<?php
$url = '../data/crc_list.json';
$data = file_get_contents($url);
$json = json_decode($data);
foreach($json as $member){
?>

<tr>
<td style="font-size:8px;"><?php echo $member->BVN?></td>
<td style="font-size:8px;"><?php echo $member->Name?></td>
<td style="font-size:8px;"><?php echo $member->Uploaded_By?></td>
<td style="font-size:8px;"><?php echo date("d-M-Y", strtotime($member->Date_Upload))?></td>
<td style="font-size:8px;"> <a href="#!"  class = "inv" data-toggle="modal" data-target="#crcData" id="<?php echo $member->id;?>">View Document</a></td>
</tr>

<?php
}
?>

</div>


      
<script>
// to show data on a modal box
$(document).ready(function() {
$('.inv').on('click', function() {
var recID = $(this).attr('id');
if(recID) {
$("#crcData").modal('show');
$.ajax({
url: 'view_pdf.php',
type: "POST",
data: {'id':recID},
dataType: "json",
success:function(data) {
$('#de').text(data.depI);
$('#pdf').attr("src", data.imageUrl);
}
});
}else{

}
});
});
</script>

