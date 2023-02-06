<?php
include_once "includes/database.php";
include_once "includes/user.php";

$success = false;

if (!isset($rqd)) {
    $alert_msg = "Something went wrong!";
} else if (sizeof($rqd) < 3 || strlen($rqd[1]) != 64) {
    $alert_msg = "Not a valid verification request!";
} else {
    try {
        $token = $rqd[1];
        $email = base64_decode($rqd[2]);
    
        $db = new VerifyDB();
        $user_id = $db->verifyVerificationToken($token, $email);
    
        if ($user_id == null) {
            $alert_msg = "Invalid verification request!";
        } else {
            $db->deleteVerifyTokens($user_id);
            $db->userEmailVerified($user_id);
            $success = true;
            $alert_msg = "Email verified successfully!";
        }
        
    } catch (Exception $e) {
        $alert_msg = "Something went wrong!";
    }
}
?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-8 mt-3">
            <div class="alert alert-<?php echo $success ? "success" : "danger" ?> alert-dismissible fade show" role="alert">
                <?php echo $alert_msg ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    </div>
</div>


