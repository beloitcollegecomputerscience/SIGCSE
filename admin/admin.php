<!-- Licensed under the BSD. See License.txt for full text. -->

<!DOCTYPE html>
<html lang="en">

<?php

// Access to global variables
require_once('../global/include.php');

// Make sure user is allowed to view admin area
if (!$isAdmin) {
    header('Location: '.SYSTEM_WEB_BASE_ADDRESS.'admin/login.php');
}

require("php/head.php");

?>

<body>

    <div id="wrapper">

        <?php require("php/sidebar.php"); echoNav($db, "admin"); ?>

        <div id="page-wrapper">

            <div class="row">
                <div class="col-lg-12">
                    <h1>
                        Administrators
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="index.php"><i class="fa fa-dashboard"></i> Dashboard</a>
                        </li>
                        <li class="active"><i class="fa fa-gear"></i> Administrators</li>
                    </ol>
                </div>
            </div>
            <!-- /.row -->

            <div class="row">
                <div class="col-lg-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <p class="pull-right">Click red X to remove</p>
                            <h3 class="panel-title">
                                <i class="fa fa-gear"></i> Current Admins
                            </h3>
                        </div>
                        <div class="panel-body">

                            <ul class="list-group">

                                <?php

                                $result = $db->query("SELECT * FROM admin");
                                $affected_rows = mysqli_num_rows($result);

                                for ($i = 0; $i < $affected_rows; $i++) {
                                    $row = $result->fetch_assoc();
                                    ?>
                                        <li class="list-group-item"><?php echo $row['email']; ?>

                                        <button type="button" admin_id=<?php echo $row['admin_id']; ?> class="btn btn-danger btn-xs pull-right delete_admin"><i class="fa fa-times"></i></button>

                                        </li>
                                    <?php
                                }
                                ?>
                            </ul>
                        </div>
                    </div>

                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                <i class="fa fa-gear"></i> Change Password
                            </h3>
                        </div>
                        <div class="panel-body">

                            <form class="form-horizontal" role="form">

                                <div class="form-group">
                                    <label for="admin_email" class="col-sm-3 control-label">Current Password</label>
                                    <div class="col-sm-9">
                                        <input type="password" class="form-control" id="change_admin_current_password"
                                            placeholder="Current Password">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="admin_password" class="col-sm-3 control-label">New Password</label>
                                    <div class="col-sm-9">
                                        <input type="password" class="form-control"
                                            id="change_admin_new_password" placeholder="New Password">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="admin_password" class="col-sm-3 control-label">Confirm New Password</label>
                                    <div class="col-sm-9">
                                        <input type="password" class="form-control"
                                            id="change_admin_confirm_password" placeholder="Confirm New Password">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-offset-3 col-sm-9">
                                        <button id="change_admin_password" type="button" class="btn btn-primary">Change Password</button>
                                    </div>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                <i class="fa fa-gear"></i> Create New Admin
                            </h3>
                        </div>
                        <div class="panel-body">

                            <form class="form-horizontal" role="form">

                                <div class="form-group">
                                    <label for="admin_email" class="col-sm-2 control-label">Email</label>
                                    <div class="col-sm-10">
                                        <input type="email" class="form-control" id="admin_email"
                                            placeholder="Email">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="admin_password" class="col-sm-2 control-label">Password</label>
                                    <div class="col-sm-10">
                                        <input type="password" class="form-control"
                                            id="admin_password" placeholder="Password">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <button id="new_admin" type="button" class="btn btn-primary">Create Admin</button>
                                    </div>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>
            </div>


        </div>
        <!-- /#page-wrapper -->

        <?php require_once("footer.html"); ?>

    </div>
    <!-- /#wrapper -->

</body>
</html>
