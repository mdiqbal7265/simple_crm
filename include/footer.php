       <!-- Main Footer -->
       <footer class="main-footer">
           <!-- To the right -->
           <div class="float-right d-none d-sm-inline">
               Anything you want
           </div>
           <!-- Default to the left -->
           <strong>Copyright &copy; <?= date('Y'); ?> <a href="https://csediary.xyz">Developed By Md Iqbal</a>.</strong> All rights reserved.
       </footer>
       </div>
       <!-- ./wrapper -->

       <!-- REQUIRED SCRIPTS -->

       <!-- jQuery -->
       <script src="assets/plugins/jquery/jquery.min.js"></script>
       <!-- Bootstrap 4 -->
       <script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
       <!-- ChartJS -->
       <script src="assets/plugins/chart.js/Chart.min.js"></script>
       <!-- SweetAlert2 -->
       <script src="assets/plugins/sweetalert2/sweetalert2.min.js"></script>
       <!-- DataTables  & Plugins -->
       <script src="assets/plugins/datatables/jquery.dataTables.min.js"></script>
       <script src="assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
       <script src="assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
       <script src="assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
       <script src="assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
       <script src="assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
       <script src="assets/plugins/jszip/jszip.min.js"></script>
       <script src="assets/plugins/pdfmake/pdfmake.min.js"></script>
       <script src="assets/plugins/pdfmake/vfs_fonts.js"></script>
       <script src="assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
       <script src="assets/plugins/datatables-buttons/js/buttons.print.min.js"></script>
       <script src="assets/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
       <!-- Switch Toggle -->
       <script src="assets/plugins/bootstrap4-toggle/js/bootstrap4-toggle.min.js"></script>
       <!-- Select2 -->
       <script src="assets/plugins/select2/js/select2.full.min.js"></script>
       <!-- AdminLTE App -->
       <script src="assets/dist/js/adminlte.min.js"></script>
       <script src="assets/dist/custom.js"></script>
       <script>
           $('.select2').select2();
           $(".switch-toggle").bootstrapToggle();
           $(function() {
               // Get context with jQuery - using jQuery's .get() method.
               var areaChartCanvas = $('#areaChart').get(0).getContext('2d')

               var areaChartData = {
                   labels: [<?= $month_label; ?>],
                   datasets: [{
                           label: 'User Visitor Statics',
                           backgroundColor: 'rgba(60,141,188,0.9)',
                           borderColor: 'rgba(60,141,188,0.8)',
                           pointRadius: false,
                           pointColor: '#3b8bba',
                           pointStrokeColor: 'rgba(60,141,188,1)',
                           pointHighlightFill: '#fff',
                           pointHighlightStroke: 'rgba(60,141,188,1)',
                           data: [<?= $total_label; ?>]
                       },
                   ]
               }

               var areaChartOptions = {
                   maintainAspectRatio: false,
                   responsive: true,
                   legend: {
                       display: false
                   },
                   scales: {
                       xAxes: [{
                           gridLines: {
                               display: false,
                           }
                       }],
                       yAxes: [{
                           gridLines: {
                               display: false,
                           }
                       }]
                   }
               }

               // This will get the first returned node in the jQuery collection.
               new Chart(areaChartCanvas, {
                   type: 'line',
                   data: areaChartData,
                   options: areaChartOptions
               })

           });
       </script>
       </body>

       </html>