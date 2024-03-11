@extends('_layouts.default')

@section('page_name')
    حساب المالية
@endsection

@section('page_content')
    <div class="row">
        <div class="col-md-3">

        <!-- Profile Image -->
        <div class="card card-primary card-outline">
            <div class="card-body box-profile">
            <div class="text-center">
              <img src="{{asset('images/user_photos/')}}/{{$users->photo}}" width="100" height="100" class="img-circle elevation-2" alt="User Image">
            </div>
            <h3 class="profile-username text-center mt-3">{{$users->name}}</h3>
            <ul class="list-group list-group-unbordered mb-3">
                <li class="list-group-item">
                <b>اجمالي الرصيد</b> <a class="float-right">{{$users->balance}}</a>
                </li>
                <li class="list-group-item">
                  <b>رصيد النقدي</b> <a class="float-right">{{$users->store_balance}}</a>
                  </li>
                <li class="list-group-item">
                <b>اخر شحنة بقيمة</b>
                @isset($last_deposet->ammount)
                <a class="float-right">{{$last_deposet->ammount}}</a>
                @endisset
                </li>
                <li class="list-group-item">
                <b>تاريخ اخر شحنة</b>
                @isset($last_deposet->created_at)
                <a class="float-right">{{$last_deposet->created_at}}</a>
                @endisset
                </li>
            </ul>
            <!-- Button trigger modal -->
              <button type="button" class="btn btn-success btn-block" data-toggle="modal" data-target="#deposet">
                تعبئة القيمة
                <i class="fa-solid fa-money-bill-trend-up"></i>
              </button>
              <button type="button" class="btn btn-danger btn-block" data-toggle="modal" data-target="#dissmisal">
                ايصال صرف
                <i class="fa-solid fa-money-bill-transfer"></i>
              </button>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
        <div class="card">
            <div class="card-header p-2">
            <ul class="nav nav-pills">
                <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">اخر عشر شحنات</a></li>
                <li class="nav-item"><a class="nav-link " href="#timeline" data-toggle="tab">تقرير مفصل</a></li>
            </ul>
            </div><!-- /.card-header -->
            <div class="card-body">
            <div class="tab-content">
                <div class="tab-pane active co_table" id="activity">
                  <table class="table table-bordered text-center datatable">
                    <thead>                  
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>القيمة</th>
                        <th>النوع</th>
                        <th>ملف الايداع</th>
                        <th>تاريخ الايداع</th>
                        <th>اجراء</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($deposets as $u)
                    <tr>
                        <td>{{$u->id}}</td>
                        <td>{{$u->ammount}}</td>
                        @if ($u->type == 1)
                            <td><span class="btn btn-success w-75">ايداع</span></td>
                        @else
                            <td><span class="btn btn-danger w-75">صرف</span></td>
                        @endif
                        <td><a href="{{asset('deposet_files')}}/{{ $u->file }}" class="btn btn-info">ملف الايداع</a></td>
                        <td>{{$u->created_at}}</td>
                        <td><a href="{{route('reports.alnajma.edit_alnajma_adds_form', $u->id)}}" class="btn btn-warning">تعديل</a></td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
                </div>
                <!-- /.tab-pane -->
                <div class="tab-pane " id="timeline">
                  <form class="form-horizontal" method="POST" action="{{route('user.alnajma_deposet_search')}}">
                    @csrf
                    <div class="form-group">

                        <label>من تاريخ</label><br>
                        @error('date_from')
                          <label class="text-danger">{{ $message }}</label><br>
                        @enderror
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text">
                              <i class="far fa-calendar-alt"></i>
                            </span>
                          </div>
                          <input name="date_from" type="datetime-local" class="form-control float-right" id="reservation">
                        </div>
                        <!-- /.input group -->
                      </div>
                      <div class="form-group">
                        <label>الى تاريخ</label><br>
                        @error('date_to')
                          <label class="text-danger">{{ $message }}</label><br>
                        @enderror
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text">
                              <i class="far fa-calendar-alt"></i>
                            </span>
                          </div>
                          <input name="date_to" type="datetime-local" class="form-control float-right" id="reservation">
                        </div>
                        <!-- /.input group -->
                      </div>
                    <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary">بحث</button>
                    </div>
                    </div>
                </form>
                </div>
                <!-- /.tab-pane -->

               
            </div>
            <!-- /.tab-content -->
            </div><!-- /.card-body -->
        </div>
        <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
    </div>

@endsection

@section('models')

<!-- Modal -->
<div class="modal fade" id="dissmisal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">ايصال صرف</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="card card-danger">
          <div class="card-header">
            <h3 class="card-title">بيانات الايصال <i class="fa-solid fa-money-bill-transfer"></i></h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->
          <form role="form" action="{{route('user.alnajma_dissmisal', $users->id)}}" method="POST" enctype="multipart/form-data">
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
                    <input type="number" step="1" min="0" name="ammount" class="form-control">
                    <div class="input-group-append">
                        <span class="input-group-text">.00</span>
                    </div>
                </div>
                <div class="form-group">
                    <label>الوصف</label><br>
                    @error('info')
                        <label class="text-danger">{{ $message }}</label><br>
                    @enderror
                    <textarea class="form-control" name="info" rows="3" placeholder="اكتب وصفا للأيصال"></textarea>
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
              <button type="submit" class="btn btn-warning">حفظ <i class="fa-solid fa-floppy-disk"></i></button>
            </div>
          </form>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق <i class="fa-solid fa-square-xmark"></i></button>
      </div>
    </div>
  </div>
</div>
</div>

<!-- Modal -->
<div class="modal fade" id="deposet" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">تعبئة القيمة</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="card card-success">
          <div class="card-header">
            <h3 class="card-title">بيانات الايصال <i class="fa-solid fa-money-bill-trend-up"></i></h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->
          <form role="form" action="{{route('user.alnajma_topup', $users->id)}}" method="POST" enctype="multipart/form-data">
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
                    <input type="number" step="1" min="0" name="ammount" class="form-control">
                    <div class="input-group-append">
                        <span class="input-group-text">.00</span>
                    </div>
                </div>
                <div class="form-group">
                    <label>الوصف</label><br>
                    @error('info')
                        <label class="text-danger">{{ $message }}</label><br>
                    @enderror
                    <textarea class="form-control" name="info" rows="3" placeholder="اكتب وصفا للأيصال"></textarea>
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
            <!-- /.card-body -->

            <div class="card-footer">
              <button type="submit" class="btn btn-warning">حفظ <i class="fa-solid fa-floppy-disk"></i></button>
            </div>
          </form>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق <i class="fa-solid fa-square-xmark"></i></button>
      </div>
    </div>
  </div>
</div>

@endsection

@section('my_scripts')

  @if($errors->get('ammount') || $errors->get('info') || $errors->get('data_file'))
    <script>
        function massge() {
            Swal.fire({
            position: 'top-end',
            icon: 'error',
            title: "حدث خطأ",
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
        title: "رصيدك غير كافي",
        showConfirmButton: false,
        timer: 1500
    })
}
window.onload = massge;
</script>
  @enderror

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
    

@endsection