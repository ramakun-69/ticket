<form id="form-shift" onsubmit="false">
    <div class="row">
        <div class="col-md-12">
            <div class="mb-3">
                <label for="field-1" class="form-label">{{ __('Shift Name')}}</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="{{ __('Example') }} : Shift 1" autocomplete="off">
                <input type="hidden" name="id" id="id" class="form-control">
            </div>
            <div class="mb-3 row">
                <div class="col-md-6">
                    <label for="start_time" class="form-label">{{ __('Start Time')}}</label>
                    <input type="time" class="form-control" id="start_time" name="start_time"  autocomplete="off">
                </div>
                <div class="col-md-6">
                    <label for="end_time" class="form-label">{{ __('End Time')}}</label>
                    <input type="time" class="form-control" id="end_time" name="end_time"  autocomplete="off">
                </div>
            </div>
            {{-- <div class="mb-3">
                <input type="checkbox" class="form-check-input" value="Y" id="is_active" name="is_active">
                <label for="field-1" class="form-check-label">{{ __('Active Shift')}}</label>
            </div> --}}
           
        </div>
    </div>
</form>

