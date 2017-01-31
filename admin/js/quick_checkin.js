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


$(document).ready(function(){


     $(".q-c-students").click(function(){



                $.ajax({
                type: 'POST',
                url: 'q_c_students.php',

                data : {

                    range_start_time : $("#range_start_time").val(),
                    range_end_time : $("#range_start_time").val()


                   }//when this is done the msg echoed from the php file that this file posts to which is add_form.php.
             }).done(function($msg) {
            alert($msg);
                }




 });
