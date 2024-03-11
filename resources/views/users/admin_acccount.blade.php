@extends('_layouts.default')

@section('page_name')
    حساب المشرف
@endsection

@section('page_content')
    <div class="row">
        <div class="col-md-3">

        <!-- Profile Image -->
        <div class="card card-primary card-outline">
            <div class="card-body box-profile">
            <div class="text-center">
              <img src="{{asset('images/user_photos/')}}/{{$users->photo}}" width="100" height="100" class="img-circle elevation-2" alt="User Image">            </div>
            <h3 class="profile-username text-center mt-5">{{$users->name}}</h3>
            <ul class="list-group list-group-unbordered mb-3">
                <li class="list-group-item">
                <b>اجمالي الرصيد</b> <a class="float-right">{{$users->balance}}</a>
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
                <div class="tab-pane active" id="activity">
                  <table class="table table-bordered datatable">
                    <thead>                  
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>القيمة</th>
                        <th>الوصف</th>
                        <th>تاريخ الايداع</th>
                        <th>تاريخ اخر تعديل</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($deposets as $u)
                    <tr>
                        <td>{{$u->id}}</td>
                        <td>{{$u->ammount}}</td>
                        <td>{{$u->info}}</td>
                        <td>{{$u->created_at}}</td>
                        <td>{{$u->updated_at}}</td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
                </div>

                

                <!-- /.tab-pane -->
                <div class="tab-pane " id="timeline">
                    <form class="form-horizontal" method="POST" action="{{route('user.admins_deposet_search', $users->id)}}">
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