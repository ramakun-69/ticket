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
@widget('modal',["title"=>__('IT Asset'),"form"=>"pages.master-data.it-asset.form", 'data' =>['pic' => $pic], "type" => "" ])
@widget('delete', ["dt" =>true])
@endsection
@push('datatable')
<script>
    var _URL = "{{ route('datatable.mIt-asset') }}";
    var _COLUMNS = [
      {'title' : 'No','data' : 'DT_RowIndex', 'orderable': false ,'searchable': false},
      {'title' : '{{ __("Code") }}','data' : 'code', 'name' : 'code'},
      {'title' : '{{ __("Name") }}','data' : 'name', 'name' : 'name'},
      {
        'title' : '{{ __("Category") }}',
        'data' : 'category',
        'name' : 'category',
        'render': function(data, type, full, meta) {
            return data.charAt(0).toUpperCase() + data.slice(1);
        }
    },
      {'title' : '{{ __("PIC") }}','data' : 'pic'},
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
    var _URL_INSERT = "{{ route('master-data.it-assets.store') }}";
    // var _TITLE_MODAL_UPDATE = "{{ __('Edit')." ". __('Location') }}"
    function attactEdit(modal,response){
    //   modal.find(".modal-title").text(_TITLE_MODAL_UPDATE);
      modal.find("input[name=id]").val(response.data.id);
      modal.find("input[name=code]").val(response.data.code);
      modal.find("input[name=name]").val(response.data.name);
      modal.find("select[name=category]").val(response.data.category);
      modal.find("select[name=user_id]").val(response.data.user_id);
  }
    $("#btn-submit").click(function(e){
      e.preventDefault();
      saveForm($('#form-it-asset'),_URL_INSERT, $('#modalForm'));
    });
</script>
@endpush