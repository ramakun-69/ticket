@can('teknisi')    
<div id="input-teknisi" class="d-none">
{{-- <div class="mb-3">
    <label for="problem_analysis">{{ __("Problem Analysis") }}</label>
    <textarea name="problem_analysis" class="form-control" name="problem_analysis" id="" cols="30" rows="10"></textarea>
</div> --}}
<div class="mb-3">
    <label for="action">{{ __("Problem Action") }}</label>
    <textarea name="action" class="form-control" name="action" id="action" cols="30" rows="10"></textarea>
</div>
<div class="mb-3 d-none" id="spare-part-div">
    <label class="form-label" for="">{{ __("Use of spare parts") }}</label>
    <hr>
   <div class="row">
        <div class="col-md-4">
            <div class="mb-3">
                <label for="part_name" class="form-label">{{ __('Name')}}</label>
                <input type="text" name="part_name[]" id="part_name" class="form-control" autocomplete="off">
            </div>
        </div>  
        <div class="col-md-2">
            <div class="mb-3">
                <label for="total" class="form-label">{{ __('Sum')}}</label>
                <input type="text" name="total[]" id="total" class="form-control" autocomplete="off">
            </div>
        </div>  
        <div class="col-md-2">
            <div class="mb-3">
                <label for="unit" class="form-label">{{ __('Unit')}}</label>
                <input type="text" name="unit[]" id="unit" class="form-control" autocomplete="off">
            </div>
        </div>  
        <div class="col-md-3">
            <div class="mb-3">
                <label for="information" class="form-label">{{ __('Information')}}</label>
                <input type="text" name="information[]" id="information" class="form-control" autocomplete="off">
            </div>
        </div>  
        <div class="col-md-1">
            <div class="mb-3">
                    <label for="" class="form-label"></label>
                    <button type="button" class="btn btn-sm btn-danger" id="addButton" style="margin-top: 33px"><i class="mdi mdi-plus"></i></button>
            </div>
        </div>  
   </div>
</div>
</div>
@push('js')
    <script>
        $(document).ready(function () {
            $(document).ready(function() {
            $('#addButton').click(function() {
                var newRow = `
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <input type="text" name="part_name[]" class="form-control" autocomplete="off">
                            </div>
                        </div>  
                        <div class="col-md-2">
                            <div class="mb-3">
                                <input type="text" name="total[]" class="form-control" autocomplete="off"">
                            </div>
                        </div>  
                        <div class="col-md-2">
                            <div class="mb-3">
                                <input type="text" name="unit[]" class="form-control" autocomplete="off"">
                            </div>
                        </div>  
                        <div class="col-md-3">
                            <div class="mb-3">
                                <input type="text" name="information[]" class="form-control" autocomplete="off"">
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="mb-3">
                                <button type="button" class="btn btn-sm btn-danger" style="margin-top: 5px; margin-left:3px" onclick="$(this).closest('.row').remove()"><i class="mdi mdi-minus"></i></button>
                            </div>
                        </div>
                    </div>
                `;
                $('#spare-part-div').append(newRow);
            });
        });
        });
    </script>
@endpush
@endcan