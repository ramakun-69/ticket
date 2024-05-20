@push('datatable')
<script>
 function ReportDataTable(response, afterLoad = null) {
    if ($.fn.DataTable.isDataTable('#report-table')) {
        $('#report-table').DataTable().destroy();
    }
    var loading = buildLoading();
    var dataTable = $('#report-table').DataTable({
        processing: true,
        serverSide: false,
        data : response.data,
        order: [[1, 'asc']],
        columns: [
            {'title' : 'No','data' : 'DT_RowIndex', 'orderable': false ,'searchable': false},
            {'title' : '{{ __("Ticket Number") }}','data' : 'ticket_number'},
            {'title' : '{{ __("Name") }}','data' : 'user.name'},
            {'title' : '{{ __("Asset Name") }}','data' : 'asset.name'},
            {'title' : '{{ __("Type") }}','data' : 'type'},
            {'title' : '{{ __("Status") }}','data' : 'status'},
        ],
        columnDefs: [
            {
                targets: [0, -1],
                searchable: false,
                orderable: false
            }
        ],
        paging: true,
        lengthChange: true,
        ordering: true,
        info: true,
        autoWidth: true,
        responsive: true,
        scrollX: true,
        scroller: true,
        preDrawCallback: function () {
            $('#report-table').find("tbody").hide();
        },
        drawCallback: function () {
            $('#report-table').find("tbody").show();
            if (afterLoad !== null) {
                afterLoad();
            }
            styleForMobile();
        }
    });

    return dataTable;
}

</script>
@endpush