<?php

//Creates or resumes a session via cookies
session_start();

//Destroy all session data
session_destroy();

//Redirect to index.php page
header("Location: index.php");
exit;