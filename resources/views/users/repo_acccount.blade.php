@extends('_layouts.default')

@section('page_name')
    حساب المندوب <i class="fa-solid fa-user"></i>
@endsection

@section('page_content')
    <div class="row mt-2">
        <div class="col-md-3">

        <!-- Profile Image -->
        <div class="card card-primary card-outline">
            <div class="card-body box-profile">
            <div class="text-center">
              <img src="{{asset('images/user_photos/')}}/{{$users->photo}}" width="100" height="100" class="img-circle elevation-2" alt="User Image">            </div>
            <h3 class="profile-username text-center mt-2">{{$users->name}}</h3>
            <ul class="list-group list-group-unbordered mb-3">
                <li class="list-group-item">
                <b>اجمالي الدين</b> <a class="float-right">{{$users->balance}}</a>
                </li>
                <li class="list-group-item">
                  <b>اجمالي القبض من المحلات</b> <a class="float-right">{{$users->store_balance}}</a>
                  </li>
                  <li class="list-group-item">
                    <b>رصيد المنظومة</b> <a class="float-right">{{$users->portal_balance}}</a>
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
                <li class="list-group-item">
                  <b>اخر ايداع بقيمة</b>
                  @isset($last_dissmisal->ammount)
                  <a class="float-right">{{$last_dissmisal->ammount}}</a>
                  @endisset
                  </li>
                  <li class="list-group-item">
                  <b>تاريخ اخر ايداع</b>
                  @isset($last_dissmisal->created_at)
                  <a class="float-right">{{$last_dissmisal->created_at}}</a>
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
              @if (auth()->user()->role == 1)
                <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">اخر عشر شحنات <i class="fa-solid fa-0"></i><i class="fa-solid fa-1"></i></a></li>
                <li class="nav-item"><a class="nav-link " href="#timeline" data-toggle="tab">تقرير مفصل <i class="fa-solid fa-circle-info"></i></a></li>
              @endif
                <li class="nav-item"><a class="nav-link {{auth()->user()->role == 2 ? 'active' : ''}}" href="#se" data-toggle="tab">راتب الشهر <i class="fa-solid fa-money-bill"></i></a></li>
            </ul>
            </div><!-- /.card-header -->
            <div class="card-body">
            <div class="tab-content">
              @if (auth()->user()->role == 1)
                <div class="tab-pane active" id="activity">
                  <table class="table table-bordered datatable">
                    <thead>                  
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>القيمة</th>
                        <th>تاريخ الايداع</th>
                        <th>تاريخ اخر تعديل</th>
                        <th>اجراء</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($deposets as $u)
                    <tr>
                        <td>{{$u->id}}</td>
                        <td>{{$u->ammount}}</td>
                        <td>{{$u->created_at}}</td>
                        <td>{{$u->updated_at}}</td>
                        @if ($u->type == 0)
                        <td><button class="btn btn-danger">صرف</button></td>                            
                        @else
                        <td><button class="btn btn-success">ايداع</button></td> 
                        @endif
                    </tr>
                    @endforeach
                    </tbody>
                </table>
                </div>
                <!-- /.tab-pane -->
                <div class="tab-pane " id="timeline">
                  <form class="form-horizontal" method="POST" action="{{route('user.repo_deposet_search', $users->id)}}">
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
                @endif
                <!-- /.tab-pane -->
                <div class="tab-pane {{auth()->user()->role == 2 ? 'active' : ''}} " id="se">
                  <table class="table table-bordered text-center">
                    <thead>                  
                    <tr>
                        <th>عدد المحلات المشحونة</th>
                        <th>الاساسي</th>
                        <th>Class A</th>
                        <th>Class B</th>
                        <th>اضافي A</th>
                        <th>اضافي B</th>
                        <th>اجمالي الراتب</th>
                    </tr>
                    </thead>
                    <tbody>
                      <td>{{$topup_co}}</td>
                      <td>{{$repo_salary}}</td>
                      <td>{{$class_A}}</td>
                      <td>{{$class_B}}</td>
                      <td>{{$salary_A}}</td>
                      <td>{{$salary_B}}</td>
                      <td>{{$repo_salary + $salary_A + $salary_B}}</td>
                    </tbody>
                </table>

                <table class="table table-bordered mt-5 text-center">
                  <thead>                  
                  <tr>
                      <th>البند</th>
                      <th style="background-color: #55eb34;">مستوى 1</th>
                      <th style="background-color: #eefa02;">مستوى 2</th>
                      <th style="background-color: #fac002;">مستوى 3</th>
                      <th style="background-color: #fa2c02;">مستوى 4</th>
                  </tr>
                  <tr>
                    <td>عدد نقاط البيع</td>
                    <td>26 الى 30</td>
                    <td>20 الى 25</td>
                    <td>19 الى 15</td>
                    <td>10 الى 14</td>
                  </tr>
                  <tr>
                    <td>الراتب</td>
                    <td>950</td>
                    <td>680</td>
                    <td>560</td>
                    <td>450</td>
                  </tr>
                  <tr>
                    <td>الاضافي</td>
                    <td colspan="2" style="background-color: #55eb34;">Class A (1دل لكل 1000دل)</td>
                    <td colspan="2" style="background-color: #eefa02;">Class B (0.5دل لكل 1000دل)</td>
                  </tr>
                  </thead>
                  <tbody>
                  
                  </tbody>
              </table>
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

  @if($errors->get('date_from') || $errors->get('date_to'))
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