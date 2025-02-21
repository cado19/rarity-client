

  <!-- JQuery  -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <!-- Bootstrap 4 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- ChartJS -->

<script src="assets/chart.js/Chart.min.js"></script>

<!-- SummerNote Js -->
<script src="assets/summernote.min.js"></script>

  <!-- Sweet Alert -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.12.4/sweetalert2.min.js" integrity="sha512-w4LAuDSf1hC+8OvGX+CKTcXpW4rQdfmdD8prHuprvKv3MPhXH9LonXX9N2y1WEl2u3ZuUSumlNYHOlxkS/XEHA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- jQuery Knob Chart -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-Knob/1.2.13/jquery.knob.min.js"></script>

    <!-- daterangepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.30.1/moment.min.js"></script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>


<!-- Tempusdominus Bootstrap 4 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.39.0/js/tempusdominus-bootstrap-4.min.js" ></script>

<!-- overlayScrollbars -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/overlayscrollbars/2.10.0/browser/overlayscrollbars.browser.es6.min.js"></script>



<!-- DataTables  & Plugins -->
<script src="assets/datatables/jquery.dataTables.min.js"></script>
<script src="assets/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="assets/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="assets/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="assets/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="assets/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="assets/jszip/jszip.min.js"></script>
<script src="assets/pdfmake/pdfmake.min.js"></script>
<script src="assets/pdfmake/vfs_fonts.js"></script>
<script src="assets/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="assets/datatables-buttons/js/buttons.print.min.js"></script>
<script src="assets/datatables-buttons/js/buttons.colVis.min.js"></script>
<script src="assets/signature.js"></script>

<!-- AdminLTE App -->
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

<script src="assets/copytext.js"></script>

<!-- telephone input init script -->
<script src="assets/phone.js"></script>

<!-- Search vehicle and client in new booking  -->
<script src="assets/search_vehicle.js"></script>
<script src="assets/search_client.js"></script>

<script>
    var input = document.querySelector("#telephone");
    window.intlTelInput(input,({
      // options here
        utilsScript: 'assets/build/js/utils.js',
        customPlaceholder: function(selectedCountryPlaceholder, selectedCountryData) {
            return "e.g. " + selectedCountryPlaceholder;
        },
        hiddenInput: function(telInputName) {
            return {
                phone: "phone_full",
                country: "country_code"
            };
          }
    }));
</script>


<?php if ($page == "Client Analytics"): ?>
    <!-- profitable client chart script -->
    <script>
        const client_names = <?php echo json_encode($loaded_client_names); ?>;
        const revenue = <?php echo json_encode($loaded_clients); ?>;
        //setup block
        const data = {
            labels: client_names,
            datasets: [{
                label: 'Clients by Revenue',
                data: revenue,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)'

                ],
                borderColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)'

                ],
                borderWidth: 1
            }]
        };

        //config block
        const config = {
            type: 'bar',
            options: {
                scales: {
                    y: {beginAtZero: true}
                }
            },
            data
        };

        //render block
        const myChart = new Chart(
            document.getElementById('myChart').getContext('2d'),
            config
        );
    </script>
<?php endif;?>

<?php if ($page == "Analytics"): ?>
    <!-- 90 day income chart script -->
    <script>
        const months = <?php echo json_encode($months); ?>;
        const money =  <?php echo json_encode($money); ?>;
        //setup block
        const income_data = {
            labels: months,
            datasets: [{
                label: 'Revenue last 90 Days',
                data: money,
                backgroundColor: [
                   'rgb(139, 0, 0)',
                    'rgb(255, 215, 0)',
                    'rgb(255, 0, 255)'

                ],
                borderColor: [
                    'rgb(139, 0, 0)',
                    'rgb(255, 215, 0)',
                    'rgb(255, 0, 255)'

                ],
                borderWidth: 1
            }]
        };

        //config block
        const income_config = {
            type: 'bar',
            options: {
                scales: {
                    y: {beginAtZero: true}
                }
            },
            data: income_data
        };

        //render block
        const incomeChart = new Chart(
            document.getElementById('threeMonthChart').getContext('2d'),
            income_config
        );
    </script>


    <script>
        const vehicles = <?php echo json_encode($vehicles); ?>;
        const popularity = <?php echo json_encode($popularity); ?>;
        //setup block
        const data = {
            labels: vehicles,
            datasets: [{
                label: 'Revenue last 90 Days',
                data: popularity,
                backgroundColor: [
                    'rgb(220, 20, 60)',
                    'rgb(255, 140, 0)',
                    'rgb(255, 87, 51)',
                    'rgb(50, 117, 168)',
                    'rgb(7, 30, 48)',
                    'rgb(15, 21, 26)',

                ],
                borderColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)'

                ],
                borderWidth: 1
            }]
        };

        //config block
        const config = {
            type: 'doughnut',
            options: {
                scales: {
                    y: {beginAtZero: true}
                }
            },
            data
        };

        //render block
        const myChart = new Chart(
            document.getElementById('popularCarChart').getContext('2d'),
            config
        );
    </script>


<?php endif;?>

<?php if($page == "General Booking Stats"): ?>
        <!-- 90 day income chart script -->
    <script>
        const months = <?php echo json_encode($months); ?>;
        const money =  <?php echo json_encode($money); ?>;
        //setup block
        const income_data = {
            labels: months,
            datasets: [{
                label: 'Revenue last 90 Days',
                data: money,
                backgroundColor: [
                   'rgb(139, 0, 0)',
                    'rgb(255, 215, 0)',
                    'rgb(255, 0, 255)'

                ],
                borderColor: [
                    'rgb(139, 0, 0)',
                    'rgb(255, 215, 0)',
                    'rgb(255, 0, 255)'

                ],
                borderWidth: 1
            }]
        };

        //config block
        const income_config = {
            type: 'bar',
            options: {
                scales: {
                    y: {beginAtZero: true}
                }
            },
            data: income_data
        };

        //render block
        const incomeChart = new Chart(
            document.getElementById('threeMonthChart').getContext('2d'),
            income_config
        );
    </script>
<?php endif; ?>


<?php include_once 'config/notifications.php';?>

<script>
    $(document).ready(function() {
        //Date picker
        $('#reservationdate').datetimepicker({
            format: 'YYYY-MM-DD'
        });

        $('#enddate').datetimepicker({
            format: 'YYYY-MM-DD'
        });

        $('#extenddate').datetimepicker({
            format: 'YYYY-MM-DD'
        });
        $('#dl_expiry').datetimepicker({
            format: 'YYYY-MM-DD'
        });


       //Timepicker
        $('#starttime').datetimepicker({
          format: 'LT'
        })
        $('#endtime').datetimepicker({
          format: 'LT'
        });


        $("#example1").DataTable();

        $('#example2').DataTable({
          "paging": true,
          "lengthChange": false,
          "searching": false,
          "ordering": true,
          "info": true,
          "responsive": true,
        });
  });

  // signature javascript
  var wrapper = document.getElementById("signature-pad");
  var clearButton = wrapper.querySelector("[data-action=clear]");
  var savePNGButton = wrapper.querySelector("[data-action=save-png]");
  var canvas = wrapper.querySelector("canvas");
  var el_note = document.getElementById("note");
  var signaturePad;
  signaturePad = new SignaturePad(canvas);

  clearButton.addEventListener("click", function (event) {
      document.getElementById("note").innerHTML="The signature should be inside box";
      signaturePad.clear();
  });
  savePNGButton.addEventListener("click", function (event){
      if (signaturePad.isEmpty()){
          alert("Please provide signature first.");
          event.preventDefault();
      }else{
          var canvas  = document.getElementById("the_canvas");
          var dataUrl = canvas.toDataURL();
          document.getElementById("signature").value = dataUrl;
      }
  });
  function my_function(){
      document.getElementById("note").innerHTML="";
  }


</script>

</body>
</html>