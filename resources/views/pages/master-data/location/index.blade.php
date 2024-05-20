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
@widget('modal',["title"=>__('Location'),"form"=>"pages.master-data.location.form", 'data' =>[], "type" => "" ])
@widget('delete', ["dt" =>true])
@endsection
@push('datatable')
<script>
    var _URL = "{{ route('datatable.mLocation') }}";
    var _COLUMNS = [
      {'title' : 'No','data' : 'DT_RowIndex', 'orderable': false ,'searchable': false},
      {'title' : '{{ __("Name") }}','data' : 'name', 'name' : 'name'},
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
    var _URL_INSERT = "{{ route('master-data.location.store') }}";
    // var _TITLE_MODAL_UPDATE = "{{ __('Edit')." ". __('Location') }}"
    function attactEdit(modal,response){
    //   modal.find(".modal-title").text(_TITLE_MODAL_UPDATE);
      modal.find("input[name=id]").val(response.data.id);
      modal.find("input[name=name]").val(response.data.name);
  }
    $("#btn-submit").click(function(e){
      e.preventDefault();
      saveForm($('#form-location'),_URL_INSERT, $('#modalForm'));
    });
</script>
@endpush