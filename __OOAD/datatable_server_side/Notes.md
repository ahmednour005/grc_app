1. If we need to add custom search fields alongside the global field you must add input or select a tag under the form tag with a class called `form.dt_adv_search` with name attribute standard as `filter_COLUMN_NAME` reference to columns that passed to `drawDatatable` js function in `resources/views/admin/panels/scripts.blade.php`

2. After applying logic in step1 now we can catch automatically any tag (select or input) with name attribute as [name="filter_COLUMN_NAME"] COLUMN_NAME  to be sent to server as `column['search']['value']`

3. `drawDatatable` js function in `resources/views/admin/panels/scripts.blade.php` this function takes parameters as 
    * columnsData: This parameter can be used to read and write data to and from any data source property
    * columnDefinitions: This parameter allows you to assign specific options to columns in the table
    * detailsOfItem: This parameter is used to show the main title data of the modal in responsive
    * detailsOfItemKey: This parameter is used to show specific `column.data` that will be used in the title alongside the main title data of the modal in responsive

4. In controller you must specify some predefined data
    * $customFilterFields
    ```
        $customFilterFields = [
            'normal' => [...], // column that will filter in the same model
            'relation' => [...], // column that will filter in another model (relationships)
            'other_global_filters' => ['description', 'created_at'], // column that will filter in the same model but without custom filter fields (global filter)
        ];
    ```

    ```
    // This array used for optimise join query for getting minimum requirede fileds
    $relationshipsWithColumns = [
        // 'relationshipName:column1,column2,....'
            'employees:job_id,name'
        ];
    ```