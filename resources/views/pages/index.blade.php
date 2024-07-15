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
                            <p class="text-muted text-truncate font-size-15 mb-2"> {{ __('Incoming Ticket') }}</p>
                            <h3 class="fs-4 flex-grow-1 mb-3"> {{ $tickets->count() }}
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
                            <p class="text-muted text-truncate font-size-15 mb-2"> {{ __('Process') }}</p>
                            <h3 class="fs-4 flex-grow-1 mb-3"> {{ $tickets->where('status', 'process')->count() }}
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
                            <p class="text-muted text-truncate font-size-15 mb-2"> {{ __('Reject') }}</p>
                            <h3 class="fs-4 flex-grow-1 mb-3"> {{ $tickets->where('status', 'rejected')->count() }}
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
                            <p class="text-muted text-truncate font-size-15 mb-2"> {{ __('Finish') }}</p>
                            <h3 class="fs-4 flex-grow-1 mb-3"> {{ $tickets->where('status', 'closed')->count() }}
                                <span class="text-muted font-size-16">Ticket</span>
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 col-xl-8 stretch-card">
            <div class="card">
                <div class="card-body">
                    <form method="GET" class="mb-3 mt-3">
                        <div class="row">
                            <div class="col-2">
                                <label for="start_date">{{ __('From') }}</label>
                                <input type="date" name="start_date" id="start_date" class="form-control">
                            </div>
                            <div class="col-2">
                                <label for="end_date">{{ __('To') }}</label>
                                <input type="date" name="end_date" id="end_date" class="form-control">
                            </div>
                            <div class="col-2">
                                <label for="type" class="form-label">{{ __('Type') }}</label>
                                <select name="type" id="type" class="form-control">
                                    <option value="" selected disabled>{{ __('Select') }}</option>
                                    <option value="produksi">Engineering</option>
                                    <option value="it">IT</option>
                                </select>
                            </div>

                            <div class="col-md-2" id="select-category">
                                <label for="category" class="form-label">{{ __('Category') }}</label>
                                <select name="category" id="category" class="form-control">
                                    <option value="" selected disabled>{{ __('Select') }}</option>
                                </select>
                            </div>
                            <div class="col-md-2" id="select-asset">
                                <label for="asset" class="form-label">{{ __('Asset') }}</label>
                                <select name="asset_id" id="asset_id" class="form-control select2 select-form">
                                    <option value="" selected disabled>{{ __('Select') }}</option>
                                </select>
                            </div>
                            <div class="col-md-2" style="margin-top: 33px">
                                <button type="submit" class="btn btn-sm btn-danger">{{ __('Submit') }}</button>
                            </div>
                        </div>
                    </form>
                    {!! $chart->container() !!}
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-xl-4 stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <span>{{ __('Asset') }}</span>
                    </div>
                    <table class="table table-responsive table-striped">
                        <thead>
                            <th>#</th>
                            <th>{{ __('Asset Name') }}</th>
                            <th>{{ __('Service') }}</th>
                        </thead>
                        <tbody>
                            @foreach ($monthlyTicket as $t)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $t['asset_name'] }}</td>
                                    <td>{{ $t['service_count'] }} </td>
                                </tr>
                            @endforeach

                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    {{ $chart->script() }}
    <script>
        $("#type").change(function() {
            var value = $(this).val();
            var categories;
            if (value === "it") {
                categories = @json(config('enum.it_asset'));
            } else {
                categories = @json(config('enum.production_asset'));
            }
            console.log(categories);
            var categorySelect = $("#category");
            categorySelect.empty();
            categorySelect.append(
                '<option value="" selected disabled>{{ __('Select') }}</option>');
            categories.forEach(function(category) {
                categorySelect.append('<option value="' + category + '">' + category.charAt(0)
                    .toUpperCase() + category.slice(1) + '</option>');
            });
        });
        $("#select-category").change(function() {
            var assetSelect = $("#asset_id");
            $.ajax({
                type: "GET",
                url: "{{ route('ticket-asset') }}",
                data: {
                    type: $("#type").val(),
                    category: $("#category").val()

                },
                dataType: "JSON",
                success: function(response) {
                    assetSelect.empty().append(
                        "<option value=''>{{ __('Select') }}</option>");
                    $.each(response, function(key, value) {
                        assetSelect.append('<option value="' + value.id + '">' +
                            value.name + '</option>');
                    });
                }
            });
        });
    </script>
@endpush
