<script>
    
/* STYLE */
function styleForMobile(){
    $(".dataTables_length select").addClass("form-control mb-2")
    $(".dataTables_filter input").addClass("form-control mb-2")
    $(".dataTables_filter input").removeClass("form-control-sm")
}
/* END STYLE */
function setDataTable(_URL,_COLUMNS, customOptions = null,afterLoad = null){
    // loadingStart();
    var loading = buildLoading();
    var options = {
        processing: true,
        serverSide: true,
        ajax: {
            url : _URL
        },
        language:{
            searchPlaceholder: "Cari",
            search: "",
            processing:`{{ __("Wait a Moment") }}....`,
            emptyTable: "{{ __('Data Not Found or Empty') }}"
        },
        order : [[1, 'desc']],
        columns: _COLUMNS,
        columnDefs: [
            {
                searchable: false,
                orderable: false,
                targets: [0,-1]
            },
        ],
        "paging": true,
        "lengthChange": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
        scrollX: true,
        scroller: true,

        preDrawCallback:function(){
            $('#datatable').find("tbody").hide();
        },
        drawCallback:function(){
            $('#datatable').find("tbody").show();
            if(afterLoad != null){
                afterLoad()
            }
            styleForMobile()
        }
    };
    if(customOptions != null){
        options = customOptions(options);
    }
    return $('#datatable').DataTable(options);
}
function setDataTableWithFooter(_URL,_COLUMNS,footerCallback = null){
    // loadingStart();
    var loading = buildLoading();

    return $('#datatable').DataTable({
        processing: true,
        serverSide: true,
        header: true,
        footer: true,
        ajax: {
            url : _URL
        },
        language:{
            searchPlaceholder: "Cari",
            search: "",
            processing:`${loading}<br> Tunggu sebentar ...`,
        },
        columns: _COLUMNS,
        columnDefs: [
            {
                searchable: false,
                orderable: false,
                targets: [0,-1]
            },
        ],
        "paging": true,
        "lengthChange": true,
        "ordering": true,
        "info": true,
        "autoWitdh": false,
        "responsive": false,
        scrollX: true,
        order: [[1, 'asc']],
        footerCallback: footerCallback,
        preDrawCallback:function(){
            $('#datatable').find("tbody").hide();
        },
        drawCallback:function(){
            console.log("aokasd");
            $('#datatable').find("tbody").show();
            styleForMobile()

        }
    });
}
function setDataTableMultiple(_TABLE,_URL,_COLUMNS){
    // loadingFormStart();
    return _TABLE.DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url : _URL
        },
        language:{
            searchPlaceholder: "Cari",
            search: "",
            emptyTable: "{{ __('Data Not Found or Empty') }}"
        },
        columns: _COLUMNS,
        columnDefs: [
            {
                searchable: false,
                orderable: false,
                targets: [0,-1]
            },
        ],
        "paging": true,
        "lengthChange": true,
        "ordering": true,
        "info": true,
        "autoWidth": true,
        "responsive": true,
        order: [[1, 'asc']],

    });
}
$.extend(false, $.fn.dataTable.defaults, {
    responsive: {
        details: {
            renderer: function ( api, rowIdx ) {
                // Select hidden columns for the given row
                var data = api.cells( rowIdx, ':hidden' ).eq(0).map( function ( cell ) {
                    var header = $( api.column( cell.column ).header() );

                    return '<tr style="border-style:hidden;">'+
                            '<th class="text-dark">'+
                                header.text()+':'+
                            '</th> '+
                            '<td>'+
                                api.cell( cell ).data()+
                            '</td>'+
                        '</tr>';
                } ).toArray().join('');

                return data ?
                    $('<table/>').append( data ) :
                    false;
            }
        }
    }
});

function iniFixedColumnDatatable(_TABLE){
    new $.fn.dataTable.FixedColumns(_TABLE, {
        rightColumns: 1 // Jumlah kolom yang ingin tetap terlihat di sebelah kanan
    });
}
function iniFixedColumnStartDatatable(_TABLE,column){
    new $.fn.dataTable.FixedColumns(_TABLE, {
        leftColumns: column // Jumlah kolom yang ingin tetap terlihat di sebelah kanan
    });
}

</script>