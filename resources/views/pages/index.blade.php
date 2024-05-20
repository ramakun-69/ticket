@extends('layouts.app', ['dt' => true])
@section('content')
<div class="row">
    <div class="col-xl-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="avatar-md flex-shrink-0">
                        <span class="avatar-title bg-subtle-primary text-primary rounded fs-2">
                            <i class="mdi mdi-ticket"></i>
                        </span>
                    </div>
                    <div class="flex-grow-1 overflow-hidden ms-4">
                        <p class="text-muted text-truncate font-size-15 mb-2"> {{ __("Total Ticket") }}</p>
                        <h3 class="fs-4 flex-grow-1 mb-3"> {{ $total }}
                            <span class="text-muted font-size-16">Ticket</span>
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="avatar-md flex-shrink-0">
                        <span class="avatar-title bg-subtle-info text-info rounded fs-2">
                            <i class="mdi mdi-ticket"></i>
                        </span>
                    </div>
                    <div class="flex-grow-1 overflow-hidden ms-4">
                        <p class="text-muted text-truncate font-size-15 mb-2"> {{ __("Open") }}</p>
                        <h3 class="fs-4 flex-grow-1 mb-3"> {{ $open }}
                            <span class="text-muted font-size-16">Ticket</span>
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="avatar-md flex-shrink-0">
                        <span class="avatar-title bg-subtle-success text-success rounded fs-2">
                            <i class="mdi mdi-check-all"></i>
                        </span>
                    </div>
                    <div class="flex-grow-1 overflow-hidden ms-4">
                        <p class="text-muted text-truncate font-size-15 mb-2"> {{ __("Closed") }}</p>
                        <h3 class="fs-4 flex-grow-1 mb-3"> {{ $closed }}
                            <span class="text-muted font-size-16">Ticket</span>
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="avatar-md flex-shrink-0">
                        <span class="avatar-title bg-subtle-warning text-warning rounded fs-2">
                            <i class="mdi mdi-information-outline"></i>
                        </span>
                    </div>
                    <div class="flex-grow-1 overflow-hidden ms-4">
                        <p class="text-muted text-truncate font-size-15 mb-2"> {{ __("Process") }}</p>
                        <h3 class="fs-4 flex-grow-1 mb-3"> {{ $onProcess }}
                            <span class="text-muted font-size-16">Ticket</span>
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12 col-xl-12 stretch-card">
      <div class="card">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-baseline mb-2">
            <h6 class="card-title mb-0">{{ __('Support Ticket') }}</h6>
          </div>
          <div class="table-responsive">
            <table id="datatable" class="table table-responsive" style="width: 100%"></table>
          </div>
        </div> 
      </div>
    </div>
</div>
@endsection
@widget('modal',["title"=>__('Support Ticket'),"form"=>"pages.ticket.form", 'data' =>["productionAssets" => $productionAssets, "itAssets"=>$itAssets, "technician" => $technician], "type" => "modal-xl  modal-dialog-scrollable" ])
@widget('delete', ["dt" =>true])
@push('datatable')
<script>
    var _URL = "{{ route('datatable.tickets') }}";
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
@include('pages.ticket.ticket-js')