<form id="form-changeShift" onsubmit="false">
    <div class="row">
        <input type="hidden" name="id" id="id">
        <div class="form-group">
            <div class="col-12">
                <label for="technician">{{ __('Select Technician') }}</label>
                <select name="technician_id[]" id="technician_id" class="form-control select2 select-shift" multiple>
                    <option value="" disabled>{{ __('Please Select') }}</option>         
                </select>
            </div>
        </div>
    </div>
</form>

