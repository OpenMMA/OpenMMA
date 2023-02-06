<?php
/* Check if user is already logged in */
$user = User::authUser(0);
if ($user && $user->privilege_level >= 1) {
    /* User is already logged in, redirect to the user page */
    if (isset($_GET['redirect']))
        header("Location: " . $_GET['redirect']);
    else
        header("Location: profile");
    exit();
}
?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-4 mt-3 p-4 border border-secondary-subtle rounded shadowed" style="background-color: #fbfbfb;"> 
            <h1 class="pb-3">Login</h1>
            <?php require "templates/login.php" ?>
        </div>
    </div>
</div>