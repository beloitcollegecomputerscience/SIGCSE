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
    $(document).ready(function() {
        $('.datatable').dataTable({
            "sPaginationType": "bs_full"
        });
        $('.datatable').each(function(){
            var datatable = $(this);
            // SEARCH - Add the placeholder for Search and Turn this into in-line form control
            var search_input = datatable.closest('.dataTables_wrapper').find('div[id$=_filter] input');
            search_input.attr('placeholder', 'Search');
            search_input.addClass('form-control input-sm');
            // LENGTH - Inline-Form control
            var length_sel = datatable.closest('.dataTables_wrapper').find('div[id$=_length] select');
            length_sel.addClass('form-control input-sm');
        });
    });

});
/* borrowed from schedule.js, possibly adapt to make query tables collapsible?
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

});*/
