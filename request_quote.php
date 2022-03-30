<?php include 'include/header.php'; ?>

<?php include 'include/aside.php'; ?>


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Request a Quote</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Request a Quote</li>
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
                <div class="col-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Request a Quote</h3>
                        </div>
                        <!-- /.card-header -->
                        <form action="#" method="post" id="request_quote_form">
                            <div class="card-body">
                                <div class="alert alert-danger alert-dismissible show fade" id="error" style="display: none;">
                                    <button class="close" data-dismiss="alert">
                                        <span>×</span>
                                    </button>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>Name <span class="text-danger">*</span></label>
                                            <input type="text" name="name" id="name" class="form-control" placeholder="John Doe">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>email <span class="text-danger">*</span></label>
                                            <input type="email" name="email" id="email" class="form-control" placeholder="johndoe@gmail.com">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>Contact No <span class="text-danger">*</span></label>
                                            <input type="tel" name="contactNo" id="contactNo" class="form-control" placeholder="+88016589***">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Company Name <span class="text-danger">*</span></label>
                                            <input type="text" name="company" id="company" class="form-control" placeholder="company Name">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Service</label>
                                            <select class="select2" multiple="multiple" name="service[]" data-placeholder="Select a service" style="width: 100%;">
                                                <?php foreach ($service as $value) : ?>
                                                    <option value="<?= $value['name'] ?>"><?= $value['name'] ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Query</label>
                                            <textarea class="form-control" name="query" rows="3" placeholder="Enter ..."></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer justify-content-between">
                                <button type="reset" class="btn btn-default" data-dismiss="modal">Reset</button>
                                <input type="submit" name="submit" value="Request Quote" id="request_quote_btn" class="btn btn-info float-right">
                            </div>
                        </form>
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