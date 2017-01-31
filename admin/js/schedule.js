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

     $(".day_toggle").click(function() {


         date = $(this).attr("date");
         display = "#" + date + "_display"
         status = $(display).attr("status");

         if (status == "expended") {
             $(display).slideUp();
             $(display).attr("status","closed");
             $(this).children().removeClass("fa-minus");
             $(this).children().addClass("fa-plus");

         } else if (status == "closed") {
             $(display).slideDown();
             $(display).attr("status","expended");
             $(this).children().removeClass("fa-plus");
             $(this).children().addClass("fa-minus");
         }


     });

});
