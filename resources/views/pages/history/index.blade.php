@extends('layouts.app', ["dt"=> true])
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-3">{{ $title }}</h4>
                
                <div class="table-responsive">
                    <table  class="table table-responsive table-striped" id="datatable">
                    </table>
                </div>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>
@endsection
@push('datatable')
<script>
    var _URL = "{{ route('datatable.history') }}";
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