@extends('layouts.master')

@section('content')
<div>
    <a href="{{ route('product.create') }}" class="btn btn-primary">Add Product</a>
    <button class="btn btn-danger" id ="bulk-delete-button" disabled="true">Delete</button>
</div>

<div class="container-fluid"  style="margin-top: 20px">
    <div class="row ">
        <div class="col-sm-8">
            <form  action="{{route('search')}}"  method="get" role="search">
                {{ csrf_field() }}
                <div class="col-sm-3 form-group topnav"><label class="control-label ">Search product</labbel></div>
                <div class="col-sm-3 form-group"><input type="text" id="serach_input" placeholder="Search.." name="search_string" onChange="inputSearchChange(this)" value="{{ isset($searchStaring) ? $searchStaring : old('search_string')}}"></div>
                <div class="col-sm-3 form-group">
                    <select class="form-control" name="category_id" >
                        <option value="">- Select Category -</option>
                        @if (isset($categories) && count($categories) > 0)                 
                        @foreach ($categories as $category)
                        <option value="{{$category['id']}}" >{{$category['category_name']}}</option>
                        @endforeach
                        @else
                        <option disabled>No Category Found</option>
                        @endif
                    </select>
                </div>
<div class="col-sm-2 form-group"><button class="btn btn-primary" id="serach_button" >Search</button></div>
               <a href="{{ route('product.index') }}" class="btn btn-default">Clear</a>
            </form>
        </div>
    </div>
</div>
@if(count($data) > 0)

<table class="table table-bordered table-striped" style="margin-top: 20px">
    <tr>
        <th width="3%"><input type="checkbox" id="bulk-checkbox-action" onClick="checkBoxBulkEvent(this,{{json_encode($data)}})" /></th>
        <th width="20%">Product Image</th>
        <th width="20%">Product Name</th>
        <th width="25%">Category Name</th>
        <th width="10%">Action</th>
    </tr>
    @foreach($data as $row)
    <tr>
        <td><input type="checkbox" class="CheckBox" onClick="checkBoxEvent(this,{{$row->id}},{{$row->count()}})"/></td>
        <td><img src="{{  $row->product_pic }}" class="img-thumbnail" /></td>
        <td>{{ $row->product_name }}</td>        
        <td>{{  $row->categories->category_name ??"-"}}</td>
        <td style="display:flex">
            <a href="{{ route('product.edit', $row->id) }}" class="btn btn-primary">Edit</a>
            <form action="{{url('product', [$row->id])}}" method="POST">
                <input type="hidden" name="_method" value="DELETE">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="submit" onclick="return confirm('Are you sure want to delete this product?')" class="btn btn-danger delete_button" value="Delete"/>
            </form>
        </td>
    </tr>
    @endforeach
</table>
@else
<h2>No,record found</h2>
@endif 
{!! $data->links() !!}

<!-- Modal -->
<div class="modal modal-danger fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center" id="myModalLabel">Delete Confirmation</h4>
            </div>
            <form action="{{route('product.destroy','test')}}" method="post">
                {{method_field('delete')}}
                {{csrf_field()}}
                <div class="modal-body">
                    <p class="text-center">
                        Are you sure you want to delete this?
                    </p>
                    <input type="hidden" name="product_id" id="prod_id" value="">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-dismiss="modal">No, Cancel</button>
                    <button type="submit" class="btn btn-warning">Yes, Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
 
</script>
@endsection
