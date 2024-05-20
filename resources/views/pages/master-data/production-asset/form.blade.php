<form id="form-production-asset" onsubmit="false">
    <div class="row">
        <div class="col-md-12">
            <div class="mb-3">
                <label for="code" class="form-label">{{ __('Code') ." ". __('Asset')}}</label>
                <input type="text" class="form-control" id="code" name="code" placeholder="{{ __('Example') }} : PG 1/2002                " autocomplete="off">
                <input type="hidden" name="id" id="id" class="form-control">
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">{{ __('Name') ." ". __('Asset')}}</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="{{ __('Example') }} : Supermixer " autocomplete="off">
            </div>
            <div class="mb-3">
                <label for="category" class="form-label">{{ __('Category')}}</label>
                <select name="category" id="category"class="form-control">
                    <option value="">{{ __('Please Select') }}</option>
                    @foreach (config('enum.production_asset') as $item)
                    <option value="{{ $item }}">{{ Str::ucfirst($item)}}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="location_id" class="form-label">{{ __('Location')}}</label>
                <select name="location_id" id="location_id"class="form-control">
                    <option value="">{{ __('Please Select') }}</option>
                    @foreach ($location as $l)
                    <option value="{{ $l->id }}">{{ $l->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</form>

@push('js')
    <script>
        var category = "{{ request('category') }}"; 
        $("#category").val(category);
    </script>
@endpush