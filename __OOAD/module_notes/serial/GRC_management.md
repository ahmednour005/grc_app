# GRC Serial management

## Database
### ERD
![Figure 1-1](/__OOAD/module_notes/serial/GRC_management.png "Figure 1-1")

### Tables
* companies
* serials
---
## Inputs
- Company
    * Name
    * Email
    * Phone
    * Address
- Serial
    * Activation status
    * Expiration date
    * Company
---
## Routes
- routes/web.php
- routes/api.php
---
## Views
- Dashboard 

    ![GRC Serial management dashboard](/__OOAD/module_notes/serial/GRC_management_dashboard.png "GRC Serial management dashboard")

    [GRC Serial management dashboard Live URL](https://www.advancedcontrols.sa/grc-man/public/home)

- Company

    ![Company list](/__OOAD/module_notes/serial/GRC_management_company_list.png "Company list")
    ![Company create](/__OOAD/module_notes/serial/GRC_management_company_create.png "Company create")
    ![Company edit](/__OOAD/module_notes/serial/GRC_management_company_edit.png "Company edit")

    [Company Live URL](https://www.advancedcontrols.sa/grc-man/public/company)

- Serial

    ![Serial list](/__OOAD/module_notes/serial/GRC_management_serial_list.png "Serial list")
    ![Serial create](/__OOAD/module_notes/serial/GRC_management_serial_create.png "Serial create")
    ![Serial edit](/__OOAD/module_notes/serial/GRC_management_serial_edit.png "Serial edit")

    [Serial Live URL](https://www.advancedcontrols.sa/grc-man/public/serial)
---
## Files
- Dashboard
    * app/Http/Controllers/HomeController.php
    * resources/views/admin/dashboard/index.blade.php

- Company
    * app/Http/Controllers/CompanyController.php
    * resources/views/admin/company/index.blade.php
    * resources/views/admin/company/edit.blade.php
    * resources/views/admin/company/create.blade.php

- Serial
    * app/Http/Controllers/Api/ApiSerialController.php
    * app/Http/Controllers/SerialController.php
    * resources/views/admin/serial/index.blade.php
    * resources/views/admin/serial/edit.blade.php
    * resources/views/admin/serial/create.blade.php
---
## Requirments
- Company
    > Company added in the system for each client and after add you get an APP_KEY for that serial work only for one and only one company

    > Each company has `main_cipher_algo_key` this algorithm key generated depends on `cipher_algo` used in encryption is `AES-256-CBC` and set key automatically

- Serial
    > Each serial has `active_status` used in checking on the serial to activate the license

    > Each serial has `usage_status` used in checking on the serial to activate the license

    > Each serial has `cipher_algo` this algorithm is used in encryption and set randomly

    > Each serial has `cipher_algo_key` this algorithm key generated depends on `cipher_algo` used in encryption and set key automatically

## How to check the serial
1. Request must have `serial_number`, `app_key` from request get company and its serial that match
    * Active status is true
    * Usage status is false
    * Serial match `serial_number`
    * Expiration date >= today
2. If the request data match a serial with all conditions in the previous point
    * Encrypt `expire_date` 

GRC Management resposes
```json
    // Validation error example 
    {
        "status": false,
        "code": 422,
        "message": "Validation error",
        "errors": {
            "app_key": [
                "The app key field is required."
            ],
            "serial_number": [
                "The serial number field is required."
            ]
        }
    }
```
```json
    // Serial isn't found (maybe isn't active, used before, expired, serial doesn't exist, or serial exists for another company)
    {
        "status": false,
        "code": 404,
        "message": "Serial Not Found",
        "errors": []
    }
```

```json
    // Sucess serial check
    {
        "status": true,
        "code": 200,
        "message": "License activation has been done Successfully",
        "data": "eyJpdiI6Ik5ST1FCUS8xa1ZiaFRsalFFTDhsZkE9PSIsInZhbHVlIjoiTkRBVkdRWXE0dFdDQVpKdGpDM3U0WWpGZGJ0MkkvajdjU2YyVDYzbEovN3kyYWJUSzRvV05wSDlucy9lS3ZOaldaMGlyeENiZktsU0UzOFJucUJJMWpaTXJmT1N3dXBWZWhmKzFMS2R5UjVXMGNVeTB2b1JJNGZhbkIvUVhnNjNPN24rU3pDVS9lQit5K3MyU2pHL2J0bFhTMFpYN243ZXd6N0ZhQ0xvWTJHV01UeXloc3oxUjhpNEJCR0VWUGlkanNzVk1ITng3cjdOQXVSRm5DaFFOZVpwSEN4bWhhVFZyK3hMMWprQWIvNTNGZFIyS0l3MDBwSElSbFZnM0V4QVVOZkJMMGQrbDVFYkI1bldCQjhBemJzM3Q1THhpbVcrM1U0QW5TR0dYZVl3bkMrV3p1V252SEZNQlJKTzBmSHkyYXdoOG9yNkRwcEI2WHhveWpYOVg2aWZvSndhaWxrK1A3eHNIcmpodldIUlJUMm9IS28rSjNqQ0NtRk04c2c3ZWlyc3A0SGpsaWZ6VFYyVEhxMnVoUjdCOEZVQkMybUwzQTZBWHVla0JFK0M0YkxWeGd1Q2lnZzFoOE5RYWNiaWxNZ0cvaHBzdTVsSWsybDMxUDhvOGdldkYzZmlOb0trZGl2NytCaUdIVkZhTUFjZFZkM2F2NXB2L3RUTHpwandOcGIwcmpPNGZnbVBwMk9GOHk3S2F3c0hCeFpCcm9CbDI3YTZ6UlNFZzB1TzRyMmY2SHVUb2VSM0p1ZjhXT2tOVVRubjc4bElCbENkMGtZQXFDZmUyckljRERINjg5Y1k5Q3l3bTcwU3NrdnNjbFdFNWRtUFJCeW5JQmVibllqTVp2TW5HMGc2S1lhNGcxTHA3U0NYVjZwcnB1VU1RUHBRSjdtcUw1UjFtUHNmZldocUhnVmFZQTFFNE1mTW9CZlBaK1BwZjU0dmhUWkg0RWRsTDZtdklXd2tIK1g5LytKQXlxSHo5Uzc2bklpTFVQVWIvVXBNa3JOelIveXpXWHh5S244S0JtaFpjSWxzdVBWTmZ2TFdwdkNISDdaa3Y2S0t4dVpZbi96TzJTVmNuaHZsdmJVZ2dodDVZUXJLVm80bjIwa1p0QUNhR1FoU2plOEVla203WTdCNitQWDdUOVBpbEp2THlZUTBQdlE9IiwibWFjIjoiNDViY2NlNzI3OTAxNTZjZjg1MzNlMzQyZjIyZGZkYjZjNmJhZGQ1NTQzYzIzNTJhZGRmMGZmMDY4NTU5NDI0NSIsInRhZyI6IiJ9"
    }
```

## How encryption work in GRC management
1. Encrypt the `expire_date` via serial algorithm and algorithm key
<br>Example with `aes-128-gcm` algorithm `eyJpdiI6IjRJcWs5T2l6eitYbjIxN0YiLCJ2YWx1ZSI6IlZtZFNtRENacWZ6Mjg3RzFQSjZWeG9wRSIsIm1hYyI6IiIsInRhZyI6IkFydUZHSVMvNU82ekNjdmJmaFhaZmc9PSJ9` and algorithm key its base64 = `ywDM+LES2LHRiJg4wBFTbQ==`

2. Encrypt the algorithm metadata
    ```php
        $encryptionDetails = [
            'cipher_algo' => $serial->cipher_algo,
            'cipher_algo_key' => base64_encode($serial->cipher_algo_key)
        ]; // cipher algorithm and algorithm key
        $encryptionDetailsString = json_encode($encryptionDetails);

    ```
3. Encrypt current server time with serial algorithm and key

4. After that you now get an array as an example
```php
    $data = [
    "d" => "eyJpdiI6ImRHYkxlOGJXSHZ6RWNOKzIiLCJ2YWx1ZSI6IlQ1aEVKYjk1YUt3MnZTWnpQUXdkZWVkYiIsIm1hYyI6IiIsInRhZyI6IlhUM3FGbzRpWVNmbk5hTStoMy9WelE9PSJ9", // expiration date (with serial algorithm and key)
    "m" => "eyJpdiI6IlM5QytkMGk3S0twSTlTT2N6b21RUUE9PSIsInZhbHVlIjoiQWFlOU1PSHlIbk5PcmhFNWh2ZUkvSGpGK2hweEpMOWs0bnF2K1ZIK1JxZGNPOXFRWTdWYmoza1NVZ0J5VUhGUDBjeVg1UEJaS2pMNXZDR0ZJNFI3VEhUdHNFam9vcmd2UUxSSW9VQnd1ajRXYVhMN0NGSjJpdUVaeHo5MjQ2UlIiLCJtYWMiOiIwM2Y4NmNlNWJjYjM5M2VkNjNkY2FhMTQ3MTVjNzYxZGZkMzcyMjgxZThhYTUxYjk3MGUwNGYyMDgyZDA5OWM3IiwidGFnIjoiIn0=", // algorithm metadata encryption/decryption as `cipher_algo` and `cipher_algo_key` with company main_cipher_algo_key and algorithm AES-256-CBC
    "t" => "eyJpdiI6IlpWWEx5dnprSW5SbmpZYzAiLCJ2YWx1ZSI6IjBzYjJjemMzM3h3SUNDTC83bDlacWFGczJJOHlUdTI0IiwibWFjIjoiIiwidGFnIjoiSm5tZ2RXRzdBMFJGQWJKYm1yUVJYQT09In0=" // current server time with serial algorithm and key
    ]
```
5. Encode this array then apply encryption using company `main_cipher_algo_key` and algorithm `AES-256-CBC`