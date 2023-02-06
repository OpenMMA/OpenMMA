<?php require_once "includes/user.php"; ?>
<nav class="navbar bg-body-tertiary fixed-top">
    <div class="container">
        <a class="navbar-brand" href="/">
            <img src="/eureka_logo.png" alt="SV Eureka" height="62">
        </a>
        <?php if (User::AuthUser(0)): ?>
        <p class="fs-5 ms-auto me-3 mb-1">
            <?php echo $_SESSION['user']->first_name . " " . $_SESSION['user']->last_name ?>
        </p>
        <div class="dropdown">
            <a href="#" class="dropdown-toggle text-decoration-none text-black" data-bs-toggle="dropdown">
                <img class="account-dropdown" src="/harold.png">
            </a>
            <ul class="dropdown-menu dropdown-menu-end mt-2" role="menu">
                <li><a class="dropdown-item" href="#">Account</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="/logout">Logout</a></li>
            </ul>
        </div>
        <?php else: ?>
        <div>
            <a href="register" class="btn btn-secondary m-1" role="button">Register</a>
            <a href="login" class="btn btn-primary m-1" role="button">Login</a>
        </div>
        <?php endif; ?>
    </div>
</nav>
<div class="padder p-5"></div>