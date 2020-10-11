
<!DOCTYPE html>

<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Laravel Crud</title>
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="{{asset('css/app.css')}}">


    </head>

    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper" id="app">

            <!-- Main Header -->
            <header class="main-header">

                <!-- Logo -->
                <a href="index2.html" class="logo">
                    <!-- mini logo for sidebar mini 50x50 pixels -->
                    <span class="logo-mini"><b>L</b>C</span>
                    <!-- logo for regular state and mobile devices -->
                    <span class="logo-lg"><b>Laravel</b>Crud</span>
                </a>

                <!-- Header Navbar -->
                <nav class="navbar navbar-static-top" role="navigation">
                    <!-- Sidebar toggle button-->
                    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                        <span class="sr-only">Toggle navigation</span>
                    </a>

                </nav>
            </header>
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="main-sidebar">

                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">

                    <!-- Sidebar user panel (optional) -->
                    <div class="user-panel">
                        <div class="pull-left image">
                            <img src="{{asset('images/avatar5.png')}}" class="img-circle" alt="User Image">
                        </div>
                        <div class="pull-left info">
                            <!-- Status -->
                            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                        </div>
                    </div>


                    <!-- Sidebar Menu -->
                    <ul class="sidebar-menu" data-widget="tree">
                        <li  id="active"><a href="{{url('category')}}"><i class="fa fa-microchip"></i> <span>Category</span></a></li>
                        <li  id="active"><a href="{{url('product')}}"><i class="fa fa-microchip"></i> <span>Product</span></a></li>

                        <li class="">
                        </li>

                    </ul>
                    <!-- /.sidebar-menu -->
                </section>
                <!-- /.sidebar -->
            </aside>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">


                <!-- Main content -->
                <section class="content container-fluid">
                    <div class="flash-message">
                        @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                        @if(Session::has('alert-' . $msg))
                        <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }}</p>
                        @endif
                        @endforeach
                    </div>
                    @yield('content')

                </section>
                <!-- /.content -->
            </div>            
        </div>


        <script src="{{asset('js/app.js')}}"></script>

        <script>
$("document").ready(function () {
    setTimeout(function () {
        $("div.flash-message").remove();
    }, 3000); // 5 secs

});
var id_array = [];
var cur_url = window.location.pathname.split('/');
cur_url = cur_url[1];

function checkBoxBulkEvent(event, records) {
    if (event.checked) {
        records.data.map(list => {
            id_array.push(list.id);
        });
        $('.CheckBox').prop('checked', true);
    } else {
        id_array = [];
        $('.CheckBox').prop('checked', false);
    }
    if (id_array.length > 0) {
        $('#bulk-delete-button').prop('disabled', false);
        $('.delete_button').prop('disabled', true);
    } else {
        $('#bulk-delete-button').prop('disabled', true);
        $('.delete_button').prop('disabled', false);
    }
}

function checkBoxEvent(event, id, total_records) {
    if (event.checked) {
        id_array.push(id);

    } else {
        var filer_list = id_array.length > 0 ? id_array.filter((x) => x !== id) : "";
        id_array = filer_list;
    }
    if (id_array.length > 0) {
        $('#bulk-delete-button').prop('disabled', false);
        $('.delete_button').prop('disabled', true);
        if (total_records === id_array.length) {
            $('#bulk-checkbox-action').prop('checked', true);
        } else {
            $('#bulk-checkbox-action').prop('checked', false);
        }
    } else {
        $('.delete_button').prop('disabled', false);
        $('#bulk-delete-button').prop('disabled', true);
    }
}
$("#bulk-delete-button").click(function (event) {
    var deleteConfirm = confirm("Are you sure want to delete ?");
    if (deleteConfirm) {

        event.preventDefault();
        let _token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: cur_url + "/bulkdelete",
            type: "POST",
            data: {
                ids: id_array,
                _token: _token
            },
            success: function (response) {
                console.log(response);
                if (response) {
                    window.location.reload();
                    $('.success').text(response.success);
                    $("#ajaxform")[0].reset();
                }
            },
        });
    }
    return true;
});
function readURL(input,type) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#'+type+'-img-tag').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

$("#cat_image").change(function () {
    readURL(this,'category');
});
$("#prod_image").change(function () {
    readURL(this,'product');
});
//function inputSearchChange(e){
//  
//    console.log("herrere",e.keyCode);
//     if(e.value.length >= 3 ){
//         $('#serach_button').prop('disabled',false);
//     }else{
//          $('#serach_button').prop('disabled',true);
//     }
//         
// };
        </script>
    </body>
</html>