<div class="col-md-12">
    <div class="" id="input-type">
        <label for="">{{ __("Ticket Category") }}</label>
        <div class="form-check mb-3">
            <div class="row">
                @can('produksiType')
                <div class="col-2">
                    <input class="form-check-input" value="machine" type="radio" name="type" id="machine">
                    <label class="form-check-label" for="machine">{{ __("Mechanical Engineering") }}</label>
                </div>
                <div class="col-2">
                    <input class="form-check-input" value="utilities" type="radio" name="type" id="utilities">
                    <label class="form-check-label" for="utilities">{{ __("Utilities Engineering") }}</label>
                </div>
                <div class="col-2">
                    <input class="form-check-input" value="non-mesin" type="radio" name="type" id="non-mesin">
                    <label class="form-check-label" for="non-mesin">{{ __("Non Machine") }}</label>
                </div>
                <div class="col-2">
                    <input class="form-check-input" value="sipil" type="radio" name="type" id="sipil">
                    <label class="form-check-label" for="sipil">{{ __("Sipil") }}</label>
                </div>
                @endcan
                @can('itType')    
                <div class="col-2">
                    <input class="form-check-input" value="it" type="radio" name="type" id="it">
                    <label class="form-check-label" for="it">{{ __("IT") }}</label>
                </div>
                @endcan
            </div>
        </div>
    </div>
    <div class="mb-3">
        <label for="assets">{{ __("Asset") }}</label>
        <select name="asset_id" id="asset_id" class="form-control select2">
            <option value="">{{ __("Please Select") }}</option>
        </select>
    </div>
    <div id="info" class="d-none">
        <div class="mb-3">
            <label for="serial_number" id="serial-number-label">{{ __("Machine Number/Serial Number") }}</label>
            <input type="text" name="serial_number" class="form-control" id="serial_number" readonly>
        </div>
        <div class="mb-3">
            <label for="location" id="location-label">{{ __("Location/PIC") }}</label>
            <input type="text" name="location" class="form-control" id="location" readonly>
        </div>
    </div>
    <div class="mb-3">
        <label for="condition">{{ __("Condition") }}</label>
        <select name="condition" id="condition" class="form-control disabled-input" >
            <option value="">{{ __("Please Select") }}</option>
            @foreach (config("enum.condition") as $item)
            <option value="{{ $item }}">{{ __($item) }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label for="description">{{ __("Problem Description") }}</label>
        <textarea name="description" id="description" class="form-control disabled-input" cols="30" rows="10"></textarea>
    </div>
    <div class="mb-3">
        <label for="damaged_time">{{ __("Damaged Time") }}</label>
        <input type="datetime-local" class="form-control disabled-input" id="damage_time" name="damage_time" autocomplete="off">
    </div>
</div>
@push('js')
    <script>
        $(document).ready(function () {
            
            var assetSelect = $("select[name=asset_id]")
            $("input[name=type]").change(function(){
                $("#info").removeClass("d-none");
                $("input[name=serial_number]").val("")
                $("input[name=location]").val("")
                $.ajax({
                    type: "GET",
                    url: "{{ route('ticket-asset') }}",
                    data: {
                        type : $(this).val()
                    },
                    dataType: "JSON",
                    success: function (response) {
                        assetSelect.empty().append("<option value=''>{{ __('Please Select') }}</option>");
                    $.each(response, function (key, value) {
                        assetSelect.append('<option value="' + value.id + '">' + value.name + '</option>');
                    });
                    }
                });
            })
            $("select[name=asset_id]").change(function(){
                $.ajax({
                    type: "GET",
                    url: "{{ route('asset-info') }}",
                    data: {
                        id : $(this).val()
                    },
                    dataType: "JSON",
                    success: function (response) {
                        $("input[name=serial_number]").val(response.code)
                        if (response.type == "produksi") {
                            $("input[name=location]").val(response.location.name)
                        }else{
                            $("input[name=location]").val(response.user.pegawai.name)
                        }
                    }
                });
            });
        });
    </script>
@endpush