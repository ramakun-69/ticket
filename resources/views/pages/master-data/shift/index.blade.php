@extends('layouts.app', ["dt"=> true])
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-3">{{ $title }}</h4>
                <div class="row mb-3">
                    <div class="col-12 text-end">
                        <button class="btn btn-danger  btn-xs" data-bs-toggle="modal" data-bs-target="#modalForm">+ {{ __('Add') }}</button>
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
@widget('modal',["title"=>__('Shift'),"form"=>"pages.master-data.shift.form", 'data' =>[], "type" => "" ])
@widget('delete', ["dt" =>true])
@endsection
@push('datatable')
<script>
    var _URL = "{{ route('datatable.mShift') }}";
    var _COLUMNS = [
      {'title' : 'No','data' : 'DT_RowIndex', 'orderable': false ,'searchable': false},
      {'title' : '{{ __("Shift") }}','data' : 'name', 'name' : 'name'},
      {'title' : '{{ __("Time") }}',   'data': 'time'},
      {
          'title' : '{{ __("Action") }}',
          'data' : 'action',
      },
  ];
    // var _WAITING = "__('Wait a Moment')";
    var _DATATABLE = setDataTable(_URL,_COLUMNS); 
  </script>
@endpush
@push('js')
<script>
    var _URL_INSERT = "{{ route('master-data.shift.store') }}";
    function attactEdit(modal,response){
      modal.find("input[name=id]").val(response.data.id);
      modal.find("input[name=name]").val(response.data.name);
      modal.find("input[name=start_time]").val(response.data.start_time);
      modal.find("input[name=end_time]").val(response.data.end_time);
  }
    $("#btn-submit").click(function(e){
      e.preventDefault();
      saveForm($('#form-shift'),_URL_INSERT, $('#modalForm'));
    });
</script>
@endpush