@can('atasan teknisi')
    <div class="mb-3 d-none" id="approval-atasan-teknik">
        <label for="status">{{ __('Confirm') }}</label>
        <select name="ticket_status" id="ticket_status" class="form-control">
            <option value="" disabled selected>{{ __('Please Select') }}</option>
            <option value="waiting process">{{ __('Approve') }}</option>
            <option value="rejected">{{ __('Reject') }}</option>
        </select>
    </div>
    <div class="mb-3 d-none" id="teknisi-div">
        <label for="technician_id">{{ __('Technician') }}</label>
        <select name="technician_id[]" id="technician_id" class="form-control select2" multiple>
            <option value="" disabled>{{ __('Please Select') }}</option>
            @foreach ($technician as $tech)
                <option value="{{ $tech->id }}">{{ $tech->name }}</option>
                @endforeach
              
        </select>
    </div>
    @push('js')
        <script>
            $(document).ready(function() {
                $("select[name=ticket_status]").change(function() {
                    var value = $(this).val();
                    $("#teknisi-div").toggleClass("d-none", value === "rejected");
                });
            });
        </script>
    @endpush
@endcan
