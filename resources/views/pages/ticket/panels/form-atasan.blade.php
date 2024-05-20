@can('atasan')    
<div class="mb-3 d-none" id="approve-atasan">
    <label for="status">{{ __("Confirm") }}</label>
    <select name="ticket_status" id="ticket_status" class="form-control">
        <option value="" disabled selected>{{ __("Please Select") }}</option>
        <option value="waiting approval">{{ __("Approve") }}</option>
        <option value="rejected">{{ __("Reject") }}</option>
    </select>
</div>
@endcan