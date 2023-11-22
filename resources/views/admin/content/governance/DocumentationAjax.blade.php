<script>

    $(document).on('click','#NexDocPage', function(event){


        event.preventDefault();
        var currentPage=$('#currentPage').val();
        var lastPage=$('#lastPage').val();
        var page=parseInt(currentPage)+1;
        if(page<=lastPage)
        {
            $('#PrevDocPage').attr('disabled',false);
            $.ajax({
                url:'{{url('admin/governance/next-doc-page')}}',
            method:"get",
            data:{page:page},
            success:function(data)
            {
                if(data[2]!=0) {
                    $('.CategoryList').html(data[0]);
                    $('#lastPage').val(data[1]);
                    $('#currentPage').val(page);
                }else{
                    $('#NexDocPage').attr('disabled',true);
                }
            },
        })
        }else{
            $('#NexDocPage').attr('disabled',true);
        }
    });

    $(document).on('click','#PrevDocPage', function(event){
        event.preventDefault();
        var currentPage=$('#currentPage').val();
        var lastPage=$('#lastPage').val();
        var page=parseInt(currentPage)>1?parseInt(currentPage)-1:1;

        if(currentPage>1)
        {
            $('#NexDocPage').attr('disabled',false);
            $.ajax({
                url:'{{url('admin/governance/prev-doc-page')}}',
            method:"get",
            data:{page:page},
            success:function(data)
            {
                $('.CategoryList').html(data[0]);
                $('#lastPage').val(data[1]);
                $('#currentPage').val(page);
            },
        })
        }else{
            $('#PrevDocPage').attr('disabled',true);
        }
    });


    //Start Right Side
    $(document).on('click','.sideNavBtn', function(event){
        event.preventDefault();
        var id=$(this).attr('id');
        $.ajax({
            url:'{{url('admin/governance/doc-details')}}',
            method:"get",
            data:{id:id},
        success:function(data)
        {
            $('.DocName').html(data[0]);

            //btns
            $('.copyItem').attr('data-bs-target','#copy-modal'+id.substring(4));
            $('.updateItem').attr('data-bs-target','#edit-modal'+id.substring(4));
            $('.deleteItem').attr('alt','item'+id.substring(4));

            $('.EditModal').attr('id','edit-modal'+id.substring(4));

            $('.add_document').attr('id','add_control'+id.substring(4));

            $('#form-edit').attr('action',data[1]);

            $('.form-add_control').attr('action',data[2]);

            $('.AddDocBtn').attr('data-bs-target','#add_control'+id.substring(4));

            $('.FrameNameInput').val(data[3]);
            $('.IconsSelect').html(data[4]);

            //active item on sidebar
            $('.list-group-item').removeClass('activeItemTab');
            $('#item'+id.substring(4)).addClass('activeItemTab');

            //Relaod Datatable
            table.ajax.reload();
        },
    })

    });

    $(document).on('click','.deleteItem', function(event){
        event.preventDefault();
        var id=$(this).attr('alt').substring(4);

        $.ajax({
            url:'{{url('admin/governance/doc-delete')}}',
            method:"get",
            data:{id:id},
        success:function(data)
        {
            location.reload();
        },
    })

    });

    //Doc Datatable
    table=$('.DocTable').DataTable({
        processing: true,
        searching:false,
        render: true,
        serverSide: true,
        dom: 'lBfrtip',
        aLengthMenu: [
            [25, 50, 100, 200,500,1000, -1],
            [25, 50, 100, 200,500,1000, "All"]
        ],
        buttons: [],
        ajax: "{{url('admin/governance/DocTable')}}",
        language: {
                "sProcessing": "{{ __('locale.Processing') }}",
                "sSearch": "{{ __('locale.Search') }}",
                "sLengthMenu": "{{ __('locale.lengthMenu') }}",
                "sInfo": "{{ __('locale.info') }}",
                "sInfoEmpty": "{{ __('locale.infoEmpty') }}",
                "sInfoFiltered": "{{ __('locale.infoFiltered') }}",
                "sInfoPostFix": "",
                "sSearchPlaceholder": "",
                "sZeroRecords": "{{ __('locale.emptyTable') }}",
                "sEmptyTable": "{{ __('locale.NoDataAvailable') }}",
                "oPaginate": {
                    "sFirst": "",
                    "sPrevious": "{{ __('locale.Previous') }}",
                    "sNext": "{{ __('locale.NextStep') }}",
                    "sLast": ""
                },
                "oAria": {
                    "sSortAscending": "{{ __('locale.sortAscending') }}",
                    "sSortDescending": "{{ __('locale.sortDescending') }}"
                }
            },
        columns: [
            // { data: 'responsive_id', name: 'responsive_id' },
            // { data: 'responsive_id', name: 'responsive_id' },
            { data: 'document_name', name: 'document_name' },
            { data: 'framework_name', name: 'doframework_namecuments' },
            { data: 'control', name: 'control' },
            { data: 'creation_date', name: 'creation_date' },
            { data: 'approval_date', name: 'approval_date' },
            { data: 'status', name: 'status' },
            { data: 'actions', name: 'actions' },

        ],
        // "language": {
        //     "sSearch":       "Search...",
        // }
    });

    // table.on('order.dt search.dt', function () {
    //     let i = 1;
    //
    //     table.cells(null, 0, { search: 'applied', order: 'applied' }).every(function (cell) {
    //         this.data(i++);
    //     });
    // }).draw();
    ////////////////////////////////////////////////////

</script>
