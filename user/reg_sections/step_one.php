<!-- Licensed under the BSD. See License.txt for full text.  -->

<!-- Step One -->
<div id="step_one">

    <h2 style="margin-top: 0px;" class="text-center"><?php echo $system_text["user_register"]["title"]; ?></h2>

    <p style="font-size: 18px;" class="lead"><?php echo $system_text["user_register"]["description_1"]; ?></p>

    <p style="font-size: 18px;" class="lead"><?php echo $system_text["user_register"]["description_2"]; ?></p>



    <div class="alert alert-warning">
        <?php echo $system_text["user_index"]["registration_warning"]; ?>
    </div>

    <hr />

    <div id="step_one_alert_success"
        class="alert alert-success col-lg-8 col-lg-offset-2"></div>
    <div id="step_one_alert_danger"
        class="alert alert-danger col-lg-8 col-lg-offset-2"></div>
    <script type="text/javascript"> $("#step_one_alert_success").hide(); </script>
    <script type="text/javascript"> $("#step_one_alert_danger").hide(); </script>

    <form class="form-horizontal" role="form">
        <div class="form-group">
            <label for="step_one_first_name" class="col-lg-3 control-label"><?php echo $system_text["user_register"]["register_first_name"]; ?></label>
            <div class="col-lg-7">
                <input type="text" class="form-control" id="step_one_first_name"
                    value="<?php echo isset($_POST['step_one_first_name']) ? $_POST['step_one_first_name'] : ""; ?>">
            </div>
        </div>

        <div class="form-group">
            <label for="step_one_last_name" class="col-lg-3 control-label"><?php echo $system_text["user_register"]["register_last_name"]; ?></label>
            <div class="col-lg-7">
                <input type="text" class="form-control" id="step_one_last_name"
                    value="<?php echo isset($_POST['step_one_last_name']) ? $_POST['step_one_last_name'] : ""; ?>">
            </div>
        </div>

        <div class="form-group">
            <label for="step_one_email" class="col-lg-3 control-label"><?php echo $system_text["user_register"]["register_email"]; ?></label>
            <div class="col-lg-7">
                <input type="email" class="form-control" id="step_one_email"
                    value="<?php echo isset($_POST['step_one_email']) ? $_POST['step_one_email'] : ""; ?>">
            </div>
        </div>

        <div class="form-group">
            <label for="step_one_password" class="col-lg-3 control-label"><?php echo $system_text["user_register"]["register_password"]; ?></label>
            <div class="col-lg-7">
                <input type="password" class="form-control"
                    id="step_one_password"
                    value="<?php echo isset($_POST['step_one_password']) ? $_POST['step_one_password'] : ""; ?>">
            </div>
        </div>

        <div class="form-group">
            <label for="step_one_confirm_password"
                class="col-lg-3 control-label"><?php echo $system_text["user_register"]["register_confirm_password"]; ?></label>
            <div class="col-lg-7">
                <input type="password" class="form-control"
                    id="step_one_confirm_password"
                    value="<?php echo isset($_POST['step_one_confirm_password']) ? $_POST['step_one_confirm_password'] : ""; ?>">
            </div>
        </div>

        <div class="form-group">
            <div class="col-lg-offset-3 col-lg-9">
                <button id="step_one_submit" type="button"
                    class="btn btn-primary"><?php echo $system_text["user_register"]["register_button"]; ?></button>
            </div>
        </div>
    </form>

    <hr/>

</div>

<?php
if (!$stepOne) {
    ?>
<script type="text/javascript"> $("#step_one").hide(); </script>
<?php
}
?>
