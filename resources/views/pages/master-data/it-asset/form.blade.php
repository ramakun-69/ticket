<form id="form-it-asset" onsubmit="false">
    <div class="row">
        <div class="col-md-12">
            <div class="mb-3">
                <label for="code" class="form-label">{{ __('Code') ." ". __('Asset')}}</label>
                <input type="text" class="form-control" id="code" name="code" placeholder="{{ __('Example') }} : PG 1/2002                " autocomplete="off">
                <input type="hidden" name="id" id="id" class="form-control">
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">{{ __('Name') ." ". __('Asset')}} / {{ __("Service") }}</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="{{ __('Example') }} : Supermixer " autocomplete="off">
            </div>
            <div class="mb-3">
                <label for="category" class="form-label">{{ __('Category')}}</label>
                <select name="category" id="category"class="form-control">
                    <option value="">{{ __('Please Select') }}</option>
                    @foreach (config('enum.it_asset') as $item)
                    <option value="{{ $item }}">{{ Str::ucfirst($item)}}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="user_id" class="form-label">{{ __('PIC')}}</label>
                <select name="user_id" id="user_id"class="form-control">
                    <option value="">{{ __('Please Select') }}</option>
                    @foreach ($pic as $p)
                    <option value="{{ $p->id }}">{{ $p->pegawai->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</form>

