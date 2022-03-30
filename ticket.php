<?php include 'include/header.php'; ?>

<?php include 'include/aside.php'; ?>


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Ticket List</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Ticket List</li>
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
                            <h3 class="card-title">Ticket List</h3>
                            <a href="#" class="btn btn-outline-info float-right" data-toggle="modal" data-target="#add_ticket_modal"><i class="fa fa-plus-circle"></i>&nbsp;Create New Ticket</a>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="ticket_list_table" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Email</th>
                                        <th>Subject</th>
                                        <th>Task Type</th>
                                        <th>Priority</th>
                                        <th>Ticket</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="ticket_list_body">

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Email</th>
                                        <th>Subject</th>
                                        <th>Task Type</th>
                                        <th>Priority</th>
                                        <th>Ticket</th>
                                        <th>Status</th>
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
<div class="modal fade" id="view_ticket_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Reply</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger alert-dismissible show fade" id="error" style="display: none;">
                    <button class="close" data-dismiss="alert">
                        <span>×</span>
                    </button>
                </div>
                <div class="callout callout-info">
                    <h5>Admin Remark Ticket</h5>
                    <hr>

                    <p id="remark_ticket"></p>
                    <p>Remark Date:- <strong id="remark_date" class="font-weight-bold"></strong></p> 
                </div>
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