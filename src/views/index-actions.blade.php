<form method="POST" action="{{icp_route('news.delete', $id)}}">
    {{csrf_field()}}
    <input type="hidden" name="_method" value="DELETE">
    <a href="{{icp_route('news.view', $id)}}" class="btn btn-xs btn-info"><i class="fa fa-eye" data-toggle="tooltip" data-placement="top" title="" data-original-title="View"></i></a>&nbsp;
    <a href="{{icp_route('news.edit', $id)}}" class="btn btn-xs btn-warning"><i class="fa fa-pencil" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"></i></a>&nbsp;
    <button onclick="return confirm('Are you sure you want to delete this article?')" type="submit" class="btn btn btn-xs btn-danger" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete">
        <i class="fa fa-trash"></i>
        <span class="sr-only">Delete</span>
    </button>
</form>