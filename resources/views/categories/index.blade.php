@extends('layouts.master')

@section('content')
<div>
     <a class="btn btn-primary" href="{{ route('category.create') }}">Add new Category</a>
    <button class="btn btn-danger" id ="bulk-delete-button" disabled="true" >Delete</button>
</div>
 @if(count($data) > 0)
<table class="table table-bordered table-striped" style="margin-top: 20px">
   
    <tr>
        <th width="3%"><input type="checkbox" id="bulk-checkbox-action" onClick="checkBoxBulkEvent(this,{{json_encode($data)}})"  /></th>
        <th width="10%">Category Image</th>
        <th width="25%">Category Name</th>
        <th width="25%">Parent Category Name</th>        
        <th width="10%">Action</th>
    </tr>
    @foreach($data as $row)
    <tr>
        <td><input type="checkbox"  class="CheckBox" onClick="checkBoxEvent(this,{{$row->id}},{{$row->count()}})" /></td>
        <td><img src="{{  $row->category_pic }}" class="img-thumbnail" width="100" height="59" /></td>
        <td>{{ $row->category_name }}</td>
        <td>{{ $row->parentCat['category_name'] ?  $row->parentCat['category_name'] : "-"}}</td>       
        <td style="display:flex">
            <a href="{{ route('category.edit', $row->id) }}" class="btn btn-primary">Edit</a>
            <form action="{{url('category', [$row->id])}}" method="POST">
                <input type="hidden" name="_method" value="DELETE">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="submit" onclick="return confirm('Are you sure want to delete this category?')" class="btn btn-danger delete_button" value="Delete"/>
            </form>
        </td>
    </tr>
    @endforeach
</table>
 @else
 <h2>No,record found</h2>
 @endif 
{!! $data->links() !!}



@endsection
