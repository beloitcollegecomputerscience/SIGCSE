<!-- Licensed under the BSD. See License.txt for full text.  -->

<?php
// The global include file
require_once ('../global/include.php');

// Function to create an instruction.
require_once (SYSTEM_WEBHOME_DIR . '/user/php/assemble.php');
// Check if user is logged in.  Either student or admin is ok.
if (!$isLoggedIn && ! $isAdmin) {
    header ( 'Location: ' . SYSTEM_WEB_BASE_ADDRESS . 'index.php' );
}

// TODO fix so reads which number from DB as top/bottom.
$instruction = processInstruction ( $db, getInstruction ( $db, -3 ), -99, -99, false );
echo $instruction;
?>
