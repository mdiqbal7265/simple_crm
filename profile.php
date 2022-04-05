<?php include 'include/header.php'; ?>

<?php include 'include/aside.php'; ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Profile</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active"><?= ($user['type'] == 2 ? 'User' : 'Admin') ?> Profile</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">

                    <!-- Profile Image -->
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img class="profile-user-img img-fluid img-circle" src="assets/upload/<?= $user['profile_img'] ?>" alt="<?= $user['name'] ?>">
                            </div>

                            <h3 class="profile-username text-center"><?= $user['name'] ?></h3>

                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Email</b> <a class="float-right"><?= $user['email'] ?></a>
                                </li>
                                <li class="list-group-item">
                                    <b>Mobile</b> <a class="float-right"><?= $user['mobile'] ?></a>
                                </li>
                                <li class="list-group-item">
                                    <b>Gender</b> <a class="float-right"><?= $user['gender'] ?></a>
                                </li>
                                <li class="list-group-item">
                                    <b>Address</b> <a class="float-right"><?= $user['address'] ?></a>
                                </li>
                                <li class="list-group-item">
                                    <b>Status</b> <a class="float-right"><?= $user['status'] == 1 ? '<span class="badge badge-success">Verified</span>' : '<span class="badge badge-danger">Unverified</span>' ?></a>
                                </li>
                            </ul>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header p-2">
                            <ul class="nav nav-pills">
                                <li class="nav-item"><a class="nav-link active" href="#settings" data-toggle="tab">Settings</a></li>
                                <li class="nav-item"><a class="nav-link" href="#change_password" data-toggle="tab">Change Password</a></li>
                            </ul>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="active tab-pane" id="settings">
                                    <form class="form-horizontal" id="update_profile_form">
                                        <input type="hidden" name="id" value="<?= $user['id']; ?>">
                                        <div class="form-group row">
                                            <label for="name" class="col-sm-2 col-form-label">Name</label>
                                            <div class="col-sm-10">
                                                <input type="email" class="form-control" id="name" name="name" value="<?= $user['name']; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="email" class="col-sm-2 col-form-label">Email</label>
                                            <div class="col-sm-10">
                                                <input type="email" class="form-control" id="email" name="email" value="<?= $user['email']; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="alt_email" class="col-sm-2 col-form-label">Alt Email</label>
                                            <div class="col-sm-10">
                                                <input type="email" class="form-control" id="alt_email" name="alt_email" value="<?= $user['alt_email']; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="mobile" class="col-sm-2 col-form-label">Mobile</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="mobile" name="mobile" value="<?= $user['mobile']; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="address" class="col-sm-2 col-form-label">Address</label>
                                            <div class="col-sm-10">
                                                <textarea class="form-control" id="address" name="address"><?= $user['address']; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="gender" class="col-sm-2 col-form-label">Gender</label>
                                            <div class="col-sm-10">
                                                <select class="form-control" name="gender" id="gender">
                                                    <option value="Male" <?= $user['gender'] == 'Male' ? 'selected': ''; ?>>Male</option>
                                                    <option value="Female" <?= $user['gender'] == 'Female' ? 'selected': ''; ?>>Female</option>
                                                    <option value="Others" <?= $user['gender'] == 'Others' ? 'selected': ''; ?>>Others</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="offset-sm-2 col-sm-10">
                                                <input type="submit" value="Update" id="update_profile_btn" class="btn btn-danger">
                                                <!-- <button type="submit" class="btn btn-danger">Submit</button> -->
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div class="tab-pane" id="change_password">
                                    <form class="form-horizontal" id="change_password_form">
                                        <input type="hidden" name="user_id" value="<?= $user['id']; ?>">
                                        <div class="form-group row">
                                            <label for="old_password" class="col-sm-2 col-form-label">Old Password</label>
                                            <div class="col-sm-10">
                                                <input type="password" class="form-control" name="old_password" id="old_password" placeholder="old password">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="password" class="col-sm-2 col-form-label">New Password</label>
                                            <div class="col-sm-10">
                                                <input type="password" class="form-control" name="new_password" id="password" placeholder="new password">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="confirm_password" class="col-sm-2 col-form-label">Confirm Password</label>
                                            <div class="col-sm-10">
                                                <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="confirm password">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="offset-sm-2 col-sm-10">
                                                <input type="submit" value="Change Password" class="btn btn-danger" id="change_password_btn">
                                                <!-- <button type="submit" class="btn btn-danger">Submit</button> -->
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <!-- /.tab-pane -->
                            </div>
                            <!-- /.tab-content -->
                        </div><!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php include 'include/footer.php'; ?>