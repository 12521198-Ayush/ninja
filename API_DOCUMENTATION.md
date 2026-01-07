# WhatsApp Messaging API Documentation

## Base URL
```
http://127.0.0.1:8000/api
```

---

## Authentication

All API requests require **two levels of authentication**:

### 1. API Key (Required for all endpoints)
Include in request headers:
```
apikey: your_api_key_here
```

### 2. JWT Token (Required for protected endpoints)
Include in request headers:
```
Authorization: Bearer your_jwt_token_here
```

---

## 1. Login API

Get JWT token for authentication.

### Endpoint
```
POST /api/login
```

### Headers
| Header | Required | Description |
|--------|----------|-------------|
| `apikey` | Yes | Your API key |
| `Content-Type` | Yes | `application/json` |

### Request Body
```json
{
    "email": "user@example.com",
    "password": "your_password"
}
```

### Success Response (200)
```json
{
    "success": true,
    "message": "Login successfully",
    "data": {
        "user": {
            "id": 1,
            "name": "John Doe",
            "email": "user@example.com",
            "phone": "+1234567890",
            "profile_image": "https://example.com/image.jpg"
        },
        "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...",
        "token_type": "bearer",
        "expires_in": 3600
    }
}
```

### Error Response (401)
```json
{
    "success": false,
    "message": "Invalid credentials",
    "data": []
}
```

---

## 2. Get Templates API

Retrieve list of available WhatsApp message templates.

### Endpoint
```
GET /api/whatsapp-templates
```

### Headers
| Header | Required | Description |
|--------|----------|-------------|
| `apikey` | Yes | Your API key |
| `Authorization` | Yes | `Bearer your_jwt_token` |

### Query Parameters
| Parameter | Required | Description |
|-----------|----------|-------------|
| `page` | No | Page number for pagination (default: 1) |

### Success Response (200)
```json
{
    "success": true,
    "message": "Template retrieved successfully",
    "data": {
        "template": [
            {
                "id": 1,
                "name": "hello_world",
                "language": "en",
                "status": "APPROVED",
                "category": "MARKETING",
                "components": [
                    {
                        "type": "HEADER",
                        "format": "TEXT",
                        "text": "Welcome!"
                    },
                    {
                        "type": "BODY",
                        "text": "Hello {{1}}, your order {{2}} is confirmed."
                    },
                    {
                        "type": "FOOTER",
                        "text": "Thank you for shopping with us"
                    },
                    {
                        "type": "BUTTONS",
                        "buttons": [
                            {
                                "type": "URL",
                                "text": "View Order",
                                "url": "https://example.com/order/{{1}}"
                            }
                        ]
                    }
                ],
                "created_at": "2025-12-25T10:00:00.000000Z"
            }
        ],
        "paginate": {
            "total": 50,
            "current_page": 1,
            "per_page": 50,
            "last_page": 1,
            "prev_page_url": null,
            "next_page_url": null,
            "path": "http://127.0.0.1:8000/api/whatsapp-templates"
        }
    }
}
```

---

## 3. Get Single Template API

Retrieve details of a specific template.

### Endpoint
```
GET /api/whatsapp/get-template
```

### Headers
| Header | Required | Description |
|--------|----------|-------------|
| `apikey` | Yes | Your API key |
| `Authorization` | Yes | `Bearer your_jwt_token` |

### Query Parameters
| Parameter | Required | Description |
|-----------|----------|-------------|
| `template_id` | Yes | ID of the template |

### Success Response (200)
```json
{
    "success": true,
    "message": "Template retrieved successfully",
    "data": {
        "id": 1,
        "name": "order_confirmation",
        "language": "en",
        "status": "APPROVED",
        "category": "UTILITY",
        "components": [
            {
                "type": "BODY",
                "text": "Hello {{1}}, your order {{2}} has been confirmed.",
                "example": {
                    "body_text": [["John", "ORD-12345"]]
                }
            }
        ]
    }
}
```

### Error Response (404)
```json
{
    "success": false,
    "message": "Template not found",
    "data": []
}
```

---

## 4. Send Template Message API

Send a WhatsApp template message to a contact.

### Endpoint
```
POST /api/whatsapp/send-template
```

### Headers
| Header | Required | Description |
|--------|----------|-------------|
| `apikey` | Yes | Your API key |
| `Authorization` | Yes | `Bearer your_jwt_token` |
| `Content-Type` | Yes | `multipart/form-data` (if sending media) or `application/json` |

### Request Body Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `template_id` | integer | Yes | ID of the template to send |
| `contact_id` | integer | Yes | ID of the contact to send message to |
| `body_values` | array | No | Values to replace template body placeholders |
| `body_matchs` | array | No | Mapping type for body placeholders (`input_value`, `contact_name`, `contact_phone`) |
| `button_values` | array | No | Values to replace button placeholders |
| `button_matchs` | array | No | Mapping type for button placeholders |
| `image` | file | No | Image file (jpeg, png, jpg - max 2MB) for IMAGE header templates |
| `document` | file | No | PDF file (max 5MB) for DOCUMENT header templates |
| `video` | file | No | MP4 file (max 10MB) for VIDEO header templates |
| `audio` | file | No | MP3 file (max 5MB) for AUDIO header templates |

### Example Request - Simple Template (JSON)
```json
{
    "template_id": 1,
    "contact_id": 123
}
```

### Example Request - Template with Variables (JSON)
```json
{
    "template_id": 5,
    "contact_id": 123,
    "body_values": {
        "1": "John Doe",
        "2": "ORD-12345"
    },
    "body_matchs": {
        "1": "input_value",
        "2": "input_value"
    }
}
```

### Example Request - Template with Dynamic Button URL (JSON)
```json
{
    "template_id": 10,
    "contact_id": 123,
    "body_values": {
        "1": "John Doe",
        "2": "5000"
    },
    "body_matchs": {
        "1": "contact_name",
        "2": "input_value"
    },
    "button_values": {
        "1": "ABC123XYZ"
    },
    "button_matchs": {
        "1": "input_value"
    }
}
```

### Example Request - Template with Image Header (Form Data)
```
POST /api/whatsapp/send-template
Content-Type: multipart/form-data

template_id: 15
contact_id: 123
body_values[1]: "Special Offer"
body_values[2]: "50%"
body_matchs[1]: "input_value"
body_matchs[2]: "input_value"
image: [FILE - product_image.jpg]
```

### Success Response (200)
```json
{
    "success": true,
    "message": "Created successfully",
    "data": {
        "id": 456,
        "contact_id": 123,
        "template_id": 5,
        "client_id": 1,
        "header_text": null,
        "footer_text": "Thank you for your business",
        "header_image": null,
        "header_audio": null,
        "header_video": null,
        "header_document": null,
        "buttons": "[{\"type\":\"URL\",\"text\":\"View Details\",\"url\":\"https://example.com\"}]",
        "value": "Hello John Doe, your order ORD-12345 is confirmed.",
        "error": null,
        "message_type": "text",
        "status": "scheduled",
        "schedule_at": "2025-12-25T10:30:00.000000Z",
        "campaign_id": null,
        "is_campaign_msg": 1,
        "created_at": "2025-12-25T10:30:00.000000Z",
        "updated_at": "2025-12-25T10:30:00.000000Z"
    }
}
```

### Error Responses

#### Validation Error (422)
```json
{
    "success": false,
    "message": "Validation failed",
    "data": {
        "template_id": ["The template id field is required."],
        "contact_id": ["The contact id field is required."]
    }
}
```

#### Insufficient Balance (200)
```json
{
    "success": false,
    "message": "Sorry balance not sufficient",
    "data": []
}
```

#### No Active Subscription (200)
```json
{
    "success": false,
    "message": "No active subscription",
    "data": []
}
```

#### Contact Not Found (404)
```json
{
    "success": false,
    "message": "Contact not found",
    "data": []
}
```

#### Template Not Found (404)
```json
{
    "success": false,
    "message": "Template not found",
    "data": []
}
```

---

## 5. Send Normal Message API

Send a regular text, image, or document message to a contact.

### Endpoint
```
POST /api/send-message
```

### Headers
| Header | Required | Description |
|--------|----------|-------------|
| `apikey` | Yes | Your API key |
| `Authorization` | Yes | `Bearer your_jwt_token` |
| `Content-Type` | Yes | `multipart/form-data` |

### Request Body Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `receiver_id` | integer | Yes | ID of the contact to send message to |
| `message` | string | Conditional | Text message content (required if no image/document) |
| `image` | file | Conditional | Image file to send (required if no message/document) |
| `document` | file | Conditional | Document file to send (required if no message/image) |

> **Note:** At least one of `message`, `image`, or `document` must be provided.

### Example Request - Text Message
```json
{
    "receiver_id": 123,
    "message": "Hello! How can I help you today?"
}
```

### Example Request - Image Message (Form Data)
```
POST /api/send-message
Content-Type: multipart/form-data

receiver_id: 123
image: [FILE - photo.jpg]
```

### Example Request - Document Message (Form Data)
```
POST /api/send-message
Content-Type: multipart/form-data

receiver_id: 123
document: [FILE - invoice.pdf]
```

### Success Response (200)
```json
{
    "success": true,
    "message": "Message sent successfully",
    "data": {
        "message_type": "text",
        "conversation_id": "conv_abc123xyz",
        "remaining_conversations": 999
    }
}
```

### Error Responses

#### Validation Error (422)
```json
{
    "success": false,
    "message": "Validation failed",
    "data": {
        "receiver_id": ["The receiver id field is required."],
        "message": ["The message field is required when image and document are not present."]
    }
}
```

#### Insufficient Conversation Limit (403)
```json
{
    "success": false,
    "message": "Insufficient conversation limit",
    "data": []
}
```

#### Contact Not Found (404)
```json
{
    "success": false,
    "message": "Contact not found",
    "data": []
}
```

---

## Common Error Responses

### API Key Missing (401)
```json
{
    "success": false,
    "message": "API key missing",
    "data": []
}
```

### Invalid API Key (403)
```json
{
    "success": false,
    "message": "API key invalid",
    "data": []
}
```

### Authorization Token Not Found (401)
```json
{
    "success": false,
    "message": "Authorization token not found",
    "data": []
}
```

### Token Expired (401)
```json
{
    "success": false,
    "message": "Token is expired",
    "data": []
}
```

### Invalid Token (401)
```json
{
    "success": false,
    "message": "Invalid token",
    "data": []
}
```

---

## Complete cURL Examples

### 1. Login
```bash
curl -X POST "http://127.0.0.1:8000/api/login" \
  -H "apikey: gzEvhGabCZjtJTasDU68iGdh1F2nARhiWo9GmNwT" \
  -H "Content-Type: application/json" \
  -d '{
    "email": "user@example.com",
    "password": "password123"
  }'
```

### 2. Get Templates
```bash
curl -X GET "http://127.0.0.1:8000/api/whatsapp-templates" \
  -H "apikey: gzEvhGabCZjtJTasDU68iGdh1F2nARhiWo9GmNwT" \
  -H "Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9..."
```

### 3. Send Template Message
```bash
curl -X POST "http://127.0.0.1:8000/api/whatsapp/send-template" \
  -H "apikey: gzEvhGabCZjtJTasDU68iGdh1F2nARhiWo9GmNwT" \
  -H "Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9..." \
  -H "Content-Type: application/json" \
  -d '{
    "template_id": 5,
    "contact_id": 123,
    "body_values": {
      "1": "John Doe",
      "2": "ORD-12345"
    },
    "body_matchs": {
      "1": "input_value",
      "2": "input_value"
    }
  }'
```

### 4. Send Template Message with Image
```bash
curl -X POST "http://127.0.0.1:8000/api/whatsapp/send-template" \
  -H "apikey: gzEvhGabCZjtJTasDU68iGdh1F2nARhiWo9GmNwT" \
  -H "Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9..." \
  -F "template_id=15" \
  -F "contact_id=123" \
  -F "body_values[1]=Special Offer" \
  -F "body_matchs[1]=input_value" \
  -F "image=@/path/to/image.jpg"
```

### 5. Send Normal Text Message
```bash
curl -X POST "http://127.0.0.1:8000/api/send-message" \
  -H "apikey: gzEvhGabCZjtJTasDU68iGdh1F2nARhiWo9GmNwT" \
  -H "Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9..." \
  -H "Content-Type: application/json" \
  -d '{
    "receiver_id": 123,
    "message": "Hello! How can I help you today?"
  }'
```

### 6. Send Image Message
```bash
curl -X POST "http://127.0.0.1:8000/api/send-message" \
  -H "apikey: gzEvhGabCZjtJTasDU68iGdh1F2nARhiWo9GmNwT" \
  -H "Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9..." \
  -F "receiver_id=123" \
  -F "image=@/path/to/photo.jpg"
```

---

## Postman Collection Setup

### Environment Variables
```json
{
    "base_url": "http://127.0.0.1:8000/api",
    "api_key": "gzEvhGabCZjtJTasDU68iGdh1F2nARhiWo9GmNwT",
    "jwt_token": ""
}
```

### Headers for All Requests
```
apikey: {{api_key}}
Authorization: Bearer {{jwt_token}}
```

---

## Rate Limits & Quotas

- Message sending is subject to your subscription limits
- Template messages reduce your `campaign_remaining` count
- Normal messages reduce your `conversation_remaining` count
- Wallet balance is checked and deducted for template messages based on template pricing

---

## Notes

1. **24-Hour Window**: Normal messages can only be sent within 24 hours of the last customer message
2. **Template Messages**: Can be sent anytime, but must use approved templates
3. **Media Requirements**:
   - Images: JPEG, PNG, JPG (max 2MB)
   - Documents: PDF (max 5MB)
   - Videos: MP4 (max 10MB)
   - Audio: MP3 (max 5MB)
4. **Body Match Types**:
   - `input_value`: Use the provided value from `body_values`
   - `contact_name`: Automatically use the contact's name
   - `contact_phone`: Automatically use the contact's phone number
