<!-- Licensed under the BSD. See License.txt for full text.  -->


<!DOCTYPE html>
<html lang="en">

<?php

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
<style>
        .datetimepicker{
        margin-top:52px;
        }
        .center{
        position:relative;
        margin-left:auto;
        margin-right:auto;
        width:70%;
        }
        .embed{
            margin-top:5px !important;
            }

        </style>
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
                            <button type="button" style="float:left; margin-top: 20px;margin-right:20px; margin-bottom: 10px;" class="btn btn-primary " onClick="window.open('<?php echo SYSTEM_WEB_BASE_ADDRESS."user/generalinstruction.php"?>')"><span class="glyphicon glyphicon-log-in"></span>General Instructions</button>
                            <button style=" margin-top: 20px; margin-bottom: 10px;margin-right:20px;" type="button" class="btn btn-primary" onClick="window.open('printinstructions.php')">Print Instructions</button>
                            <button style=" margin-top: 20px; margin-bottom: 10px;margin-right:20px;" type="button" class="btn btn-primary" onClick="window.open('php/quick_checkin.php')">Quick Checkin</button>
                        </div>

                                            </div>
<!--             modal             -->
<div class="modal fade" id="rangeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" id="myModalLabel">Please select the time range to check people in:</h4>
      </div>
      <div class="modal-body">
      <div class="center">
     <div class="input-group date form_date col-sm-12 "  data-date-format="yyyy-mm-dd  hh:ii:00" >
                    <input class="form-control required"  type="datetime" readonly id="range_start_time" placeholder="range starts" >
                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                </div>
                 <br/>
                 <div class="input-group date form_date col-sm-12 "  data-date-format="yyyy-mm-dd  hh:ii:00" >
                    <input class="form-control required"  placeholder="range ends" type="datetime" readonly id="range_end_time" >
                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                </div>
             <br/>
                    <button class="btn btn-primary q-c-students">See Students</button></div>
      </div>

    </div>
  </div>
</div>

<!--             modal    ends here          -->



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
$queries=array();
    $query_result = $db->query("select query_id, query_name from mass_email_query");
    $affected_rows = mysqli_num_rows($query_result);
for ($i = 0; $i < $affected_rows; $i++) {
        $row = $query_result->fetch_assoc();

    $query_id=$row['query_id'];
    $query_name=$row['query_name'];
    $queries[$query_id]=$query_name;};



?>
    <div>
  <div class="row">
    <div class="col-sm-9"><select class="form-control" id="mass_email_query_selection">
<option value= '-1' >Select a group to send email</option>
<?php

                foreach ($queries  as $id => $name) {
                    ?>
                                <option value= '<?php echo $id?>' ><?php echo $name?></option>

                    <?php
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



                            </div>
                            <p></p>
                        <button id="send_mass_email"
                                type="button"
                                class="btn btn-primary pull-right">Send</button>

                        <div class="update_template_button"></div>


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
    <script type="text/javascript">

     $(document).on('click', '.embed', function(){
 var toInsert= " %"+$(this).attr('id')+"%";
 document.getElementsByClassName('note-editable')[0].focus();
 pasteHtmlAtCaret(toInsert);

    });


function pasteHtmlAtCaret(html) {
    var sel, range;
    if (window.getSelection) {
        // IE9 and non-IE
        sel = window.getSelection();
        if (sel.getRangeAt && sel.rangeCount) {
            range = sel.getRangeAt(0);
            range.deleteContents();

            // Range.createContextualFragment() would be useful here but is
            // only relatively recently standardized and is not supported in
            // some browsers (IE9, for one)
            var el = document.createElement("div");
            el.innerHTML = html;
            var frag = document.createDocumentFragment(), node, lastNode;
            while ( (node = el.firstChild) ) {
                lastNode = frag.appendChild(node);
            }
            range.insertNode(frag);

            // Preserve the selection
            if (lastNode) {
                range = range.cloneRange();
                range.setStartAfter(lastNode);
                range.collapse(true);
                sel.removeAllRanges();
                sel.addRange(range);
            }
        }
    } else if (document.selection && document.selection.type != "Control") {
        // IE < 9
        document.selection.createRange().pasteHTML(html);
    }
}

            $('.form_date').datetimepicker({
                language:  'en',
                weekStart: 1,
                todayBtn:  1,
                autoclose: 1,
                todayHighlight: 1,
                startView: 2,
                forceParse:0,
                showMeridian:1
            });


            $(document).ready(function(){


//                  $(".q-c-students").click(function(){



//                             $.ajax({
//                             type: 'POST',
//                             url: 'php/q_c_students.php',

//                             data : {
//                                 action:"1",
//                                 range_start_time : $("#range_start_time").val(),
//                                 range_end_time : $("#range_end_time").val()


//                                }//when this is done the msg echoed from the php file that this file posts to which is add_form.php.
//                          }).done(function($msg) {
//                         alert($msg);
//                         window.location.href = "php/q_c_students.php";
//                             });


//                  });

             });


        </script>
</body>
</html>
