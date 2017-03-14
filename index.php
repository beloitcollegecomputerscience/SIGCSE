<?php

/*
There's an oddity with the placement of this echo. As is, it prevents include from loading. When placed right under the require for include, it works fine.
*/

// Access to global variables
require_once('global/include.php');
//echo (SYSTEM_WEB_BASE_ADDRESS.'user/index.php');

// Queries the database to see if login lock is on
$query = "SELECT locked FROM system_locks WHERE name = 'can_login'";
$result = $db->query($query);
$row = $result->fetch_assoc();

// This edits the header! Something here is causing issues displaying when the echo isn't present
// Header cannot be used after require code if require code changes output (look into)

if ($row['locked'] != 't') {
    header('Location: '.SYSTEM_WEB_BASE_ADDRESS.'user/index.php');
    exit;
}

// Include the head for every page
require_once(SYSTEM_WEBHOME_DIR.'/user/php/head.php');

if (session_status() === PHP_SESSION_ACTIVE) {
    echo ("<body> <div style=\"margin-top: 50px;\" class=\"container\">
        <div class=\"jumbotron col-lg-6 col-lg-offset-3\">
            <p class=\"text-center\">
                <i class=\"fa fa-exclamation fa-5x\"></i>
            </p>
            <h2>SIGCSE Volunteer Registration</h2>
            <p class=\"lead\">We\'ll be back shortly. Website is undergoing
                maintence.</p>
        </div>

    </div>

</body>
</html>");
}


?>