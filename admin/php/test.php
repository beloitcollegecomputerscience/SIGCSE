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