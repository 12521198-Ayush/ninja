@extends('backend.layouts.master')
@section('title', __('clients'))
@section('content')
    @push('css_asset')
        <link rel="stylesheet" href="{{ static_asset('admin/css/dropzone.min.css') }}">
    @endpush
    <section>
        <div class="container-fluid d-flex justify-content-center">
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="section-title">{{ __('edit_client') }}</h3>
                    <form action="{{ route('clients.update', $client->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('patch')
                        <div class="bg-white redious-border p-20 p-sm-30">
                            <h6 class="sub-title">{{ __('client_information') }}</h6>
                            <div class="row gx-20">
                                <div class="col-lg-6">
                                    <div class="mb-4">
                                        <label for="organisationName" class="form-label">{{ __('company_name') }}<span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control rounded-2" id="company_name"
                                            name="company_name" value="{{ old('company_name', $client->company_name) }}"
                                            placeholder="{{ __('company_name') }}" required>
                                        @if ($errors->has('company_name'))
                                            <div class="nk-block-des text-danger">
                                                <p>{{ $errors->first('company_name') }}</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="select-type-v2 mb-4 list-space">
                                        <label for="country" class="form-label">{{ __('country') }}<span
                                                class="text-danger">*</span></label>
                                        <div class="select-type-v1 list-space">
                                            <select class="form-select form-select-lg rounded-0 mb-3 with_search"
                                                aria-label=".form-select-lg example" name="country_id" required>
                                                <option value="" selected>{{ __('select_country') }}</option>
                                                @foreach ($countries as $country)
                                                    <option value="{{ $country->id }}"
                                                        {{ $country->id == old('country_id', @$client->primaryUser->country_id) ? 'selected' : '' }}>
                                                        {{ __($country->name) }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('country_id'))
                                                <div class="nk-block-des text-danger">
                                                    <p>{{ str_replace('id', '', $errors->first('country_id')) }}</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="col-lg-6">
                                    <div class="select-type-v2 mb-4 list-space">
                                        <label for="is_email_verified" class="form-label">{{ __('is_email_verified') }}<span
                                                class="text-danger">*</span></label>
                                            <select class="form-control"
                                                aria-label=".form-select-lg example" name="is_email_verified" required>
                                                    <option value="yes" {{ $country->email_verified_at }}>{{ __('yes') }}</option>
                                                    <option value="no" {{ $country->email_verified_at }}>{{ __('no') }}</option>
                                            </select>
                                            @if ($errors->has('country_id'))
                                                <div class="nk-block-des text-danger">
                                                    <p>{{ str_replace('id', '', $errors->first('country_id')) }}</p>
                                                </div>
                                            @endif
                                    </div>
                                </div> --}}
                                <div class="col-lg-6">
                                    <div class="mb-4">
                                        <label for="address" class="form-label">{{ __('address_line') }}</label>
                                        <input type="text" class="form-control rounded-2" id="address" name="address"
                                            value="{{ old('address', @$client->primaryUser->address) }}"
                                            placeholder="{{ __('address') }}">
                                        @if ($errors->has('address'))
                                            <div class="nk-block-des text-danger">
                                                <p>{{ $errors->first('address') }}</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- pricing moved to separate section -->


                                <div class="col-lg-6 input_file_div">
                                    <div class="mb-3">
                                        <label class="form-label mb-1">{{ __('logo') }}</label>
                                        <label for="logo" class="file-upload-text">
                                            <p></p><span class="file-btn">{{ __('choose_file') }}</span>
                                        </label>
                                        <input class="d-none file_picker" type="file" id="logo" name="logo"
                                            accept=".jpg,.png">
                                        <div class="nk-block-des text-danger">
                                            <p class="logo_error error">{{ $errors->first('logo') }}</p>
                                        </div>
                                    </div>
                                    <div class="selected-files d-flex flex-wrap gap-20">
                                        <div class="selected-files-item">
                                            <img class="selected-img" src="{{ getFileLink('80x80', $client->logo) }}"
                                                alt="favicon">
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mt-30">
                                    <button type="submit" class="btn sg-btn-primary">{{ __('submit') }}</button>
                                    @include('backend.common.loading-btn', [
                                        'class' => 'btn sg-btn-primary',
                                    ])
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- Wallet History Modal -->
                    <div class="modal fade" id="walletHistoryModalAdmin" tabindex="-1" aria-labelledby="walletHistoryModalAdminLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="walletHistoryModalAdminLabel">{{ __('wallet_history') }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div id="wallet_history_spinner_admin" class="text-center py-3 d-none">
                                        <div class="spinner-border" role="status">
                                            <span class="visually-hidden">{{ __('loading') }}</span>
                                        </div>
                                    </div>
                                    <div id="wallet_history_error_admin" class="text-center text-danger py-3 d-none"></div>
                                    <div id="wallet_history_empty_admin" class="text-center d-none py-3">{{ __('no_history_found') }}</div>
                                    <div class="table-responsive d-none" id="wallet_history_table_wrap_admin">
                                        <table class="table table-striped table-sm" id="wallet_history_table_admin">
                                            <thead>
                                                <tr>
                                                    <th>{{ __('date') }}</th>
                                                    <th>{{ __('type') }}</th>
                                                    <th>{{ __('amount') }}</th>
                                                    <th>{{ __('balance_after') }}</th>
                                                    <th>{{ __('description') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('close') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Wallet Balance Section -->
                    <form id="wallet-form" class="mt-4" onsubmit="return false;">
                        @csrf
                        <div class="bg-white redious-border p-20 p-sm-30">
                            <h6 class="sub-title">{{ __('Wallet Balance') }}</h6>
                            <div class="row gx-20">
                                <div class="col-lg-6">
                                    <div class="mb-4">
                                        <label for="wallet_balance" class="form-label">{{ __('current_balance') }}</label>
                                        <div class="input-group">
                                            <input type="number" step="0.01" class="form-control rounded-2" id="wallet_balance" name="wallet_balance"
                                                value="{{ old('wallet_balance', isset($client->wallet_balance) ? $client->wallet_balance : '') }}"
                                                placeholder="{{ __('wallet_balance') }}" readonly>
                                            <span class="input-group-text d-none" id="wallet_balance_loading">
                                                <div class="spinner-border spinner-border-sm" role="status">
                                                    <span class="visually-hidden">{{ __('loading') }}</span>
                                                </div>
                                            </span>
                                            <span class="input-group-text text-danger d-none" id="wallet_balance_refresh_error">
                                                <i class="las la-exclamation-circle" title="{{ __('balance_refresh_failed') }}"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-4">
                                        <label for="add_balance" class="form-label">{{ __('Credit Balance') }}</label>
                                        <div class="input-group">
                                            <input type="number" step="0.01" class="form-control rounded-2" id="add_balance" name="add_balance"
                                                placeholder="{{ __('Enter amount') }}">
                                            <button class="btn sg-btn-primary" type="button" id="add_balance_btn">{{ __('Credit') }}</button>
                                        </div>
                                        <div class="nk-block-des text-danger">
                                            <p class="wallet_balance_error"></p>
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <label for="deduct_balance" class="form-label">{{ __('Debit Balance') }}</label>
                                        <div class="input-group">
                                            <input type="number" step="0.01" class="form-control rounded-2" id="deduct_balance" name="deduct_balance"
                                                placeholder="{{ __('Enter amount') }}">
                                            <button class="btn sg-btn-primary" type="button" id="deduct_balance_btn">{{ __('Debit') }}</button>
                                        </div>
                                        <div class="nk-block-des text-danger">
                                            <p class="wallet_deduct_error"></p>
                                        </div>
                                    </div>
                                    <div class="mb-2">
                                        <button type="button" id="view_wallet_history_btn" class="btn btn-sm btn-outline-primary">{{ __('View Transaction History') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- Pricing Section -->
                    <form id="pricing-form" class="mt-4" onsubmit="return false;">
                        @csrf
                        <div class="bg-white redious-border p-20 p-sm-30">
                            <h6 class="sub-title">{{ __('Pricing') }}</h6>
                            <div class="row gx-20">
                                <div class="col-lg-4">
                                    <div class="mb-4">
                                        <label for="price_marketing" class="form-label">{{ __('Marketing ') }}</label>
                                        <input type="number" step="0.0001" class="form-control rounded-2" id="price_marketing" name="price_marketing"
                                            value="{{ old('price_marketing', isset($client->price_marketing) ? $client->price_marketing : '') }}"
                                            placeholder="{{ __('Enter marketing price') }}">
                                        <div class="nk-block-des text-danger">
                                            <p class="price_marketing_error"></p>
                                        </div>
                                        <small class="form-text text-muted">{{ __('Pricing for marketing messages') }}</small>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="mb-4">
                                        <label for="price_utility" class="form-label">{{ __('Utility ') }}</label>
                                        <input type="number" step="0.0001" class="form-control rounded-2" id="price_utility" name="price_utility"
                                            value="{{ old('price_utility', isset($client->price_utility) ? $client->price_utility : '') }}"
                                            placeholder="{{ __('Enter utility price') }}">
                                        <div class="nk-block-des text-danger">
                                            <p class="price_utility_error"></p>
                                        </div>
                                        <small class="form-text text-muted">{{ __('Pricing for utility messages') }}</small>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="mb-4">
                                        <label for="price_auth" class="form-label">{{ __('Authentication ') }}</label>
                                        <input type="number" step="0.0001" class="form-control rounded-2" id="price_auth" name="price_auth"
                                            value="{{ old('price_auth', isset($client->price_auth) ? $client->price_auth : '') }}"
                                            placeholder="{{ __('Enter authentication price') }}">
                                        <div class="nk-block-des text-danger">
                                            <p class="price_auth_error"></p>
                                        </div>
                                        <small class="form-text text-muted">{{ __('Pricing for authentication messages') }}</small>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end align-items-center mt-10">
                                    <button id="save-pricing-btn" class="btn sg-btn-primary">{{ __('Save Pricing') }}</button>
                                    <span id="pricing-status" class="ms-3"></span>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    @include('backend.common.gallery-modal')
 
@endsection
@push('js')
   <script src="{{ static_asset('admin/js/countries.js') }}"></script>
<script>
(function(){
    // API endpoints expect the user's id, not the client id.
    // Prefer the client's primary user id when available, otherwise fall back to common fields.
    const clientId = '{{ $client->primaryUser->id ?? $client->primary_user_id ?? $client->user_id ?? $client->id }}';
    const csrf = '{{ csrf_token() }}';

    // DOM elements
    const addBalanceBtn = document.getElementById('add_balance_btn');
    const walletBalanceInput = document.getElementById('wallet_balance');
    const addBalanceInput = document.getElementById('add_balance');
    const walletError = document.querySelector('.wallet_balance_error');
    const deductBalanceBtn = document.getElementById('deduct_balance_btn');
    const deductBalanceInput = document.getElementById('deduct_balance');
    const walletDeductError = document.querySelector('.wallet_deduct_error');
    const loadingSpinner = document.getElementById('wallet_balance_loading');
    const refreshError = document.getElementById('wallet_balance_refresh_error');
    const priceMarketingInput = document.getElementById('price_marketing');
    const priceUtilityInput = document.getElementById('price_utility');
    const priceAuthInput = document.getElementById('price_auth');
    const priceMarketingError = document.querySelector('.price_marketing_error');
    const priceUtilityError = document.querySelector('.price_utility_error');
    const priceAuthError = document.querySelector('.price_auth_error');
    const pricingStatusEl = document.getElementById('pricing-status');
    const pricingForm = document.getElementById('pricing-form');
    const savePricingBtn = document.getElementById('save-pricing-btn');

    // Utility to format number to 2 decimals
    function formatAmount(n) {
        const num = Number(n);
        if (Number.isNaN(num)) return '0.00';
        return num.toFixed(2);
    }

    // Format ISO date/time into India Standard Time (IST)
    function formatDateIST(iso) {
        if (!iso) return '';
        try {
            const d = new Date(iso);
            if (Number.isNaN(d.getTime())) return iso;
            return d.toLocaleString('en-IN', {
                timeZone: 'Asia/Kolkata',
                year: 'numeric',
                month: 'short',
                day: '2-digit',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            });
        } catch (e) {
            return iso;
        }
    }

    // Normalize response to extract balance when possible
    function extractBalanceFromResponse(data) {
        // common shapes:
        // { balance: "100.00" }
        // { data: { balance: "100.00" } }
        // { data: { new_balance: 100 } }
        // { user: { wallet_balance: "100.00" } }
        // { new_balance: 100 }
        if (!data) return null;

        if (data.balance !== undefined && data.balance !== null) return data.balance;
        if (data.new_balance !== undefined && data.new_balance !== null) return data.new_balance;
        if (data.data) {
            if (data.data.balance !== undefined && data.data.balance !== null) return data.data.balance;
            if (data.data.new_balance !== undefined && data.data.new_balance !== null) return data.data.new_balance;
        }
        if (data.user && data.user.wallet_balance !== undefined && data.user.wallet_balance !== null) return data.user.wallet_balance;
        if (data.wallet_balance !== undefined && data.wallet_balance !== null) return data.wallet_balance;

        return null;
    }

    function setPricingStatus(message, variant = 'muted') {
        if (!pricingStatusEl) return;
        pricingStatusEl.textContent = message || '';
        pricingStatusEl.classList.remove('text-success', 'text-danger', 'text-muted');
        const variantClass = variant === 'success' ? 'text-success' : variant === 'error' ? 'text-danger' : 'text-muted';
        pricingStatusEl.classList.add(variantClass);
    }

    function resetPricingErrors() {
        if (priceMarketingError) priceMarketingError.textContent = '';
        if (priceUtilityError) priceUtilityError.textContent = '';
        if (priceAuthError) priceAuthError.textContent = '';
    }

    async function apiPostJson(url, payload) {
        const res = await fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrf,
                'Accept': 'application/json'
            },
            body: JSON.stringify(payload)
        });
        let json;
        try { json = await res.json(); } catch (e) { json = null; }
        return { ok: res.ok, status: res.status, data: json };
    }

    async function apiGetJson(url) {
        const res = await fetch(url, {
            method: 'GET',
            headers: { 'Accept': 'application/json' }
        });
        let json;
        try { json = await res.json(); } catch (e) { json = null; }
        return { ok: res.ok, status: res.status, data: json };
    }

    async function loadPricing() {
        if (!priceMarketingInput || !priceUtilityInput || !priceAuthInput) return;
        try {
            setPricingStatus('{{ __("loading") }}...', 'muted');
            const { ok, data } = await apiGetJson(`/api/users/${clientId}/get-prices`);
            const priceData = data && typeof data === 'object' && data.data ? data.data : data;
            if (!ok || !priceData) {
                throw new Error((data && data.message) ? data.message : '{{ __("operation_failed") }}');
            }
            if (priceMarketingInput) priceMarketingInput.value = priceData.marketing_price ?? '';
            if (priceUtilityInput) priceUtilityInput.value = priceData.utility_price ?? '';
            if (priceAuthInput) priceAuthInput.value = priceData.auth_price ?? '';
            setPricingStatus('', 'muted');
        } catch (err) {
            console.error('loadPricing error:', err);
            setPricingStatus(err.message || '{{ __("operation_failed") }}', 'error');
            if (window.toastr) toastr.error(err.message || '{{ __("operation_failed") }}');
        }
    }

    function collectPricingPayload() {
        const marketing = (priceMarketingInput?.value ?? '').trim();
        const utility = (priceUtilityInput?.value ?? '').trim();
        const auth = (priceAuthInput?.value ?? '').trim();

        const invalidMsg = '{{ __("please_enter_valid_amount") }}';
        let hasError = false;
        resetPricingErrors();

        const parsedMarketing = Number(marketing);
        if (!marketing || Number.isNaN(parsedMarketing) || parsedMarketing < 0) {
            if (priceMarketingError) priceMarketingError.textContent = invalidMsg;
            hasError = true;
        }
        const parsedUtility = Number(utility);
        if (!utility || Number.isNaN(parsedUtility) || parsedUtility < 0) {
            if (priceUtilityError) priceUtilityError.textContent = invalidMsg;
            hasError = true;
        }
        const parsedAuth = Number(auth);
        if (!auth || Number.isNaN(parsedAuth) || parsedAuth < 0) {
            if (priceAuthError) priceAuthError.textContent = invalidMsg;
            hasError = true;
        }

        if (hasError) return null;

        return {
            marketing_price: marketing,
            utility_price: utility,
            auth_price: auth
        };
    }

    async function submitPricing(event) {
        event.preventDefault();
        if (!savePricingBtn) return;

        const payload = collectPricingPayload();
        if (!payload) return;

        try {
            savePricingBtn.disabled = true;
            setPricingStatus('{{ __("loading") }}...', 'muted');

            const { ok, data } = await apiPostJson(`/api/users/${clientId}/update-prices`, payload);
            if (!ok) {
                const message = (data && data.message) ? data.message : '{{ __("operation_failed") }}';
                throw new Error(message);
            }

            if (window.toastr) toastr.success('{{ __("Pricing updated successfully") }}');
            setPricingStatus('{{ __("Pricing updated") }}', 'success');

            if (data) {
                const priceResponse = data && typeof data === 'object' && data.data ? data.data : data;
                if (priceMarketingInput && priceResponse.marketing_price !== undefined) priceMarketingInput.value = priceResponse.marketing_price;
                if (priceUtilityInput && priceResponse.utility_price !== undefined) priceUtilityInput.value = priceResponse.utility_price;
                if (priceAuthInput && priceResponse.auth_price !== undefined) priceAuthInput.value = priceResponse.auth_price;
            }
        } catch (err) {
            console.error('submitPricing error:', err);
            setPricingStatus(err.message || '{{ __("operation_failed") }}', 'error');
            if (window.toastr) toastr.error(err.message || '{{ __("operation_failed") }}');
        } finally {
            savePricingBtn.disabled = false;
        }
    }

    // Main: load wallet balance
    async function loadWalletBalance(options = {}) {
        const { isAfterOperation = false, showSuccessMessage = false, successMessage = '' } = options;
        try {
            if (loadingSpinner) loadingSpinner.classList.remove('d-none');
            if (refreshError) refreshError.classList.add('d-none');

            const { ok, data } = await apiGetJson(`/api/wallet/get-balance/${clientId}`);

            if (!ok) {
                throw new Error((data && data.message) ? data.message : 'Failed to fetch balance');
            }

            const balance = extractBalanceFromResponse(data);
            if (balance === null) {
                throw new Error('Unexpected balance response from server');
            }

            if (walletBalanceInput) walletBalanceInput.value = formatAmount(balance);

            if (isAfterOperation && showSuccessMessage && window.toastr) {
                toastr.success(successMessage || '{{ __("operation_completed_successfully") }}');
            }

            return true;
        } catch (err) {
            console.error('loadWalletBalance error:', err);
            if (refreshError) {
                refreshError.classList.remove('d-none');
                try {
                    refreshError.querySelector('i')?.setAttribute('title', err.message);
                } catch(e){}
            }
            if (!isAfterOperation && window.toastr) {
                toastr.error('{{ __("failed_to_load_wallet_balance") }}');
            }
            return false;
        } finally {
            if (loadingSpinner) loadingSpinner.classList.add('d-none');
        }
    }

    // Handler for increment
    if (addBalanceBtn) {
        addBalanceBtn.addEventListener('click', async function() {
            const raw = addBalanceInput.value;
            const amount = parseFloat(raw);
            if (!raw || Number.isNaN(amount) || amount <= 0) {
                if (walletError) walletError.textContent = '{{ __("please_enter_valid_amount") }}';
                return;
            }
            addBalanceBtn.disabled = true;
            if (walletError) walletError.textContent = '';
            try {
                const { ok, data } = await apiPostJson(`/api/users/${clientId}/increment-balance`, { amount });

                // If server immediately returns new balance, use it; otherwise call loadWalletBalance
                const newBalance = extractBalanceFromResponse(data);
                if (ok && newBalance !== null) {
                    addBalanceInput.value = '';
                    if (walletError) walletError.textContent = '';
                    // update UI directly
                    if (walletBalanceInput) walletBalanceInput.value = formatAmount(newBalance);
                    if (window.toastr) toastr.success('{{ __("Balance credited successfully") }}');
                    // Optional: also refresh the canonical balance from GET endpoint
                    await loadWalletBalance({ isAfterOperation: true, showSuccessMessage: false });
                } else if (ok && data && data.success) {
                    // fallback to GET
                    addBalanceInput.value = '';
                    if (walletError) walletError.textContent = '';
                    const refreshed = await loadWalletBalance({ isAfterOperation: true, showSuccessMessage: true, successMessage: '{{ __("balance_added_successfully") }}' });
                    if (!refreshed && window.toastr) toastr.warning('{{ __("balance_added_refresh_failed") }}');
                } else {
                    // try to obtain message from response
                    const msg = (data && data.message) ? data.message : '{{ __("failed_to_add_balance") }}';
                    throw new Error(msg);
                }
            } catch (err) {
                console.error('Add balance error:', err);
                if (walletError) walletError.textContent = err.message || '{{ __("failed_to_add_balance") }}';
                if (window.toastr) toastr.error(err.message || '{{ __("failed_to_add_balance") }}');
            } finally {
                addBalanceBtn.disabled = false;
            }
        });
    }

    // Handler for decrement
    if (deductBalanceBtn) {
        deductBalanceBtn.addEventListener('click', async function() {
            const raw = deductBalanceInput.value;
            const amount = parseFloat(raw);
            if (!raw || Number.isNaN(amount) || amount <= 0) {
                if (walletDeductError) walletDeductError.textContent = '{{ __("please_enter_valid_amount") }}';
                return;
            }
            deductBalanceBtn.disabled = true;
            if (walletDeductError) walletDeductError.textContent = '';
            try {
                const { ok, data } = await apiPostJson(`/api/users/${clientId}/decrement-balance`, { amount });

                const newBalance = extractBalanceFromResponse(data);
                if (ok && newBalance !== null) {
                    deductBalanceInput.value = '';
                    if (walletDeductError) walletDeductError.textContent = '';
                    if (walletBalanceInput) walletBalanceInput.value = formatAmount(newBalance);
                    if (window.toastr) toastr.success('{{ __("Balance debited successfully") }}');
                    // refresh canonical balance as well
                    await loadWalletBalance({ isAfterOperation: true, showSuccessMessage: false });
                } else if (ok && data && data.success) {
                    deductBalanceInput.value = '';
                    if (walletDeductError) walletDeductError.textContent = '';
                    const refreshed = await loadWalletBalance({ isAfterOperation: true, showSuccessMessage: true, successMessage: '{{ __("balance_deducted_successfully") }}' });
                    if (!refreshed && window.toastr) toastr.warning('{{ __("balance_deducted_refresh_failed") }}');
                } else {
                    const msg = (data && data.message) ? data.message : '{{ __("failed_to_deduct_balance") }}';
                    throw new Error(msg);
                }
            } catch (err) {
                console.error('Deduct balance error:', err);
                if (walletDeductError) walletDeductError.textContent = err.message || '{{ __("failed_to_deduct_balance") }}';
                if (window.toastr) toastr.error(err.message || '{{ __("failed_to_deduct_balance") }}');
            } finally {
                deductBalanceBtn.disabled = false;
            }
        });
    }

    // Initialize on DOM ready
    document.addEventListener('DOMContentLoaded', function() {
        loadWalletBalance();
        loadPricing();
        if (pricingForm) {
            pricingForm.addEventListener('submit', submitPricing);
        }
        // Wire up history button
        const viewHistoryBtn = document.getElementById('view_wallet_history_btn');
        if (viewHistoryBtn) {
            viewHistoryBtn.addEventListener('click', async function() {
                // clear previous state
                const spinner = document.getElementById('wallet_history_spinner_admin');
                const errBox = document.getElementById('wallet_history_error_admin');
                const emptyBox = document.getElementById('wallet_history_empty_admin');
                const tableWrap = document.getElementById('wallet_history_table_wrap_admin');
                const tbody = document.querySelector('#wallet_history_table_admin tbody');

                if (spinner) spinner.classList.remove('d-none');
                if (errBox) errBox.classList.add('d-none');
                if (emptyBox) emptyBox.classList.add('d-none');
                if (tableWrap) tableWrap.classList.add('d-none');
                if (tbody) tbody.innerHTML = '';

                // fetch history from API: /api/{userId}/balance-history
                try {
                    const { ok, data } = await apiGetJson(`/api/${clientId}/balance-history`);
                    if (!ok) throw new Error((data && data.message) ? data.message : 'Failed to fetch history');

                    const items = Array.isArray(data?.balance_history) ? data.balance_history : (Array.isArray(data?.data) ? data.data : []);

                    if (!items.length) {
                        if (spinner) spinner.classList.add('d-none');
                        if (emptyBox) emptyBox.classList.remove('d-none');
                    } else {
                        items.forEach(function(it) {
                            const tr = document.createElement('tr');
                            const date = it.created_at || it.date || '';
                            const type = it.type || '';
                            const amount = (it.amount !== undefined) ? it.amount : (it.value !== undefined ? it.value : '0');
                            const balanceAfter = it.balance_after !== undefined ? it.balance_after : '';
                            const note = it.note || it.description || '';

                            const tdDate = document.createElement('td'); tdDate.textContent = formatDateIST(date);
                            const tdType = document.createElement('td'); tdType.textContent = type;
                            const tdAmount = document.createElement('td'); tdAmount.textContent = Number(amount || 0).toFixed(2);
                            const tdBalance = document.createElement('td'); tdBalance.textContent = balanceAfter ? Number(balanceAfter).toFixed(2) : '';
                            const tdNote = document.createElement('td'); tdNote.textContent = note;

                            tr.appendChild(tdDate); tr.appendChild(tdType); tr.appendChild(tdAmount); tr.appendChild(tdBalance); tr.appendChild(tdNote);
                            if (tbody) tbody.appendChild(tr);
                        });

                        if (spinner) spinner.classList.add('d-none');
                        if (tableWrap) tableWrap.classList.remove('d-none');
                    }

                    // show modal
                    const modalEl = document.getElementById('walletHistoryModalAdmin');
                    if (modalEl && typeof bootstrap !== 'undefined' && bootstrap.Modal) {
                        const modal = new bootstrap.Modal(modalEl);
                        modal.show();
                    }
                } catch (err) {
                    console.error('Error loading wallet history:', err);
                    if (spinner) spinner.classList.add('d-none');
                    if (errBox) {
                        errBox.textContent = err.message || '{{ __('wallet_history_load_error') }}';
                        errBox.classList.remove('d-none');
                    }
                    if (window.toastr) toastr.error('{{ __('wallet_history_load_error') }}');
                }
            });
        }
    });

})();
</script>

@endpush
