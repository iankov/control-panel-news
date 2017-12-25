@extends('icp::master')

@section('title', 'News')

@section('content')

    <style>
        .additional{display: none;}
        .additional td{border: none !important;}
        .has-more .glyphicon{cursor: pointer}
        .filter select, .filter input{width: 100% !important;}
        #table-list_length select{width: 75px !important;}
    </style>

    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.16/css/dataTables.bootstrap.min.css">

    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <button type="button" onclick="document.location.href='{{icp_route('news.create')}}'" class="btn btn-default">Add new</button>
                    <button id="delete-button" type="submit" class="btn btn-danger pull-right" disabled>Delete</button>
                </div>

                <div class="box-body">
                    <table id="table-list" class="table table-bordered table-striped">
                        <thead>
                        <tr class="filter">
                            <td colspan="2" id="dt-length"></td>
                            <td>
                                <select name="filter[active]" class="form-control input-sm" data-type="select">
                                    <option value="-1"> -- </option>
                                    <option value="1" {{session('article.datatable.filter.active', -1) == 1 ? 'selected="selected"' : ''}}>Yes</option>
                                    <option value="0" {{session('article.datatable.filter.active', -1) == 0 ? 'selected="selected"' : ''}}>No</option>
                                </select>
                            </td>
                            <td>
                                <select name="filter[category_id]" class="form-control input-sm" data-type="select">
                                    <option value="-1">-- no filter --</option>
                                    <option value="0">No category</option>
                                    @foreach($categories as $category)
                                        <option value="{{$category->id}}" {{session('article.datatable.filter.category_id') == $category->id ? 'selected="selected"' : ''}}>{{$category->title}}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td></td>
                            <td>
                                <input name="filter[title]" value="" class="form-control input-sm" data-type="string">
                            </td>
                            <td>
                                <input name="filter[slug]" value="" class="form-control input-sm" data-type="string">
                            </td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <th class="checkbox-header">
                                <input type="checkbox" id="check-all">
                            </th>
                            <th>ID</th>
                            <th style="padding-right: 8px;">Active</th>
                            <th>Category</th>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Slug</th>
                            <th>Views</th>
                            <th>Created</th>
                            <th style="width: 90px;">Actions</th>
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
        var filterSelector = '#table-list .filter';
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

            $(filterSelector).find('[name]').change(function(){
                $(dt.selector()).DataTable().ajax.reload();
            });

            $(dt.selector()).DataTable({
                paging: true,
                stateSave: true,
                //show menu: items per page
                lengthChange: true,
                lengthMenu: [ 10, 25, 50, 75, 100 ],
                pageLength: 25,

                searching: false,
                ordering: true,
                info: true,
                autoWidth: false,
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{icp_route('news.json')}}",
                    data: function(d){
                        $(filterSelector).find('[name]').each(function(key, item){
                            d[$(item).attr('name')] = $(item).val();
                        });
                    },
                    complete: function(response){
                        dt.initComplete();
                        if(response.responseJSON && response.responseJSON.csrf_token) {
                            Icp.token(response.responseJSON.csrf_token);
                        }
                    }
                    //type: "POST"
                },
                columns: [
                    {data: "checkbox", name: "checkbox", orderable: false, searchable: false, className: 'text-center' },
                    {data: "id", name: "id", orderable: true },
                    {data: "active", name: "active", className: 'text-center', orderable: false, searchable: false},
                    {data: "category", name: 'category', orderable: false},
                    {
                        className: 'text-center',
                        data: null,
                        name: "image",
                        orderable: false,
                        render: function(data){
                            return '<a target="_blank" href="'+data.url+'"><img style="width: 100px;" src="'+data.image+'"></a>';
                        }
                    },
                    {data: "title", name: 'title', orderable: false},
                    {data: "slug", name: 'slug', orderable: false},
                    {data: "views", name: 'views', orderable: true},
                    {data: "created_at", name: "created_at", orderable: true },
                    {data: 'actions', name: 'actions', orderable: false, searchable: false},
                ],
                order: [[ 1, "desc" ]],
                fnDrawCallback: function () {
                    $('#dt-length').prepend($('#table-list_length'));
                },
                stateLoadParams: function( settings, data ) {
                    if(data.filter){
                        $(filterSelector).find('[name]').each(function(key, item){
                            var name = $(item).attr('name');
                            if(data.filter[name]){
                                $(item).val(data.filter[name]);
                            }
                        });
                    }
                },
                stateSaveParams: function(settings, data){
                    data.filter = {};
                    $(filterSelector).find('[name]').each(function(key, item){
                        var name = $(item).attr('name');
                        data.filter[name] = $(item).val();
                    });

                    console.log(data);
                }
            });

            $('#delete-button').click(function(){
                if(confirm('Are you sure to DELETE this item?')) {
                    dt.postReload(
                        '{{icp_route('news.delete')}}',
                        $(checkboxSlavesSel).serialize() + '&_method=DELETE&_token='+Icp.token(),
                        dt.initComplete
                    )
                }
            });

        });
    </script>

@endsection