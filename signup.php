<?php

//Check that a name is entered
if (empty($_POST["name"])) {
    die("name requrired");
}

//Checks that the email is a valid email format
if ( ! filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
    die("Email must be valid");
}

//Checks that a password has been entered and that it is at least 6 characters long
if (strlen($_POST["password"]) < 6) {
    die("Password must be 6 characters or more");
}

//Checks that both entered passwords match
if ($_POST["password"] !== $_POST["confirm_password"]) {
    die("Passwords do not match");
}

//Creates a hash of the submitted password
$hashed_password = password_hash($_POST["password"], PASSWORD_DEFAULT);

//Makes this script require the database_connect script. Ensures a connection with the database.
$sql_var = require __DIR__ . "/database_connect.php";

//MySQL statement for inserting user info into the database
$sql_statement = "INSERT INTO user (name, email, hash_password) VALUES (?,?,?)";

//Initialing SQL statement
$prepared_statement = $sql_var->stmt_init();

//Preparing SQL statement for execution
$prepared_statement->prepare($sql_statement);

//Binding values to placehoders in $sql_statement
$prepared_statement->bind_param("sss", $_POST["name"], $_POST["email"], $hashed_password);


//Inserts the values into the database.
//Checks if the email is already registered -----------------------> this does not work - fatal error if email already registered.
if ($prepared_statement->execute()) {
    
    //Redirects once completed
    header("Location: successful_signup.php");
    exit;

} else {
    echo "Email already registered";
}


