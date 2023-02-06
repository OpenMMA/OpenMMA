<?php
    // Start session if it does not exist yet
    // if (session_status() === PHP_SESSION_NONE) 
    //     session_start();

    // Convert URL path to list
    $rqd = explode('/', isset($_GET['rqd']) ? $_GET['rqd'] : "");
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>OpenCDX - Eureka</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
        <link href="/css/style.css" rel="stylesheet">
    </head>
    <body class="bg-body vh-100">
        <?php include("templates/header.php"); ?>
        <?php
            // Retrieve template page based on first URL path element
            if ($rqd[0] == "" || $rqd[0] == "#")
                include("templates/pages/home.php");
            elseif (file_exists("templates/pages/" . $rqd[0] . ".php"))
                include("templates/pages/" . $rqd[0] . ".php");
            else
                include("templates/pages/404.php");            
        ?>
        <?php include("templates/footer.php"); ?>
    </body>
</html>