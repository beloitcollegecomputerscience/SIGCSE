<!-- Copyright (C) 2017  Beloit College

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program (License.txt).  If not, see <http://www.gnu.org/licenses/>. -->

require_once('../../global/include.php');
  <script>
function test(){
var html = "<div class=\"make-switch\" data-on=\"info\" data-off=\"success\"><input type=\"checkbox\" checked></div>";
$("#test").append(html);
}

</script>
<div id="test"></div>

<script>
test();
</script>
