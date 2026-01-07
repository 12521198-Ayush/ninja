@if (@Auth::user()->client->whatsappSetting)
    <style>
        .business-profile-wrapper {
            padding: 0;
        }
        
        .alert-modern {
            border-radius: 12px;
            border: none;
            padding: 1rem 1.25rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
        }
        
        .alert-modern i {
            font-size: 1.25rem;
            margin-top: 2px;
        }
        
        .alert-modern.alert-danger {
            background: #fef2f2;
            border-left: 4px solid #ef4444;
            color: #991b1b;
        }
        
        .alert-modern.alert-warning {
            background: #fffbeb;
            border-left: 4px solid #f59e0b;
            color: #92400e;
        }
        
        .section-title-modern {
            font-size: 1.25rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .section-title-modern::before {
            content: '';
            width: 4px;
            height: 24px;
            background: linear-gradient(180deg, #10b981 0%, #059669 100%);
            border-radius: 2px;
        }
        
        .info-card {
            background: #ffffff;
            border-radius: 12px;
            padding: 1.25rem;
            margin-bottom: 1rem;
            border: 1px solid #e2e8f0;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            transition: all 0.2s ease;
        }
        
        .info-card:hover {
            border-color: #10b981;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.1);
        }
        
        .info-card-header {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            margin: -1.25rem -1.25rem 1rem -1.25rem;
            padding: 0.875rem 1.25rem;
            border-bottom: 1px solid #e2e8f0;
            border-radius: 12px 12px 0 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .info-card-header i {
            color: #10b981;
            font-size: 1.1rem;
        }
        
        .info-card-header span {
            font-weight: 600;
            color: #334155;
            font-size: 0.95rem;
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
        }
        
        @media (max-width: 768px) {
            .info-grid {
                grid-template-columns: 1fr;
            }
        }
        
        .info-item {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }
        
        .info-label {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.8rem;
            font-weight: 500;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.025em;
        }
        
        .info-label i {
            color: #10b981;
            font-size: 0.95rem;
        }
        
        .info-value {
            color: #1e293b;
            font-weight: 600;
            font-size: 0.95rem;
            word-break: break-word;
        }
        
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            padding: 0.25rem 0.75rem;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.025em;
        }
        
        .status-badge.status-green {
            background: #dcfce7;
            color: #166534;
        }
        
        .status-badge.status-verified {
            background: #dbeafe;
            color: #1e40af;
        }
        
        .status-badge.status-not-verified {
            background: #fee2e2;
            color: #dc2626;
        }
        
        .status-badge.status-unknown {
            background: #ffedd5;
            color: #ea580c;
        }
        
        .action-bar {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 0.75rem;
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid #e2e8f0;
        }
        
        .btn-action {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.625rem 1.25rem;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.875rem;
            border: none;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        
        .btn-action i {
            font-size: 1rem;
        }
        
        .btn-action:hover {
            transform: translateY(-1px);
        }
        
        .btn-sync {
            background: #f1f5f9;
            color: #475569;
            border: 1px solid #e2e8f0;
        }
        
        .btn-sync:hover {
            background: #e2e8f0;
            color: #334155;
        }
        
        .btn-edit {
            background: #3b82f6;
            color: white;
        }
        
        .btn-edit:hover {
            background: #2563eb;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }
        
        .btn-delete {
            background: #fee2e2;
            color: #dc2626;
            border: 1px solid #fecaca;
        }
        
        .btn-delete:hover {
            background: #fecaca;
            color: #b91c1c;
        }
        
        @media (max-width: 576px) {
            .action-bar {
                flex-wrap: wrap;
                justify-content: stretch;
            }
            
            .btn-action {
                flex: 1;
                justify-content: center;
                min-width: 120px;
            }
        }
    </style>
    
    <div class="business-profile-wrapper">
        @if (!empty(@Auth::user()->client->whatsappSetting))
            @if (!whatsappConnected())
                <div class="alert alert-modern alert-danger" role="alert">
                    <i class="las la-exclamation-circle"></i>
                    <div>{{ __('not_connected!_please_complete_all_the_steps_in_order_to_connect_to_whatsapp_cloud_api') }}</div>
                </div>
            @endif
        @endif
        
        @if (!empty(@Auth::user()->client->whatsappSetting) && !isWhatsAppWebhookConnected())
            <div class="alert alert-modern alert-warning" role="alert">
                <i class="las la-exclamation-triangle"></i>
                <div>
                    <strong>{{ __('oops') }}</strong> {{ __('whatsapp_webhook_not_connected') }}<br>
                    <small>{{ __('real_time_updates_will_not_be_available_until_the_webhook_is_connected') }}</small>
                    @if (!empty(@Auth::user()->client->whatsappSetting->access_token) && !empty(@Auth::user()->client->whatsappSetting->scopes))
                        <a href="https://developers.facebook.com/apps/{{ Auth::user()->client->whatsappSetting->app_id }}/whatsapp-business/wa-settings/?business_id={{ Auth::user()->client->whatsappSetting->business_account_id }}"
                            target="_blank" style="color: #92400e; font-weight: 600; text-decoration: underline;">
                            <i class="las la-external-link-alt"></i> {{ __('add_whatsapp_webhook') }}
                        </a>
                    @endif
                </div>
            </div>
        @endif
        
        <h5 class="section-title-modern">{{ __('business_account_details') }}</h5>
        
        <!-- Business Account Info Card -->
        <div class="info-card">
            <div class="info-card-header">
                <i class="las la-building"></i>
                <span>Account Information</span>
            </div>
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">
                        <i class="las la-user-circle"></i>
                        {{ __('business_account_name') }}
                    </div>
                    <div class="info-value">{{ @Auth::user()->client->whatsappSetting->business_account_name }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">
                        <i class="las la-hashtag"></i>
                        {{ __('business_account_id') }}
                    </div>
                    <div class="info-value">{{ Auth::user()->client->whatsappSetting->business_account_id }}</div>
                </div>
            </div>
        </div>

        @foreach (Auth::user()->client->whatsappSetting->details as $index => $details)
            <!-- Phone Number Card -->
            <div class="info-card">
                <div class="info-card-header">
                    <i class="las la-phone"></i>
                    <span>{{ $details->verified_name ?? 'Phone Number ' . ($index + 1) }}</span>
                </div>
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">
                            <i class="las la-mobile"></i>
                            {{ __('phone_number') }}
                        </div>
                        <div class="info-value">{{ $details->display_phone_number ?? 'N/A' }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">
                            <i class="las la-check-double"></i>
                            {{ __('verified_name') }}
                        </div>
                        <div class="info-value">{{ $details->verified_name ?? 'N/A' }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">
                            <i class="las la-fingerprint"></i>
                            {{ __('phone_number_id') }}
                        </div>
                        <div class="info-value">{{ $details->phone_number_id ?? 'N/A' }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">
                            <i class="las la-star"></i>
                            {{ __('quality_rating') }}
                        </div>
                        <div class="info-value">
                            @if($details->quality_rating ?? null)
                                @if(strtoupper($details->quality_rating) == 'GREEN')
                                    <span class="status-badge status-green">
                                        <i class="las la-check-circle"></i>
                                        {{ $details->quality_rating }}
                                    </span>
                                @elseif(strtoupper($details->quality_rating) == 'UNKNOWN')
                                    <span class="status-badge status-unknown">
                                        <i class="las la-question-circle"></i>
                                        {{ $details->quality_rating }}
                                    </span>
                                @else
                                    <span class="status-badge status-not-verified">
                                        <i class="las la-exclamation-circle"></i>
                                        {{ $details->quality_rating }}
                                    </span>
                                @endif
                            @else
                                N/A
                            @endif
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">
                            <i class="las la-comments"></i>
                            {{ __('message_limit') }}
                        </div>
                        <div class="info-value">{{ $details->message_limit ?? 'N/A' }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">
                            <i class="las la-signal"></i>
                            {{ __('number_status') }}
                        </div>
                        <div class="info-value">{{ $details->number_status ?? 'N/A' }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">
                            <i class="las la-shield-alt"></i>
                            {{ __('code_verification_status') }}
                        </div>
                        <div class="info-value">
                            @if($details->code_verification_status ?? null)
                                @if(strtoupper($details->code_verification_status) == 'VERIFIED')
                                    <span class="status-badge status-verified">
                                        <i class="las la-check"></i>
                                        {{ $details->code_verification_status }}
                                    </span>
                                @else
                                    <span class="status-badge status-not-verified">
                                        <i class="las la-times"></i>
                                        {{ $details->code_verification_status }}
                                    </span>
                                @endif
                            @else
                                N/A
                            @endif
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">
                            <i class="las la-clipboard-check"></i>
                            {{ __('account_review_status') }}
                        </div>
                        <div class="info-value">{{ $details->account_review_status ?? 'N/A' }}</div>
                    </div>
                </div>
            </div>
        @endforeach
        
        <!-- Action Buttons -->
        <div class="action-bar">
            @if (@Auth::user()->client->whatsappSetting)
                <button type="button" class="btn-action btn-sync" id="sync_button"
                    data-id="{{ @Auth::user()->client->whatsappSetting->id }}"
                    data-url="{{ route('client.whatsapp.embedded-signup.sync', @Auth::user()->client->whatsappSetting->id) }}">
                    <i class="las la-sync-alt"></i> {{ __('sync') }}
                </button>
            @endif
            
            <button type="button" class="btn-action btn-edit __js_edit"
                data-id="{{ @Auth::user()->client->whatsappSetting->id }}"
                data-url="{{ route('client.whatsapp.profile.edit', @Auth::user()->client->whatsappSetting->id) }}">
                <i class="las la-edit"></i> {{ __('edit') }}
            </button>
            
            @if (@Auth::user()->client->whatsappSetting->access_token)
                <button type="button" class="btn-action btn-delete __js_delete"
                    data-id="{{ @Auth::user()->client->whatsappSetting->id }}"
                    data-url="{{ route('client.whatsapp.embedded-signup.delete', @Auth::user()->client->whatsappSetting->id) }}">
                    <i class="las la-trash-alt"></i> {{ __('remove_whatsapp_account') }}
                </button>
            @endif
        </div>
    </div>
@endif
