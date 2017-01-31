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
  $('#summernote').summernote();


  $("#send_student_email").click(function() {

      student_id = $(this).attr("student_id");
      message = $('#summernote').code();

      bootbox.confirm("Are you sure you want to send this email?", function(result) {

          if (result == true) {
              $.ajax({
                    type : "POST",
                    url : "php/email_volunteer.php",
                    data : {
                        message : message,
                        student_id : student_id
                    }
                }).done(function(msg) {

                    if (msg == "") {
                        setTimeout(function() {
                            bootbox.alert("Message sent successfully");
                        }, 1000);

                    }

                });
          }

        });

    });


});
