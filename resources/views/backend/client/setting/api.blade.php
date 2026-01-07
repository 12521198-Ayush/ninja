@extends('backend.layouts.master')
@section('title', __('api'))
@section('content')
    <style>
        .api-page {
            background: #f1f3fb;
            min-height: 100vh;
            padding: 1.5rem 0;
        }
        
        .api-header {
            background: linear-gradient(135deg, #1e3a5f 0%, #0d1b2a 100%);
            border-radius: 16px;
            padding: 2rem;
            margin-bottom: 1.5rem;
            color: white;
            position: relative;
            overflow: hidden;
        }
        
        .api-header::before {
            content: '</>';
            position: absolute;
            right: 2rem;
            top: 50%;
            transform: translateY(-50%);
            font-size: 6rem;
            opacity: 0.1;
            font-weight: bold;
        }
        
        .api-header h1 {
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        
        .api-header p {
            opacity: 0.8;
            margin: 0;
        }
        
        .credentials-card {
            background: #ffffff;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }
        
        .credentials-card .card-title {
            font-size: 1rem;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .credentials-card .card-title i {
            color: #3b82f6;
        }
        
        .credential-item {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1rem;
        }
        
        .credential-item:last-child {
            margin-bottom: 0;
        }
        
        .credential-item label {
            font-size: 0.75rem;
            font-weight: 600;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 0.5rem;
            display: block;
        }
        
        .credential-input-group {
            display: flex;
            gap: 0.5rem;
        }
        
        .credential-input-group input {
            flex: 1;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 0.625rem 0.875rem;
            font-size: 0.875rem;
            color: #1e293b;
            font-family: 'Monaco', 'Menlo', monospace;
        }
        
        .btn-copy {
            background: #3b82f6;
            color: white;
            border: none;
            border-radius: 6px;
            padding: 0.625rem 1rem;
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 0.35rem;
        }
        
        .btn-copy:hover {
            background: #2563eb;
        }
        
        .api-nav {
            background: #ffffff;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            padding: 1rem;
            position: sticky;
            top: 1rem;
        }
        
        .api-nav-title {
            font-size: 0.75rem;
            font-weight: 600;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 0.75rem;
            padding-left: 0.5rem;
        }
        
        .api-nav-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .api-nav-list li {
            margin-bottom: 0.25rem;
        }
        
        .api-nav-list a {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 0.75rem;
            border-radius: 6px;
            color: #475569;
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.2s;
        }
        
        .api-nav-list a:hover,
        .api-nav-list a.active {
            background: #f1f5f9;
            color: #3b82f6;
        }
        
        .api-nav-list a .step-num {
            width: 20px;
            height: 20px;
            background: #e2e8f0;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
            font-weight: 600;
            color: #64748b;
        }
        
        .api-nav-list a:hover .step-num,
        .api-nav-list a.active .step-num {
            background: #3b82f6;
            color: white;
        }
        
        .api-section {
            background: #ffffff;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            margin-bottom: 1.5rem;
            overflow: hidden;
        }
        
        .api-section-header {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
        }
        
        .api-section-header h3 {
            font-size: 1.1rem;
            font-weight: 700;
            color: #1e293b;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .api-section-header .step-badge {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            color: white;
            font-size: 0.75rem;
            font-weight: 600;
            padding: 0.25rem 0.75rem;
            border-radius: 50px;
        }
        
        .method-badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 4px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.025em;
        }
        
        .method-badge.get {
            background: #dcfce7;
            color: #166534;
        }
        
        .method-badge.post {
            background: #dbeafe;
            color: #1e40af;
        }
        
        .api-section-body {
            padding: 1.5rem;
        }
        
        .endpoint-box {
            background: #1e293b;
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
        }
        
        .endpoint-box code {
            color: #22d3ee;
            font-size: 0.9rem;
            font-family: 'Monaco', 'Menlo', monospace;
        }
        
        .endpoint-box .btn-copy-sm {
            background: rgba(255,255,255,0.1);
            color: white;
            border: none;
            border-radius: 4px;
            padding: 0.35rem 0.75rem;
            font-size: 0.75rem;
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .endpoint-box .btn-copy-sm:hover {
            background: rgba(255,255,255,0.2);
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
            margin-bottom: 1.5rem;
        }
        
        @media (max-width: 768px) {
            .info-grid {
                grid-template-columns: 1fr;
            }
        }
        
        .info-card {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 1rem;
        }
        
        .info-card h5 {
            font-size: 0.75rem;
            font-weight: 600;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .info-card h5 i {
            color: #3b82f6;
        }
        
        .param-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.875rem;
        }
        
        .param-table th {
            text-align: left;
            padding: 0.75rem;
            background: #f1f5f9;
            color: #475569;
            font-weight: 600;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border-bottom: 1px solid #e2e8f0;
        }
        
        .param-table td {
            padding: 0.75rem;
            border-bottom: 1px solid #e2e8f0;
            color: #334155;
        }
        
        .param-table tr:last-child td {
            border-bottom: none;
        }
        
        .param-name {
            font-family: 'Monaco', 'Menlo', monospace;
            background: #e2e8f0;
            padding: 0.15rem 0.5rem;
            border-radius: 4px;
            font-size: 0.8rem;
            color: #0f172a;
        }
        
        .param-required {
            color: #dc2626;
            font-weight: 600;
            font-size: 0.75rem;
        }
        
        .param-optional {
            color: #64748b;
            font-size: 0.75rem;
        }
        
        .code-block {
            background: #1e293b;
            border-radius: 8px;
            overflow: hidden;
            margin-bottom: 1rem;
        }
        
        .code-block-header {
            background: #0f172a;
            padding: 0.75rem 1rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid #334155;
        }
        
        .code-block-header span {
            color: #94a3b8;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
        }
        
        .code-block-header .btn-copy-code {
            background: transparent;
            color: #94a3b8;
            border: none;
            font-size: 0.75rem;
            cursor: pointer;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            transition: all 0.2s;
        }
        
        .code-block-header .btn-copy-code:hover {
            background: rgba(255,255,255,0.1);
            color: white;
        }
        
        .code-block pre {
            margin: 0;
            padding: 1rem;
            overflow-x: auto;
            color: #e2e8f0;
            font-size: 0.8rem;
            font-family: 'Monaco', 'Menlo', monospace;
            line-height: 1.6;
        }
        
        .code-block pre .key {
            color: #7dd3fc;
        }
        
        .code-block pre .string {
            color: #86efac;
        }
        
        .code-block pre .number {
            color: #fcd34d;
        }
        
        .response-tabs {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }
        
        .response-tab {
            padding: 0.5rem 1rem;
            border: none;
            background: #f1f5f9;
            color: #64748b;
            font-size: 0.8rem;
            font-weight: 600;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .response-tab.active {
            background: #3b82f6;
            color: white;
        }
        
        .response-tab.success {
            border-left: 3px solid #22c55e;
        }
        
        .response-tab.error {
            border-left: 3px solid #ef4444;
        }
        
        .response-content {
            display: none;
        }
        
        .response-content.active {
            display: block;
        }
        
        .alert-info-custom {
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            border-radius: 8px;
            padding: 1rem;
            display: flex;
            gap: 0.75rem;
            margin-bottom: 1rem;
        }
        
        .alert-info-custom i {
            color: #3b82f6;
            font-size: 1.25rem;
        }
        
        .alert-info-custom p {
            color: #1e40af;
            font-size: 0.875rem;
            margin: 0;
        }
        
        .try-it-section {
            background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
            border: 1px solid #86efac;
            border-radius: 8px;
            padding: 1.25rem;
            margin-top: 1.5rem;
        }
        
        .try-it-section h5 {
            color: #166534;
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .curl-command {
            background: #1e293b;
            border-radius: 6px;
            padding: 1rem;
            color: #e2e8f0;
            font-size: 0.75rem;
            font-family: 'Monaco', 'Menlo', monospace;
            overflow-x: auto;
            white-space: pre-wrap;
            word-break: break-all;
        }
    </style>

    <div class="api-page">
        <div class="container-fluid">
            <!-- Header -->
            <div class="api-header">
                <h1><i class="las la-code"></i> {{ __('api_documentation') }}</h1>
                <p>Complete guide to integrate WhatsApp messaging into your applications</p>
            </div>
            
            <div class="row">
                <!-- Sidebar Navigation -->
                <div class="col-lg-3">
                    <div class="api-nav">
                        <div class="api-nav-title">Quick Navigation</div>
                        <ul class="api-nav-list">
                            <li><a href="#credentials" class="active"><span class="step-num">0</span> API Credentials</a></li>
                            <li><a href="#step1"><span class="step-num">1</span> Login / Authentication</a></li>
                            <li><a href="#step2"><span class="step-num">2</span> Get Templates</a></li>
                            <li><a href="#step3"><span class="step-num">3</span> Send Template Message</a></li>
                            <li><a href="#step4"><span class="step-num">4</span> Send Normal Message</a></li>
                            <li><a href="#errors"><span class="step-num">!</span> Error Handling</a></li>
                        </ul>
                    </div>
                </div>
                
                <!-- Main Content -->
                <div class="col-lg-9">
                    <!-- API Credentials -->
                    <div class="credentials-card" id="credentials">
                        <div class="card-title"><i class="las la-key"></i> Your API Credentials</div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="credential-item">
                                    <label>Base URL / API Endpoint</label>
                                    <div class="credential-input-group">
                                        <input type="text" value="{{ url('/api') }}" readonly id="base-url">
                                        <button type="button" class="btn-copy" onclick="copyToClipboard('base-url')">
                                            <i class="las la-copy"></i> Copy
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="credential-item">
                                    <label>Your API Key</label>
                                    <div class="credential-input-group">
                                        <input type="text" value="{{ isDemoMode() ? '******************' : @Auth::user()->client->api_key }}" readonly id="api-key">
                                        <button type="button" class="btn-copy" onclick="copyToClipboard('api-key')">
                                            <i class="las la-copy"></i> Copy
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Step 1: Login -->
                    <div class="api-section" id="step1">
                        <div class="api-section-header">
                            <h3>
                                <span class="step-badge">Step 1</span>
                                Login / Get JWT Token
                            </h3>
                            <span class="method-badge post">POST</span>
                        </div>
                        <div class="api-section-body">
                            <div class="alert-info-custom">
                                <i class="las la-info-circle"></i>
                                <p><strong>Important:</strong> You must first login to get a JWT token. This token is required for all other API calls.</p>
                            </div>
                            
                            <div class="endpoint-box">
                                <code>POST {{ url('/api') }}/login</code>
                                <button class="btn-copy-sm" onclick="copyText('{{ url('/api') }}/login')"><i class="las la-copy"></i> Copy</button>
                            </div>
                            
                            <div class="info-grid">
                                <div class="info-card">
                                    <h5><i class="las la-heading"></i> Headers</h5>
                                    <table class="param-table">
                                        <tr>
                                            <td><span class="param-name">apikey</span></td>
                                            <td><span class="param-required">Required</span></td>
                                            <td>Your API key</td>
                                        </tr>
                                        <tr>
                                            <td><span class="param-name">Content-Type</span></td>
                                            <td><span class="param-required">Required</span></td>
                                            <td>application/json</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="info-card">
                                    <h5><i class="las la-file-alt"></i> Body Parameters</h5>
                                    <table class="param-table">
                                        <tr>
                                            <td><span class="param-name">email</span></td>
                                            <td><span class="param-required">Required</span></td>
                                            <td>Your email</td>
                                        </tr>
                                        <tr>
                                            <td><span class="param-name">password</span></td>
                                            <td><span class="param-required">Required</span></td>
                                            <td>Your password</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            
                            <h6 style="font-weight: 600; color: #475569; margin-bottom: 0.75rem;">Request Example</h6>
                            <div class="code-block">
                                <div class="code-block-header">
                                    <span>JSON</span>
                                    <button class="btn-copy-code" onclick="copyCodeBlock(this)"><i class="las la-copy"></i> Copy</button>
                                </div>
                                <pre>{
    <span class="key">"email"</span>: <span class="string">"user@example.com"</span>,
    <span class="key">"password"</span>: <span class="string">"your_password"</span>
}</pre>
                            </div>
                            
                            <h6 style="font-weight: 600; color: #475569; margin-bottom: 0.75rem;">Response</h6>
                            <div class="response-tabs">
                                <button class="response-tab success active" onclick="showResponse(this, 'login-success')">✓ Success (200)</button>
                                <button class="response-tab error" onclick="showResponse(this, 'login-error')">✗ Error (401)</button>
                            </div>
                            <div class="response-content active" id="login-success">
                                <div class="code-block">
                                    <div class="code-block-header">
                                        <span>Response</span>
                                        <button class="btn-copy-code" onclick="copyCodeBlock(this)"><i class="las la-copy"></i> Copy</button>
                                    </div>
                                    <pre>{
    <span class="key">"success"</span>: <span class="number">true</span>,
    <span class="key">"message"</span>: <span class="string">"Login successfully"</span>,
    <span class="key">"data"</span>: {
        <span class="key">"user"</span>: {
            <span class="key">"id"</span>: <span class="number">1</span>,
            <span class="key">"name"</span>: <span class="string">"John Doe"</span>,
            <span class="key">"email"</span>: <span class="string">"user@example.com"</span>
        },
        <span class="key">"token"</span>: <span class="string">"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9..."</span>,
        <span class="key">"token_type"</span>: <span class="string">"bearer"</span>,
        <span class="key">"expires_in"</span>: <span class="number">3600</span>
    }
}</pre>
                                </div>
                            </div>
                            <div class="response-content" id="login-error">
                                <div class="code-block">
                                    <div class="code-block-header">
                                        <span>Error Response</span>
                                    </div>
                                    <pre>{
    <span class="key">"success"</span>: <span class="number">false</span>,
    <span class="key">"message"</span>: <span class="string">"Invalid credentials"</span>,
    <span class="key">"data"</span>: []
}</pre>
                                </div>
                            </div>
                            
                            <div class="try-it-section">
                                <h5><i class="las la-terminal"></i> Try it with cURL</h5>
                                <div class="curl-command">curl -X POST "{{ url('/api') }}/login" \
  -H "apikey: YOUR_API_KEY" \
  -H "Content-Type: application/json" \
  -d '{"email": "user@example.com", "password": "your_password"}'</div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Step 2: Get Templates -->
                    <div class="api-section" id="step2">
                        <div class="api-section-header">
                            <h3>
                                <span class="step-badge">Step 2</span>
                                Get WhatsApp Templates
                            </h3>
                            <span class="method-badge get">GET</span>
                        </div>
                        <div class="api-section-body">
                            <p style="color: #64748b; margin-bottom: 1rem;">Retrieve all your approved WhatsApp message templates.</p>
                            
                            <div class="endpoint-box">
                                <code>GET {{ url('/api') }}/whatsapp-templates</code>
                                <button class="btn-copy-sm" onclick="copyText('{{ url('/api') }}/whatsapp-templates')"><i class="las la-copy"></i> Copy</button>
                            </div>
                            
                            <div class="info-card" style="margin-bottom: 1.5rem;">
                                <h5><i class="las la-heading"></i> Headers</h5>
                                <table class="param-table">
                                    <tr>
                                        <td><span class="param-name">apikey</span></td>
                                        <td><span class="param-required">Required</span></td>
                                        <td>Your API key</td>
                                    </tr>
                                    <tr>
                                        <td><span class="param-name">Authorization</span></td>
                                        <td><span class="param-required">Required</span></td>
                                        <td>Bearer {your_jwt_token}</td>
                                    </tr>
                                </table>
                            </div>
                            
                            <h6 style="font-weight: 600; color: #475569; margin-bottom: 0.75rem;">Success Response (200)</h6>
                            <div class="code-block">
                                <div class="code-block-header">
                                    <span>Response</span>
                                    <button class="btn-copy-code" onclick="copyCodeBlock(this)"><i class="las la-copy"></i> Copy</button>
                                </div>
                                <pre>{
    <span class="key">"success"</span>: <span class="number">true</span>,
    <span class="key">"message"</span>: <span class="string">"Template retrieved successfully"</span>,
    <span class="key">"data"</span>: {
        <span class="key">"template"</span>: [
            {
                <span class="key">"id"</span>: <span class="number">1</span>,
                <span class="key">"name"</span>: <span class="string">"order_confirmation"</span>,
                <span class="key">"language"</span>: <span class="string">"en"</span>,
                <span class="key">"status"</span>: <span class="string">"APPROVED"</span>,
                <span class="key">"category"</span>: <span class="string">"UTILITY"</span>,
                <span class="key">"components"</span>: [...]
            }
        ],
        <span class="key">"paginate"</span>: {
            <span class="key">"total"</span>: <span class="number">10</span>,
            <span class="key">"current_page"</span>: <span class="number">1</span>,
            <span class="key">"per_page"</span>: <span class="number">50</span>
        }
    }
}</pre>
                            </div>
                            
                            <div class="try-it-section">
                                <h5><i class="las la-terminal"></i> Try it with cURL</h5>
                                <div class="curl-command">curl -X GET "{{ url('/api') }}/whatsapp-templates" \
  -H "apikey: YOUR_API_KEY" \
  -H "Authorization: Bearer YOUR_JWT_TOKEN"</div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Step 3: Send Template Message -->
                    <div class="api-section" id="step3">
                        <div class="api-section-header">
                            <h3>
                                <span class="step-badge">Step 3</span>
                                Send Template Message
                            </h3>
                            <span class="method-badge post">POST</span>
                        </div>
                        <div class="api-section-body">
                            <p style="color: #64748b; margin-bottom: 1rem;">Send a pre-approved WhatsApp template message to a contact.</p>
                            
                            <div class="endpoint-box">
                                <code>POST {{ url('/api') }}/whatsapp/send-template</code>
                                <button class="btn-copy-sm" onclick="copyText('{{ url('/api') }}/whatsapp/send-template')"><i class="las la-copy"></i> Copy</button>
                            </div>
                            
                            <div class="info-grid">
                                <div class="info-card">
                                    <h5><i class="las la-heading"></i> Headers</h5>
                                    <table class="param-table">
                                        <tr>
                                            <td><span class="param-name">apikey</span></td>
                                            <td><span class="param-required">Required</span></td>
                                            <td>Your API key</td>
                                        </tr>
                                        <tr>
                                            <td><span class="param-name">Authorization</span></td>
                                            <td><span class="param-required">Required</span></td>
                                            <td>Bearer {jwt_token}</td>
                                        </tr>
                                        <tr>
                                            <td><span class="param-name">Content-Type</span></td>
                                            <td><span class="param-required">Required</span></td>
                                            <td>application/json</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="info-card">
                                    <h5><i class="las la-file-alt"></i> Required Parameters</h5>
                                    <table class="param-table">
                                        <tr>
                                            <td><span class="param-name">template_id</span></td>
                                            <td><span class="param-required">Required</span></td>
                                            <td>Template ID</td>
                                        </tr>
                                        <tr>
                                            <td><span class="param-name">contact_id</span></td>
                                            <td><span class="param-required">Required</span></td>
                                            <td>Contact ID</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            
                            <div class="info-card" style="margin-bottom: 1.5rem;">
                                <h5><i class="las la-sliders-h"></i> Optional Parameters (for dynamic templates)</h5>
                                <table class="param-table">
                                    <thead>
                                        <tr>
                                            <th>Parameter</th>
                                            <th>Type</th>
                                            <th>Description</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><span class="param-name">body_values</span></td>
                                            <td>object</td>
                                            <td>Values for body placeholders {1}, {2}, etc.</td>
                                        </tr>
                                        <tr>
                                            <td><span class="param-name">body_matchs</span></td>
                                            <td>object</td>
                                            <td>Match type: <code>input_value</code>, <code>contact_name</code>, <code>contact_phone</code></td>
                                        </tr>
                                        <tr>
                                            <td><span class="param-name">button_values</span></td>
                                            <td>object</td>
                                            <td>Values for button placeholders</td>
                                        </tr>
                                        <tr>
                                            <td><span class="param-name">button_matchs</span></td>
                                            <td>object</td>
                                            <td>Match type for buttons</td>
                                        </tr>
                                        <tr>
                                            <td><span class="param-name">image</span></td>
                                            <td>file</td>
                                            <td>Image for header (jpeg, png, jpg - max 2MB)</td>
                                        </tr>
                                        <tr>
                                            <td><span class="param-name">document</span></td>
                                            <td>file</td>
                                            <td>PDF document for header (max 5MB)</td>
                                        </tr>
                                        <tr>
                                            <td><span class="param-name">video</span></td>
                                            <td>file</td>
                                            <td>Video for header (mp4 - max 10MB)</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            
                            <h6 style="font-weight: 600; color: #475569; margin-bottom: 0.75rem;">Request Examples</h6>
                            
                            <p style="font-size: 0.85rem; color: #64748b; margin-bottom: 0.5rem;"><strong>Simple Template (no variables):</strong></p>
                            <div class="code-block">
                                <div class="code-block-header">
                                    <span>JSON</span>
                                    <button class="btn-copy-code" onclick="copyCodeBlock(this)"><i class="las la-copy"></i> Copy</button>
                                </div>
                                <pre>{
    <span class="key">"template_id"</span>: <span class="number">1</span>,
    <span class="key">"contact_id"</span>: <span class="number">123</span>
}</pre>
                            </div>
                            
                            <p style="font-size: 0.85rem; color: #64748b; margin-bottom: 0.5rem; margin-top: 1rem;"><strong>Template with Variables:</strong></p>
                            <div class="code-block">
                                <div class="code-block-header">
                                    <span>JSON</span>
                                    <button class="btn-copy-code" onclick="copyCodeBlock(this)"><i class="las la-copy"></i> Copy</button>
                                </div>
                                <pre>{
    <span class="key">"template_id"</span>: <span class="number">5</span>,
    <span class="key">"contact_id"</span>: <span class="number">123</span>,
    <span class="key">"body_values"</span>: {
        <span class="key">"1"</span>: <span class="string">"John Doe"</span>,
        <span class="key">"2"</span>: <span class="string">"ORD-12345"</span>
    },
    <span class="key">"body_matchs"</span>: {
        <span class="key">"1"</span>: <span class="string">"input_value"</span>,
        <span class="key">"2"</span>: <span class="string">"input_value"</span>
    }
}</pre>
                            </div>
                            
                            <h6 style="font-weight: 600; color: #475569; margin-bottom: 0.75rem; margin-top: 1.5rem;">Response</h6>
                            <div class="response-tabs">
                                <button class="response-tab success active" onclick="showResponse(this, 'template-success')">✓ Success (200)</button>
                                <button class="response-tab error" onclick="showResponse(this, 'template-error')">✗ Error</button>
                            </div>
                            <div class="response-content active" id="template-success">
                                <div class="code-block">
                                    <div class="code-block-header">
                                        <span>Success Response</span>
                                    </div>
                                    <pre>{
    <span class="key">"success"</span>: <span class="number">true</span>,
    <span class="key">"message"</span>: <span class="string">"Created successfully"</span>,
    <span class="key">"data"</span>: {
        <span class="key">"id"</span>: <span class="number">456</span>,
        <span class="key">"contact_id"</span>: <span class="number">123</span>,
        <span class="key">"template_id"</span>: <span class="number">5</span>,
        <span class="key">"value"</span>: <span class="string">"Hello John Doe, your order ORD-12345 is confirmed."</span>,
        <span class="key">"status"</span>: <span class="string">"scheduled"</span>
    }
}</pre>
                                </div>
                            </div>
                            <div class="response-content" id="template-error">
                                <div class="code-block">
                                    <div class="code-block-header">
                                        <span>Error Response</span>
                                    </div>
                                    <pre>{
    <span class="key">"success"</span>: <span class="number">false</span>,
    <span class="key">"message"</span>: <span class="string">"Sorry balance not sufficient"</span>,
    <span class="key">"data"</span>: []
}</pre>
                                </div>
                            </div>
                            
                            <div class="try-it-section">
                                <h5><i class="las la-terminal"></i> Try it with cURL</h5>
                                <div class="curl-command">curl -X POST "{{ url('/api') }}/whatsapp/send-template" \
  -H "apikey: YOUR_API_KEY" \
  -H "Authorization: Bearer YOUR_JWT_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{"template_id": 5, "contact_id": 123, "body_values": {"1": "John"}, "body_matchs": {"1": "input_value"}}'</div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Step 4: Send Normal Message -->
                    <div class="api-section" id="step4">
                        <div class="api-section-header">
                            <h3>
                                <span class="step-badge">Step 4</span>
                                Send Normal Message
                            </h3>
                            <span class="method-badge post">POST</span>
                        </div>
                        <div class="api-section-body">
                            <div class="alert-info-custom">
                                <i class="las la-exclamation-triangle" style="color: #f59e0b;"></i>
                                <p><strong>Note:</strong> Normal messages can only be sent within 24 hours of the customer's last message.</p>
                            </div>
                            
                            <div class="endpoint-box">
                                <code>POST {{ url('/api') }}/send-message</code>
                                <button class="btn-copy-sm" onclick="copyText('{{ url('/api') }}/send-message')"><i class="las la-copy"></i> Copy</button>
                            </div>
                            
                            <div class="info-grid">
                                <div class="info-card">
                                    <h5><i class="las la-heading"></i> Headers</h5>
                                    <table class="param-table">
                                        <tr>
                                            <td><span class="param-name">apikey</span></td>
                                            <td><span class="param-required">Required</span></td>
                                            <td>Your API key</td>
                                        </tr>
                                        <tr>
                                            <td><span class="param-name">Authorization</span></td>
                                            <td><span class="param-required">Required</span></td>
                                            <td>Bearer {jwt_token}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="info-card">
                                    <h5><i class="las la-file-alt"></i> Body Parameters</h5>
                                    <table class="param-table">
                                        <tr>
                                            <td><span class="param-name">receiver_id</span></td>
                                            <td><span class="param-required">Required</span></td>
                                            <td>Contact ID</td>
                                        </tr>
                                        <tr>
                                            <td><span class="param-name">message</span></td>
                                            <td><span class="param-optional">Conditional</span></td>
                                            <td>Text message</td>
                                        </tr>
                                        <tr>
                                            <td><span class="param-name">image</span></td>
                                            <td><span class="param-optional">Conditional</span></td>
                                            <td>Image file</td>
                                        </tr>
                                        <tr>
                                            <td><span class="param-name">document</span></td>
                                            <td><span class="param-optional">Conditional</span></td>
                                            <td>PDF file</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            
                            <h6 style="font-weight: 600; color: #475569; margin-bottom: 0.75rem;">Request Example</h6>
                            <div class="code-block">
                                <div class="code-block-header">
                                    <span>JSON</span>
                                    <button class="btn-copy-code" onclick="copyCodeBlock(this)"><i class="las la-copy"></i> Copy</button>
                                </div>
                                <pre>{
    <span class="key">"receiver_id"</span>: <span class="number">123</span>,
    <span class="key">"message"</span>: <span class="string">"Hello! How can I help you today?"</span>
}</pre>
                            </div>
                            
                            <h6 style="font-weight: 600; color: #475569; margin-bottom: 0.75rem; margin-top: 1rem;">Success Response (200)</h6>
                            <div class="code-block">
                                <div class="code-block-header">
                                    <span>Response</span>
                                </div>
                                <pre>{
    <span class="key">"success"</span>: <span class="number">true</span>,
    <span class="key">"message"</span>: <span class="string">"Message sent successfully"</span>,
    <span class="key">"data"</span>: {
        <span class="key">"message_type"</span>: <span class="string">"text"</span>,
        <span class="key">"conversation_id"</span>: <span class="string">"conv_abc123xyz"</span>,
        <span class="key">"remaining_conversations"</span>: <span class="number">999</span>
    }
}</pre>
                            </div>
                            
                            <div class="try-it-section">
                                <h5><i class="las la-terminal"></i> Try it with cURL</h5>
                                <div class="curl-command">curl -X POST "{{ url('/api') }}/send-message" \
  -H "apikey: YOUR_API_KEY" \
  -H "Authorization: Bearer YOUR_JWT_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{"receiver_id": 123, "message": "Hello! How can I help you?"}'</div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Error Handling -->
                    <div class="api-section" id="errors">
                        <div class="api-section-header">
                            <h3>
                                <span class="step-badge" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);">!</span>
                                Common Error Responses
                            </h3>
                        </div>
                        <div class="api-section-body">
                            <table class="param-table" style="background: #fff; border-radius: 8px; overflow: hidden;">
                                <thead>
                                    <tr>
                                        <th>Status</th>
                                        <th>Error Message</th>
                                        <th>Solution</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><span style="background: #fee2e2; color: #dc2626; padding: 0.15rem 0.5rem; border-radius: 4px; font-size: 0.75rem; font-weight: 600;">401</span></td>
                                        <td>API key missing</td>
                                        <td>Add <code>apikey</code> header to your request</td>
                                    </tr>
                                    <tr>
                                        <td><span style="background: #fee2e2; color: #dc2626; padding: 0.15rem 0.5rem; border-radius: 4px; font-size: 0.75rem; font-weight: 600;">403</span></td>
                                        <td>API key invalid</td>
                                        <td>Check your API key is correct</td>
                                    </tr>
                                    <tr>
                                        <td><span style="background: #fee2e2; color: #dc2626; padding: 0.15rem 0.5rem; border-radius: 4px; font-size: 0.75rem; font-weight: 600;">401</span></td>
                                        <td>Authorization token not found</td>
                                        <td>Add <code>Authorization: Bearer {token}</code> header</td>
                                    </tr>
                                    <tr>
                                        <td><span style="background: #fee2e2; color: #dc2626; padding: 0.15rem 0.5rem; border-radius: 4px; font-size: 0.75rem; font-weight: 600;">401</span></td>
                                        <td>Token is expired</td>
                                        <td>Login again to get a new JWT token</td>
                                    </tr>
                                    <tr>
                                        <td><span style="background: #fee2e2; color: #dc2626; padding: 0.15rem 0.5rem; border-radius: 4px; font-size: 0.75rem; font-weight: 600;">401</span></td>
                                        <td>Invalid credentials</td>
                                        <td>Check your email and password</td>
                                    </tr>
                                    <tr>
                                        <td><span style="background: #fef3c7; color: #d97706; padding: 0.15rem 0.5rem; border-radius: 4px; font-size: 0.75rem; font-weight: 600;">200</span></td>
                                        <td>Sorry balance not sufficient</td>
                                        <td>Add funds to your wallet</td>
                                    </tr>
                                    <tr>
                                        <td><span style="background: #fef3c7; color: #d97706; padding: 0.15rem 0.5rem; border-radius: 4px; font-size: 0.75rem; font-weight: 600;">200</span></td>
                                        <td>Insufficient conversation limit</td>
                                        <td>Upgrade your subscription plan</td>
                                    </tr>
                                    <tr>
                                        <td><span style="background: #fee2e2; color: #dc2626; padding: 0.15rem 0.5rem; border-radius: 4px; font-size: 0.75rem; font-weight: 600;">404</span></td>
                                        <td>Contact not found</td>
                                        <td>Verify the contact_id exists in your contacts</td>
                                    </tr>
                                    <tr>
                                        <td><span style="background: #fee2e2; color: #dc2626; padding: 0.15rem 0.5rem; border-radius: 4px; font-size: 0.75rem; font-weight: 600;">404</span></td>
                                        <td>Template not found</td>
                                        <td>Verify the template_id exists</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
<script>
    // Copy to clipboard function
    function copyToClipboard(elementId) {
        var input = document.getElementById(elementId);
        input.select();
        input.setSelectionRange(0, 99999);
        document.execCommand("copy");
        toastr.success("{{ __('copied') }}");
    }
    
    // Copy text directly
    function copyText(text) {
        navigator.clipboard.writeText(text).then(function() {
            toastr.success("{{ __('copied') }}");
        });
    }
    
    // Copy code block
    function copyCodeBlock(button) {
        var pre = button.closest('.code-block').querySelector('pre');
        var text = pre.innerText;
        navigator.clipboard.writeText(text).then(function() {
            toastr.success("{{ __('copied') }}");
        });
    }
    
    // Show response tab
    function showResponse(button, contentId) {
        var parent = button.closest('.api-section-body');
        parent.querySelectorAll('.response-tab').forEach(function(tab) {
            tab.classList.remove('active');
        });
        parent.querySelectorAll('.response-content').forEach(function(content) {
            content.classList.remove('active');
        });
        button.classList.add('active');
        document.getElementById(contentId).classList.add('active');
    }
    
    // Smooth scroll for navigation
    document.querySelectorAll('.api-nav-list a').forEach(function(link) {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            var target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
            document.querySelectorAll('.api-nav-list a').forEach(function(l) {
                l.classList.remove('active');
            });
            this.classList.add('active');
        });
    });
    
    // Highlight active section on scroll
    window.addEventListener('scroll', function() {
        var sections = document.querySelectorAll('.api-section, .credentials-card');
        var navLinks = document.querySelectorAll('.api-nav-list a');
        
        sections.forEach(function(section) {
            var rect = section.getBoundingClientRect();
            if (rect.top >= 0 && rect.top < 300) {
                var id = section.getAttribute('id');
                navLinks.forEach(function(link) {
                    link.classList.remove('active');
                    if (link.getAttribute('href') === '#' + id) {
                        link.classList.add('active');
                    }
                });
            }
        });
    });
</script>
@endpush
