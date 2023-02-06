<?php
include_once "includes/user.php";
include_once "includes/database.php";

$username = "";
$loginError = "";
/* Process login form if it was submitted */
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    /* Get the user from the database */
    $db = new UserDB();
    $user = $db->getUser($username);

    /* Check if the user exists and if the password is correct */
    if ($user && $user->checkPassword($password)) {
        /* Password is correct, start a new session and redirect to the user page */
        $_SESSION['user'] = $user;

        /* Get redirect url or default and redirect */
        $redirect_url = $_GET['redirect'] ?? "account";
        header("Location: $redirect_url");
        exit();
    } else {
        /* Username or password is incorrect, show an error message */
        $loginError = "Incorrect username or password.";
    }
}
?>
<?php if ($loginError != ""): ?>
<div class="alert alert-danger" role="alert"><?php echo $loginError; ?></div>
<?php endif; ?>

<form action="<?php echo htmlspecialchars("login"
                         . (isset($_GET['redirect']) ? "?redirect=" . urlencode($_GET['redirect']) : "")); ?>"
      method="post" autocomplete="off">
    <div class="mb-3">
        <label for="username" class="form-label">Username or email:</label>
        <input type="text" class="form-control" id="username" name="username" value="<?php echo $username; ?>" required>
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Password:</label>
        <input type="password" class="form-control" id="password" name="password" required>
    </div>

    <button type="submit" class="btn btn-primary">Login</button>
</form>
<a href="forgot_password">Forgot password?</a><br>
<a href="register">Register</a>