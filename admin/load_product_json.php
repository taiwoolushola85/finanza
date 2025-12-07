
<?php
// Sanitize and validate inputs
$search = isset($_POST['search']) ? trim($_POST['search']) : '';
$maxRows = isset($_POST['maxRows']) ? (int)$_POST['maxRows'] : 0;

// Set CORS headers at the top
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Origin: *");

include '../config/db.php';
include '../config/user_session.php';

// Escape user input for SQL
$search_escaped = mysqli_real_escape_string($con, $search);

// Build query based on conditions
$whereClause = "";
if (!empty($search)) {
$whereClause = "WHERE Product LIKE '%$search_escaped%'";
}

// Count query (without LIMIT - LIMIT doesn't apply to COUNT)
$countQuery = "SELECT COUNT(*) FROM product_list $whereClause";
$countResult = mysqli_query($con, $countQuery);
$row = mysqli_fetch_array($countResult);
$total = $row[0];

// Data query
$dataQuery = "SELECT id, Product, Tenure, Frequency, Inssurance, Rate
              FROM product_list
              $whereClause 
              ORDER BY Product ASC";

if ($maxRows > 0) {
    $dataQuery .= " LIMIT $maxRows";
} elseif (empty($search) && $maxRows == 0) {
    $dataQuery .= " LIMIT 10";
}

$result = mysqli_query($con, $dataQuery) or die("Database query failed: " . mysqli_error($con));

// Fetch results
$results = array();
while($row = mysqli_fetch_assoc($result)) {
    $results[] = $row; 
}

// Save to JSON file
$fp = fopen('../data/product_list.json', 'w'); 
fwrite($fp, json_encode($results)); 
fclose($fp);

mysqli_close($con);
?>

<small>
Total Record: <?php echo $total; ?>
</small>
<br><br>

<div class="table-container" style="height:200px;">
<table>
<thead>
<tr>
<th style="font-size:8px">ID</th>
<th style="font-size:8px">PRODUCT</th>
<th style="font-size:8px">TENURE</th>
<th style="font-size:8px">FREQUENCY</th>
<th style="font-size:8px">INSURANCE</th>
<th style="font-size:8px">INTEREST RATE</th>
<th style="font-size:8px">STATUS</th>
<th style="font-size:8px">EDIT</th>
<th style="font-size:8px">DELETE</th>
</tr>
</thead>
<tbody>
<?php
foreach($results as $member) {
// Escape output for XSS protection
$id = (int)$member['id'];
$productName = htmlspecialchars($member['Product']);
$tenure = htmlspecialchars($member['Tenure']);
$frequency = htmlspecialchars($member['Frequency']);
$insurance = htmlspecialchars($member['Inssurance']);
$rate = htmlspecialchars($member['Rate']);
?>
<tr style="font-size:8px">
<td><?php echo $id; ?></td>
<td style="text-transform:capitalize"><?php echo $productName; ?></td>
<td><?php echo $tenure; ?></td>
<td><?php echo $frequency; ?></td>
<td><?php echo $insurance; ?> %</td>
<td><?php echo $rate; ?> %</td>
<td><?php echo "Active"; ?></td>
<td>
<a href="#!" class="invks" data-id="<?php echo $id; ?>">
<i class="fa fa-edit"></i> Edit
</a>
</td>
<td>
<a href="#" class="indel" data-id="<?php echo $id; ?>" style="color:red;">
<i class="fa fa-trash"></i> Remove
</a>
</td>
</tr>
<?php
}
?>
</tbody>
</table>
</div>

<script>
// Load product data into modal for editing
$(document).ready(function() {
$('.invks').on('click', function(e) {e.preventDefault();
var id = $(this).data('id');
if(id) {
$.ajax({
url: 'edit_product_json.php',
type: "POST",
data: {'id': id},
dataType: "json",
success: function(data) { 
$('#stid').val(data.productId);
$('#stno').val(data.productNo);
$('#name').val(data.productName);
$('#in').val(data.productIns);
$('#tenure').val(data.productTenure);
$('#rate').val(data.productRate);
$('#frequency').val(data.productFrequency);
},
error: function(xhr, status, error) {
alert('Error loading product data: ' + error);
}
});
} else {
alert('Invalid product ID');
}
});
});

// Delete product with confirmation
$(document).ready(function() {
$('.indel').on('click', function(e) {e.preventDefault();
var WRN_PROFILE_DELETE = "You are about to remove this product from the database..";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
$("#tst1").css("display", "block");
$("#productModal").modal('hide');
$("#please").show();
var id = $(this).data('id');
if(id) {
$.ajax({
url: 'product_delete_json.php',
type: "POST",
data: {'id': id},
dataType: "json",
success: function(data) { 
setTimeout(function() {
$("#please").hide();
$("#toast1").show();
$('#product').load('product.php #product');// to reload zone without refreshing the page
loadup();
}, 3000);
setTimeout(function() {
$("#toast1").hide();
$("#productModal").modal('hide');
}, 6000);
},
error: function(xhr, status, error) {
$("#please").hide();
alert('Error deleting product: ' + error);
}
});
} else {
$("#please").hide();
alert('Invalid product ID');
}
}
});
});

// Reload product list
function loadup() {
$.ajax({
method: "POST",
url: "load_product_json.php",
dataType: "html",
success: function(data) {
setTimeout(function() {
$('#result').html(data);
}, 1000);
},
error: function(xhr, status, error) {
console.error('Error reloading products: ' + error);
}
});
}

// Update product form submission
$(document).ready(function(e) {
$("#uploadForm").on('submit', function(e) { e.preventDefault();
$("#productModal").modal('hide');
$("#please").show();
$.ajax({
url: "update_product_json.php",
type: "POST",
data: new FormData(this),
contentType: false, 
cache: false, 
processData: false,
success: function(data) { 
if(data == 1) {
setTimeout(function() {
$("#please").hide();
$("#productModal").modal('show');
$("#uploadForm")[0].reset();
$("#updatep").show();
loadup();
}, 3000);
setTimeout(function() {
$("#updatep").hide();
}, 7000);
} else {
$("#please").hide();
alert('Update failed: ' + data);
}
},
error: function(xhr, status, error) {
$("#please").hide();
alert('Error updating product: ' + error);
}
});
});
});
</script>