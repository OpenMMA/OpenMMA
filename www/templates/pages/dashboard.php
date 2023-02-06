<?php
include_once "includes/user.php";
include_once "includes/database.php";

/* Check if user is already logged in */
$user = User::authUser(0);
if (!$user || $user->privilege_level < 1) {
    /* User is already logged in, redirect to the user page */
    header("Location: login?redirect=dashboard");
    exit();
}
?>
<link href="/css/dashboard.css" rel="stylesheet">
<div class="container mt-3 p-4 rounded shadowed" style="background-color: white;">
    <div class="row justify-content-center">
        <div class="col-2 p-0">
            <ul class="nav nav-tabs flex-column pt-2 pb-4 ms-5" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="dashboard-tab-1" data-bs-toggle="tab" data-bs-target="#dashboard-pane-1" type="button" role="tab">Active</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="dashboard-tab-2" data-bs-toggle="tab" data-bs-target="#dashboard-pane-2" type="button" role="tab">Link</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="dashboard-tab-3" data-bs-toggle="tab" data-bs-target="#dashboard-pane-3" type="button" role="tab">Link</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="dashboard-tab-4" data-bs-toggle="tab" data-bs-target="#dashboard-pane-4" type="button" role="tab">Disabled</button>
                </li>
            </ul>
        </div>
        <div class="col-10 tab-content">
            <div class="tab-pane fade show active" id="dashboard-pane-1" role="tabpanel" aria-labelledby="dashboard-tab-1" tabindex="0">One</div>
            <div class="tab-pane fade" id="dashboard-pane-2" role="tabpanel" aria-labelledby="dashboard-tab-2" tabindex="0">Two</div>
            <div class="tab-pane fade" id="dashboard-pane-3" role="tabpanel" aria-labelledby="dashboard-tab-3" tabindex="0">Three</div>
            <div class="tab-pane fade" id="dashboard-pane-4" role="tabpanel" aria-labelledby="dashboard-tab-4" tabindex="0">Four</div>
        </div>
    </div>
</div>