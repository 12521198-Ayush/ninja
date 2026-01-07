<form action="{{ route('client.whatsapp.profile.update', $row->id) }}" id="updateProfileForm" class="form-validate"
    method="POST" enctype="multipart/form-data"> 
    @csrf
    <input type="hidden" name="is_modal" class="is_modal" value="1">
    <div class="row gx-20">
        <div class="col-lg-12">
            <div class="mb-4">
                <label for="address" class="form-label">{{ __('address') }} <span
                        class="text-danger">*</span></label>
                <textarea class="form-control rounded-2" name="address" id="address" cols="30" rows="10"
                    placeholder="{{ __('enter_address') }}">{{ $profile_info->address ?? '' }}</textarea>
                <div class="invalid-feedback"></div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="mb-4">
                <label for="email" class="form-label">{{ __('email') }}</label>
                <input type="text" class="form-control rounded-2" id="email" name="email"
                    placeholder="{{ __('enter_email') }}" value="{{ $profile_info->email ?? '' }}">
                <div class="invalid-feedback"></div>
            </div>
        </div>
        
        <div class="col-lg-12">
            <div class="mb-4">
                <label for="description" class="form-label">{{ __('description') }} <span
                        class="text-danger">*</span></label>
                <textarea class="form-control rounded-2" name="description" id="description" cols="30" rows="10"
                    placeholder="{{ __('enter_description') }}">{{ $profile_info->description ?? '' }}</textarea>
                <div class="invalid-feedback"></div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="mb-4">
                <label for="vertical" class="form-label">{{ __('category') }}</label>
                <div class="select-type-v1 list-space">
                    <select class="form-control"
                        id="vertical" aria-label=".form-select-lg example" name="vertical">
                        <option value="" selected>{{ __('select_category') }}</option>
                        @foreach(config('static_array.whatsapp_category') as $key=> $category)
                        <option value="{{ $key }}" {{ $key==$profile_info->vertical ? 'selected':'' }}>{{ __($category) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="invalid-feedback"></div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="mb-4">
                <label for="about" class="form-label">{{ __('about') }}</label>
                <textarea class="form-control rounded-2" name="about" id="about" cols="30" rows="10"
                    placeholder="{{ __('enter_about') }}">{{ $profile_info->about ?? '' }}</textarea>
                <div class="invalid-feedback"></div>
            </div>
        </div>
        
        <div class="col-lg-12">
            <div class="mb-4">
                <label for="websites" class="form-label">{{ __('websites') }}</label>
                <div id="websites-container">
                    @if(isset($profile_info->websites) && is_array($profile_info->websites))
                        @foreach($profile_info->websites as $website)
                            <div class="input-group mb-3">
                                <input type="url" class="form-control rounded-2" name="websites[]" placeholder="{{ __('enter_websites') }}" value="{{ $website }}">
                                {{-- <button type="button" class="btn btn-danger remove-website">
                                    <i class="fa fa-minus"></i>
                                </button> --}}
                            </div>
                        @endforeach
                    @else
                        <div class="input-group mb-3">
                            <input type="url" class="form-control rounded-2" name="websites[]" placeholder="{{ __('enter_websites') }}">
                            {{-- <button type="button" class="btn btn-danger remove-website">
                                <i class="fa fa-minus"></i>
                            </button> --}}
                        </div>
                    @endif
                </div>
                {{-- <button type="button" id="add-website" class="btn btn-primary mt-2">{{ __('add_website') }}</button> --}}
                <div class="invalid-feedback"></div>
            </div>
        </div>

        <div class="d-flex justify-content-end align-items-center mt-30">
            <button id="" class="btn btn-primary d-none preloader" type="button" disabled>
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                Loading...
            </button>
            <button type="submit" class="btn btn-primary save">{{ __('submit') }}</button>
            <button type="button" class="btn btn-danger mx-2 text-white" data-bs-dismiss="modal">{{ __('close') }}</button>
        </div>
    </div>
</form>
