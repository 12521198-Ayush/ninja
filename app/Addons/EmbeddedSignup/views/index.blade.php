@extends('backend.layouts.master')
@section('title', __('whatsApp_settings'))
@section('content')
    <style>
        .whatsapp-settings-container {
            background: #f1f3fb;
            min-height: calc(100vh - 60px);
            padding: 2rem 0;
        }
        
        .whatsapp-main-card {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1), 0 1px 2px rgba(0, 0, 0, 0.06);
            overflow: hidden;
            border: 1px solid #e2e8f0;
        }
        
        .settings-header {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            padding: 2rem;
            text-align: center;
            position: relative;
        }
        
        .settings-header::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #059669 0%, #10b981 50%, #059669 100%);
        }
        
        .settings-header h3 {
            color: #ffffff;
            font-size: 1.5rem;
            font-weight: 700;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
        }
        
        .settings-header h3 i {
            font-size: 1.75rem;
        }
        
        .whatsapp-connect-section {
            padding: 3rem 2rem;
            text-align: center;
            background: linear-gradient(180deg, #f8fafc 0%, #ffffff 100%);
        }
        
        .whatsapp-icon-wrapper {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            border-radius: 20px;
            width: 80px;
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            box-shadow: 0 10px 25px rgba(16, 185, 129, 0.25);
        }
        
        .whatsapp-button {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            border: none;
            padding: 0.875rem 2.5rem;
            font-size: 1rem;
            font-weight: 600;
            border-radius: 10px;
            color: white;
            transition: all 0.2s ease;
            box-shadow: 0 4px 14px rgba(16, 185, 129, 0.35);
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .whatsapp-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.45);
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
        }
        
        .whatsapp-button i {
            font-size: 1.25rem;
        }
        
        .common-issues-link {
            color: #64748b;
            font-weight: 500;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            transition: all 0.2s ease;
        }
        
        .common-issues-link:hover {
            background: #f1f5f9;
            color: #10b981;
        }
    </style>

    <div class="container-fluid whatsapp-settings-container">
        <div class="row justify-content-md-center">
            <div class="col col-lg-8 col-md-10">
                <div class="whatsapp-main-card">
                    <div class="settings-header">
                        <h3><i class="lab la-whatsapp"></i> {{ __('whatsApp_settings') }}</h3>
                    </div>
                    <div class="p-4">
                        @php
                            $embadedSignupActivated = addon_is_activated('embedded_signup');
                        @endphp
                        @if ($embadedSignupActivated && empty(Auth::user()->client->whatsappSetting))
                            <div class="whatsapp-connect-section" id="embedded_signup_integration">
                                <div class="whatsapp-icon-wrapper">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 175.216 175.552" style="width: 45px">
                                        <path fill="#fff" d="m12.966 161.238 10.439-38.114a73.42 73.42 0 0 1-9.821-36.772c.017-40.556 33.021-73.55 73.578-73.55 19.681.01 38.154 7.669 52.047 21.572s21.537 32.383 21.53 52.037c-.018 40.553-33.027 73.553-73.578 73.553h-.032c-12.313-.005-24.412-3.094-35.159-8.954z" />
                                        <path fill="#fff" fill-rule="evenodd" d="M68.772 55.603c-1.378-3.061-2.828-3.123-4.137-3.176l-3.524-.043c-1.226 0-3.218.46-4.902 2.3s-6.435 6.287-6.435 15.332 6.588 17.785 7.506 19.013 12.718 20.381 31.405 27.75c15.529 6.124 18.689 4.906 22.061 4.6s10.877-4.447 12.408-8.74 1.532-7.971 1.073-8.74-1.685-1.226-3.525-2.146-10.877-5.367-12.562-5.981-2.91-.919-4.137.921-4.746 5.979-5.819 7.206-2.144 1.381-3.984.462-7.76-2.861-14.784-9.124c-5.465-4.873-9.154-10.891-10.228-12.73s-.114-2.835.808-3.751c.825-.824 1.838-2.147 2.759-3.22s1.224-1.84 1.836-3.065.307-2.301-.153-3.22-4.032-10.011-5.666-13.647" />
                                    </svg>
                                </div>
                                <h4 style="color: #1e293b; font-weight: 700; font-size: 1.25rem; margin-bottom: 0.5rem;">Connect Your WhatsApp Business</h4>
                                <p style="color: #64748b; margin-bottom: 1.5rem; font-size: 0.95rem;">Link your WhatsApp Business account to start managing conversations</p>
                                <button onclick="launchWhatsAppSignup()" class="whatsapp-button">
                                    <i class="lab la-whatsapp"></i> {{ __('connect_whatsApp') }}
                                </button>
                            </div>
                        @endif
                        <div class="profile_card" id="profile_card">
                            @include('addon:EmbeddedSignup::partials.business_profile_card')
                        </div>
                        <div class="text-center mt-3 pb-2">
                            <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#commonIssuesModal"
                               class="common-issues-link">
                                <i class="las la-question-circle"></i>
                                {{ __('common_issues') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('addon:EmbeddedSignup::partials.__common_issues')
    @include('addon:EmbeddedSignup::partials.update_profile_modal')
@endsection
@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.6.7/axios.min.js"></script>
    <script src="{{ static_asset('admin/js/embedded-signup.js') }}"></script>
    <script>
        var url = "{{ route('client.whatsapp.embedded-signup.store') }}";
        let signupData = {};
        window.addEventListener('message', (event) => {
            if (event.origin !== "https://www.facebook.com" && event.origin !== "https://web.facebook.com") {
                return;
            }
            const whatsappButton = $('.whatsapp-button');
            console.log("Raw event data: ", event.data);
            let data;
            if (typeof event.data === 'string') {
                try {
                    data = JSON.parse(event.data);
                } catch (error) {
                    console.log('Invalid JSON received:', event.data);
                    return;
                }
            } else {
                data = event.data;
            }
            console.log("Parsed data: ", data);
            console.log("data_type: ", data.type);
            if (data.type === 'WA_EMBEDDED_SIGNUP') {
                console.log("Inside WA_EMBEDDED_SIGNUP");
                if (data.event === 'FINISH') {
                    console.log("Inside FINISH event");
                    signupData = {
                        phone_number_id: data.data.phone_number_id,
                        business_account_id: data.data.waba_id,
                        app_id: data.data.app_id,
                        access_token: data.code
                    };

                } else if (data.event === 'CANCEL') {
                    const {
                        current_step
                    } = data.data;
                    console.warn("Cancel at step: ", current_step);
                    toastr.warning('Signup process was cancelled at step: ' + current_step, 'Cancelled');
                    whatsappButton.prop('disabled', false).html(
                        '<i class="la la-whatsapp"></i> {{ __('connect_whatsApp') }}');
                    $("body").css("cursor", "default");
                } else if (data.event === 'ERROR') {
                    const {
                        error_message
                    } = data.data;
                    console.error("Error: ", error_message);
                    Swal.fire({
                        icon: 'error',
                        title: 'Signup Error',
                        text: error_message
                    });
                    whatsappButton.prop('disabled', false).html(
                        '<i class="la la-whatsapp"></i> {{ __('connect_whatsApp') }}');
                    $("body").css("cursor", "default");
                }
            }
            // document.getElementById("session-info-response").textContent = JSON.stringify(data, null, 2);
        });
        // Function to access the stored data elsewhere in your code
        function getSignupData() {
            return signupData;
        }
        // Callback function for Facebook login
        const fbLoginCallback = (response) => {
            const whatsappButton = $('.whatsapp-button');
            // Check if response or authResponse is missing
            if (!response || !response.authResponse) {
                Swal.fire({
                    icon: 'error',
                    title: '{{ __('login_failed') }}',
                    text: '{{ __('failed_to_receive_authentication') }}'
                });
                // Re-enable button and restore text
                whatsappButton.prop('disabled', false).html(
                    '<i class="la la-whatsapp"></i> {{ __('connect_whatsApp') }}');
                $("body").css("cursor", "default");
                return;
            }
            // Extract code from response
            const code = response.authResponse.code;
            // Check if code is empty or undefined
            if (!code) {
                Swal.fire({
                    icon: 'error',
                    title: '{{ __('login_failed') }}',
                    text: '{{ __('failed_to_receive_authentication') }}'
                });
                whatsappButton.prop('disabled', false).html(
                    '<i class="la la-whatsapp"></i> {{ __('connect_whatsApp') }}');
                $("body").css("cursor", "default");
                return;
            }
            // Gather signup data
            const signupData = getSignupData();
            // Check if signupData has necessary properties
            if (!signupData || !signupData.phone_number_id || !signupData.business_account_id) {
                Swal.fire({
                    icon: 'error',
                    title: 'Data Error',
                    text: '{{ __('signup_data_is_incomplete') }}'
                });
                // Re-enable button and restore text
                whatsappButton.prop('disabled', false).html(
                    '<i class="la la-whatsapp"></i> {{ __('connect_whatsApp') }}');
                $("body").css("cursor", "default");
                return;
            }
            // Prepare request data
            const requestData = {
                phone_number_id: signupData.phone_number_id,
                business_account_id: signupData.business_account_id,
                app_id: signupData.app_id,
                code: code,
            };
            // Send data to the server
            axios.post(url, requestData, {
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}' // Laravel CSRF token
                    },
                })
                .then(response => {
                    // document.getElementById("session-info-response").textContent = JSON.stringify(response.data,
                    //     null, 2);
                    toastr.success(response.data.message);
                    whatsappButton.prop('disabled', false).html(
                        '<i class="la la-whatsapp"></i> {{ __('connect_whatsApp') }}');
                    $("body").css("cursor", "default");
                    $('#embedded_signup_integration').remove();
                    $('#profile_card').html(response.data.data);
                    showConfettiEffect();
                    // location.reload();
                })
                .catch((error) => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: '{{ __('an_error_occurred_while_processing_the_request') }}'
                    });
                    // Re-enable button and restore text
                    whatsappButton.prop('disabled', false).html(
                        '<i class="la la-whatsapp"></i> {{ __('connect_whatsApp') }}');
                    $("body").css("cursor", "default");
                });
        };
        // Function to launch the WhatsApp signup process
        const launchWhatsAppSignup = () => {
            $("body").css("cursor", "progress");
            // Select the button and disable it
            const whatsappButton = $('.whatsapp-button');
            whatsappButton.prop('disabled', true).html(
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processing...'
            );
            // Validate if the settings are not empty
            const metaConfigurationId = "{{ setting('meta_configuration_id') }}";
            const metaAppId = "{{ setting('meta_app_id') }}";
            if (!metaConfigurationId || !metaAppId) {
                Swal.fire({
                    icon: 'warning',
                    title: '{{ __('configuration_missing') }}',
                    text: '{{ __('meta_configuration_id_missing') }}'
                });
                // Enable the button and restore its text
                whatsappButton.prop('disabled', false).html(
                    '<i class="la la-whatsapp"></i> {{ __('connect_whatsApp') }}');
                $("body").css("cursor", "default");
                return;
            }
            // Trigger Facebook login using the Facebook SDK
            FB.login(fbLoginCallback, {
                config_id: metaConfigurationId, // Configuration ID set in your settings
                response_type: 'code', // Must be 'code' to get the access token
                scope: "business_management, whatsapp_business_management, whatsapp_business_messaging",
                override_default_response_type: true,
                extras: {
                    setup: {},
                    featureType: '',
                    sessionInfoVersion: '3',
                }
            });
        };
        // Initialize the Facebook SDK
        window.fbAsyncInit = function() {
            FB.init({
                appId: "{{ setting('meta_app_id') }}", // App ID from your settings
                autoLogAppEvents: true,
                xfbml: true,
                version: 'v20.0'
            });
        };
        $(document).ready(function() {
            $('.copy-text').click(function() {
                var inputField = $(this).closest('.input-group').find('input');
                inputField.select();
                document.execCommand("copy");
                toastr.success("{{ __('copied') }}");
            });
        });
        $(document).on('click', '.__js_delete', function() {
            confirmationAlert(
                $(this).data('url'),
                $(this).data('id'),
                'Yes, Delete It!'
            );
        });
        const confirmationAlert = (url, data_id, button_text = 'Yes, Confirmed it!') => {
            Swal.fire({
                title: 'Are you sure?',
                text: "{{ __('removing_this_integration') }}",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: button_text,
                confirmButtonColor: '#ff0000',
                preConfirm: () => {
                    Swal.showLoading();
                    return axios.get(url, {
                            params: {
                                data_id: data_id
                            }
                        })
                        .then(response => {
                            console.log(response);
                            Swal.fire({
                                icon: response.data.status ? 'success' : 'error',
                                title: response.data.message,
                            }).then(() => {
                                if (response.data.status) {
                                    location.reload();
                                }
                            });
                        })
                        .catch(error => {
                            console.log(error);
                            Swal.fire('Error',
                                '{{ __('an_error_occurred_while_processing_the_request') }}');
                        });
                }
            });
        };
        $('#sync_button').click(function() {
            var button = $(this);
            var url = button.data('url');
            var id = button.data('id');
            // Change cursor to progress
            $("body").css("cursor", "progress");
            // Change button content to show spinner and syncing text
            button.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> ' +
                '{{ __('syncing') }}');
            axios.get(url, {
                    params: {
                        id: id
                    },
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => {
                    // Restore button content after request completes
                    button.html('<i class="las la-sync-alt"></i>');

                    // Reset cursor back to default
                    $("body").css("cursor", "default");

                    if (response.data.status) {
                        toastr.success(response.data.message);
                        // location.reload();
                    } else {
                        toastr.error(response.data.message);
                    }
                })
                .catch(error => {
                    // Restore button content in case of error
                    button.html('<i class="las la-sync-alt"></i>');

                    // Reset cursor back to default
                    $("body").css("cursor", "default");

                    console.error('Error:', error);
                    toastr.error("{{ __('an_error_occurred_while_processing_the_request') }}");
                });
        });

        $('#test_button').click(function() {
            showConfettiEffect();
        });

        function showConfettiEffect(particleCount = 200, spread = 60, originY = 0.6) {
            confetti({
                particleCount: particleCount,
                spread: spread,
                origin: {
                    y: originY
                } // Adjust the origin of the confetti
            });
        }
    </script>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.5.1/dist/confetti.browser.min.js"></script>
@endpush
