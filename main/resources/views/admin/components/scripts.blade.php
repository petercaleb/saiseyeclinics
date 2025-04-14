 <!-- jQuery -->
 <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
 <!-- Bootstrap -->
 <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
 <!-- SweetAlert2 -->
 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.20/dist/sweetalert2.all.min.js"></script>
 <!-- Toastr -->
 <script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
 <!-- DataTables -->
 <!-- DataTables  & Plugins -->
 <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
 <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
 <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
 <script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
 <script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
 <script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
 <script src="{{ asset('plugins/jszip/jszip.min.js') }}"></script>
 <script src="{{ asset('plugins/pdfmake/pdfmake.min.js') }}"></script>
 <script src="{{ asset('plugins/pdfmake/vfs_fonts.js') }}"></script>
 <script src="{{ asset('plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
 <script src="{{ asset('plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
 <script src="{{ asset('plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
 <!-- Select2 -->
 <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>

 <!-- Bootstrap4 Duallistbox -->
 <script src="{{ asset('plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js') }}"></script>

 <!-- InputMask -->
 <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
 <script src="{{ asset('plugins/inputmask/jquery.inputmask.min.js') }}"></script>


 <!-- Tempusdominus Bootstrap 4 -->
 {{-- <script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script> --}}
 <!-- Bootstrap Switch -->
 <script src="{{ asset('plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}"></script>

 <!-- date-range-picker -->
 <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
 <!-- bs-custom-file-input -->
 <script src="{{ asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
 <!-- AdminLTE -->
 <script src="{{ asset('js/adminlte.js') }}"></script>

 <!-- OPTIONAL SCRIPTS -->
 <script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
 <script src="{{ asset('js/demo.js') }}"></script>
 <script>
     $(document).ready(function() {
         bsCustomFileInput.init();
         //Initialize Select2 Elements
         $('.select2').select2()
         //Date picker
         $('.datepicker').datepicker({
             format: 'yyyy-mm-dd',
             autoclose: true,
             todayHighlight: true,
         });

         $("input[data-bootstrap-switch]").each(function() {
             $(this).bootstrapSwitch('state', $(this).prop('checked'));
         });

         $('[data-mask]').inputmask();

     });
 </script>
