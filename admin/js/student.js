/* Licensed under the BSD. See License.txt for full text.  */


$(document).ready(function() {

    handleCheckedIn();
    handleToggleRefund();
    handleAttendActivity();
    handleAttendActivity_quick();
    handleToggleTimesComplete();
    handleGrantHours();
     handleGrantHours_quick();
    handleUnschedule();
    handleUnschedule_quick();
    handleManualSchedule();
    handleDelete();
    handleNotes();


    handleNewVolunteer()
});

function handleNewVolunteer() {
    $("#new_vol").click(function() {
        email = $("#new_vol_email").val();

        bootbox.confirm("Are you sure you want to create a new volunteer?", function(result) {
            if (result == true) {

                $.ajax({
                    type : "POST",
                    url : "php/create_vol.php",
                    data : {
                        email : email
                    }
                }).done(function(msg) {
                    if (msg == "true") {
                        setTimeout(function() {
                            bootbox.alert("Volunteer has been created.", function() {
                                location.reload();
                            });
                        }, 1000);

                    } else {
                        bootbox.alert("An error occured.  Verify that you input a correct email address.  Verify the email address isn't already in use.");
                    }
                });

            }
        });

    });
}


/*-------------------------THIS PART ------------------*/
/*-------------------------THIS PART ------------------*/
/*-------------------------THIS PART ------------------*/

function handleNotes() {
    $.fn.editable.defaults.mode = 'popup';

    $('#student_note').editable({
        placement: 'right',
        url: 'php/student_notes.php',
        title: 'Enter note.',
        rows: 5
    });

}


/*------------------------------------------*/
/*-------------------------------------------*/
/*---------------------------------------------*/





function handleDelete() {
    $("#delete_vol").click(function() {
        student_id = $(this).attr("student_id");
        console.log(student_id);

        bootbox.confirm("Are you sure you want to delete this volunteer?", function(result) {
            if (result == true) {
                bootbox.confirm("Are you positive?  This is irreversible.", function(result) {
                    if (result == true) {

                        $.ajax({
                            type : "POST",
                            url : "php/delete_vol.php",
                            data : {
                                student_id : student_id
                            }
                        }).done(function(msg) {
                            if (msg == "true") {
                                setTimeout(function() {
                                    bootbox.alert("Volunteer has been deleted.", function() {
                                        location.reload();
                                    });
                                }, 1000);

                            } else {
                                bootbox.alert("An error occured.");
                            }
                        });


                    }
                });
            }

        });
    });

}











function handleManualSchedule() {
    $(".schedule_manual").click(function() {
        student_id = $(this).attr("student_id");
        activity_id = $(this).attr("activity_id");

        bootbox.confirm("Are you sure you want to schedule this volunteer?", function(result) {
            if (result == true) {

                $.ajax({
                    type : "POST",
                    url : "php/schedule.php",
                    data : {
                        activity_ids : activity_id,
                        student_ids : student_id
                    }
                }).done(function(msg) {
                    if (msg == "true") {
                        setTimeout(function() {
                            bootbox.alert("Volunteer has been scheduled.", function() {
                                location.reload();
                            });
                        }, 1000);

                    } else {
                        bootbox.alert("An error occured.");
                    }
                });

            }
        });

    });
}

function handleUnschedule() {

    $(".unschedule").click(function() {
        student_id = $(this).attr("student_id");
        activity_id = $(this).attr("activity_id");

        bootbox.confirm("Are you sure you want to unschedule?", function(result) {

              if (result == true) {
                  $.ajax({
                        type : "POST",
                        url : "php/unschedule.php",
                        data : {
                            activity_id : activity_id,
                            student_id : student_id
                        }
                    }).done(function(msg) {
                        console.log(msg);
                        if (msg == "") {
                            setTimeout(function() {
                                bootbox.alert("Volunteer unscheduled.", function() {
                                    location.reload();
                                });
                            }, 1000);

                        }

                    });
              }
            });
    });

}
function handleUnschedule_quick() {

    $(".q_c_table").on('click','.unschedule',function() {
        student_id = $(this).attr("student_id");
        activity_id = $(this).attr("activity_id");
        var current =$(this);
        bootbox.confirm("Are you sure you want to unschedule?", function(result) {

              if (result == true) {
                  $.ajax({
                        type : "POST",
                        url : "unschedule.php",
                        data : {
                            activity_id : activity_id,
                            student_id : student_id
                        }
                    }).done(function(msg) {
                        console.log(msg);
                        if (msg == "") {
                            setTimeout(function() {
                                bootbox.alert("Volunteer unscheduled.", function() {
                                    current.replaceWith("<div>Unscheduled</div>");
                                });
                            }, 1000);

                        }

                    });
              }
            });
    });

}

function handleToggleTimesComplete() {
    $("div[id^='vol_times_complete']").on('switch-change', function(e, data) {
        student_id = $(this).attr("student_id");

        $.ajax({
            type : "POST",
            url : "php/student.php",
            data : {
                func : "ToggleTimesComplete",
                student_id : student_id
            }
        }).done(function(msg) {
            // code could go here
        });

    });
}

function handleToggleRefund() {
    $("div[id^='toggle_refund']").on('switch-change', function(e, data) {
        student_id = $(this).attr("student_id");

        $.ajax({
            type : "POST",
            url : "php/student.php",
            data : {
                func : "ToggleRefund",
                student_id : student_id
            }
        }).done(function(msg) {
            // code could go here
        });

    });
}

function handleCheckedIn() {

    $("div[id^='check_in']").on('switch-change', function(e, data) {
        student_id = $(this).attr("student_id");

        $.ajax({
            type : "POST",
            url : "php/student.php",
            data : {
                func : "ToggleCheckedIn",
                student_id : student_id
            }
        }).done(function(msg) {
            // code could go here
        });

    });

}

function handleAttendActivity() {

    $("div[id^='attended']").on('switch-change', function(e, data) {
        student_id = $(this).attr("student_id");
        activity_id = $(this).attr("activity_id");

        $.ajax({
            type : "POST",
            url : "php/student.php",
            data : {
                func : "ToggleAttendedActivity",
                student_id : student_id,
                activity_id : activity_id
            }
        }).done(function(msg) {
            // code could go here
        });

    });
}
function handleAttendActivity_quick() {

    $(".q_c_table").on('switch-change','#attended', function(e, data) {
        student_id = $(this).attr("student_id");
        activity_id = $(this).attr("activity_id");

        $.ajax({
            type : "POST",
            url : "student.php",
            data : {
                func : "ToggleAttendedActivity",
                student_id : student_id,
                activity_id : activity_id
            }
        }).done(function(msg) {
            // code could go here
        });

    });
}

function handleGrantHours() {

    $("button[id^='grant']").click(function() {
        student_id = $(this).attr("student_id");
        activity_id = $(this).attr("activity_id");
        hours = $("#" + activity_id + "_" + student_id + "_hours_input").val();
        minutes = $("#" + activity_id + "_" + student_id + "_minutes_input").val();

        $.ajax({
            type : "POST",
            url : "php/student.php",
            data : {
                func : "GrantHours",
                student_id : student_id,
                activity_id : activity_id,
                hours : hours,
                minutes : minutes
            }
        }).done(function(msg) {
            // code could go here
        });

        $("#" + activity_id + "_" + student_id + "_hours_display").html(hours);
        $("#" + activity_id + "_" + student_id + "_minutes_display").html(minutes);

    });

}
function handleGrantHours_quick() {

    $(".q_c_table").on('click','#grant',function() {
        student_id = $(this).attr("student_id");
        activity_id = $(this).attr("activity_id");
        hours = $("#" + activity_id + "_" + student_id + "_hours_input").val();
        minutes = $("#" + activity_id + "_" + student_id + "_minutes_input").val();

        $.ajax({
            type : "POST",
            url : "student.php",
            data : {
                func : "GrantHours",
                student_id : student_id,
                activity_id : activity_id,
                hours : hours,
                minutes : minutes
            }
        }).done(function(msg) {
            // code could go here
        });

        $("#" + activity_id + "_" + student_id + "_hours_display").html(hours);
        $("#" + activity_id + "_" + student_id + "_minutes_display").html(minutes);

    });

}
