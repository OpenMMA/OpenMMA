<?php
include_once "includes/user.php";
if (User::AuthUser(0) == null)
    header("location: /");

/* Destroy the session */
if (session_status() === PHP_SESSION_NONE) 
    session_start();
$_SESSION = array();
session_destroy();
?>
You were logged succesfully logged out.<br>
You will now be redirected back to the home page.<br>
<a href="/">Home</a>
<script>
    setTimeout(function() {
        window.location.href = "/";
    }, 3000);
</script>