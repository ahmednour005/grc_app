/** Start update 20/8/2023 **/
/*  solve Server migration issue */
UPDATE
    `migrations`
SET
    `migration` = '2022_02_15_091906_create_control_maturities_table'
WHERE
    `migrations`.`id` = 44;

UPDATE
    `migrations`
SET
    `migration` = '2022_02_15_091909_create_impacts_table'
WHERE
    `migrations`.`id` = 47;

UPDATE
    `migrations`
SET
    `migration` = '2022_02_15_091909_create_likelihoods_table'
WHERE
    `migrations`.`id` = 48;

/* update all users mail domain to  @srg.gov.sa in demo1.advancedcontrols.sa */
UPDATE
    users
SET
    email = REPLACE(email, '@momrah.gov.sa', '@srg.gov.sa')
WHERE
    email LIKE '%@momrah%';

UPDATE
    users
SET
    email = REPLACE(email, '@momrah.sa', '@srg.gov.sa')
WHERE
    email LIKE '%@momrah%';

UPDATE
    users
SET
    email = REPLACE(email, '@momrah', '@srg.gov.sa')
WHERE
    email LIKE '%@momrah%';

/** End update 20/8/2023 **/