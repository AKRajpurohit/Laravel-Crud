@extends('layouts.master')

@section('content')
<div class="container ">
    <h2 class="text-center text-white mb-4">Create Category</h2>
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

    <form method="post" action="{{ route('category.store') }}" enctype="multipart/form-data" class="form-horizontal" role="form" id="add">

        @csrf
        <div class="form-group">
            <label>Category Name</label>
            <input type="text" name="category_name" class="form-control" value="{{ old('category_name') }}" required="true"/>
        </div>
        <div class="form-group">
            <label>Select Category <span class="danger">*</span></label>
            <select class="form-control" name="parent_category" product_image>
                <option value="">- Select Parent Category -</option>
                @if (isset($parent_categories) && count($parent_categories) > 0)                 
                @foreach ($parent_categories as $category)
                <option value="{{$category['id']}}">{{$category['category_name']}}</option>
                @endforeach
                @else
                <option disabled>No Category Found</option>
                @endif
            </select>
        </div>
        <div class="form-group">
            <div class="form-group">
                <label>Select Category Image</label>
                <input type="file" name="category_image" id="cat_image" />
                <br>
                <img src="{{ asset('images/no_image.jpg')}}" alt="your image"   id="category-img-tag" width="100" height="59"  />
            </div>
            <div class="form-group text-center">
                <input type="submit" name="add" class="btn btn-primary" value="Add" />
                <a href="{{ route('category.index') }}" class="btn btn-default">Cancel</a>
            </div>

    </form>
</div>
<script>
     function readURL(input) {
        alert(input);
        var input = this;
        var url = $(this).val();
        var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
        if (inp ut.files && input.files[0] && (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#img').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        } else
        {
            $('#img').attr('src', '/assets/no_preview.png');
        }
    };

   


</script>
@endsection
