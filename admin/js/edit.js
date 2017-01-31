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

    $.fn.editable.defaults.mode = 'popup';

    $('#activity_note').editable({
        placement: 'right',
        url: 'php/activity_notes.php',
        title: 'enter note.',
        rows: 5
    });

    $.fn.editable.defaults.mode = 'inline';

    $('.system_text').editable({
        url: 'php/text.php',
        title: 'Enter text.',
        rows: 5,
    });

});
