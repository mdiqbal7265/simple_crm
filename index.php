<?php

session_start();
if(isset($_SESSION['email'])){
  header('location: dashboard.php');
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login || CRM</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="assets/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="assets/dist/css/adminlte.min.css">
</head>

<body class="hold-transition login-page">
  <div class="login-box">
    <!-- /.login-logo -->
    <div class="card card-outline card-primary">
      <div class="card-header text-center">
        <a href="index.php" class="h1"><b>CUSTOMER</b>RM</a>
      </div>
      <div class="card-body">
        <p class="login-box-msg">Sign in to start your session</p>
        <div class="alert alert-danger alert-dismissible show fade" id="error" style="display: none;">
          <button class="close" data-dismiss="alert">
            <span>×</span>
          </button>
        </div>

        <form action="" method="post" id="login_form">
          <div class="input-group mb-3">
            <input type="email" class="form-control" name="email" placeholder="Email">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" name="password" placeholder="Password">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-8">
              <div class="icheck-primary">
                <input type="checkbox" name="rem" id="remember">
                <label for="remember">
                  Remember Me
                </label>
              </div>
            </div>
            <!-- /.col -->
            <div class="col-4">
              <input type="submit" name="login" class="btn btn-primary btn-block" value="Sign In" id="login_btn">
              <!-- <button type="submit" class="btn btn-primary btn-block">Sign In</button> -->
            </div>
            <!-- /.col -->
          </div>
        </form>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
  <!-- /.login-box -->

  <!-- jQuery -->
  <script src="assets/plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- SweetAlert2 -->
  <script src="assets/plugins/sweetalert2/sweetalert2.min.js"></script>
  <!-- AdminLTE App -->
  <script src="assets/dist/js/adminlte.min.js"></script>
  <script>
    /***** Admin Login Button */
    $(function() {
      var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 5000
      });
      $("#login_btn").click(function(e) {
        e.preventDefault();
        $("#login_btn").val('Please Wait...');
        $.ajax({
          type: "POST",
          url: "lib/action.php",
          data: $("#login_form").serialize() + '&action=login',
          success: function(response) {
            $("#login_btn").val("Login");
            $("#login_form")[0].reset()
            if (response == "login") {
              $("#error").hide();
              Toast.fire({
                icon: 'success',
                title: 'Login Successfully. Please Wait. We will redirect you to dashboard!'
              });
              setTimeout(() => {
                window.location = 'dashboard.php';
              }, 2000);
            } else if (response == 'password_not_matched') {
              $("#error").hide();
              Toast.fire({
                icon: 'error',
                title: 'Password didn\'t match. Please try again!'
              });
            } else if (response == 'data_not_found') {
              $("#error").hide();
              Toast.fire({
                icon: 'error',
                title: 'Your Email Address not found in our database!'
              });
            } else {
              $("#error").show();
              $("#error").html(response);
            }
          }
        });
      });
    });
  </script>
</body>

</html>