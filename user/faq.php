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

<!DOCTYPE html>
<html lang="en">

<?php

// Access to global variables
require_once('../global/include.php');

// Include the head for every page
require_once(SYSTEM_WEBHOME_DIR.'user/php/head.php');
?>

<body>

    <?php require(SYSTEM_WEBHOME_DIR."user/php/nav.php"); echoNav($system_text, $db, $isLoggedIn, $isAdmin, "faq"); ?>

    <div style="" class="container">

        <div class="row col-lg-10 col-lg-offset-1">


            <h2 style="margin-top: 0px;" class="text-center"><?php echo $system_text["user_faq"]["title"]; ?></h2>

            <p style="font-size: 18px;" class="lead">
                <?php echo $system_text["user_faq"]["description"]; ?>
            </p>

            <ul>

                <li>
                    <div>
                        <h4 style="margin-bottom: 0px;"><?php echo $system_text["user_faq"]["question_1"]; ?></h4>
                        <p style="font-size: 18px; margin-left: 20px" class="lead"><?php echo $system_text["user_faq"]["answer_1"]; ?></p>
                    </div>
                </li>

                <li>
                    <div>
                        <h4 style="margin-bottom: 0px;"><?php echo $system_text["user_faq"]["question_2"]; ?></h4>
                        <p style="font-size: 18px; margin-left: 20px" class="lead"><?php echo $system_text["user_faq"]["answer_2"]; ?></p>
                    </div>
                </li>

                <li>
                    <div>
                        <h4 style="margin-bottom: 0px;"><?php echo $system_text["user_faq"]["question_3"]; ?></h4>
                        <p style="font-size: 18px; margin-left: 20px" class="lead"><?php echo $system_text["user_faq"]["answer_3"]; ?></p>
                    </div>
                </li>

                <li>
                    <div>
                        <h4 style="margin-bottom: 0px;"><?php echo $system_text["user_faq"]["question_4"]; ?></h4>
                        <p style="font-size: 18px; margin-left: 20px" class="lead"><?php echo $system_text["user_faq"]["answer_4"]; ?></p>
                    </div>
                </li>

                <li>
                    <div>
                        <h4 style="margin-bottom: 0px;"><?php echo $system_text["user_faq"]["question_5"]; ?></h4>
                        <p style="font-size: 18px; margin-left: 20px" class="lead"><?php echo $system_text["user_faq"]["answer_5"]; ?></p>
                    </div>
                </li>

                <li>
                    <div>
                        <h4 style="margin-bottom: 0px;"><?php echo $system_text["user_faq"]["question_6"]; ?></h4>
                        <p style="font-size: 18px; margin-left: 20px" class="lead"><?php echo $system_text["user_faq"]["answer_6"]; ?></p>
                    </div>
                </li>

                <li>
                    <div>
                        <h4 style="margin-bottom: 0px;"><?php echo $system_text["user_faq"]["question_7"]; ?></h4>
                        <p style="font-size: 18px; margin-left: 20px" class="lead"><?php echo $system_text["user_faq"]["answer_7"]; ?></p>
                    </div>
                </li>

                <li>
                    <div>
                        <h4 style="margin-bottom: 0px;"><?php echo $system_text["user_faq"]["question_8"]; ?></h4>
                        <p style="font-size: 18px; margin-left: 20px" class="lead"><?php echo $system_text["user_faq"]["answer_8"]; ?></p>
                    </div>
                </li>

                <li>
                    <div>
                        <h4 style="margin-bottom: 0px;"><?php echo $system_text["user_faq"]["question_9"]; ?></h4>
                        <p style="font-size: 18px; margin-left: 20px" class="lead"><?php echo $system_text["user_faq"]["answer_9"]; ?></p>
                    </div>
                </li>

                <li>
                    <div>
                        <h4 style="margin-bottom: 0px;"><?php echo $system_text["user_faq"]["question_10"]; ?></h4>
                        <p style="font-size: 18px; margin-left: 20px" class="lead"><?php echo $system_text["user_faq"]["answer_10"]; ?></p>
                    </div>
                </li>

                <li>
                    <div>
                        <h4 style="margin-bottom: 0px;"><?php echo $system_text["user_faq"]["question_11"]; ?></h4>
                        <p style="font-size: 18px; margin-left: 20px" class="lead"><?php echo $system_text["user_faq"]["answer_11"]; ?></p>
                    </div>
                </li>

                <li>
                    <div>
                        <h4 style="margin-bottom: 0px;"><?php echo $system_text["user_faq"]["question_12"]; ?></h4>
                        <p style="font-size: 18px; margin-left: 20px" class="lead"><?php echo $system_text["user_faq"]["answer_12"]; ?></p>
                    </div>
                </li>

                <li>
                    <div>
                        <h4 style="margin-bottom: 0px;"><?php echo $system_text["user_faq"]["question_13"]; ?></h4>
                        <p style="font-size: 18px; margin-left: 20px" class="lead"><?php echo $system_text["user_faq"]["answer_13"]; ?></p>
                    </div>
                </li>


            </ul>

            <hr />

        </div>

    </div>

    <?php require_once("footer.html") ?>

</body>
</html>
