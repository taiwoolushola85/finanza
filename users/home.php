<?php include "head.php"; ?>

<?php

// displaying dashboard base on user role



if($gr == 'Loan Officers'){// loan officer dashboard
include 'loan_officer_dashboard.php';
}else if($gr == 'Team Leaders'){// team leader dashboard
include 'team_lead_dashboard.php';
}else if($gr == 'Credit Analyst'){ // verification officer dashboard


}else if($gr == 'HR'){//  Human Resources dashboard


}else if($gr == 'Underwriters'){



}else if($gr == 'Operations'){



}else if($gr == 'Portfolio Manager'){




}else if($gr == 'Recovery Officer'){




}else if($gr == 'Head Of Recovery'){



}else if($gr == 'Customer Service'){



}else{



}


?>


<?php include "../footer.php"; ?>



