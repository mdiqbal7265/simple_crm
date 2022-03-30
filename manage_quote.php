<?php include 'include/header.php'; ?>

<?php include 'include/aside.php'; ?>


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Manage Quote</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Manage Quote</li>
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
                            <h3 class="card-title">Manage Quote</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="quote_manage_table" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Contact No</th>
                                        <th>Service</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="quote_manage_body">

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Contact No</th>
                                        <th>Service</th>
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

<!-- Add Branch List Modal -->
<div class="modal fade" id="manage_quote_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">View Quote</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="callout callout-info">
                    <h5>View Quote and Reply Quote</h5>

                    <p><strong>Name: </strong> <span class="font-weight-bold" id="name"></span></p>
                    <p><strong>Email: </strong> <span class="font-weight-bold" id="email"></span></p>
                    <p><strong>Contact: </strong> <span class="font-weight-bold" id="contact"></span></p>
                    <p><strong>Company: </strong> <span class="font-weight-bold" id="company"></span></p>
                    <p><strong>Service: </strong> <span class="font-weight-bold" id="service"></span></p>
                    <p><strong>Query: </strong> <span class="font-weight-bold" id="query"></span></p>
                    <p><strong>Posting Date: </strong> <span class="font-weight-bold" id="date"></span></p>
                </div>
                <form action="#" method="post" id="admin_remark_form">
                    <div class="form-group">
                        <input type="hidden" name="id" id="id" value="">
                        <input type="hidden" name="email_id" id="email_id" value="">
                        <label>Remark</label>
                        <textarea class="form-control" name="remark" rows="3" placeholder="Enter ..."></textarea>
                    </div>
                    <div class="form-group">
                        <input type="submit" value="Remark Quote" class="btn btn-success" id="admin_remark_btn">
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- Add Branch list modal -->




<?php include 'include/footer.php'; ?>