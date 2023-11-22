# user Story 1 :
### As a "user with permission to import assets" , I can see the form for importing assets.

## Aceceptance Criteria: 
1. user should find the import button.
2. when user click import button he will go to import form page.

# user Story 2 :
### As a "user with permission to import assets" , I select an excel file to import.

## Aceceptance Criteria: 
1. user should be able to select a file .
2. if he selects any kind of files rather than excel files, he will get a validation error.
3. when he selects an excel file, he shall see a table containing a list of assets table database columns, each row of the table represents 
database column name , rules for that column, example of data that can be imported in that column , and a select box containg names of columns
of excel file .

# user Story 3 :
### As a "user with permission to import assets" , I shall be able to import data from selected file.
1. when user map database columns to excel file column and clicks import , he shall see that the data is imported.
2. each database column that he mapped to a column in excel file shall take the data in that column.
2. if data in any column is invalid , he shall see validation errors .
