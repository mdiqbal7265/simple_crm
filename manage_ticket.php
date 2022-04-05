<?php include 'include/header.php'; ?>
<?php if($user['type'] == 2){header('Location:error.php');} ?>
<?php include 'include/aside.php'; ?>


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Manage Ticket</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Manage Ticket</li>
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
                            <h3 class="card-title">Manage Ticket</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="ticket_manage_table" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Email</th>
                                        <th>Subject</th>
                                        <th>Task Type</th>
                                        <th>Priority</th>
                                        <th>Ticket</th>
                                        <th>Post Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="ticket_manage_body">

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Email</th>
                                        <th>Subject</th>
                                        <th>Task Type</th>
                                        <th>Priority</th>
                                        <th>Ticket</th>
                                        <th>Post Date</th>
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
<div class="modal fade" id="reply_ticket_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Reply</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="post" id="remark_ticket_form">
                <div class="modal-body">
                    <div class="alert alert-danger alert-dismissible show fade" id="error" style="display: none;">
                        <button class="close" data-dismiss="alert">
                            <span>×</span>
                        </button>
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="ticket_id" value="" id="ticket_id">
                        <label>Remark Ticket</label>
                        <textarea class="form-control" name="ticket" rows="3" placeholder="Enter ..."></textarea>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
                    <input type="submit" name="submit" value="Remark Ticket" id="remark_ticket_btn" class="btn btn-info">
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- Add Branch list modal -->




<?php include 'include/footer.php'; ?>