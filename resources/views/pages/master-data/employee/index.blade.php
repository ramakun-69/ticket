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
                    <table  class="table table-striped" id="datatable">
                    </table>
                </div>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>
@widget('modal',["title"=>__('employee'),"form"=>"pages.master-data.employee.form", 'data' =>['department'=> $department, 'shifts' => $shifts], "type" => "modal-lg" ])
@widget('delete', ["dt" =>true])
@endsection
@push('datatable')
<script>
    var _URL = "{{ route('datatable.mPegawai') }}";
    var _COLUMNS = [
      {'title' : 'No','data' : 'DT_RowIndex', 'orderable': false ,'searchable': false},
      {'title' : '{{ __("Photo") }}','data' : 'foto','name' : null,'orderable': false ,'searchable': false,
       'render': function(data)
       {
            return ` <div class="rounded-circle m-auto bg-dark overflow-hidden" style="width: 3rem;height: 3rem;">
                                    <img id="user-image" src="${data}" alt="user-image"
                                    class="w-100">
                                </div>`;
       }
        },
      {'title' : '{{ __("Name") }}','data' : 'name', 'name' : 'name'},
      {'title' : '{{ __("Email") }}','data' : 'user.email'},
      {'title' : '{{ __("Gender") }}','data' : 'gender',
      'render': function(data, type, full, meta) {
            return data.charAt(0).toUpperCase() + data.slice(1);
        }
      },
      {'title' : '{{ __("Position") }}','data' : 'position', 'name' : 'position'},
      {'title' : '{{ __("Department") }}','data' : 'department.name'},
      {'title' : '{{ __("Shift") }}','data' : 'shift'},
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
    var _URL_INSERT = "{{ route('master-data.employee.store') }}";
    function attactEdit(modal,response){
      modal.find("input[name=id]").val(response.data.id);
      modal.find("input[name=name]").val(response.data.name);
      modal.find("select[name=gender]").val(response.data.gender);
      modal.find("input[name=address]").val(response.data.address);
      modal.find("input[name=phone]").val(response.data.phone);
      modal.find("input[name=position]").val(response.data.position);
      modal.find("select[name=department_id]").val(response.data.department.id);
      modal.find("select[name=shift_id]").val(response.data.shift_id);
      modal.find("input[name=email]").val(response.data.user.email);
      modal.find("input[name=username]").val(response.data.user.username);
      modal.find("select[name=role]").val(response.data.user.role);
      modal.find("input[name=user_id]").val(response.data.user.id);
  }
    $("#btn-submit").click(function(e){
      e.preventDefault();
      saveForm($('#form-employee'),_URL_INSERT, $('#modalForm'));
    });
</script>
@endpush