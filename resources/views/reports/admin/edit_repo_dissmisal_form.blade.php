@extends('_layouts.default')

@section('page_name')
    تعديل ايصال
@endsection

@section('page_content')
    <div class="card">
        <div class="card-header">
        <h3 class="card-title">تعديل ايصال للمندوب <span class="btn btn-info">{{$user->name}}</span></h3>
        <button type="button" class="btn btn-block btn-info btn-sm w-25">دين المندوب  {{$user->balance}}</button>
        </div>
        <div class="card card-primary card-outline px-5 py-2">
            <form action="{{route('reports.admin.edit_repo_dissmisal', $deposet_dissmisal->id)}}" method="POST" enctype="multipart/form-data">
                @csrf
                        <label>قيمة الايصال</label><br>
                @error('ammount')
                    <label class="text-danger">{{ $message }}</label><br>
                @enderror
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">$</span>
                    </div>
                    <input type="number" value="{{$deposet_dissmisal->ammount}}" step="1" min="0" name="ammount" class="form-control">
                    <div class="input-group-append">
                        <span class="input-group-text">.00</span>
                    </div>
                </div>
                
                <div class="form-group">
                    <label>الوصف</label><br>
                    @error('info')
                        <label class="text-danger">{{ $message }}</label><br>
                    @enderror
                    <textarea class="form-control" name="info" rows="3" placeholder="اكتب وصفا للأيصال">{{$deposet_dissmisal->info}}</textarea>
                </div>
                    <div class="row">
                    <!-- /.col -->
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block"><b>حفظ الايصال</b></button>
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
          title: "{{ $errors->first('big_ammount') }}",
          showConfirmButton: false,
          timer: 1500
      })
  }
  window.onload = massge;
  </script>
@enderror
@endsection