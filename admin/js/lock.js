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

    handleLocks();

});

function handleLocks() {

    $("div[id^='lock']").on('switch-change', function(e, data) {
        lock_id = $(this).attr("lock_id");

        $.ajax({
            type : "POST",
            url : "php/lock.php",
            data : {
                func : "ToggleLock",
                lock_id : lock_id
            }
        }).done(function(msg) {
            // code could go here
        });

    });

}
