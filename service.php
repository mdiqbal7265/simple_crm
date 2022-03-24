<?php include 'include/header.php'; ?>

<?php include 'include/aside.php'; ?>


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Service List</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Service List</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- Add Service -->
                <div class="col-4" id="add_form">
                    <div class="card card-info card-outline">
                        <div class="card-header">
                            <h3>Add Service</h3>
                        </div>
                        <form action="#" method="post" id="add_service_form">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" class="form-control" placeholder="Enter service name">
                                </div>
                            </div>
                            <div class="card-footer">
                                <input type="submit" value="Add" class="btn btn-primary float-right" id="add_service_btn">
                                <!-- <button type="submit" class="btn btn-primary">Submit</button> -->
                            </div>
                        </form>
                    </div>
                </div>
                <!-- Update Service -->
                <div class="col-4" style="display: none;" id="update_form">
                    <div class="card card-info card-outline">
                        <div class="card-header">
                            <h3>Update Service</h3>
                        </div>
                        <form action="#" method="post" id="update_service_form">
                            <div class="card-body">
                                <div class="form-group">
                                    <input type="hidden" name="id" id="service_id" value="">
                                    <label for="name">Name</label>
                                    <input type="email" name="name" class="form-control" id="name" placeholder="Enter service name">
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="button" class="btn btn-danger" id="service_cancel">Cancel</button>
                                <input type="submit" value="Update" class="btn btn-primary float-right" id="edit_service_btn">
                                <!-- <button type="submit" class="btn btn-primary">Submit</button> -->
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-8">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Service List</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="service_list_table" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Created Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="service_list_body">

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Created Date</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->




<?php include 'include/footer.php'; ?>