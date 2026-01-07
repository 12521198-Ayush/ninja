<!-- Modal -->
<div class="modal fade" id="commonIssuesModal" tabindex="-1" aria-labelledby="commonIssuesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="commonIssuesModalLabel">{{ __('common_issues_solutions') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('close') }}"></button>
            </div>
            <!-- Modal -->
            <div class="modal-body">
                <h5 class="mt-2">{{ __('popup_plocker_prevents_signup') }}</h5>
                <p class="mt-2"><strong>{{ __('symptoms') }}:</strong> {{ __('popup_blocker_symptoms') }}</p>
                <p class="mt-2"><strong>{{ __('solution:') }}</strong> {{ __('popup_blocker_solution') }}</p>

                <h5 class="mt-2">{{ __('login_error_failed_facebook_authentication') }}</h5>
                <p class="mt-2"><strong>{{ __('symptoms') }}:</strong> {{ __('login_error_symptoms') }}</p>
                <p class="mt-2"><strong>{{ __('solution:') }}</strong>
                    <ul class="ps-3">
                        <li><i class="las la-arrow-right"></i> {{ __('login_error_solution_1') }}</li>
                        <li><i class="las la-arrow-right"></i> {{ __('login_error_solution_2') }}</li>
                    </ul>
                </p>

                <h5 class="mt-2">{{ __('missing_permissions') }}</h5>
                <p class="mt-2"><strong>{{ __('symptoms') }}:</strong> {{ __('missing_permissions_symptoms') }}</p>
                <p class="mt-2"><strong>{{ __('solution:') }}</strong> {{ __('missing_permissions_solution') }}</p>

                <h5 class="mt-2">{{ __('phone_number_not_verified') }}</h5>
                <p class="mt-2"><strong>{{ __('symptoms') }}:</strong> {{ __('phone_number_not_verified_symptoms') }}</p>
                <p class="mt-2"><strong>{{ __('solution:') }}</strong>
                    <ul class="ps-3">
                        <li><i class="las la-arrow-right"></i> {{ __('phone_number_not_verified_solution_1') }}</li>
                        <li><i class="las la-arrow-right"></i> {{ __('phone_number_not_verified_solution_2') }}</li>
                    </ul>
                </p>

                <h5 class="mt-2">{{ __('invalid_business_information') }}</h5>
                <p class="mt-2"><strong>{{ __('symptoms') }}:</strong> {{ __('invalid_business_information_symptoms') }}</p>
                <p class="mt-2"><strong>{{ __('solution:') }}</strong> {{ __('invalid_business_information_solution') }}</p>

                <h5 class="mt-2">{{ __('access_token_expired_invalid') }}</h5>
                <p class="mt-2"><strong>{{ __('symptoms') }}:</strong> {{ __('access_token_expired_symptoms') }}</p>
                <p class="mt-2"><strong>{{ __('solution:') }}</strong> {{ __('access_token_expired_solution') }}</p>

                <h5 class="mt-2">{{ __('signup_fails_mobile') }}</h5>
                <p class="mt-2"><strong>{{ __('symptoms') }}:</strong> {{ __('signup_fails_mobile_symptoms') }}</p>
                <p class="mt-2"><strong>{{ __('solution:') }}</strong> {{ __('signup_fails_mobile_solution') }}</p>

                <h5 class="mt-2">{{ __('phone_number_already_in_use') }}</h5>
                <p class="mt-2"><strong>{{ __('symptoms') }}:</strong> {{ __('phone_number_already_in_use_symptoms') }}</p>
                <p class="mt-2"><strong>{{ __('solution:') }}</strong> {{ __('phone_number_already_in_use_solution') }}</p>

                <h5 class="mt-2">{{ __('business_profile_not_loading') }}</h5>
                <p class="mt-2"><strong>{{ __('symptoms') }}:</strong> {{ __('business_profile_not_loading_symptoms') }}</p>
                <p class="mt-2"><strong>{{ __('solution:') }}</strong> {{ __('business_profile_not_loading_solution') }}</p>

                <h5 class="mt-2">{{ __('unsupported_get_request_error') }}</h5>
                <p class="mt-2"><strong>{{ __('symptoms') }}:</strong> {{ __('unsupported_get_request_symptoms') }}</p>
                <p class="mt-2"><strong>{{ __('solution:') }}</strong> {{ __('unsupported_get_request_solution') }}</p>

                <h5 class="mt-2">{{ __('payment_method_integration_issues') }}</h5>
                <p class="mt-2"><strong>{{ __('symptoms') }}:</strong> {{ __('payment_method_integration_issues_symptoms') }}</p>
                <p class="mt-2"><strong>{{ __('solution:') }}</strong>
                    <ol class="ps-3">
                        <li><i class="las la-arrow-right"></i> {{ __('payment_method_integration_issues_solution_1') }}</li>
                        <li><i class="las la-arrow-right"></i> {{ __('payment_method_integration_issues_solution_2') }}</li>
                        <li><i class="las la-arrow-right"></i> {{ __('payment_method_integration_issues_solution_3') }}</li>
                    </ol>
                </p>
                <h5>{{ __('additional_tips') }}</h5>
                <ol class="ps-3">
                    <li><i class="las la-arrow-right"></i> {{ __('browser_update') }}</li>
                    <li><i class="las la-arrow-right"></i> {{ __('check_internet') }}</li>
                    <li><i class="las la-arrow-right"></i> {{ __('clear_cache_cookies') }}</li>
                </ol>
                <h5 class="mt-2">{{ __('step_by_step_directions') }}</h5>
                <ol class="list-unstyled">
                    <li><i class="las la-arrow-right"></i> {{ __('connect_whatsapp_button') }}</li>
                    <li><i class="las la-arrow-right"></i> {{ __('follow_prompts_facebook_login') }}</li>
                    <li><i class="las la-arrow-right"></i> {{ __('grant_permissions_when_prompted') }}</li>
                    <li><i class="las la-arrow-right"></i> {{ __('verify_phone_number_sms_voice') }}</li>
                    <li><i class="las la-arrow-right"></i> {{ __('complete_business_information_prompted') }}</li>
                </ol>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('close') }}</button>
            </div>
        </div>
    </div>
</div>
