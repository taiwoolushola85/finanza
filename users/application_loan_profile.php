<?php 
include '../config/db.php';
$reg_id = $_GET['id']; // reg id
// 
$Query = "SELECT * FROM register WHERE id = '$reg_id'";
$result = mysqli_query($con, $Query);
$row = mysqli_fetch_array($result);
$regid = $row['id'];
$reg_status = $row['Status'];
// gaurantor info
$Query = "SELECT * FROM gaurantors WHERE Regis_id = '$reg_id'";
$result = mysqli_query($con, $Query);
$rows = mysqli_fetch_array($result);
$id = $rows['id'];
//remark
$Query = "SELECT * FROM comment WHERE Reg_No = '$reg_id'";
$result = mysqli_query($con, $Query);
$remarks = mysqli_fetch_array($result);

?>
<center>
<div id="image">
<img src="<?php echo $row['Location']; ?>" height="100" width="100" style="border-radius:50px">
</div>
<br>
[ Virtual Acct: <?php echo $row['Virtual_Account']; ?> ]
<br><br>
<div style="overflow-x: auto;">
<div class="btn-group" style="margin: auto;">
<button class="btn btn-light" onclick="clientInfo()"><i class="fa fa-user"></i> Client Details</button>
<?php 
if($reg_status == 'Declined'){
?>
<a class="resubmit" href="#!" id="<?php echo $regid; ?>"><button class="btn btn-light"><i class="fa fa-file"></i> Re-Submit Application</button></a>
<?php
}else{
?>

<?php 
}
?>
<button class="btn btn-light" onclick="updateInfo()"><i class="fa fa-edit"></i> Update Info</button>
<button class="btn btn-light" onclick="updateDoc()"><i class="fa fa-folder"></i> Document Uploading</button>
<button class="btn btn-light" onclick="uploadImage()"><i class="fa fa-upload"></i> Upload Image</button>
<button class="btn btn-light" onclick="uploadProduct()"><i class="fa fa-star"></i> Change Product</button>
</div>
</div>
</center>


<div id="firsts" style="display:block;">

<div id="mydiv">
<div class="row">
<div class="col-sm-6">
<br><br>
<b><i class="fa fa-star"></i> CLIENT INFO</b>
<br><br>
<div class="card border-primary border border-dashed">
<br>
<div class="row">
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Name:</b> <?php echo $row['Firstname']." ". $row['Middlename']." ".$row['Lastname']; ?></span>
</div>
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Phone:</b> <?php echo $row['Phone']; ?></span>
</div>
</div>


<div class="row">
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Gender:</b> <?php echo $row['Gender']; ?></span>
</div>
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Branch:</b> <?php echo $row['Branch']; ?></span>
</div>
</div>

<div class="row" >
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Marriage Status:</b> <?php echo $row['Maritial_Status']; ?></span>
</div>
<div class="col-sm-6">
<span style="margin-left:8px;"><b> Client BVN:</b> <?php echo $row['BVN']; ?></span>
</div>
</div>


<div class="row">
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Education:</b> <?php echo $row['Education']; ?></span>
</div>
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Document:</b> <?php echo $row['Document']; ?></span>
</div>
</div>


<div class="row">
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Document No:</b> <?php echo $row['Document_No']; ?></span>
</div>
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Registration ID:</b> <?php echo $row['id']; ?></span>
</div>
</div>


<div class="row">
<div class="col-sm-12">
<span style="margin-left:8px;"><b>Address:</b> <?php echo $row['Address']; ?></span>
</div>
</div>
<br>
</div>

</div>
<div class="col-sm-6">
<br><br>
<b><i class="fa fa-star"></i> GAURANTOR INFO</b>
<br><br>
<div class="card border-primary border border-dashed">
<br>
<div class="row">
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Name:</b> <?php echo $rows['Firstname']." ".$rows['Middlename']." ".$rows['Lastname']; ?></span>
</div>
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Phone:</b>  <?php echo $rows['Phone']; ?></span>
</div>
</div>




<div class="row">
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Relationship:</b>  <?php echo $rows['Relationship']; ?></span>
</div>
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Gender:</b> <?php echo $rows['Gender']; ?></span>
</div>
</div>


<div class="row">
<div class="col-sm-6">
<span style="margin-left:8px;"><b>BVN/NIN:</b>  <?php echo $rows['Gaurantor_BVN']; ?></span>
</div>
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Occupation:</b>  <?php echo $rows['Occupation']; ?></span>
</div>
</div>

<div class="row">
<div class="col-sm-6">
<span style="margin-left:8px;"><b>ID No:</b> <?php echo $rows['ID_No']; ?></span>
</div>
<div class="col-sm-6">
<span style="margin-left:8px;"><b>ID Type:</b>   <?php echo $rows['ID_Type']; ?></span>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Gaurantor ID:</b>  <?php echo $rows['id']; ?></span>
</div>
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Reg ID:</b>  <?php echo $row['id']; ?></span>
</div>
</div>

<div class="row">
<div class="col-sm-12">
<span style="margin-left:8px;"><b>Address:</b> <?php echo $rows['Address']; ?></span>
</div>
</div>
<br>

</div>

</div>
</div>



<?php 
if($reg_status == "Under Review"){

}else{
?>
<div id="prlist">
<div class="row">
<div class="col-sm-6">

<div class="card border-primary border border-dashed">
<br>
<div class="row">
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Principal Amt:</b> <?php echo number_format($row['Loan_Amount'],2); ?></span>
</div>
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Interest  Amt:</b> <?php echo number_format($row['Interest_Amt'],2); ?></span>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Repayment Amt:</b> <?php echo number_format($row['Repayment_Amt'],2); ?></span>
</div>
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Total Loan:</b> <?php echo number_format($row['Total_Loan'],2); ?></span>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Bank:</b> <?php echo $row['Bank']; ?></span>
</div>
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Account Name:</b> <?php echo $row['Account_Name']; ?></span>
</div>
</div>
<div class="row">
<div class="col-sm-12">
<span style="margin-left:8px;"><b>Account No:</b> <?php echo $row['Account_No']; ?></span>
</div>
</div>
<br>
</div>
</div>
<div class="col-sm-6">

<div class="card border-primary border border-dashed">
<br>
<div class="row">
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Product:</b> <?php echo $row['Product']; ?></span>
</div>
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Frequency:</b> <?php echo $row['Frequency']; ?></span>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Tenure:</b> <?php echo $row['Tenure']; ?></span>
</div>
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Rate:</b> <?php echo $row['Rate']; ?></span>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Product ID:</b> <?php echo $row['Product_id']; ?></span>
</div>
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Status:</b> <?php echo $row['Status']; ?></span>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Loan Officer:</b> <?php echo $row['Officer_Name']; ?></span>
</div>
<div class="col-sm-6">
<span style="margin-left:8px;"><b>Team Leader:</b> <?php echo $row['Team_Name']; ?></span>
</div>
</div>
<br>
</div>

</div>
</div>
<?php
}
?>
</div>


</div>
</div>

<br>

<div id="seconds" style="display:none;">


<div  id="first">
<div>
<div >
<div class="container">
<br>
<i><b style="color:red">Note:</b> All fields in red border are required</i><br><br>

<form action="" method="POST" enctype="multipart/form-data" id="updateForm">
<b><i class="fa fa-star"></i> Personal Information</b><br>
<div class="row" style="margin-top: 20px;">
<div class="col-sm-6">
<label style="font-size:13px"><i style="color:red">*</i> Address</label>
<input type="text" class="form-control form-control-sm" placeholder="Address" name="id" hidden required value="<?php echo htmlspecialchars($row['id']); ?>">
<input type="text" class="form-control form-control-sm" placeholder="Address" name="ad" required required value="<?php echo htmlspecialchars($row['Address']); ?>">
</div>
<div class="col-sm-6">
<label style="font-size:13px"><i style="color:red">*</i> Education Level</label>
<select class="form-control form-control-sm" value="<?php echo htmlspecialchars($row['Education']); ?>" required  name="ed">
<option value="<?php echo htmlspecialchars($row['Education']); ?>"><?php echo htmlspecialchars($row['Education']); ?></option>
<option value="Primary School">Primary School</option>
<option value="Secondary School">Secondary School</option>
<option value="Tertiary School">Tertiary School</option>
<option value="No Education">No Education</option>
</select>
</div>
</div>
<br>
<b><i class="fa fa-star"></i> Means Of Identification</b><br>
<div class="row" style="margin-top: 20px;">
<div class="col-sm-4">
<label style="font-size:13px"><i style="color:red">*</i> Document Type</label>
<select type="text" class="form-control form-control-sm" name="doc" value="<?php echo htmlspecialchars($row['Document']); ?>" required>
<option value="<?php echo htmlspecialchars($row['Document']); ?>"><?php echo htmlspecialchars($row['Document']); ?></option>
<option value="National ID Card">National ID Card</option>
<option value="Voter Card">Voters Card</option>
<option value="International Passport">International Passport</option>
<option value="Driver License">Driver's License</option>
<option value="Membership Card">Membership Card</option>
<option value="Other">Other</option>
</select>
</div>
<div class="col-sm-4">
<label style="font-size:13px"><i style="color:red">*</i> Document No</label>
<input type="text" class="form-control form-control-sm" placeholder="Document No" name="docn" required value="<?php echo htmlspecialchars($row['Document_No']); ?>">
</div>
<div class="col-sm-4">
<label style="font-size:13px"><i style="color:red">*</i> Repayment Day</label>
<select class="form-control form-control-sm"  name="repday" required>
<option value="<?php echo htmlspecialchars($row['Repayment_Day']); ?>"><?php echo htmlspecialchars($row['Repayment_Day']); ?></option>
<option value="Mon">Monday</option>
<option value="Tue">Tuesday</option>
<option value="Wed">Wednesday</option>
<option value="Thu">Thursday</option>
<option value="Fri">Friday</option>
<option value="Daily">Everyday</option>
</select>
</div>
</div>
<br>
<b><i class="fa fa-star"></i> Contact Information</b><br>
<div class="row" style="margin-top: 20px;">
<div class="col-sm-4">
<label style="font-size:13px"><i style="color:red">*</i> State Of Origin</label>
<input type="text" class="form-control form-control-sm" value="<?php echo htmlspecialchars($row['State']); ?>" required  name="sta"  placeholder="State Of Origin">
</div>
<div class="col-sm-4">
<label style="font-size:13px"><i style="color:red">*</i> Town/City</label>
<input type="text" class="form-control form-control-sm" placeholder="Town/City" name="cit" required value="<?php echo htmlspecialchars($row['Town']); ?>">
</div>
<div class="col-sm-4">
<label style="font-size:13px"><i style="color:red">*</i> Maritial Status</label>
<select class="form-control form-control-sm"  name="ms" required value="<?php echo htmlspecialchars($row['Maritial_Status']); ?>">
<option value="<?php echo htmlspecialchars($row['Maritial_Status']); ?>"><?php echo htmlspecialchars($row['Maritial_Status']); ?></option>
<option value="Single">Single</option>
<option value="Married">Married</option>
<option value="Divorce">Divorce</option>
<option value="Widow">Widow</option>
</select>
</div>
</div>
<br>
<b><i class="fa fa-star"></i> Business Information</b><br>
<div class="row" style="margin-top:20px;">
<div class="col-sm-4">
<label style="font-size:13px"><i style="color:red">*</i> Business Name</label>
<input type="text" class="form-control form-control-sm" placeholder="Business Name" required name="bsn" value="<?php echo htmlspecialchars($row['Business']); ?>" >
</div>
<div class="col-sm-4">
<label style="font-size:13px"><i style="color:red">*</i> Business Type</label>
<input type="text" class="form-control form-control-sm" placeholder="Business Type" required name="bt" value="<?php echo htmlspecialchars($row['Biz_Type']); ?>">
</div>
<div class="col-sm-4">
<label style="font-size:13px"><i style="color:red">*</i> State</label>
<input type="text" class="form-control form-control-sm" name="st2" required placeholder="State Of Origin" value="<?php echo htmlspecialchars($row['Biz_State']); ?>">
</div>
</div>
<div class="row" style="margin-top:20px;">
<div class="col-sm-6">
<label style="font-size:13px"><i style="color:red">*</i> Start Date</label>
<input type="Date" class="form-control form-control-sm" name="sd" required value="<?php echo htmlspecialchars($row['Start_Date']); ?>">
</div>
<div class="col-sm-6">
<label style="font-size:13px"><i style="color:red">*</i> Address</label>
<input type="text" class="form-control form-control-sm" placeholder="Address" required name="ad2" value="<?php echo htmlspecialchars($row['Biz_Address']); ?>" >
</div>
</div>
<div class="row" style="margin-top:20px;">
<div class="col-sm-6">
<label style="font-size:13px"><i style="color:red">*</i> Business Owner Name</label>
<input type="text" class="form-control form-control-sm" placeholder="Business Owner Name" required name="owner" value="<?php echo htmlspecialchars($row['Biz_Owner']); ?>">
</div>
<div class="col-sm-6">
<label style="font-size:13px"><i style="color:red">*</i> Shop Ownership</label>
<select type="text" class="form-control form-control-sm" name="sh" value="<?php echo htmlspecialchars($row['Shop_Owner']); ?>" required>
<option value="<?php echo htmlspecialchars($row['Shop_Owner']); ?>"><?php echo htmlspecialchars($row['Shop_Owner']); ?></option>
<option value="Rented">Rented</option>
<option value="Owned">Owned</option>
<option value="Leased">Leased</option>
<option value="No Shop">No Shop</option>
</select>
</div>
</div>
<br>
<b><i class="fa fa-star"></i> Gaurantor Information</b><br>
<div class="row" style="margin-top:20px;">
<div class="col-sm-4">
<label style="font-size:13px"><i style="color:red">*</i> Address</label>
<input type="text" class="form-control form-control-sm" placeholder="Address" name="address3" required value="<?php echo htmlspecialchars($rows['Address']); ?>">
</div>
<div class="col-sm-4">
<label style="font-size:13px"><i style="color:red">*</i> Occupation</label>
<input type="text" class="form-control form-control-sm" placeholder="Occupation" name="occupation" required value="<?php echo htmlspecialchars($rows['Occupation']); ?>">
</div>
<div class="col-sm-4">
<label style="font-size:13px"><i style="color:red">*</i> Relationship</label>
<select class="form-control form-control-sm" name="relationship" value="<?php echo htmlspecialchars($rows['Relationship']); ?>" required>
<option value="<?php echo htmlspecialchars($rows['Relationship']); ?>"><?php echo htmlspecialchars($rows['Relationship']); ?></option>
<option value="Sister">Sister</option>
<option value="Brother">Brother</option>
<option value="Spouse">Spouse</option>
<option value="Father">Father</option>
<option value="Mother">Mother</option>
<option value="Daughter">Daughter</option>
<option value="Friend">Friend</option>
<option value="In-Law">In-Law</option>
<option value="Nephew">Nephew</option>
<option value="Niece">Niece</option>
<option value="Husband">Husband</option>
<option value="Wife">Wife</option>
<option value="Neighbor">Neighbor</option>
<option value="Other">Other</option>
</select>
</div>
</div>
<div class="row" style="margin-top:20px;">
<div class="col-sm-6">
<label style="font-size:13px"><i style="color:red">*</i> ID Type</label>
<select type="text" class="form-control form-control-sm" name="idtype" value="<?php echo htmlspecialchars($rows['ID_Type']); ?>" required>
<option value="<?php echo htmlspecialchars($rows['ID_Type']); ?>"><?php echo htmlspecialchars($rows['ID_Type']); ?></option>
<option value="National ID Card">National ID Card</option>
<option value="Voter Card">Voters Card</option>
<option value="International Passport">International Passport</option>
<option value="Driver License">Driver's License</option>
<option value="Membership Card">Membership Card</option>
<option value="Other">Other</option>
</select>
</div>
<div class="col-sm-6">
<label style="font-size:13px"><i style="color:red">*</i> ID Card No</label>
<input type="text" class="form-control form-control-sm" placeholder="ID Number" required name="idno" value="<?php echo htmlspecialchars($rows['ID_No']); ?>">
</div>
</div>
<div class="row" style="margin-top:20px;">
<div class="col-sm-12">
<label style="font-size:13px"><i style="color:red">*</i> Remark/Comment</label>
<textarea class="form-control form-control-sm" name="remark" cols="6" rows="6" required><?php echo htmlspecialchars($remarks['Comment']); ?></textarea>
</div>
</div>


<br>
<button type="submit" class="btn btn-outline-success btn-sm"  style="float:right; "><i class="fa fa-edit"></i> Update Record</button>
</form>

</div>
</div>
</div>
</div>


</div>

<div id="forths" style="display:none;">
<b>Document Uploading</b>
<center>
<p><img src="" id="doc" style="height: 250px; width:450px; border-radius:50px;" class="img-thumbnail" /></p>
</center>
<form action="" method="POST" id="uploadDoc" enctype="multipart/form-data">
<div>
<div class="col-sm-4" style="margin: auto;">
<label style="font-size:13px"><i style="color:red">*</i> Document Type</label>
<select class="form-control form-control-sm" name="doc"  required>
<option value="">Select Option</option>
<option value="Loan Form">Loan Form</option>
<option value="Utility Bill">Utility Bill</option>
<option value="ID Card">ID Card</option>
<option value="KYC Form">KYC Form</option>
<option value="Other Document">Other Document</option>
</select>
<input type="text" hidden class="form-control form-control-sm" name="id" placeholder="" value="<?php echo $reg_id; ?>"><br>
<input type="file" class="form-control form-control-sm" name="Pic" required="required" onchange="loadDocument(event)"><br><br>
<button type="submit" class="btn btn-outline-primary btn-sm btn-block" id="saveimg" onclick="data()">Upload Document</button>
</form>
</div>
</div>



</div>

<div id="product" style="display:none;">
<br>
<b><h5>Change Product</h5></b>
<br><br>
<form action="" method="POST" enctype="multipart/form-data" id="productUpdate">
<b>Loan Product Information</b><br><br>
<div class="row">
<div class="col-sm-6">
<input type="text" hidden="hidden" class="form-control form-control-sm" name="id" placeholder="id" required="required" value="<?php echo $reg_id ; ?>">
<label style="font-size:13px"><i style="color:red">*</i> Loan Products</label><br>
<select type="text" class="form-control form-control-md" name="pr" required = "required">
<option value="">Select Loan Product</option>
<?php 
include '../config/db.php';
$Query = "SELECT id, Product_Name FROM product WHERE Status = 'Activated' ORDER BY id ASC";
$result = mysqli_query($con, $Query);
$Count = mysqli_num_rows($result);
if ($Count > 0) {
for ($j=0 ; $j < $Count; $j++){
$rows = mysqli_fetch_array($result);
$pp= $rows['id']; // product id
$name= $rows['Product_Name'];
?>
<option value="<?php echo $pp; ?>"><?php echo $name; ?></option>
<?php
}
}
?>
</select>
</div>
<div class="col-sm-6">
<label style="font-size:13px"><i style="color:red">*</i> Principal Amount</label>
<input type="number" class="form-control form-control-md" placeholder="Principal Amount" hidden name="lum" required = "required" value="<?php echo $row['Loan_Amount']; ?>">
<input type="number" class="form-control form-control-md" placeholder="Principal Amount" disabled required = "required" value="<?php echo $row['Loan_Amount']; ?>">
</div>
</div>
<br>
<div class="row">
<div class="col-sm-3">
<button type="submit" class="btn btn-outline-primary btn-sm"  onclick="data()" id="cli">Change Product</button>
</form>
</div>
<div class="col-sm-4">
<i style="display:none;" id="update"><img src="../loader/loader.gif" style="height:18px"> Updating Product ! Please wait...</i>
<i class="fa fa-check" style="color:green; display:none" id="done"> Loan Product Updated. Please confirm the update</i>
</div>
</div>
<hr>






</div>



<div id="thirds" style="display:none;">
<div class="row">
<div class="col-sm-4">
<form action="" method="POST" id="imageupload" enctype="multipart/form-data">
<center>
<p><img src="<?php echo $row['Location']; ?>" id="client" style="height: 250px; width:250px; border-radius:50px;" class="img-thumbnail" /></p>
</center>
<input type="text" hidden class="form-control form-control-sm" name="id" placeholder="" value="<?php echo $reg_id; ?>"><br>
<input type="file" class="form-control form-control-sm" name="Pic" required="required" onchange="loadClient(event)"><br><br>
<button type="submit" class="btn btn-outline-primary btn-sm btn-block" id="saveimg" onclick="data()">Upload Client Image</button>
</form>
</div>
<div class="col-sm-4">
<form action="" method="POST" enctype="multipart/form-data" id="guarantorupload">
<center>
<p><img id="ga" src="<?php echo $rows['Location']; ?>" style="height: 250px; width:250px; border-radius:50px;"  class="img-thumbnail"/></p>
</center>
<input type="text"  hidden = "hidden" class="form-control form-control-sm" name="id" placeholder="" value="<?php echo $reg_id; ?>">
<br>
<input type="file" name="Pics" class="form-control form-control-sm" required="required" onchange="loadGuarantor(event)"><br><br>
<button type="submit" class="btn btn-outline-primary btn-sm btn-block" id="card"  onclick="data()">Upload Gaurantor Image</button>
</form>
</div>
<div class="col-sm-4">
<form action="" method="POST" enctype="multipart/form-data" id="cardupload">
<center>
<p><img id="idcd" src="<?php echo $rows['ID_Image']; ?>" style="height: 250px; width:250px; border-radius:50px;"  class="img-thumbnail"/></p>
</center>
<input type="text"  hidden = "hidden" class="form-control form-control-sm" name="id" placeholder="" value="<?php echo $reg_id; ?>">
<br>
<input type="file" class="form-control form-control-sm" name="Pic" required="required" onchange="loadCard(event)"><br><br>
<button type="submit" class="btn btn-outline-primary btn-sm btn-block" id="card"  onclick="data()">Upload ID Card Image</button>
</form>
</div>
</div>

</div>
<script>
var loadCard = function(event) {
var image = document.getElementById('idcd');
image.src = URL.createObjectURL(event.target.files[0]);
};

var loadGuarantor= function(event) {
var image = document.getElementById('ga');
image.src = URL.createObjectURL(event.target.files[0]);
};

var loadDocument = function(event) {
var image = document.getElementById('doc');
image.src = URL.createObjectURL(event.target.files[0]);
};

var loadClient = function(event) {
var image = document.getElementById('client');
image.src = URL.createObjectURL(event.target.files[0]);
};
</script>

<script>
function clientInfo(){
var x = document.getElementById("firsts");
var y = document.getElementById("seconds");
var z = document.getElementById("thirds");
var a = document.getElementById("forths");
var b = document.getElementById("product");
x.style.display = 'block';
y.style.display = 'none';
z.style.display = 'none';
a.style.display = 'none';
b.style.display = 'none';
}
function updateInfo(){
var x = document.getElementById("firsts");
var y = document.getElementById("seconds");
var z = document.getElementById("thirds");
var a = document.getElementById("forths");
var b = document.getElementById("product");
x.style.display = 'none';
a.style.display = 'none';
b.style.display = 'none';
z.style.display = 'none';
y.style.display = 'block';
}
function updateDoc(){
var x = document.getElementById("firsts");
var y = document.getElementById("seconds");
var z = document.getElementById("thirds");
var a = document.getElementById("forths");
var b = document.getElementById("product");
x.style.display = 'none';
b.style.display = 'none';
z.style.display = 'none';
y.style.display = 'none';
a.style.display = 'block';
}
function uploadImage(){
var x = document.getElementById("firsts");
var y = document.getElementById("seconds");
var z = document.getElementById("thirds");
var a = document.getElementById("forths");
var b = document.getElementById("product");
z.style.display = 'block';
x.style.display = 'none';
a.style.display = 'none';
y.style.display = 'none';
b.style.display = 'none';
}
function uploadProduct(){
var x = document.getElementById("firsts");
var y = document.getElementById("seconds");
var z = document.getElementById("thirds");
var a = document.getElementById("forths");
var b = document.getElementById("product");
b.style.display = 'block';
z.style.display = 'none';
x.style.display = 'none';
a.style.display = 'none';
y.style.display = 'none';
}
</script>



<script>
var loadFile = function(event) {
var image = document.getElementById('output');
image.src = URL.createObjectURL(event.target.files[0]);
};
var loads = function(event) {
var image = document.getElementById('outputs');
image.src = URL.createObjectURL(event.target.files[0]);
};
function datas(){
var x = document.getElementById("first");
var y = document.getElementById("second");
x.style.display = 'none';
y.style.display = 'block';
}

function bck(){
var x = document.getElementById("first");
var y = document.getElementById("second");
x.style.display = 'block';
y.style.display = 'none';
}

function sec(){
var x = document.getElementById("second");
var y = document.getElementById("third");
x.style.display = 'none';
y.style.display = 'block';
}

function bcks(){
var x = document.getElementById("second");
var y = document.getElementById("third");
x.style.display = 'block';
y.style.display = 'none';
}
</script>


<script>
// to show data on a modal box
$(document).ready(function() {
$('.resubmit').on('click', function() {
WRN_PROFILE_DELETE = "You are about to resubmit this loan application..";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
var id = $(this).attr('id');
if(id) {
$("#updateModal").modal('hide');
$("#please").show();
$.ajax({
url: 'resubmit_application.php?id' + id,
type: "GET",
data: {'id':id},
success:function(data) { 
if(data == 1){
setTimeout(function(){
$("#please").hide();
$("#toasts").show();
load();
}, 4000);
setTimeout(function(){
$("#please").hide();
$("#toasts").hide();
}, 6000);
}else{
alert (data);
}
}
});
}else{
alert (data);
}
}
});
});
</script>



<script type="text/javascript">
$(document).ready(function (e){
$("#updateForm").on('submit',(function(e){ e.preventDefault();
WRN_PROFILE_DELETE = "You are about to update this client record ..";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
$("#updateModal").modal('hide');
$("#please").show();
$.ajax({
url: "update_record_bck.php",
type: "POST",
data: new FormData(this),
contentType: false, 
cache: false, 
processData:false,
success: function(data){
$("#please").show();
$("#updateForm")[0].reset();
if(data == 1){
setTimeout(function(){
$("#please").hide();
$("#toast").css("display", "block");
$("#toast").show();
}, 3000);
setTimeout(function(){
$("#please").hide();
$("#toast").hide();
}, 6000);
}else{
$("#please").hide();
alert ("🚫" + data)
}
},
error: function(){
}
});
}
}));
});
</script>




<script type="text/javascript">
$(document).ready(function (e){
$("#imageupload").on('submit',(function(e){ e.preventDefault();
WRN_PROFILE_DELETE = "You are about to upload this client image ..";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
$("#updateModal").modal('hide');
$("#please").show();
$.ajax({
url: "update_image_bck.php",
type: "POST",
data: new FormData(this),
contentType: false, 
cache: false, 
processData:false,
success: function(data){
$("#please").show();
if(data == 1){
setTimeout(function(){
$("#please").hide();
$("#toat").css("display", "block");
$("#toat").show();
}, 3000);
setTimeout(function(){
$("#updateModal").modal('show');
$( "#image" ).load( "application_loan_profile.php?id=<?php echo $reg_id; ?> #image" );// reloading table
$("#please").hide();
$("#toat").hide();
}, 6000);
}else{
$("#please").hide();
alert ("🚫" + data)
}
},
error: function(){
}
});
}
}));
});
</script>






<script type="text/javascript">
$(document).ready(function (e){
$("#guarantorupload").on('submit',(function(e){ e.preventDefault();
WRN_PROFILE_DELETE = "You are about to upload this client image ..";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
$("#updateModal").modal('hide');
$("#please").show();
$.ajax({
url: "guarantor_image_upload_bck.php",
type: "POST",
data: new FormData(this),
contentType: false, 
cache: false, 
processData:false,
success: function(data){
$("#please").show();
if(data == 1){
setTimeout(function(){
$("#please").hide();
$("#toat").css("display", "block");
$("#toat").show();
}, 3000);
setTimeout(function(){
$("#updateModal").modal('show');
$( "#image" ).load( "application_loan_profile.php?id=<?php echo $reg_id; ?> #image" );// reloading table
$("#please").hide();
$("#toat").hide();
}, 6000);
}else{
$("#please").hide();
alert ("🚫" + data)
}
},
error: function(){
}
});
}
}));
});
</script>




<script type="text/javascript">
$(document).ready(function (e){
$("#cardupload").on('submit',(function(e){ e.preventDefault();
WRN_PROFILE_DELETE = "You are about to upload this client image ..";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
$("#updateModal").modal('hide');
$("#please").show();
$.ajax({
url: "id_image_upload_bck.php",
type: "POST",
data: new FormData(this),
contentType: false, 
cache: false, 
processData:false,
success: function(data){
$("#please").show();
if(data == 1){
setTimeout(function(){
$("#please").hide();
$("#toat").css("display", "block");
$("#toat").show();
}, 3000);
setTimeout(function(){
$("#updateModal").modal('show');
$( "#image" ).load( "application_loan_profile.php?id=<?php echo $reg_id; ?> #image" );// reloading table
$("#please").hide();
$("#toat").hide();
}, 6000);
}else{
$("#please").hide();
alert ("🚫" + data)
}
},
error: function(){
}
});
}
}));
});
</script>


<script type="text/javascript">
$(document).ready(function (e){
$("#uploadDoc").on('submit',(function(e){ e.preventDefault();
WRN_PROFILE_DELETE = "You are about to upload this client document ..";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
$("#updateModal").modal('hide');
$("#please").show();
$.ajax({
url: "document_upload_bck.php",
type: "POST",
data: new FormData(this),
contentType: false, 
cache: false, 
processData:false,
success: function(data){
$("#uploadDoc")[0].reset();
$("#please").show();
if(data == 1){
setTimeout(function(){
$("#please").hide();
$("#docu").css("display", "block");
$("#docu").show();
}, 3000);
setTimeout(function(){
$("#updateModal").modal('show');
$("#please").hide();
$("#docu").hide();
}, 6000);
}else{
$("#please").hide();
alert ("🚫" + data)
}
},
error: function(){
}
});
}
}));
});
</script>




<script type="text/javascript">
$(document).ready(function (e){
$("#productUpdate").on('submit',(function(e){ e.preventDefault();
WRN_PROFILE_DELETE = "You are about to change this loan product..!! ?";
var checked = confirm(WRN_PROFILE_DELETE);
if(checked == true) {
$("#update").show();
$.ajax({
type: "POST",
url: "change_product.php",
data: new FormData(this),
contentType: false, 
cache: false, 
processData:false,
success: function(data){
if(data == 1){
setTimeout(function(){
$("#update").hide();
$("#done").show();
$( "#prlist" ).load( "application_loan_profile.php?id=<?php echo $reg_id; ?> #prlist" );// reloading table
}, 3000);
setTimeout(function(){
$("#update").hide();
$("#done").hide();
}, 6000);
}else{
$("#update").hide();
alert(data);
}
},
error: function(){
}
});
}
}));
});
</script>
