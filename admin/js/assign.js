/* Copyright (C) 2017  Beloit College

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program (License.txt).  If not, see <http://www.gnu.org/licenses/>. */


$(document).ready(function() {

    $(".add_volunteer").click(function() {

        id = $(this).attr("id");
        title = $("#" + id + "_stu_title").html();

        button = "<button id='' type='button' class='btn btn-danger btn-xs pull-right remove_volunteer'><i class='fa fa-times'></i></button>"
        $("#volunteer_list").append("<li id='" + id + "' class='list-group-item'>" + button + title + "</li>");

        $(".remove_volunteer").on("click", function(){
            $(this).parent().remove();
        });
    });

    $(".add_activity").click(function() {

        id = $(this).attr("id");
        title = $("#" + id + "_act_title").html();

        button = "<button id='' type='button' class='btn btn-danger btn-xs pull-right remove_activity'><i class='fa fa-times'></i></button>"
        $("#activity_list").append("<li id='" + id + "' class='list-group-item'>" + button + title + "</li>");

        $(".remove_activity").on("click", function(){
            $(this).parent().remove();
        });
    });

    $("#schedule_assign").click(function() {

        activity_ids = "";
        student_ids = "";

        $("#activity_list").find('li').each(function(){
            id = $(this).attr("id");
            activity_ids += id + ",";
        });

        $("#volunteer_list").find('li').each(function(){
            id = $(this).attr("id");
            student_ids += id + ",";
        });

        activity_ids = activity_ids.substring(0, activity_ids.length - 1);
        student_ids = student_ids.substring(0, student_ids.length - 1);

        bootbox.confirm("Are you sure you want to schedule these volunteers?", function(result) {
            if (result == true) {

                $.ajax({
                    type : "POST",
                    url : "php/schedule.php",
                    data : {
                        activity_ids : activity_ids,
                        student_ids : student_ids
                    }
                }).done(function(msg) {
                    if (msg == "true") {
                        setTimeout(function() {
                            bootbox.alert("Volunteers have been scheduled.", function() {
                                location.reload();
                            });
                        }, 1000);

                    } else {
                        bootbox.alert("Please make sure you have selected at least one volunteer and one activity.");
                    }
                });

            }
        });

    });
});
