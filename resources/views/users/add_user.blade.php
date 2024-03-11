@extends('_layouts.default')

@section('page_name')
    المستخدمين
@endsection

@section('page_content')

<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">اضافة مستخدم <i class="fa-solid fa-user-plus"></i></h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    <form role="form" action="{{route('user.store')}}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="card-body">
        <div class="row">
            <div class="col-sm-6">
                @error('name')
                    <label class="text-danger">{{ $message }}</label><br>
                @enderror
                <div class="form-group">
                    <label for="exampleInputEmail1">الاسم الثلاثي</label>
                    <input type="text" name="name" class="form-control" id="exampleInputEmail1" placeholder="ادخل الاسم الشخصي" value="{{old('name')}}">
                </div>
            </div>
            <div class="col-sm-6">
                @error('username')
                    <label class="text-danger">{{ $message }}</label><br>
                @enderror
                <div class="form-group">
                    <label for="exampleInputEmail1">اسم المستخدم</label>
                    <input type="text" name="username" class="form-control" id="exampleInputEmail1" placeholder="ادخل الاسم المستخدم فالنظام" value="{{old('username')}}">
                </div>
            </div>
        </div>
        <div class="row">
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
                        <input type="text" name="phone" class="form-control" placeholder="09X-XXXXXXX" value="{{old('phone')}}">
                    </div>
                    <!-- /.input group -->
                </div>
            </div>
            <div class="col-sm-6">
                @error('role')
                    <label class="text-danger">{{ $message }}</label><br>
                @enderror
                <div class="form-group">
                    <label>نوع المستخدم</label>
                    <select class="form-control" name="role">
                        <option value="1">مندوب</option>
                        <option value="2">مشرف</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                @error('password')
                    <label class="text-danger">{{ $message }}</label><br>
                @enderror
                <div class="form-group">
                    <label for="exampleInputPassword1">كلمة المرور</label>
                    <input type="text" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password" value="{{old('password')}}">
                </div>
            </div>
            <div class="col-sm-6">
                @error('photo')
                    <label class="text-danger">{{ $message }}</label><br>
                @enderror
                <div class="form-group">
                    <label for="exampleInputFile">صورة شخصية</label>
                    <div class="input-group">
                        <div class="custom-file">
                            <input type="file" name="user_photo" class="custom-file-input" id="exampleInputFile">
                            <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                        </div>
                        <div class="input-group-append">
                            <span class="input-group-text" id="">تحميل</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        

    <!-- /.card-body -->

    <div class="card-footer mt-5">
        <button type="submit" class="btn btn-primary">حفظ البيانات <i class="fa-solid fa-floppy-disk"></i></button>
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