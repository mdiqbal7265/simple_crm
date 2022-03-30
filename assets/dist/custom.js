$(document).ready(function() {
  var spinner = $("#loader");
  // toaster
  var Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 5000
  });
  //   Swal Bootstrap btn
  const swalWithBootstrapButtons = Swal.mixin({
    customClass: {
      confirmButton: "btn btn-success",
      cancelButton: "btn btn-danger"
    },
    buttonsStyling: true
  });

  // Function of Table Data Table
  function datatable(id) {
    $(id)
      .DataTable({
        responsive: true,
        lengthChange: false,
        autoWidth: false,
        retrieve: true,
        paging: true,
        buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"]
      })
      .buttons()
      .container()
      .appendTo(id + "_wrapper .col-md-6:eq(0)");
  }

  // Delete Function
  function deleteData(action, id, fetchFunction) {
    swalWithBootstrapButtons
      .fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "No, cancel!",
        reverseButtons: true
      })
      .then(result => {
        if (result.isConfirmed) {
          $.ajax({
            type: "POST",
            url: "lib/action.php",
            data: { action: action, id: id },
            success: function(response) {
              swalWithBootstrapButtons.fire(
                "Deleted!",
                "Your file has been deleted.",
                "success"
              );
              fetchFunction();
            }
          });
        } else if (
          /* Read more about handling dismissals below */
          result.dismiss === Swal.DismissReason.cancel
        ) {
          swalWithBootstrapButtons.fire(
            "Cancelled",
            "Your imaginary file is safe :)",
            "error"
          );
        }
      });
  }

  // Logout Ajax request
  $("#logout").click(function(e) {
    e.preventDefault();
    $.ajax({
      type: "POST",
      url: "lib/action.php",
      data: { action: "logout" },
      success: function(response) {
        if (response == "logout") {
          Toast.fire({
            icon: "success",
            title: "Logout Successfully!"
          });
          setTimeout(() => {
            window.location = "index.php";
          }, 2000);
        }
      }
    });
  });

  // Fetch User List
  fetchUser();
  function fetchUser() {
    $.ajax({
      type: "POST",
      url: "lib/action.php",
      data: { action: "fetchUser" },
      success: function(response) {
        $("#user_list_body").html(response);
        datatable("#user_list_table");
      }
    });
  }

  // View User By Id
  $("body").on("click", ".viewUser", function() {
    id = $(this).attr("id");
    $.ajax({
      type: "POST",
      url: "lib/action.php",
      data: { action: "viewUser", id: id },
      success: function(response) {
        data = JSON.parse(response);
        $("#userName").text(data.name);
        $("#userEmail").text(data.email);
        $("#user_alt_email").text(data.alt_email);
        $("#userMobile").text(data.mobile);
        data.gender == "m"
          ? $("#userGender").text("Male")
          : $("#userGender").text("Female");
        $("#userAddress").text(data.address);
        data.status == "1"
          ? $("#userStatus").html(
              '<span class="badge badge-success">Verified</span>'
            )
          : $("#userStatus").html(
              '<span class="badge badge-danger">UnVerified</span>'
            );

        $("#user_registration_date").text(data.posting_date);
      }
    });
  });

  // Edit User By Id
  $("body").on("click", ".editUser", function(e) {
    e.preventDefault();
    id = $(this).attr("id");
    $.ajax({
      type: "POSt",
      url: "lib/action.php",
      data: { action: "editUser", id: id },
      success: function(response) {
        data = JSON.parse(response);
        $("#user_id").val(data.id);
        $("#name").val(data.name);
        $("#address").val(data.address);
        $("#email").val(data.email);
        $("#alt_email").val(data.alt_email);
        $("#mobile").val(data.mobile);
        $('#gender option[value="' + data.gender + '"]').prop("selected", true);
        if (data.status == 1) {
          $("#customCheckbox4").prop("checked", true);
        }
      }
    });
  });

  // Update User By Id
  $("#edit_user_btn").click(function(e) {
    e.preventDefault();
    $("#edit_user_btn").val("Please Wait...");
    $.ajax({
      type: "POST",
      url: "lib/action.php",
      data: $("#edit_user_form").serialize() + "&action=update_user",
      success: function(response) {
        $("#edit_user_btn").val("Update User");
        $("#edit_user_form")[0].reset();
        if (response == "success") {
          $("#edit_user_modal").modal("hide");
          Toast.fire({
            icon: "success",
            title: "User Updated Successfully!"
          });
        } else if (response == "error") {
          $("#edit_user_modal").modal("hide");
          Toast.fire({
            icon: "error",
            title: "Something went wrong. Please try again!"
          });
        } else {
          $("#error").show();
          $("#error").html(response);
        }
        fetchUser();
      }
    });
  });

  // Delete User By Id
  $("body").on("click", ".dltUser", function(e) {
    e.preventDefault();
    id = $(this).attr("id");
    deleteData("dltUser", id, fetchUser);
  });

  // Fetch Service
  fetchService();
  function fetchService() {
    $.ajax({
      type: "POST",
      url: "lib/action.php",
      data: { action: "fetchService" },
      success: function(response) {
        $("#service_list_body").html(response);
        datatable("#service_list_table");
      }
    });
  }

  // Add Service
  $("#add_service_btn").click(function(e) {
    e.preventDefault();
    $("#add_service_btn").val("Please Wait...");
    $.ajax({
      type: "POST",
      url: "lib/action.php",
      data: $("#add_service_form").serialize() + "&action=add_service",
      success: function(response) {
        $("#add_service_btn").val("Add Service");
        $("#add_service_form")[0].reset();
        Toast.fire({
          icon: "success",
          title: "Service Added Successfully!"
        });

        fetchService();
      }
    });
  });

  // Edit Service
  $("body").on("click", ".editService", function(e) {
    e.preventDefault();
    $("#add_form").hide();
    $("#update_form").show();
    id = $(this).attr("id");
    $.ajax({
      type: "POSt",
      url: "lib/action.php",
      data: { action: "editService", id: id },
      success: function(response) {
        data = JSON.parse(response);
        $("#service_id").val(data.id);
        $("#name").val(data.name);
      }
    });
  });

  $("#service_cancel").click(function(e) {
    e.preventDefault();
    $("#update_form").hide();
    $("#add_form").show();
  });

  // Update Service By Id
  $("#edit_service_btn").click(function(e) {
    e.preventDefault();
    $("#edit_service_btn").val("Please Wait...");
    $.ajax({
      type: "POST",
      url: "lib/action.php",
      data: $("#update_service_form").serialize() + "&action=update_service",
      success: function(response) {
        $("#edit_service_btn").val("Update Service");
        $("#update_service_form")[0].reset();
        $("#update_form").hide();
        $("#add_form").show();
        Toast.fire({
          icon: "success",
          title: "Service Updated Successfully!"
        });
        fetchService();
      }
    });
  });

  // Delete Service By id
  $("body").on("click", ".dltService", function(e) {
    e.preventDefault();
    id = $(this).attr("id");
    deleteData("dltService", id, fetchService);
  });

  // Request a Quote
  $("#request_quote_btn").click(function(e) {
    e.preventDefault();
    $("#request_quote_btn").val("Please wait...");
    $.ajax({
      type: "POST",
      url: "lib/action.php",
      data: $("#request_quote_form").serialize() + "&action=request_quote",
      success: function(response) {
        $("#request_quote_btn").val("Request Quote");
        $("#request_quote_form")[0].reset();
        if (response == "success") {
          Toast.fire({
            icon: "success",
            title:
              "Your Request sent successfully. We will reply soon in your registered email!"
          });
        } else if (response == "error") {
          Toast.fire({
            icon: "error",
            title: "Something went wrong. Please try again!"
          });
        } else {
          $("#error").show();
          $("#error").html(response);
        }
      }
    });
  });

  // Fetch Ticket
  fetchTicket();
  function fetchTicket() {
    $.ajax({
      type: "POST",
      url: "lib/action.php",
      data: { action: "fetchTicket" },
      success: function(response) {
        $("#ticket_list_body").html(response);
        datatable("#ticket_list_table");
      }
    });
  }

  // Add Ticket
  $("#add_ticket_btn").click(function(e) {
    e.preventDefault();
    $("#add_ticket_btn").val("Please wait...");
    $.ajax({
      type: "POST",
      url: "lib/action.php",
      data: $("#add_ticket_form").serialize() + "&action=add_ticket",
      success: function(response) {
        $("#add_ticket_btn").val("Request Quote");
        $("#add_ticket_form")[0].reset();
        if (response == "success") {
          $("#add_ticket_modal").modal("hide");
          Toast.fire({
            icon: "success",
            title: "Your Ticket sent successfully. We will reply soon!"
          });
        } else if (response == "error") {
          $("#add_ticket_modal").modal("hide");
          Toast.fire({
            icon: "error",
            title: "Something went wrong. Please try again!"
          });
        } else {
          $("#error").show();
          $("#error").html(response);
        }

        fetchTicket();
      }
    });
  });

  // Fetch Manage Ticket For Admin
  fetchTicketForManage();
  function fetchTicketForManage() {
    $.ajax({
      type: "POST",
      url: "lib/action.php",
      data: { action: "fetchTicketForManage" },
      success: function(response) {
        $("#ticket_manage_body").html(response);
        datatable("#ticket_manage_table");
      }
    });
  }

  // Admin Remark Ticket
  $("body").on("click", ".remarkTicket", function(e) {
    e.preventDefault();
    id = $(this).attr("id");
    $("#ticket_id").val(id);
  });

  // Admin Remark Ticket By Id
  $("#remark_ticket_btn").click(function(e) {
    e.preventDefault();
    $("#remark_ticket_btn").val("Please wait...");
    $.ajax({
      type: "POST",
      url: "lib/action.php",
      data: $("#remark_ticket_form").serialize() + "&action=remark_ticket",
      success: function(response) {
        $("#remark_ticket_btn").val("Request Quote");
        $("#remark_ticket_form")[0].reset();
        if (response == "success") {
          $("#reply_ticket_modal").modal("hide");
          Toast.fire({
            icon: "success",
            title: "Ticket Remark successfully..!"
          });
        } else if (response == "error") {
          $("#reply_ticket_modal").modal("hide");
          Toast.fire({
            icon: "error",
            title: "Something went wrong. Please try again!"
          });
        } else {
          $("#error").show();
          $("#error").html(response);
        }

        fetchTicketForManage();
        // console.log(response);
      }
    });
  });

  // Fetch quote for manage by admin
  fetchQuoteForManage();
  function fetchQuoteForManage() {
    $.ajax({
      type: "POST",
      url: "lib/action.php",
      data: { action: "fetchQuoteForManage" },
      success: function(response) {
        $("#quote_manage_body").html(response);
        datatable("#quote_manage_table");
      }
    });
  }

  // View Quote
  $("body").on("click", ".viewQuote", function(e) {
    e.preventDefault();
    id = $(this).attr("id");
    $.ajax({
      type: "POSt",
      url: "lib/action.php",
      data: { action: "viewQuote", id: id },
      success: function(response) {
        data = JSON.parse(response);
        // $("#service_id").val(data.id);
        $("#name").text(data.name);
        $("#email").text(data.email);
        $("#contact").text(data.contactno);
        $("#company").text(data.company);
        $("#service").text(data.service_id);
        $("#query").text(data.query);
        $("#date").text(data.posting_date);
        $("#id").val(data.id);
        $("#email_id").val(data.email);
        // console.log(data);
      }
    });
  });

  // Admin Remark Quote By Id
  $("#admin_remark_btn").click(function(e) {
    e.preventDefault();
    $("#admin_remark_btn").val("Please wait...");
    spinner.show();
    $.ajax({
      type: "POST",
      url: "lib/action.php",
      data: $("#admin_remark_form").serialize() + "&action=remark_quote",
      success: function(response) {
        $("#admin_remark_btn").val("Request Quote");
        $("#admin_remark_form")[0].reset();
        if (response == "success") {
          $("#manage_quote_modal").modal("hide");
          Toast.fire({
            icon: "success",
            title: "Quote Remark successfully..!"
          });
        } else if (response == "error") {
          $("#manage_quote_modal").modal("hide");
          Toast.fire({
            icon: "error",
            title: "Something went wrong. Please try again!"
          });
        } else {
          $("#error").show();
          $("#error").html(response);
        }
        spinner.hide();
        fetchQuoteForManage();
        // console.log(response);
      }
    });
  });

  // View Remark Ticket
  $("body").on("click", ".viewRemarkTicket", function(e) {
    e.preventDefault();
    id = $(this).attr("id");
    $.ajax({
      type: "POSt",
      url: "lib/action.php",
      data: { action: "viewRemarkTicket", id: id },
      success: function(response) {
        data = JSON.parse(response);
        $("#remark_ticket").text(data.admin_remark);
        $("#remark_date").text(data.admin_remark_date);
      }
    });
  });
});
