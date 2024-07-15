@extends('layouts.app', ['dt' => true])
@section('content')
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="col-md-6">
                        <h6 class="card-title">{{ $title }}</h6>
                    </div>
                    <form action="" method="post" id="report-form" class="mt-4">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="type" class="form-label">{{ __('Type') }}</label>
                                    <select name="type" id="type" class="form-control">
                                        <option value="" selected disabled>{{ __('Please Select') }}</option>
                                        <option value="produksi">Engineering</option>
                                        <option value="it">IT</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 d-none" id="select-category">
                                <div class="mb-3">
                                    <label for="category" class="form-label">{{ __('Category') }}</label>
                                    <select name="category" id="category" class="form-control">
                                        <option value="" selected disabled>{{ __('Please Select') }}</option>
                                        @foreach (config('enum.production_asset') as $item)
                                            <option value="{{ $item }}">{{ Str::ucfirst(__($item)) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 d-none" id="select-asset">
                                <div class="mb-3">
                                    <label for="asset" class="form-label">{{ __('Asset') }}</label>
                                    <select name="asset_id" id="asset_id" class="form-control select2">
                                        <option value="" selected disabled>{{ __('Please Select') }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="start_date" class="form-label">{{ __('From Date') }}</label>
                                    <input type="date" name="start_date" id="start_date" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="end_date" class="form-label">{{ __('To Date') }}</label>
                                    <input type="date" name="end_date" id="end_date" class="form-control">
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-sm btn-danger btn-submit">{{ __('Generate') }}</button>
                        <a href="#" class="btn btn-sm btn-success d-none" id="export-link">{{ __('Export') }}</a>
                    </form>
                    <div class="table-responsive mt-3">
                        <table id="report-table" class="table table-responsive" style="width: 100%"></table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @widget('report')
@endsection
@push('datatable')
    <script>
        $(document).ready(function() {
            $(".select2").select2();
            $("#type").change(function() {
                var value = $(this).val();
                $("#select-category").toggleClass("d-none", value == "it");
                $("#select-asset").toggleClass("d-none", value == "it");
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
                            "<option value=''>{{ __('Please Select') }}</option>");
                            
                        $.each(response, function(key, value) {
                            assetSelect.append('<option value="' + value.id + '">' +
                                value.name + '</option>');
                        });
                       
                    }
                });
            });
            var _LOADING = `<div class="w-100 d-flex align-items-center">
                <div class="m-auto d-flex align-items-center">
                    ${buildLoadingWhite("20px","20px")} <span class="ms-2">Tunggu sebentar ...</span>
                </div>
            </div>`;
            $("#report-form").submit(function(e) {
                e.preventDefault()
                var btn = $(".btn-submit");
                var btnOri = btn.html();
                var form = $(this)
                $.ajax({
                    type: "POST",
                    url: "{{ route('report.store') }}",
                    data: $(this).serialize(),
                    dataType: "JSON",
                    beforeSend: function() {
                        btn.attr('disabled', 'disabled');
                        btn.html(_LOADING)
                    },
                    success: function(response) {
                        var exportLink = $("#export-link");
                        var start_date = $("#start_date").val();
                        var end_date = $("#end_date").val();
                        var type = $("#type").val();
                        var href = "{{ route('report.export') }}";
                        var newHref = href + "?start_date=" + start_date + "&end_date=" +
                            end_date + "&type=" + type;
                        exportLink.attr('href', newHref);
                        exportLink.removeClass('d-none')
                        resetBtnSubmit(btn, btnOri);
                        resetErrorValidate(form);
                        ReportDataTable(response);
                    },
                    statusCode: {
                        422: function(response) {
                            var data = jsonToArray(response.responseJSON.data);
                            data.forEach(function(e) {
                                $("[name='" + e.key + "']").addClass("is-invalid");
                                $("[name='" + e.key + "']").siblings(
                                    "small.text-danger").remove();
                                $("[name='" + e.key + "']").after(
                                    `<small class="text-danger invalid">${e.value}</small>`
                                );
                            })
                            resetBtnSubmit(btn, btnOri)
                        },
                        500: function(response) {
                            console.log(response);
                            iziToast.error({
                                title: 'Failed',
                                message: response.responseJSON.data.error,
                                position: 'bottomCenter'
                            });

                            resetBtnSubmit(btn, btnOri)
                        }
                    }
                });
            });

        });
    </script>
@endpush
