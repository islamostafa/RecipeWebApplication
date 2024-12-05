<?php

//Variable to check login validity within HTML below
$valid_login = true;

//Checks if login form has been submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    //Makes this script require the database_connect script. Ensures a connection with the database.
    $sql_var = require __DIR__ . "/database_connect.php";

    //MySQL query.
    //real_escape_string prevents SQL injection attacks.
    $sql = sprintf("SELECT * FROM user WHERE email = '%s'", $sql_var->real_escape_string($_POST["email"]));

    //Stores SQL query result as a variable
    $sql_result = $sql_var->query($sql);

    //Stores result as an array
    $email_data = $sql_result->fetch_assoc();

    //Checks if $email_data array contains data, meaning the email exists in the database
    if ($email_data) {
        //Checks if the password given matches the password stored in the database
        if (password_verify($_POST["password"], $email_data["hash_password"])) {

            //Creates or resumes a session via cookies
            session_start();

            //Stores the user's id in the global session
            $_SESSION["user_id"] = $email_data["id"];

            //redirects to the index.php page and stops this script
            header("Location: index.php");
            exit;
        }
    }
    //If the code reaches this point, the details entered are not valid, so the $valid_login variable becomes false
    $valid_login = false;

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./global.css">
    <title>Login</title>
</head>

<body>
    
    <section class="Login">
        <h1>Login</h1>
        <!--Checks the $valid_login variable to see if the login details are correct-->
        <?php if (! $valid_login): ?>
            <p>Login invalid</p>
        <?php endif; ?>

        <form method="post">

            <!--Area to input email address-->
            <div>
                <label for="email">Email address</label>
                <!--value section keeps user's email displayed after an invalid login attempt-->
                <input type="email" class="email" name="email" value="<?= htmlspecialchars($_POST["email"] ?? "") ?>">
            </div>

            <!--Area to input password-->
            <div>
                <label for="password">Password</label>
                <input type="password" class="password" name="password">
            </div>

            <!--Login button-->
            <button>Log in</button>
        
        </form>
    </section>
</body>
</html>