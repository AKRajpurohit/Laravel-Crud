@extends('layouts.master')

@section('content')
<div class="container ">
    <h2 class="text-center text-white mb-4">Create Product</h2>
    @if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <div align="right">
        <a href="{{ route('product.index') }}" class="btn btn-default">Back</a>
    </div>

    <form method="post" action="{{ route('product.store') }}" enctype="multipart/form-data" class="form-horizontal" role="form" id="add">

        @csrf
        <div class="form-group">
            <label>Product Name<span class="danger">*</span></label>
            <input type="text" name="product_name" class="form-control" value="{{ old('product_name') }}" required="true" placeholde="Enter product name"/>
        </div>
       <div class="form-group">
            <label>Select Category</label>
            <select class="form-control" name="category_id" >
                <option value="">- Select Category -</option>
                @if (isset($categories) && count($categories) > 0)                 
                @foreach ($categories as $category)
                <option value="{{$category['id']}}">{{$category['category_name']}}</option>
                @endforeach
                @else
                <option disabled>No Category Found</option>
                @endif
            </select>
        </div>
        <div class="form-group">
            <label>Product Description</label>
            <textarea row="5" cols="5" name="product_description" class="form-control">{{ old('product_description') ? old('product_description'):""}}</textarea>
        </div>
        <div class="form-group">
            <div class="form-group">
                <label>Select Profile Image</label>
                <input type="file" name="product_image"  value="{{ old('product_image') }}" id="prod_image"/>
                <br>
                <img src="{{ asset('images/no_image.jpg')}}" height="59" width="100" id="product-img-tag"/>
            </div>
            <div class="form-group text-center">
                <input type="submit" name="add" class="btn btn-primary" value="Add" />
                 <a href="{{ route('product.index') }}" class="btn btn-default">Cancel</a>
            </div>

    </form>
</div>
@endsection
