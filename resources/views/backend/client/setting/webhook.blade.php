@extends('backend.layouts.master')
@section('title', __('Webhook Settings'))
@section('content')
    <style>
        .webhook-page {
            background: #f1f3fb;
            min-height: 100vh;
            padding: 1.5rem 0;
        }
        
        .webhook-header {
            background: linear-gradient(135deg, #1e3a5f 0%, #0d1b2a 100%);
            border-radius: 16px;
            padding: 2rem;
            margin-bottom: 1.5rem;
            color: white;
            position: relative;
            overflow: hidden;
        }
        
        .webhook-header::before {
            content: '{ }';
            position: absolute;
            right: 2rem;
            top: 50%;
            transform: translateY(-50%);
            font-size: 6rem;
            opacity: 0.1;
            font-weight: bold;
        }
        
        .webhook-header h1 {
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        
        .webhook-header p {
            opacity: 0.8;
            margin: 0;
        }
        
        .webhook-card {
            background: #ffffff;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }
        
        .webhook-card .card-title {
            font-size: 1rem;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .webhook-card .card-title i {
            color: #3b82f6;
        }
        
        .webhook-item {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1rem;
        }
        
        .webhook-item:last-child {
            margin-bottom: 0;
        }
        
        .webhook-item label {
            font-size: 0.75rem;
            font-weight: 600;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 0.5rem;
            display: block;
        }
        
        .webhook-input-group {
            display: flex;
            gap: 0.5rem;
        }
        
        .webhook-input-group input {
            flex: 1;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 0.625rem 0.875rem;
            font-size: 0.875rem;
            color: #1e293b;
        }
        
        .toggle-switch {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 26px;
        }
        
        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }
        
        .toggle-slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 26px;
        }
        
        .toggle-slider:before {
            position: absolute;
            content: "";
            height: 20px;
            width: 20px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }
        
        input:checked + .toggle-slider {
            background-color: #25D366;
        }
        
        input:checked + .toggle-slider:before {
            transform: translateX(24px);
        }
        
        .payload-preview {
            background: #1e293b;
            border-radius: 8px;
            padding: 1rem;
            color: #e2e8f0;
            font-family: 'Monaco', 'Menlo', monospace;
            font-size: 0.8rem;
            overflow-x: auto;
            margin-top: 1rem;
        }
        
        .payload-preview pre {
            margin: 0;
            white-space: pre-wrap;
            word-wrap: break-word;
        }
        
        .info-box {
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            border-radius: 8px;
            padding: 1rem;
            margin-top: 1rem;
        }
        
        .info-box i {
            color: #3b82f6;
        }
        
        .test-btn {
            background: #f59e0b;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            cursor: pointer;
            font-size: 0.875rem;
        }
        
        .test-btn:hover {
            background: #d97706;
        }
        
        .copy-btn {
            background: #e2e8f0;
            border: none;
            padding: 0.5rem 0.75rem;
            border-radius: 6px;
            cursor: pointer;
        }
        
        .copy-btn:hover {
            background: #cbd5e1;
        }
    </style>
    
    <div class="webhook-page">
        <div class="container-fluid">
            <!-- Header -->
            <div class="webhook-header">
                <h1><i class="las la-broadcast-tower"></i> {{ __('Webhook Settings') }}</h1>
                <p>{{ __('Forward incoming WhatsApp messages to your external server or application') }}</p>
            </div>
            
            <!-- Webhook Configuration -->
            <div class="webhook-card">
                <div class="card-title">
                    <i class="las la-cog"></i>
                    {{ __('Webhook Configuration') }}
                </div>
                
                <form action="{{ route('client.webhook.settings.update') }}" method="POST" id="webhookSettingsForm">
                    @csrf
                    
                    <div class="webhook-item">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <label class="mb-0">{{ __('Enable Webhook Forwarding') }}</label>
                                <small class="text-muted d-block">{{ __('When enabled, all incoming WhatsApp messages will be forwarded to your webhook URL') }}</small>
                            </div>
                            <label class="toggle-switch">
                                <input type="checkbox" name="webhook_enabled" id="webhook_enabled" value="1" {{ $client->webhook_enabled ? 'checked' : '' }}>
                                <span class="toggle-slider"></span>
                            </label>
                        </div>
                    </div>
                    
                    <div class="webhook-item">
                        <label>{{ __('Webhook URL') }}</label>
                        <div class="webhook-input-group">
                            <input type="url" name="webhook_url" id="webhook_url" class="form-control" 
                                   placeholder="https://your-server.com/webhook/incoming" 
                                   value="{{ $client->webhook_url }}">
                        </div>
                        <small class="text-muted mt-2 d-block">{{ __('Enter the URL where you want to receive incoming message payloads') }}</small>
                        @if ($errors->has('webhook_url'))
                            <div class="text-danger mt-1">
                                <small>{{ $errors->first('webhook_url') }}</small>
                            </div>
                        @endif
                    </div>
                    
                    <div class="webhook-item">
                        <label>{{ __('Webhook Secret') }} <span class="text-muted">({{ __('Optional') }})</span></label>
                        <div class="webhook-input-group">
                            <input type="text" name="webhook_secret" id="webhook_secret" class="form-control" 
                                   placeholder="{{ __('Your secret key for signature verification') }}" 
                                   value="{{ $client->webhook_secret }}">
                            <button type="button" class="copy-btn" onclick="generateSecret()">
                                <i class="las la-sync-alt"></i> {{ __('Generate') }}
                            </button>
                        </div>
                        <small class="text-muted mt-2 d-block">{{ __('Used to sign webhook payloads. The signature will be sent in X-Webhook-Signature header') }}</small>
                    </div>
                    
                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn sg-btn-primary">
                            <i class="las la-save"></i> {{ __('Save Settings') }}
                        </button>
                        <button type="button" class="test-btn" onclick="testWebhook()">
                            <i class="las la-vial"></i> {{ __('Test Webhook') }}
                        </button>
                    </div>
                </form>
            </div>
            
            <!-- Payload Information -->
            <div class="webhook-card">
                <div class="card-title">
                    <i class="las la-code"></i>
                    {{ __('Payload Format') }}
                </div>
                
                <p class="text-muted">{{ __('When a new message is received, the following payload will be sent to your webhook URL via POST request:') }}</p>
                
                <div class="payload-preview">
                    <pre>{
    "event": "incoming_message",
    "timestamp": "2026-01-01T12:00:00Z",
    "client_id": {{ $client->id }},
    "data": {
        "message_id": "wamid.xxxxx",
        "from": "+919876543210",
        "contact_name": "John Doe",
        "type": "text",
        "text": "Hello, this is a message",
        "timestamp": "1704067200",
        "metadata": {
            "phone_number_id": "your_phone_number_id",
            "display_phone_number": "+1234567890"
        }
    },
    "raw_payload": { ... }
}</pre>
                </div>
                
                <div class="info-box">
                    <p class="mb-2"><i class="las la-info-circle"></i> <strong>{{ __('Headers sent with each request:') }}</strong></p>
                    <ul class="mb-0" style="font-size: 0.875rem;">
                        <li><code>Content-Type: application/json</code></li>
                        <li><code>X-Webhook-Signature: sha256=...</code> {{ __('(if secret is configured)') }}</li>
                        <li><code>X-Webhook-Event: incoming_message</code></li>
                        <li><code>X-Client-Id: {{ $client->id }}</code></li>
                    </ul>
                </div>
            </div>
            
            <!-- Security Tips -->
            <div class="webhook-card">
                <div class="card-title">
                    <i class="las la-shield-alt"></i>
                    {{ __('Security Recommendations') }}
                </div>
                
                <ul class="mb-0">
                    <li>{{ __('Always use HTTPS for your webhook URL') }}</li>
                    <li>{{ __('Set a webhook secret and verify the signature on your server') }}</li>
                    <li>{{ __('Respond with a 200 status code quickly to acknowledge receipt') }}</li>
                    <li>{{ __('Process messages asynchronously to avoid timeouts') }}</li>
                </ul>
            </div>
        </div>
    </div>
@endsection

@push('js')
<script>
    function generateSecret() {
        const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        let secret = '';
        for (let i = 0; i < 32; i++) {
            secret += chars.charAt(Math.floor(Math.random() * chars.length));
        }
        document.getElementById('webhook_secret').value = secret;
    }
    
    function testWebhook() {
        const url = document.getElementById('webhook_url').value;
        if (!url) {
            if (typeof toastr !== 'undefined') {
                toastr.error('{{ __("Please enter a webhook URL first") }}');
            } else {
                alert('{{ __("Please enter a webhook URL first") }}');
            }
            return;
        }
        
        $.ajax({
            url: '{{ route("client.webhook.settings.test") }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                webhook_url: url,
                webhook_secret: document.getElementById('webhook_secret').value
            },
            beforeSend: function() {
                $('.test-btn').prop('disabled', true).html('<i class="las la-spinner la-spin"></i> {{ __("Testing...") }}');
            },
            success: function(response) {
                if (response.success) {
                    if (typeof toastr !== 'undefined') {
                        toastr.success(response.message || '{{ __("Webhook test successful!") }}');
                    } else {
                        alert(response.message || '{{ __("Webhook test successful!") }}');
                    }
                } else {
                    if (typeof toastr !== 'undefined') {
                        toastr.error(response.message || '{{ __("Webhook test failed") }}');
                    } else {
                        alert(response.message || '{{ __("Webhook test failed") }}');
                    }
                }
            },
            error: function(xhr) {
                let message = '{{ __("Webhook test failed") }}';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    message = xhr.responseJSON.message;
                }
                if (typeof toastr !== 'undefined') {
                    toastr.error(message);
                } else {
                    alert(message);
                }
            },
            complete: function() {
                $('.test-btn').prop('disabled', false).html('<i class="las la-vial"></i> {{ __("Test Webhook") }}');
            }
        });
    }
</script>
@endpush
