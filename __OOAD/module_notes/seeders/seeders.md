# Seeders

## SEEDING_MODE
```php
define('SEEDING_MODE', 'production');
define('SEEDING_MODE', 'development');
```
1. production
> In this mode, we publish only the required data for the customer

2. development
> In this mode, we publish many data to help me in testing
---
## SEEDING_FRAMEWORKS
```php
// In the next example we need to publish only the "NCA-ECC – 1: 2018" framework with its related controls
define('SEEDING_FRAMEWORKS', [
    'NCA-ECC – 1: 2018',
    // 'NCA-SMACC',
    // 'NCA-CCC – 1: 2020',
    // 'NCA-TCC',
    // 'NCA-CSCC – 1: 2019',
    // 'NCA-OTCC-1:2022',
    // 'NCA-DCC-1:2022',
    // 'SAMA',
    // 'ISO-27001'
]);
```
> This is an array constant that contains all framework names<br>
> We have to comment on the frameworks that we don't need to publish for the customer
