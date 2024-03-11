@extends('_layouts.default')

@section('page_name')
     تعديل ايصال {{$deposet_dissmisal->type == 1 ? 'القبض' : 'الصرف'}}
@endsection

@section('page_content')
<div class="card {{$deposet_dissmisal->type == 1 ? 'card-success' : 'card-danger'}}">
    <div class="card-header">
      <h3 class="card-title">بيانات الايصال</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    <form role="form" action="{{route('reports.alnajma.edit_alnajma_adds', $deposet_dissmisal->id)}}" method="POST" enctype="multipart/form-data">
      <div class="card-body">
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
        <div class="form-group">
          <label for="exampleInputFile">بيانات الصرف</label><br>
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
      <!-- /.card-body -->

      <div class="card-footer">
        <button type="submit" class="btn btn-warning">حفظ</button>
      </div>
    </form>
  </div>
</div>
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