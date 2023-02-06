<?php
include_once "includes/user.php";
include_once "includes/database.php";
include_once "includes/mailer.php";

/* Check if user is already logged in */
$user = User::authUser(0);
if ($user && $user->privilege_level >= 1) {
    /* User is already logged in, redirect to the user page */
    header("Location: https://".$_SERVER['SERVER_NAME']."/account");
    exit();
}

$username = $password = $email = $first_name = $last_name = "";
$registerError = "";
/* Process registration form if it was submitted */
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $email = trim($_POST['email']);
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);

    /* Check if input is valid */
    if (strlen($username) > 32 || strlen($email) > 128 ||
        strlen($first_name) > 256 || strlen($last_name) > 256) {
        /* Input is too long */
        $registerError = "Input is too long.";
    } else if ($username == "" || $first_name == "" || $last_name == "") {
        /* Input is empty */
        $registerError = "Input cannot be empty.";
    } else if (strlen($password) < 8) {
        /* Password is too short */
        $registerError = "Password must be at least 8 characters long.";
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        /* Email is invalid */
        $registerError = "Invalid email address.";
    } else {
        /* Hash the password */
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        /* Create new user and log it in if no exception is thrown */
        try {
            $db = new RegisterDB();
            $new_user = $db->createUser($username, $password_hash, $email, $first_name, $last_name);
            $_SESSION['user'] = $new_user;

            echo "A\n";
            $verify_link = "https://".$_SERVER['SERVER_NAME']."/verify/".$db->createVerifyToken($new_user->id)."/".base64_encode($email);
            echo "B\n";
            $mailer = new Mailer();
            echo "C\n";
            $mailer->sendMail($email, "Email verification", "Dear $first_name $last_name,\n\nPlease verify your email address using the following link:\n$verify_link\n");

            header("Location: /account");
            exit();
        } catch (usernameAlreadyExistsException $e) {
            $registerError = "Username already exists.";
        } catch (emailAlreadyExistsException $e) {
            $registerError = "Email already in use.";
        }
    }
}
?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-4 mt-3 p-4 border bg-body-secondary border-secondary-subtle rounded" style="box-shadow: 0px 0px 12px -6px rgba(0,0,0,0.75);"> 
            <h1>Register</h1>
            <?php if ($registerError != ""): ?>
            <div class="alert alert-danger" role="alert"><?php echo $registerError; ?></div>
            <?php endif; ?>
            <form action="/register" method="post" autocomplete="off">
                <div class="mb-3">
                    <label for="username" class="form-label">Username:</label>
                    <input type="text" class="form-control" id="username" name="username" value="<?php echo $username; ?>" maxlength="32" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password:</label>
                    <input type="password" class="form-control" id="password" name="password" value="<?php echo $password; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo $email; ?>" maxlength="128" required>
                </div>
                <div class="mb-3">
                    <label for="first_name" class="form-label">First Name:</label>
                    <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo $first_name; ?>" maxlength="256" required>
                </div>
                <div class="mb-3">
                    <label for="last_name" class="form-label">First Name:</label>
                    <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo $last_name; ?>" maxlength="256" required>
                </div>
                <button type="submit" class="btn btn-primary">Register</button>
            </form>
        </div>
    </div>
</div>
