@extends('icp::master')

@section('title', 'Article categories')

@section('content')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.16/css/dataTables.bootstrap.min.css" />

    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <button type="button" onclick="document.location.href='{{icp_route('news.category.create')}}'" class="btn btn-default">Add new</button>
                    <button id="delete-button" type="submit" class="btn btn-danger pull-right" disabled>Delete</button>
                </div>

                <div class="box-body">
                    <table id="table-list" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th class="checkbox-header">
                                <input type="checkbox" id="check-all">
                            </th>
                            <th>ID</th>
                            <th style="padding-right: 8px;">Active</th>
                            <th>Title</th>
                            <th>Slug</th>
                            <th>Updated</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>

    <!-- DataTables -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.16/js/dataTables.bootstrap.min.js"></script>
    <script src="{{ asset_v('icp/js/datatablejs.js') }}"></script>

    <script type="text/javascript">
        var dt = new DataTableJs('#table-list');
        var checkboxSlavesSel = '#table-list [name="ids[]"]';
        var initCompleteCallback = function(data){
            var onToggle = function () {
                var disabled = !($(checkboxSlavesSel+':checked').length > 0);
                $('#delete-button').prop('disabled', disabled);
            };
            Icp.iCheck(checkboxSlavesSel);
            $('#check-all').iCheck('uncheck');

            $(checkboxSlavesSel).on('ifToggled', function (event) {
                onToggle();
            });

            onToggle();
        };
        dt.setInitCompleteCallback(initCompleteCallback);

        $(document).ready(function() {
            Icp.assignCheckAll('#check-all', checkboxSlavesSel);

            $(dt.selector()).DataTable({
                paging: true,
                stateSave: true,
                lengthChange: true,
                lengthMenu: [ 10, 25, 50, 75, 100 ],
                pageLength: 25,
                searching: true,
                ordering: true,
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{icp_route('news.categories.json')}}",
                    complete: function(response){
                        dt.initComplete();
                        if(response.responseJSON && response.responseJSON.csrf_token) {
                            Icp.token(response.responseJSON.csrf_token);
                        }
                    }
                },
                columns: [
                    {data: "checkbox", name: "checkbox", orderable: false, searchable: false, className: 'text-center' },
                    {data: "id", name: "id", orderable: true, searchable: false },
                    {data: "active", name: "active", orderable: true, searchable: false, className: 'text-center' },
                    {data: "title", name: "title", orderable: true },
                    {data: "slug", name: "slug", orderable: true },
                    {data: "updated_at", name: "updated_at", orderable: true, searchable: false },
                    {data: "actions", name: "actions", orderable: false, searchable: false, className: 'text-center' },
                ],
                order: [[ 1, "desc" ]],
                //initComplete: dt.initComplete
            });

            $('#delete-button').click(function(){
                if(confirm('Are you sure to DELETE this item?')) {
                    dt.postReload(
                        '{{icp_route('news.category.delete')}}',
                        $(checkboxSlavesSel).serialize() + '&_method=DELETE&_token='+Icp.token(),
                        dt.initComplete
                    )
                }
            });
        });
    </script>

@endsection