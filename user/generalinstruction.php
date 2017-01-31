<!-- Copyright (C) 2017  Beloit College

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program (License.txt).  If not, see <http://www.gnu.org/licenses/>. -->

<?php
// The global include file
require_once ('../global/include.php');

// Function to create an instruction.
require_once (SYSTEM_WEBHOME_DIR . 'user/php/assemble.php');
// Check if user is logged in.  Either student or admin is ok.
if (!$isLoggedIn && ! $isAdmin) {
    header ( 'Location: ' . SYSTEM_WEB_BASE_ADDRESS . 'index.php' );
}

// TODO fix so reads which number from DB as top/bottom.
$instruction = processInstruction ( $db, getInstruction ( $db, -3 ), -99, -99, false );
echo $instruction;
?>
