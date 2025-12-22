<?php 
$nin = $_GET['nin'];
?>
<input hidden id="nin" value="<?php echo $nin; ?>">
<style>
.nin-slip {
    max-width: 900px;
    margin: auto;
    border: 1px solid #000;
    font-family: Arial, Helvetica, sans-serif;
    background: #fff;
    font-size: 13px;
}

.nin-header {
    display: flex;
    justify-content: space-between;
    border-bottom: 2px solid #000;
    padding: 10px;
    text-align: center;
}

.nimc-logo {
    font-weight: bold;
    font-size: 20px;
}

.nin-body {
    display: flex;
    padding: 10px;
    gap: 15px;
}

.nin-table {
    width: 65%;
    border-collapse: collapse;
}

.nin-table td {
    border: 1px solid #000;
    padding: 5px;
}

.nin-table td:first-child {
    font-weight: bold;
    width: 160px;
}

.nin-photo {
    width: 35%;
    text-align: center;
}

.nin-photo img {
    width: 180px;
    border: 1px solid #000;
}

.nin-status {
    margin-top: 10px;
}

.nin-footer {
    border-top: 1px solid #000;
    padding: 8px;
    text-align: center;
}

/* 📱 MOBILE RESPONSIVE */
@media (max-width: 768px) {
    .nin-body {
        flex-direction: column;
    }
    .nin-table, .nin-photo {
        width: 100%;
    }
}


</style>

<div class="nin-slip" id="viewPage" style="display:none">

    <!-- HEADER -->
    <div class="nin-header" style="color:black;">
        <div>
            <b>NATIONAL IDENTITY MANAGEMENT SYSTEM</b><br>
            <small>Federal Republic of Nigeria</small><br>
            <small><b>National Identification Number Slip (NINS)</b></small>
        </div>
        <div class="nimc-logo">NIMC</div>
    </div>

    <!-- BODY -->
    <div class="nin-body">

        <!-- LEFT INFO -->
        <table class="nin-table">
            <tr><td>NIN</td><td id="nins"></td></tr>
            <tr><td>Surname</td><td id="lastName"></td></tr>
            <tr><td>First Name</td><td id="firstName"></td></tr>
            <tr><td>Middle Name</td><td id="middleName"></td></tr>
            <tr><td>Gender</td><td id="gender"></td></tr>
            <tr><td>Date of Birth</td><td id="dateOfBirth"></td></tr>
            <tr><td>Phone</td><td id="phones"></td></tr>
            <tr><td>Email</td><td id="email"></td></tr>
            <tr><td>Birth State</td><td id="birthstate"></td></tr>
            <tr><td>Birth Country</td><td id="nationality"></td></tr>
            <tr><td>Address</td><td id="residenceAddress"></td></tr>
            <tr><td>Residence LGA</td><td id="lgaOfResidence"></td></tr>
            <tr><td>Residence State</td><td id="stateOfResidence"></td></tr>
        </table>

        <!-- PHOTO -->
        <div class="nin-photo">
            <img id="userPhoto" src="">
            <div class="nin-status">
                Status: <span id="status" style="color:green;font-weight:bold"></span>
            </div>
        </div>

    </div>

    <!-- FOOTER -->
    <div class="nin-footer" style="color:black;">
        <small>
            Note: The National Identification Number (NIN) is your identity.  
            It is confidential and should only be released for legitimate transactions.
        </small>
    </div>

</div>


<script>
$(document).ready(function() {
$('#viewPage').hide();
const nin = $('#nin').val().trim();
// Validate BVN
if (nin.length !== 11 || !/^\d+$/.test(nin)) {
alert('Please enter a valid 11-digit NIN number');
return;
}
// Show loader and disable button
$('#submitBtn').prop('disabled', true).text('Verifying...');
$('#loaders').show();
// Make API call
$.ajax({
url: 'https://api.creditchek.africa/v1/identity/verifyData?nin=' + <?php echo $nin; ?>,
type: 'POST',
headers: {
'token': '5Gy5jXFNPWLnBnVeGDxylnL5oqorcdC+nVrCZI31Kxt1z2DFqN4sCUvnuN0hBX8h',
'Content-Type': 'application/json'
},
data: JSON.stringify({
nin: nin
}),
success: function(response) {
if (response.status && response.data) {
displaySuccessResult(response.data);
} else {
displayErrorResult(response.message || 'Verification failed');
}
},
error: function(xhr, status, error) {
let errorMsg = 'An error occurred during verification';
try {
const errorResponse = JSON.parse(xhr.responseText);
errorMsg = errorResponse.message || errorMsg;
} catch(e) {
errorMsg = `Status: ${xhr.status} - ${error}`;
}
displayErrorResult(errorMsg);
},
complete: function() {
$('#submitBtn').prop('disabled', false).text('Verify BVN');
$('#loaders').hide();
$('#viewPage').show();
}
});
});
function displaySuccessResult(data) {
alert("NIN Verification Successfull.");
$("#updateModal").modal('show');
// Helper function to display value or N/A
const displayValue = (value) => value || 'N/A';
// Populate profile section
$('#userPhoto').attr('src', data.photo || 'https://via.placeholder.com/230');
$('#fullName').text(`${displayValue(data.firstname)} ${displayValue(data.surname)}`);
$('#statusBadge').text(data.verification?.status || 'VERIFIED');
// Populate personal information (Left card)
$('#gender').text(data.gender === 'm' ? 'MALE' : data.gender === 'f' ? 'FEMALE' : displayValue(data.gender));
$('#dateOfBirth').text(displayValue(data.birthdate));
$('#maritalStatus').text(displayValue(data.maritalstatus));
$('#nationality').text(displayValue(data.birthcountry));
$('#phones').text(displayValue(data.telephoneno));
$('#height').text(data.heigth ? `${data.heigth} cm` : 'N/A');
$('#centralId').text(displayValue(data.centralID));
$('#educationLevel').text(displayValue(data.educationallevel));
// Populate location information (Right card)
$('#lgaOfResidence').text(displayValue(data.residence_lga));
$('#stateOfResidence').text(displayValue(data.residence_state));
$('#stateOfOrigin').text(displayValue(data.self_origin_state));
$('#lgaOfOrigin').text(displayValue(data.self_origin_lga));
$('#language').text(displayValue(data.ospokenlang));
$('#religion').text(displayValue(data.religion));
$('#email').text(displayValue(data.email));
$('#nins').text(displayValue(data.nin));
$('#birthstate').text(displayValue(data.birthstate) || 'NA');
$('#status').text(data.verification?.status || 'VERIFIED');
// Show success message
}
function displayErrorResult(message) {
alert('Verification Error: ' + message);
// Clear photo on error
$('#userPhoto').attr('src', 'https://via.placeholder.com/230');
$('#fullName').text('N/A');
$('#statusBadge').text('FAILED').css('color', 'red');
}

</script>
