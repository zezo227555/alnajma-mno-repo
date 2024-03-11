@extends('_layouts.default')

@section('page_name')
    المستخدمين
@endsection

@section('page_content')
    <div class="card">
        <div class="card-header">
        <h3 class="card-title">تعديل بيانات المستخدم</h3>
        </div>
        <div class="card card-primary card-outline px-5 py-2">
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
            <form action="{{route('user.update', $user->id)}}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                @error('name')
                    <label class="text-danger">{{ $message }}</label><br>
                @enderror
                <div class="input-group mb-3">
                    <input type="text" value="{{ $user->name }}" name="name" class="form-control" placeholder="الاسم الثلاثي">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                </div>
                @error('username')
                    <label class="text-danger">{{ $message }}</label><br>
                @enderror
                <div class="input-group mb-3">
                    <input type="text" class="form-control" value="{{ $user->username }}" name="username" placeholder="اسم المستخدم">
                    <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-user"></span>
                    </div>
                </div>
                </div>
                @error('phone')
                    <label class="text-danger">{{ $message }}</label><br>
                @enderror
                <div class="input-group mb-3">
                    <input type="text" name="phone" class="form-control" value="{{ $user->phone }}" placeholder="رقم الهاتف">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-phone"></span>
                        </div>
                    </div>
                </div>
                <div class="form-group" data-select2-id="25">
                    <select value="{{ $user->role }}" required name="role" class="form-control select2 select2-hidden-accessible" style="width: 100%;" data-select2-id="1" tabindex="-1" aria-hidden="true">
                        <option value="salse">موظف مبيعات</option>
                        <option value="admin">مسؤول</option>
                    </select>
                </div>
                @error('password')
                    <label class="text-danger">{{ $message }}</label><br>
                @enderror
                <div class="input-group mb-3">
                    <input type="password" name="password" value="{{ $user->password }}" class="form-control" placeholder="كلمة المرور">
                    <div class="input-group-append">
                        <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                        </div>
                    </div>
                    </div>
                    @error('user_photo')
                    <label class="text-danger">{{ $message }}</label><br>
                    @enderror
                    <div class="form-group">
                    <div class="custom-file">
                        <label class="custom-file-label" for="customFile">صورة شخصية</label>
                        <input type="file" name="user_photo" class="custom-file-input" id="customFile">
                    </div>
                    </div>
                    <div class="row">
                    <!-- /.col -->
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block"><b>حفظ البيانات</b></button>
                    </div>
                    <!-- /.col -->
                    </div>
                </form>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
    <script src="{{asset('assets/plugins/jquery/jquery.min.js')}}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

    <script>
        function mySubmitFunction(e) {
            e.preventDefault();
        
            Swal.fire(
                'Good job!',
                'You clicked the button!',
                'success'
            );
        
            return false;
        }
    </script>
@endsection