<!-- Licensed under the BSD. See License.txt for full text.  -->

<!DOCTYPE html>
<html lang="en">
<?php
/*
this is the form that the admin is going to fill out to add the activity.
admin is directed to this page after clicking on the add activity button on the activity page.
*/

// Access to global variables
require_once('../../global/include.php');

// Make sure user is allowed to view admin area
if (!$isAdmin) {
    header('Location: '.SYSTEM_WEB_BASE_ADDRESS.'admin/login.php');
}
//add_activity.js is added to the head php so can be used here.
require("head.php");
?>
        <style>
        body{
            margin-top: 0px;
        }
        .datetimepicker{
        margin-top:0px;
        }
        .center{
        position:relative;
        margin-left:auto;
        margin-right:auto;
        width:700px;
        }
        .center .input-group{
        float:left;
        margin-right:35px;}

        .center buttom{
        float:left;}
        .activity-info{
        max-width:250px;
        }
        .activity-info span{
        font-size:11px;
        color:#777;
        }
        .mask{
        opacity:0.7;
        display: none;
        position:fixed;
        width:100%;
        height:100%;
        background-color: #000000;
        z-index: 999;

        }
        </style>

<body>
<div class="mask"></div>
<a href="../index.php" class="btn btn-link" role="button">Back</a>
    <div class="container">
        <div class="text-center">
            <h3 class="center-text"> Quick Check-in</h3>
            <p>&nbsp;</p>
        </div>

        <div class="center">
        <span class="col-sm-6">Please select the time range to check people in:</span><br><br>
                 <div class="input-group date form_date col-sm-4"  data-date-format="yyyy-mm-dd  hh:ii:00" >
                    <input class="form-control required"  type="datetime" readonly id="range_start_time" placeholder="range starts" >
                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                </div>

                 <div class="input-group date form_date col-sm-4 "  data-date-format="yyyy-mm-dd  hh:ii:00" >
                    <input class="form-control required"  placeholder="range ends" type="datetime" readonly id="range_end_time" >
                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                </div>

                    <button class="btn btn-primary q-c-students">See Students</button>


          </div>

        </div>

        <div class="col-sm-12">

        <br><br>
            <table class="table table-striped table-bordered table-hover q_c_table">

                    <thead>
                        <tr>
                            <td><strong>Student</strong></td>
                            <td><strong>Mark Attended</strong></td>
                            <td><strong>Grant Hours</strong></td>
                            <td><strong>Activity Info</strong></td>
                        </tr>
                    </thead>

                </table>

        </div>


    </div>

        <script type="text/javascript">

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

                var c_start=timeToString(-1);
                var c_end=timeToString(2);


                function timeToString(offset){

                 var mydate = new Date();
                 mydate.setHours(mydate.getHours()+offset);
                    var str = "" + mydate.getFullYear();
                    var mm = mydate.getMonth()+1
                    if(mm>9){
                     str += mm;
                    }
                    else{
                     str += "0" + mm;
                    }
                    if(mydate.getDate()>9){
                     str += mydate.getDate();
                    }
                    else{
                     str += "0" + mydate.getDate();
                    }
                    var hh=mydate.getHours();
                    var ii=mydate.getMinutes();
                    var ss=mydate.getSeconds();
                    if(hh>9){
                        str+=hh;}
                    else{
                        str+="0"+hh;}
                    if(ii>9){
                        str+=ii;}
                    else{
                        str+="0"+ii;}
                    if(ss>9){
                        str+=ss}
                    else{
                        str+="0"+ss;
                            }

                   return str;
                }
                $.ajax({
                    type: 'POST',
                    url: 'q_c_students.php',

                    data : {
                        action:"1",
                        range_start_time : c_start,
                        range_end_time : c_end


                       }//when this is done the msg echoed from the php file that this file posts to which is add_form.php.
                 }).done(function(msg) {
                     var parsedData = JSON.parse(msg);

                     displayStudents(0,parsedData);





                    });


                 $(".q-c-students").click(function(){


                    $(".q_c_table thead").nextAll().remove();
                    if(($("#range_start_time").val()!=""&&$("#range_end_time").val()=="")||($("#range_start_time").val()==""&&$("#range_end_time").val()!="")){
                 alert("please complete time field");}
                       else if($("#range_start_time").val()==""&&$("#range_end_time").val()==""){

                var c_start_display1=c_start.substring(0, 4) + "." + c_start.substring(4,6)+ "." + c_start.substring(6,8)+ "." + c_start.substring(8,10)+ ":" + c_start.substring(10,12);
                var c_end_display1=c_end.substring(0, 4) + "." + c_end.substring(4,6)+ "." + c_end.substring(6,8)+ "." + c_end.substring(8,10)+ ":" + c_end.substring(10,12);

                           $(".q_c_table").append("<div>No students in this period from "+c_start_display1+" to "+c_end_display1+"</div>");

                   }
                   else{$.ajax({
                            type: 'POST',
                            url: 'q_c_students.php',

                            data : {
                                action:"1",
                                range_start_time : $("#range_start_time").val(),
                                range_end_time : $("#range_end_time").val()


                               }//when this is done the msg echoed from the php file that this file posts to which is add_form.php.
                         }).done(function(msg) {
                             var parsedData = JSON.parse(msg);

                             displayStudents(0,parsedData);





                            });}



                 });



             function displayStudents(k,parsedData){


                       if(parsedData.length==0){
                           if($("#range_start_time").val()!=""&&$("#range_end_time").val()!=""){
                               $(".q_c_table").append("<div>No students in this period</div>");
                           }
                           else{
                var c_start_display=c_start.substring(0, 4) + "." + c_start.substring(4,6)+ "." + c_start.substring(6,8)+ "." + c_start.substring(8,10)+ ":" + c_start.substring(10,12);
                var c_end_display=c_end.substring(0, 4) + "." + c_end.substring(4,6)+ "." + c_end.substring(6,8)+ "." + c_end.substring(8,10)+ ":" + c_end.substring(10,12);
                           $(".q_c_table").append("<div>No students in this period from "+c_start_display+" to "+c_end_display+"</div>");
                       }
                   }
                   else{
                       var currently_granted_hour = Math.floor(parsedData[k]['hours_granted']*60 / 60);
                    var currently_granted_min = Math.round(((parsedData[k]['hours_granted'] - currently_granted_hour) * 60), 0);
                    var checked_in="";
                     var BASE = 'https://csserver.beloit.edu/~huss/sigcse/sigcse_testing/project/';
                     var attended="";
                     if(parsedData[k]['attended']=='t'){
                         attended="checked";}
                    if (parsedData[k]['checked_in'] == 't'){
                        checked_in= "led-green";}
                    else{
                        checked_in="led-red";}

                    $.ajax({
                    type: 'POST',
                    url: 'q_c_students.php',

                    data : {
                        action:"2",
                        current_activity:parsedData[k]['activity_id'] }//when this is done the msg echoed from the php file that this file posts to which is add_form.php.
                 }).done(function(msg) {

                     var parsedGrantHour=JSON.parse(msg);
                     var activity_hours = parsedGrantHour[0];
                    var activity_mins = parsedGrantHour[1];
                    var sh0="";
                    var sh1="";
                    var sh2="";
                    var sh3="";
                    var sh4="";
                    var sg0="";
                    var sg1="";
                    var sg2="";
                    var sg3="";
                    var sg4="";
                    var sg5="";
                    var sg6="";
                    var sg7="";
                    var sg8="";
                    var sg9="";
                    var sg10="";
                    var sg11="";


                    switch (activity_hours) {
                    case '0':
                        sh0="selected";
                        break;
                    case '1':
                        sh1="selected";
                        break;
                    case '2':
                        sh2="selected";
                        break;
                    case '3':
                        sh3="selected";
                        break;
                    case '4':
                        sh4="selected";
                        break;

                }

                    switch (activity_mins) {
                    case '0':
                        sg0="selected";
                        break;
                    case '5':
                        sg1="selected";
                        break;
                    case '10':
                        sg2="selected";
                        break;
                    case '15':
                        sg3="selected";
                        break;
                    case '20':
                        sg4="selected";
                        break;
                    case '25':
                        sg5="selected";
                        break;
                    case '30':
                        sg6="selected";
                        break;
                    case '35':
                        sg7="selected";
                        break;
                    case '40':
                        sg8="selected";
                        break;
                    case '45':
                        sg9="selected";
                        break;
                    case '50':
                        sg10="selected";
                        break;
                    case '55':
                        sg11="selected";
                        break;

                }



                    var html = "<tr id='row_"+parsedData[k]['activity_id']+"'"+"><td><p style='margin:0px;'><a href='volunteer.php?id="+parsedData[k]['student_id']+"'><div class='led "+checked_in+"'>&nbsp;&nbsp;&nbsp;</div>"+parsedData[k]['first_name']+" "+parsedData[k]['last_name']+"</a></p><p style='margin:0px;'><span class='label label-info'>Currently granted <span id='"+parsedData[k]['activity_id']+"_"+parsedData[k]['student_id']+"_"+"hours_display'>"+currently_granted_hour+"</span> hour(s), <span id='"+parsedData[k]['activity_id']+"_"+parsedData[k]['student_id']+"_minutes_display'>"+currently_granted_min+"</span> min(s).</span></p><p style='margin:0px;'><button student_id='"+parsedData[k]['student_id']+"' activity_id="+parsedData[k]['activity_id']+" type='button' class='btn btn-danger btn-xs pull-right unschedule'>Unschedule</button></p><a href='"+BASE+"user/assemble.php?student_id='"+parsedData[k]['student_id']+"&activity_id='"+parsedData[k]['activity_id']+"' target='_blank'>Student instructions</a></td><td><div id='attended' activity_id='"+parsedData[k]['activity_id']+"' student_id='"+parsedData[k]['student_id']+"' class='make-switch switch-small' data-on='success' data-off='danger' data-on-label=\"<i class='fa fa-check'></i>\" data-off-label=\"<i class='fa fa-times'></i>\"><input type='checkbox'"+attended+"></div></td><td style='min-width:325px;'><form class='form-inline' style='margin-bottom: 5px;'><select id='"+parsedData[k]['activity_id']+"_"+parsedData[k]['student_id']+"_"+"hours_input' style='width:75px;'class='form-control input-sm'><option "+sh0+">0</option><option "+sh1+">1</option><option "+sh2+">2</option><option "+sh3+">3</option><option "+sh4+">4</option></select> hour(s) and <select id='"+parsedData[k]['activity_id']+"_"+parsedData[k]['student_id']+"_"+"minutes_input' style='width:75px;' class='form-control input-sm'><option "+sg0+">0</option><option "+sg1+">5</option><option "+sg2+">10</option><option "+sg3+">15</option><option "+sg4+">20</option><option "+sg5+">25</option><option "+sg6+">30</option><option "+sg7+">35</option><option "+sg8+">40</option><option "+sg9+">45</option><option "+sg10+">50</option><option "+sg11+">55</option></select> minute(s)</form><button id='grant' activity_id='"+parsedData[k]['activity_id']+"' student_id='"+parsedData[k]['student_id']+"' class='btn btn-primary btn-xs pull-right' type='button'>Grant</button></td><td><div class='activity-info'><a href='../activity.php?id="+parsedData[k]['activity_id']+"' target='_blank'>"+parsedData[k]['activity_name']+"</a><br><span> from "+parsedData[k]['start_time']+" to "+parsedData[k]['end_time']+"</span></div></td></tr>";
                    $(".q_c_table").append(html);
                    $(".make-switch:eq("+k+")").bootstrapSwitch();
                    if(k<=parsedData.length){
                        if(k==parsedData.length){
                            alert("hey");
                        }
                        else{displayStudents(k+1,parsedData);}
                    }

                });


                  }}
                     });


        </script>

</body>
</html>
