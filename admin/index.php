<!DOCTYPE html>
<html lang="en">

<?php
    //surprise, more test of oddity
// Access to global variables
require_once ('../global/include.php');

// Make sure user is allowed to view admin area
if (! $isAdmin) {
    header ( 'Location: ' . SYSTEM_WEB_BASE_ADDRESS . 'admin/login.php' );
}

require ("php/head.php");

// Get a count of how many students
$result = $db->query ( "SELECT count(*) as count FROM students" );
$row = $result->fetch_assoc ();
$studentCount = $row ['count'];

// Get a count of how many activities
$result = $db->query ( "SELECT count(*) as count FROM activity" );
$row = $result->fetch_assoc ();
$activityCount = $row ['count'];

?>

<body>

    <div id="wrapper">

        <?php require("php/sidebar.php"); echoNav($db, "index"); ?>

        <div id="page-wrapper">

            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-md-8">
                            <h1>
                                Dashboard <small>Overview</small>
                            </h1>
                        </div>
                        <div class="col-md-4">
                            <button type="button" style="float:left; margin-top: 20px; margin-bottom: 10px;" class="btn btn-primary btn-lg" onClick="window.open('<?php echo SYSTEM_WEB_BASE_ADDRESS."user/generalinstruction.php"?>')"><span class="glyphicon glyphicon-log-in"></span></button>
                            <button style="float:right; margin-top: 20px; margin-bottom: 10px;" type="button" class="btn btn-primary btn-lg" onClick="window.open('printinstructions.php')">Print Instructions</button>
                        </div>

                                            </div>
                    <ol class="breadcrumb">
                        <li class="active"><i class="fa fa-dashboard"></i> Dashboard</li>
                    </ol>
                </div>
            </div>
            <!-- /.row -->

            <div class="row">
                <div class="col-lg-6">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-6">
                                    <i class="fa fa-users fa-5x"></i>
                                </div>
                                <div class="col-xs-6 text-right">
                                    <p class="announcement-heading"><?php echo $studentCount; ?></p>
                                    <p class="announcement-text">Volunteers</p>
                                </div>
                            </div>
                        </div>
                        <a href="volunteer.php">
                            <div class="panel-footer announcement-bottom">
                                <div class="row">
                                    <div class="col-xs-6">View Volunteers</div>
                                    <div class="col-xs-6 text-right">
                                        <i class="fa fa-arrow-circle-right"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-6">
                                    <i class="fa fa-th-list fa-5x"></i>
                                </div>
                                <div class="col-xs-6 text-right">
                                    <p class="announcement-heading"><?php echo $activityCount; ?></p>
                                    <p class="announcement-text">Activities</p>
                                </div>
                            </div>
                        </div>
                        <a href="activity.php">
                            <div class="panel-footer announcement-bottom">
                                <div class="row">
                                    <div class="col-xs-6">View Activities</div>
                                    <div class="col-xs-6 text-right">
                                        <i class="fa fa-arrow-circle-right"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <!-- /.row -->

            <div class="row">
                <div class="col-lg-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <p class="pull-right">Click toggles to flip lock</p>
                            <h3 class="panel-title">
                                <i class="fa fa-lock"></i> System Locks
                            </h3>
                        </div>
                        <div class="panel-body">

                            <?php

                            $result = $db->query ( "SELECT * FROM system_locks" );
                            $affected_rows = mysqli_num_rows ( $result );

                            for($i = 0; $i < $affected_rows; $i ++) {
                                $row = $result->fetch_assoc ();

                                ?>

                            <div class="col-md-6">
                                <h4 style="margin: 0px; margin-bottom: 5px">
                                    <?php echo $row['name']; ?>
                                    <small><?php echo $row['description']; ?> </small>
                                </h4>
                                <div id="lock" lock_id="<?php echo $row['system_lock_id']; ?>">
                                    <div class="make-switch switch-small" data-on="success"
                                        data-off="danger" data-on-label="<i


                                        class='fa fa-unlock'>
                                        </i>" data-off-label="<i class='fa fa-lock'></i>"> <input
                                            type="checkbox"
                                            <?php echo $row['locked'] == "t" ? "" : "checked"; ?>>
                                    </div>
                                </div>
                                <hr />
                            </div>



                            <?php
                            }
                            ?>

                        </div>
                    </div>
                </div>


            </div>






            <div class="row">
                <div class="col-lg-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <p class="pull-right">Send email to volunteer groups</p>
                            <h3 class="panel-title">
                                <i class="fa fa-envelope"></i> Group Email
                            </h3>
                        </div>
                        <div class="panel-body">


    <?php

// Query to find students who can come to dinner

$queries = array(

        #query for shift soon but not checked in with us

        #query for missed shift

        "SELECT email FROM students where profile_complete = 'f';"
            => "Have not finished basic profile.",

        "SELECT email FROM students where times_complete = 'f' and profile_complete = 't';"
            => "Have not given available times.",


        "SELECT email FROM students where times_complete = 't' and profile_complete = 't';"
            => "who completely registered for sending notes",





);


?>
    <div>
  <div class="row">
    <div class="col-sm-9"><select class="form-control" id="mass_email_query_selection">
<option value= '-1' >Select a group to send email</option>
<?php
$query_number=1;
                foreach ($queries as $query => $desc) {
                    ?>
                                <option value= '<?php echo $query_number?>' ><?php echo $desc?></option>

                    <?php $query_number++;
                }
                    ?>

  </select>    </div>
    <div class="col-sm-3"><button class="btn btn-primary form-control" id="edit_recipient_button" data-toggle="modal" data-target="#recipient_window">Edit Recipient</button></div>
  </div>

</div>

<p></p>

<div class ="modal fade" role="dialog" id ="recipient_window" data-backdrop="static",
        data-keyboard="false">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">

        <h4 class="modal-title">Select Recipients</h4>
      </div>
      <div class="modal-body">
        <div  class ="checkbox" id="recipient" >
        <p> select a query</p>

</div>
<div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" id="recipient_confirm">Confirm</button>
      </div>
      </div>
</div></div></div>


<div id="recipients_to_show"></div>

      <div id="mass_email">
                                Hello

                                ,<br /> <br /> <br />
                            </div>
                            <p></p>
                        <button id="send_mass_email"
                                type="button"
                                class="btn btn-primary pull-right">Send</button>
</div>
                        </div>
                    </div>



            </div>











        </div>
        <p>&nbsp;</p>
        <!-- /#page-wrapper -->

        <?php require_once("footer.html"); ?>

    </div>
    <!-- /#wrapper -->

</body>
</html>
