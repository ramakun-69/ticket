<!-- JAVASCRIPT -->
<script src="{{ URL::asset('libs/jquery/jquery.min.js') }}"></script>
<script src="{{ URL::asset('libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ URL::asset('libs/metismenu/metisMenu.min.js') }}"></script>
<script src="{{ URL::asset('libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ URL::asset('libs/node-waves/waves.min.js') }}"></script>
<!-- Icon -->
<script src="https://unicons.iconscout.com/release/v2.0.1/script/monochrome/bundle.js"></script>
<!-- Sweetalert 2 -->
<script src="{{ URL::asset('libs/sweetalert2/sweetalert2.min.js') }}"></script>
<!-- Datepicker -->
<script src="{{ asset('libs/flatpickr/dist/flatpickr.min.js') }}"></script>
<!-- Izitost -->
<script src="{{ URL::asset('libs/iziToast/iziToast.min.js') }}"></script>
<!-- Jquery Confirm -->
<script src="{{ asset('libs/jquery-confirm/jquery-confirm.min.js') }}"></script>
<!-- Select 2 -->
<script src="{{ asset('libs/select2/js/select2.min.js') }}"></script>
<script src="{{ asset('js/pages/select2.init.js') }}"></script>
@if (isset($dt))
    <script src="{{ asset('libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('libs/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('libs/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('libs/datatables.net-buttons-bs5/js/buttons.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('libs/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('libs/datatables.net-buttons/js/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('libs/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('libs/datatables.net-keytable/js/dataTables.keyTable.min.js') }}"></script>
    <script src="{{ asset('libs/datatables.net-select/js/dataTables.select.min.js') }}"></script>
    <script src="{{ URL::asset('libs/jszip/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('libs/pdfmake/build/pdfmake.min.js') }}"></script>
    <script src="{{ URL::asset('libs/pdfmake/build/vfs_fonts.js') }}"></script>

    @widget('datatable')
@endif
<!-- App js -->
<script src="{{ URL::asset('js/app.js') }}"></script>
<script src="{{ asset('js/support/mask-input.min.js') }}"></script>
<script src="{{ asset('js/support/moment.min.js') }}"></script>
<script src="{{ asset('js/support/loading.js') }}"></script>
<script src="{{ asset('js/support/custom.js') }}"></script>
<script src="{{ asset('js/support/save.js') }}"></script>
<script>
    $('.rupiah').mask("#.##0", {
        reverse: true
    });
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
    });
    moment.locale('id');
    var form = $('#logout-form');
    $('#logout').on('click', function(e) {
        e.preventDefault(); // Mencegah pengiriman formulir standar
        // console.log('test');
        $.confirm({
            title: '<label class="text-dark">{{ __('Logout') }}</label>',
            content: '<label class="text-dark">{{ __('Confirm Logout') }}</label>',
            buttons: {
                confirm: {
                    text: '{{ __('Sure') }}',
                    btnClass: 'btn-danger',
                    action: function() {
                        form.submit();
                        return;
                    }
                },
                cancel: {
                    text: '{{ __('No') }}',
                    action: function() {
                        return;
                    }
                }
            }
        });
    });

    function realClock() {
        const now = new Date();
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');
        const time = `${hours}:${minutes}:${seconds}`;

        $("#clock").text(time);
        $("#clock").removeClass('d-none');
    }
    setInterval(realClock, 1000);
    realClock();
</script>
@stack('datatable')
@stack('js')
@vite('resources/js/app.js')