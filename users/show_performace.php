<?php 
$br = $_POST['br'];
?>


<?php 
if($br == 'All'){
?>
<div class="row" style="font-size:10px">
<div class="col-sm-4">
<b>Branch: <?php echo $br; ?> </b>
</div>
<div class="col-sm-4">
<b>Total Principal Amt: 
<?php 
include_once '../config/db.php';
$d = date('Y-m-d');
$sql = "SELECT SUM(Loan_Amount) AS lm FROM repayments WHERE Status != 'Cancelled'";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$lm = $data['lm'];
echo number_format($lm,2);
?>
</b>
</div>
<div class="col-sm-4">
<b>Total Interest Amt:
<?php 
include_once '../config/db.php';
$d = date('Y-m-d');
$sql = "SELECT SUM(Interest_Amt) AS lm FROM repayments WHERE Status != 'Cancelled'";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$lm = $data['lm'];
echo number_format($lm,2);
?>
</b>
</div>
</div>
<br>
<button type="button" class="btn btn-info btn-sm btn-flat" onclick="tableToCSV()">Download Data</button>
<script type="text/javascript">
function tableToCSV() {
// Variable to store the final csv data
let csv_data = [];
// Get each row data
let rows = document.getElementsByTagName('tr');
for (let i = 0; i < rows.length; i++) {
// Get each column data
let cols = rows[i].querySelectorAll('td,th');
// Stores each csv row data
let csvrow = [];
for (let j = 0; j < cols.length; j++) {
// Get the text data of each cell
// of a row and push it to csvrow
csvrow.push(cols[j].innerHTML);
}
// Combine each column value with comma
csv_data.push(csvrow.join(","));
}
// Combine each row data with new line character
csv_data = csv_data.join('\n');
// Call this function to download csv file  
downloadCSVFile(csv_data);
}
function downloadCSVFile(csv_data) {
// Create CSV file object and feed
// our csv_data into it
CSVFile = new Blob([csv_data], {
type: "text/csv"
});
// Create to temporary link to initiate
// download process
let temp_link = document.createElement('a');
// Download csv file
temp_link.download = "Branch_Performance_Report.csv";
let url = window.URL.createObjectURL(CSVFile);
temp_link.href = url;
// This link should not be displayed
temp_link.style.display = "none";
document.body.appendChild(temp_link);
// Automatically click the link to
// trigger download
temp_link.click();
document.body.removeChild(temp_link);
}
</script>
<br><br>
<span>Total Count:  
<?php 
include_once '../config/db.php';
$d = date('Y-m-d');
$sql = "SELECT COUNT(*) AS lm FROM branch WHERE Status = 'Activate'";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$lm = $data['lm'];
echo $lm;
?>
</span>
<br><br>

<?php
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Origin: *");
include '../config/db.php';
$st = $_POST['st'];
$br = $_POST['br'];
$en = $_POST['en'];
$d = date('Y-m-d');
$result = mysqli_query($con, "
SELECT 
    b.id,
    b.Name,
    b.Status,

    (SELECT COALESCE(COUNT(*), 0)
     FROM repayments r
     WHERE r.Branch = b.Name
       AND r.Status != 'Cancelled') AS `cont`,

    (SELECT COALESCE(SUM(u.Sale_Target), 0)
     FROM users u
     WHERE u.Branch = b.Name) AS `target`,

    (SELECT COALESCE(SUM(r.Loan_Amount), 0)
     FROM repayments r
     WHERE r.Branch = b.Name
       AND r.Status != 'Cancelled') AS `act`,

    (SELECT COALESCE(SUM(r.Interest_Amt), 0)
     FROM repayments r
     WHERE r.Branch = b.Name
       AND r.Status != 'Cancelled') AS `tb`

FROM branch b
ORDER BY b.Name ASC
") or die("Bad Query.");

mysqli_close($con);

$results = array();
while($row = mysqli_fetch_assoc($result))
{
    $results[] = $row; 
}
$fp = fopen('../data/all_performance.json', 'w'); 
fwrite($fp, json_encode($results)); 
fclose($fp);
//echo json_encode($results);
?>
<div class="table-responsive" style="overflow: auto; height:300px;">
<table >
<thead>
<tr style="font-size:9px;">
<th scope="col">BRANCH ID</th>
<th scope="col">BRANCH</th>
<th scope="col">PRINCIPAL AMOUNT</th>
<th scope="col">TOTAL INTEREST</th>
<th scope="col">TOTAL TARGET</th>
<th scope="col">TARGET OUTSTANDING</th>
<th scope="col">NO OF CLIENTS</th>
</tr>
<tbody>
<?php
$url = '../data/all_performance.json';
$data = file_get_contents($url);
$json = json_decode($data);
foreach($json as $member){
?>
<tr>
<td class="sort border-top"><?php echo $member->id?></td>
<td class="sort border-top" style="text-transform:uppercase"><?php echo $member->Name?></td>
<td class="sort border-top"><?php echo number_format($member->act,2)?></td>
<td class="sort border-top"><?php echo number_format($member->tb,2)?></td>
<td class="sort border-top"><?php echo number_format($member->target,2)?></td>
<td class="sort border-top"><?php echo number_format($member->target - $member->act,2)?></td>
<td class="sort border-top"><?php echo $member->cont?></td>

</tr>
<?php
}
?>
</tbody>
</table>


<?php
}else{
?>


<div class="row" style="font-size:10px">
<div class="col-sm-4">
<b>Branch: <?php
if($br == 'All'){
echo "All";
}else{
include '../config/db.php';
$Query = "SELECT Name FROM branch WHERE id ='$br'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$brn = $row['Name'];
echo $brn; 
}
?> </b>
</div>
<div class="col-sm-4">
<b>Total Principal Amt: 
<?php 
include_once '../config/db.php';
$d = date('Y-m-d');
$sql = "SELECT SUM(Loan_Amount) AS lm FROM repayments WHERE Status != 'Cancelled' AND Branch_id = '$br'";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$lm = $data['lm'];
echo number_format($lm,2);
?>
</b>
</div>
<div class="col-sm-4">
<b>Total Interest Amt:
<?php 
include_once '../config/db.php';
$d = date('Y-m-d');
$sql = "SELECT SUM(Interest_Amt) AS lm FROM repayments WHERE Status != 'Cancelled'  AND Branch_id = '$br'";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$lm = $data['lm'];
echo number_format($lm,2);
?>
</b>
</div>
</div>
<br>
<button type="button" class="btn btn-info btn-sm btn-flat" onclick="tableToCSV()">Download Data</button>
<script type="text/javascript">
function tableToCSV() {
// Variable to store the final csv data
let csv_data = [];
// Get each row data
let rows = document.getElementsByTagName('tr');
for (let i = 0; i < rows.length; i++) {
// Get each column data
let cols = rows[i].querySelectorAll('td,th');
// Stores each csv row data
let csvrow = [];
for (let j = 0; j < cols.length; j++) {
// Get the text data of each cell
// of a row and push it to csvrow
csvrow.push(cols[j].innerHTML);
}
// Combine each column value with comma
csv_data.push(csvrow.join(","));
}
// Combine each row data with new line character
csv_data = csv_data.join('\n');
// Call this function to download csv file  
downloadCSVFile(csv_data);
}
function downloadCSVFile(csv_data) {
// Create CSV file object and feed
// our csv_data into it
CSVFile = new Blob([csv_data], {
type: "text/csv"
});
// Create to temporary link to initiate
// download process
let temp_link = document.createElement('a');
// Download csv file
temp_link.download = "Branch_Performance_Report.csv";
let url = window.URL.createObjectURL(CSVFile);
temp_link.href = url;
// This link should not be displayed
temp_link.style.display = "none";
document.body.appendChild(temp_link);
// Automatically click the link to
// trigger download
temp_link.click();
document.body.removeChild(temp_link);
}
</script>
<br><br>
<span>Total Count:  
<?php 
include_once '../config/db.php';
$d = date('Y-m-d');
$sql = "SELECT COUNT(*) AS lm FROM branch WHERE Status = 'Activate' AND id = '$br'";
$result=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($result);
$lm = $data['lm'];
echo $lm;
?>
</span>
<br><br>

<?php
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Origin: *");
include '../config/db.php';
$st = $_POST['st'];
$br = $_POST['br'];
$en = $_POST['en'];
$d = date('Y-m-d');
$result = mysqli_query($con, "
SELECT 
    b.id,
    b.Name,
    b.Status,

    (SELECT COALESCE(COUNT(*), 0)
     FROM repayments r
     WHERE r.Branch = b.Name
       AND r.Status != 'Cancelled' AND Branch_id='$br') AS `cont`,

    (SELECT COALESCE(SUM(u.Sale_Target), 0)
     FROM users u
     WHERE u.Branch = b.Name AND Branch_id='$br') AS `target`,

    (SELECT COALESCE(SUM(r.Loan_Amount), 0)
     FROM repayments r
     WHERE r.Branch = b.Name
       AND r.Status != 'Cancelled' AND Branch_id='$br') AS `act`,

    (SELECT COALESCE(SUM(r.Interest_Amt), 0)
     FROM repayments r
     WHERE r.Branch = b.Name
       AND r.Status != 'Cancelled' AND Branch_id='$br') AS `tb`

FROM branch b WHERE id='$br'
ORDER BY b.Name ASC
") or die("Bad Query.");

mysqli_close($con);

$results = array();
while($row = mysqli_fetch_assoc($result))
{
    $results[] = $row; 
}
$fp = fopen('../data/all_performance.json', 'w'); 
fwrite($fp, json_encode($results)); 
fclose($fp);
//echo json_encode($results);
?>
<div class="table-responsive" style="overflow: auto; height:300px;">
<table >
<thead>
<tr style="font-size:9px;">
<th scope="col">BRANCH ID</th>
<th scope="col">BRANCH</th>
<th scope="col">PRINCIPAL AMOUNT</th>
<th scope="col">TOTAL INTEREST</th>
<th scope="col">TOTAL TARGET</th>
<th scope="col">TARGET OUTSTANDING</th>
<th scope="col">NO OF CLIENTS</th>
</tr>
<tbody>
<?php
$url = '../data/all_performance.json';
$data = file_get_contents($url);
$json = json_decode($data);
foreach($json as $member){
?>
<tr>
<td class="sort border-top"><?php echo $member->id?></td>
<td class="sort border-top" style="text-transform:uppercase"><?php echo $member->Name?></td>
<td class="sort border-top"><?php echo number_format($member->act,2)?></td>
<td class="sort border-top"><?php echo number_format($member->tb,2)?></td>
<td class="sort border-top"><?php echo number_format($member->target,2)?></td>
<td class="sort border-top"><?php echo number_format($member->target - $member->act,2)?></td>
<td class="sort border-top"><?php echo $member->cont?></td>

</tr>
<?php
}
?>
</tbody>
</table>


<?php
}
?>

</div>
</div>
