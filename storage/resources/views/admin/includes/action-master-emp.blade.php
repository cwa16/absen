<a href="javascript:void(0);" id="delete" onClick="deleteFunc({{ $id }})" data-toggle="tooltip" data-original-title="Delete" class="delete btn btn-danger btn-sm">
Delete
</a>
<a href="{{ route('edit-emp', $id) }}" class="btn btn-success btn-sm">EDIT</a>
<a href="{{ route('view-emp',$id) }}" class="btn btn-primary btn-sm">VIEW</a>