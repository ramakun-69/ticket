@extends('layouts.app', ["dt"=> true])
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-3">{{ $title }}</h4>
                
               <div class="row mb-3">
                   <div class="col-12 text-end">
                       <button class="btn btn-danger  btn-xs" data-bs-toggle="modal" data-bs-target="#modalForm">+ {{ __('Create Support Ticket') }}</button>
                   </div>
               </div>
              
                <div class="table-responsive">
                    <table  class="table table-responsive table-striped" id="datatable">
                    </table>
                </div>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>
@widget('modal',["title"=>__('Support Ticket'),"form"=>"pages.ticket.form", 'data' =>["productionAssets" => $productionAssets, "itAssets"=>$itAssets, "technician" => $technician], "type" => "modal-xl  modal-dialog-scrollable" ])
@widget('delete', ["dt" =>true])
@endsection
@push('datatable')
<script>
    var _URL = "{{ route('datatable.myTicket') }}";
    var _COLUMNS = [
      {'title' : 'No','data' : 'DT_RowIndex', 'orderable': false ,'searchable': false},
      {'title' : '{{ __("Ticket Number") }}','data' : 'ticket_number'},
      {'title' : '{{ __("Name") }}','data' : 'user.name'},
      {'title' : '{{ __("Asset Name") }}','data' : 'asset.name'},
      {'title' : '{{ __("Type") }}','data' : 'type'},
      {'title' : '{{ __("Status") }}','data' : 'status'},
      {
          'title' : '{{ __("Action") }}',
          'data' : 'action',
      },
  ];
    var _DATATABLE = setDataTable(_URL,_COLUMNS); 
  </script>
@endpush
@push('js')
<script>
    var _URL_INSERT = "{{ route('ticket.store') }}";
    var _TITLE_MODAL_UPDATE = `{{ __('Confirm') }} `+_TITLE_PAGE;
    $("#btn-submit").click(function(e){
      e.preventDefault();
      saveForm($('#form-ticket'),_URL_INSERT, $('#modalForm'));
    });
</script>
@endpush