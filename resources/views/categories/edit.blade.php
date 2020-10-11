@extends('layouts.master')

@section('content')
<div class="container ">
    <h2 class="text-center text-white mb-4">Update Category</h2>
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
        <a href="{{ route('category.index') }}" class="btn btn-default">Back</a>
    </div>

    <form method="post" action="{{ route('category.update', $data->id) }}" enctype="multipart/form-data" class="form-horizontal" role="form" id="update">

        @csrf
        {{ method_field('PATCH') }}
        <div class="form-group">
            <label>Category Name<span class="danger">*</span></label>
            <input type="text" name="category_name" class="form-control" value="{{  $data['category_name']}}" required="true"/>
        </div>
        <div class="form-group">
            <label>Select Category</label>
            <select class="form-control" name="parent_category" product_image>
                <option value="">- Select Parent Category -</option>
                @if (isset($parent_categories) && count($parent_categories) > 0)                 
                @foreach ($parent_categories as $category)
                <option value="{{$category['id']}}"  {{ $category['id'] == $data['parent_category'] ? 'selected' : '' }}>{{$category['category_name']}}</option>
                @endforeach
                @else
                <option disabled>No Category Found</option>
                @endif
            </select>
        </div>
        <div class="form-group">
            <div class="form-group">
                <label>Select Profile Image</label>
                <input type="file" name="category_image" id="cat_image" value="{{ old('category_image')}}"/>
                <br>
                <img src="{{asset($data['category_pic']) }}" id="category-img-tag" width="100" height="59" />
            </div>
            <div class="form-group text-center">
                <input type="submit" name="add" class="btn btn-primary" value="Update" />
                <a href="{{ route('category.index') }}" class="btn btn-default">Cancel</a>
            </div>

    </form>
</div>
@endsection
