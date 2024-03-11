@extends('_layouts.default')

@section('page_name')
    تعديل بيانات
@endsection

@section('page_content')

<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">تعديل بيانات المحل ({{$store->name}})</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    <form role="form" action="{{route('stores.update', $store->id)}}" method="POST">
        @method('PUT')
    @csrf
    <div class="card-body">
        <div class="row">
            <div class="col-sm-6">
                @error('name')
                    <label class="text-danger">{{ $message }}</label><br>
                @enderror
                <div class="form-group">
                    <label for="exampleInputEmail1">اسم المحل</label>
                    <input type="text" name="name" class="form-control" id="exampleInputEmail1" value="{{$store->name}}">
                </div>
            </div>
            <div class="col-sm-6">
                @error('phone')
                    <label class="text-danger">{{ $message }}</label><br>
                @enderror
                <div class="form-group">
                    <label>رقم الهاتف</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                        </div>
                        <input type="text" name="phone" class="form-control" value="{{$store->phone}}">
                    </div>
                    <!-- /.input group -->
                </div>
            </div>
        </div>
    <!-- /.card-body -->

    <div class="card-footer mt-5">
        <button type="submit" class="btn btn-primary">حفظ البيانات</button>
    </div>
    </form>
</div>
</div>

@endsection

@section('my_scripts')
    @if (Session::has('message'))
    <script>
        function massge() {
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: "{{ session('message') }}",
                showConfirmButton: false,
                timer: 1500
            })
        }
        window.onload = massge;
    </script>
    @endif
@endsection