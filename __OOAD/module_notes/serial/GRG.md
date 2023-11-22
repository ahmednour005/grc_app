# GRC Serial

## Routes

- routes/serial.php

---

## Views

- Serial

    ![Figure 1-1](/__OOAD/module_notes/serial/GRC_enter_manipulation.png "Figure 1-1")

    [Serial Live URL](https://advancedcontrols.sa/grc/public/serial)

- Manipulation

    ![Figure 1-2](/__OOAD/module_notes/serial/GRC_manipulation.png "Figure 1-2")

    [Manipulation Live URL](https://advancedcontrols.sa/grc/public/manipulation)

---

## Files

- Serail

    - app/Http/Controllers/admin/serial/SerialController.php
    - resources/views/admin/content/serial/index.blade.php

- Manipulation
    - resources/views/admin/manipulation.blade.php

---
## Requirments

- Serial

    > Enter license key view will show only if the system in the first time running or the license has been expired

- Manipulation

    > (1) This view will show if the server date has been changed
    > <br> (2) the system has been Hacked via change or deleted encrypted files

## Serial check

1. Send a request to GRC serial management with the serial license number
2. Deccrypt data from response object using **company algorithm** and **company key** default (These are set before)
3. If there is an error return with the error else continue
4. If the first time catch server time (TODO catch current date from request) and write it in the `vendor/laravel/framework/src/Illuminate/Encryption/t` path
5. Decode decrypt data in step2 and use `d`, and `m` data to write it in `vendor/laravel/framework/src/Illuminate/Encryption/ed` and `vendor/laravel/framework/src/Illuminate/Encryption/am` paths

## Non-serial routes protected by `ValidateSerialMiddleware`

1. Try reading **`t` catch time file**, **`ed` expiration date file**, and **`am` algorithm metadata encryption/decryption as ***cipher_algo**_ and _**cipher_algo_key**\* file** for checking file existence
2. Check if the first time redirects to serial view else continue
3. Decrypt data from `am` file using **company algorithm** and **company key** default (These are set before)
4. Decrypt data of `t` and `ed` files using **serial algorithm** and **serial key**
5. Check if the server date was changed or set current time if  it is greater than the old time
6. Check the expiration date

## Serial routes protected by `InvalidateSerialMiddleware`

1. Try reading **`t` catch time file**, **`ed` expiration date file**, and **`am` algorithm metadata encryption/decryption as ***cipher_algo**_ and _**cipher_algo_key**\* file**
2. Check if the first time redirects to serial view else continue
3. Decrypt data from `am` file using **company algorithm** and **company key** default (These are set before)
4. Decrypt data of `t` and `ed` files using **serial algorithm** and **serial key**
5. Check if the server date was changed or set current time if it is greater than the old time
6. Check the expiration date
