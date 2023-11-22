//select2 class
$(document).ready(function () {
    $('.multiple-select2').select2();
});


drawDatatable(
    // columnsData
    [
        {
            data: 'id'
        },
        {
            data: 'objective',
            orderable: false
        },
        {
            data: 'control',
            orderable: false
        },
        {
            data: 'responsible',
            orderable: false
        },
        {
            data: 'due_date',
            orderable: false
        },
        {
            data: 'evidences',
            orderable: false
        },
        {
            data: 'evidences',
            orderable: false
        },

    ],
    // columnDefinitions
    [{
        // evidences
        targets: -2,
        title: 'evidences created at',
        orderable: false,
        searchable: false,
        render: function (data) {
            let returnedString = '';
            console.log(data);
            index = 0
            data.forEach(evidence => {
                index++;
                // Append the data to the returnedString
                let evidence_created_at = evidence.created_at.split('T')[0];
                returnedString += index + ' . ' + evidence_created_at + '<br>';
            });
            return (
                returnedString
            );
        }
    },
    {
        // evidences
        targets: -1,
        title: 'evidences updated at',
        orderable: false,
        searchable: false,
        render: function (data) {
            let returnedString = '';
            console.log(data);
            index = 0
            data.forEach(evidence => {
                index++;
                // Append the data to the returnedString
                let evidence_updated_at = evidence.updated_at.split('T')[0];
                returnedString += index + ' . ' + evidence_updated_at + '<br>';
            });
            return (
                returnedString
            );
        }
    }
    ],
);
