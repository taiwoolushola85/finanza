<?php include "head.php"; ?>

<?php

// displaying dashboard base on user role
if($gr == 'Loan Officers'){// loan officer dashboard
include 'loan_officer_dashboard.php';
}else if($gr == 'Team Leaders'){// team leader dashboard
include 'team_lead_dashboard.php';
}else if($gr == 'Credit Analyst'){ // verification officer dashboard
include 'verification_dashboard.php';
}else{
include 'general_dashboard.php';
}
?>


<?php include "../footer.php"; ?>



