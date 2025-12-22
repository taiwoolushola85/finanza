<?php 
$bvn = $_GET['bvn'];
?>
<style>
.bvn-wrapper {
    max-width: 900px;
    margin: auto;
    font-family: Arial, Helvetica, sans-serif;
    border: 1px solid #ccc;
    background: #fff;
}

/* HEADER */
.bvn-header {
    display: flex;
    align-items: center;
    gap: 10px;
    border-bottom: 2px solid #999;
    padding: 10px;
}

.header-text {
    flex: 1;
    text-align: center;
    font-size: 14px;
}

/* BODY */
.bvn-body {
    display: flex;
    padding: 15px;
    gap: 15px;
}

.photo-box {
    width: 260px;
    border-right: 1px solid #ccc;
}

.photo-box img {
    width: 100%;
    border: 1px solid #ccc;
}

.info-box {
    flex: 1;
}

.info-title {
    text-align: center;
    font-weight: bold;
    border-bottom: 1px solid #ccc;
    margin-bottom: 8px;
    padding-bottom: 4px;
}

/* TABLE */
.info-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 13px;
}

.info-table td {
    border-bottom: 1px solid #ccc;
    padding: 6px;
}

.info-table td:first-child {
    width: 170px;
    font-weight: bold;
    background: #f7f7f7;
}

/* 🔥 MOBILE VIEW */
@media (max-width: 768px) {

    .bvn-header {
        flex-direction: column;
        text-align: center;
    }

    .bvn-body {
        flex-direction: column;
    }

    .photo-box {
        width: 100%;
        border-right: none;
        text-align: center;
    }

    .photo-box img {
        max-width: 220px;
    }

    .info-table td {
        font-size: 14px;
    }
}

/* EXTRA SMALL SCREENS */
@media (max-width: 480px) {

    .info-table td:first-child {
        width: 140px;
        font-size: 12px;
    }

    .header-text {
        font-size: 13px;
    }
}


</style>

<div class="bvn-wrapper" id="viewPage" style="display:none">

<!-- HEADER -->
<div class="bvn-header" style="color:black;">
<div class="header-text">
<b>The Bank Verification Number has successfully been verified.</b>
</div>
</div>
<!-- BODY -->
<div class="bvn-body">
<!-- PHOTO -->
<div class="photo-box">
<center>
<br>
<br>
<br>
<br>
<img id="userPhoto" src="" alt="User Photo" style="height:200px; width:200px; border-radius:100px">
</center>
</div>
<!-- DETAILS -->
<div class="info-box" style="color:black">
<div class="info-title">Personal Information</div>
<table>
<tr><td>BVN</td><td id="bvnData"></td></tr>
<tr><td>NIN</td><td id="nin"></td></tr>
<tr><td>First Name</td><td id="firstName"></td></tr>
<tr><td>Last Name</td><td id="lastName"></td></tr>
<tr><td>Middle Name</td><td id="middleName"></td></tr>
<tr><td>Phone</td><td id="phones"></td></tr>
<tr><td>Email</td><td id="email"></td></tr>
<tr><td>Date of Birth</td><td id="dateOfBirth"></td></tr>
<tr><td>Gender</td><td id="gender"></td></tr>
<tr><td>Enrollment Bank</td><td id="enrollmentBank"></td></tr>
<tr><td>Enrollment Branch</td><td id="enrollmentBranch"></td></tr>
<tr><td>Registration Date</td><td id="registrationDate"></td></tr>
<tr><td>Address</td><td id="residentialAddress"></td></tr>
</table>
</div>
</div>
</div>



<script>
$(document).ready(function() {
$('#viewPage').hide();
const bvn = $('#bvn').val().trim();
// Validate BVN
if (bvn.length !== 11 || !/^\d+$/.test(bvn)) {
alert('Please enter a valid 11-digit BVN number');
return;
}
// Show loader and disable button
$('#submitBtn').prop('disabled', true).text('Verifying...');
$('#loaders').show();
// Make API call
$.ajax({
url: 'https://api.creditchek.africa/v1/identity/verifyData?bvn=' + <?php echo $bvn; ?>,
type: 'POST',
headers: {
'token': '5Gy5jXFNPWLnBnVeGDxylnL5oqorcdC+nVrCZI31Kxt1z2DFqN4sCUvnuN0hBX8h',
'Content-Type': 'application/json'
},
data: JSON.stringify({
bvn: bvn
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
$("#loaders").hide();
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
alert("BVN Verification Successfull.");
$("#updateModal").modal('show');
$("#loaders").hide();
// Set status badge
$('#statusBadge').removeClass('error').addClass('success').text('Verified');
// Set photo and name
$('#userPhoto').attr('src', data.photo || 'https://via.placeholder.com/150');
$('#fullName').text(data.nameOnCard || `${data.firstName} ${data.middleName} ${data.lastName}`);
// Populate table
$('#bvnData').text(data.bvn || 'N/A');
$('#firstName').text(data.firstName || 'N/A');
$('#middleName').text(data.middleName || 'N/A');
$('#lastName').text(data.lastName || 'N/A');
$('#dateOfBirth').text(data.dateOfBirth || 'N/A');
$('#gender').text(data.gender || 'N/A');
$('#maritalStatus').text(data.maritalStatus || 'N/A');
$('#nationality').text(data.nationality || 'N/A');
$('#nin').text(data.nin || 'N/A');
// Handle phone numbers array
const phones = data.phones ? data.phones.filter(p => p).join(', ') : 'N/A';
$('#phones').text(phones);
$('#email').text(data.email || 'N/A');
$('#residentialAddress').text(data.residentialAddress || 'N/A');
$('#stateOfResidence').text(data.stateOfResidence || 'N/A');
$('#lgaOfResidence').text(data.lgaOfResidence || 'N/A');
$('#stateOfOrigin').text(data.stateOfOrigin || 'N/A');
$('#lgaOfOrigin').text(data.lgaOfOrigin || 'N/A');
$('#enrollmentBank').text(data.enrollmentBank || 'N/A');
$('#enrollmentBranch').text(data.enrollmentBranch || 'N/A');
$('#levelOfAccount').text(data.levelOfAccount || 'N/A');
// Handle watch listed status
const watchListed = data.watchListed || 'NO';
const watchClass = watchListed.toUpperCase() === 'NO' ? 'watchlist-no' : 'watchlist-yes';
$('#watchListed').html(`<span class="${watchClass}">${watchListed}</span>`);
// Show success result
$('#successResult').show();
$('#errorResult').hide();
$('#resultSection').slideDown();
$('#bvn').val();
}
function displayErrorResult(message) {
alert('Verification Error: ' + message);
$('#statusBadge').removeClass('success').addClass('error').text('Failed');
$('#errorMessage').text(message);
$('#successResult').hide();
$('#errorResult').show();
$('#resultSection').slideDown();
}
</script>
