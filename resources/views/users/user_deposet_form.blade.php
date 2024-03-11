@extends('_layouts.default')

@section('page_name')
    ايصال قبض
@endsection

@section('page_content')
    <div class="card">
        <div class="card-header">
        <h3 class="card-title">ايصال قبض من المستخدم  <span class="btn btn-success">{{$user->name}} <i class="fa-solid fa-user"></i></span></h3>
        <button type="button" class="btn btn-block btn-info btn-sm w-25">الرصيد  {{$user->balance}}</button>
        </div>
        <div class="card card-primary card-outline px-5 py-2">
            <form action="{{route('user.user_deposet', $user->id)}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-sm-6">
                        <label>قيمة الايصال</label><br>
                @error('ammount')
                    <label class="text-danger">{{ $message }}</label><br>
                @enderror
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">$</span>
                    </div>
                    <input value="{{$user->store_balance}}" value="{{old('ammount')}}" type="number" step="1" min="0" name="ammount" class="form-control">
                    <div class="input-group-append">
                        <span class="input-group-text">.00</span>
                    </div>
                </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="exampleInputFile">بيانات الايداع</label><br>
                            @error('data_file')
                              <label class="text-danger">{{ $message }}</label><br>
                            @enderror
                            <div class="input-group">
                              <div class="custom-file">
                                <input type="file" name="data_file" class="custom-file-input" id="exampleInputFile">
                                <label class="custom-file-label" for="exampleInputFile">اختر ملف</label>
                              </div>
                              <div class="input-group-append">
                                <span class="input-group-text" id="">تحميل</span>
                              </div>
                            </div>
                          </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label>الوصف</label><br>
                    @error('info')
                        <label class="text-danger">{{ $message }}</label><br>
                    @enderror
                    <textarea class="form-control" name="info" rows="3" placeholder="اكتب وصفا للأيصال">{{old('info')}}</textarea>
                </div>
                    <div class="row">
                    <!-- /.col -->
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block"><b>حفظ الايصال</b></button>
                    </div>
                    <!-- /.col -->
                    </div>
                </form>

            <a href="{{ route('user.index') }}" class="btn btn-secondary mt-3 btn-block"><b>رجوع الى القائمة</b></a>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
    <script src="{{asset('assets/plugins/jquery/jquery.min.js')}}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
@endsection

@section('my_scripts')
@if (Session::has('messege'))
                <script>
                    function massge() {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: "{{ session('messege') }}",
                            showConfirmButton: false,
                            timer: 1500
                        })
                    }
                    window.onload = massge;
                </script>
            @endif

@error('big_ammount')
  <script>
    function massge() {
        Swal.fire({
        position: 'top-end',
        icon: 'error',
        title: "القيمة لا تكفي",
        showConfirmButton: false,
        timer: 1500
    })
}
window.onload = massge;
</script>
  @enderror

  @error('zero_ammount')
  <script>
    function massge() {
        Swal.fire({
        position: 'top-end',
        icon: 'error',
        title: "{{$errors->first('zero_ammount')}}",
        showConfirmButton: false,
        timer: 1500
    })
}
window.onload = massge;
</script>
@enderror
  
@endsection