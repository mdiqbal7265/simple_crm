$(document).ready(function() {
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

});
