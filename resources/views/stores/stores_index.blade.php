@extends('_layouts.default')

@section('page_name')
    قائمة المحلات
@endsection

@section('page_action')
    @if (auth()->user()->role == 1)
        <!-- اضافة محل -->
        <button type="button" class="btn btn-primary w-100" data-toggle="modal" data-target="#exampleModal">
            اضافة محل جديد <i class="fa-solid fa-circle-plus"></i>
        </button>
    @endif
@endsection

@section('page_info')
    <span class="btn btn-warning w-100">اجمالي الديون : {{$ammount}}</span>
@endsection

@section('page_content')
    
    <div class="card co">
        <div class="card-header">
        <h3 class="card-title">المحلات</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
        <table class="table table-bordered text-center datatable">
            <thead>                  
            <tr>
                <th style="width: 10px">#</th>
                <th>الاسم</th>
                <th>رقم الهاتف</th>
                <th>عدد الشحنات للشهر</th>
                <th>اجمالي الدين</th>
                <th>اجراء</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($stores as $u)
            <tr>
                <td>{{$u->id}}</td>
                <td>{{$u->name}}</td>
                <td>{{$u->phone}}</td>
                <td>{{count($u->Ricept)}}</td>
                <td>{{$u->balance}}</td>
                @if (auth()->user()->role == 1)
                    <td>
                        <a href="{{ route('stores.edit', $u->id) }}" class="btn mr-1 btn-warning">تعديل <i class="fa-solid fa-pen-to-square"></i></a>
                        <a href="{{ route('store.store_deposet_form', $u->id) }}" class="btn mr-1 btn-success">ايصال قبض <i class="fa-solid fa-money-bill-trend-up"></i></a>
                        <a href="{{ route('store.store_dissmisal_form', $u->id) }}" class="btn mr-1 btn-danger">ايصال صرف <i class="fa-solid fa-money-bill-transfer"></i></a>
                    </td>
                @else
                    <td><a href="{{ route('reports.get_repo_stores_balance_report', $u->id) }}" class="btn mr-1 btn-info">تقرير <i class="fa-solid fa-file-lines"></i></a></td>
                @endif
            </tr>
            @endforeach
            </tbody>
        </table>
        </div>
        
    </div>

@endsection

@section('models')

    <!-- اضافة محل -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">اضافة محل جديد</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <div class="card card-primary">
                    <div class="card-header">
                      <h3 class="card-title">بيانات المحل <i class="fa-solid fa-shop"></i></h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form role="form" action="{{route('stores.store')}}" method="post">
                        @csrf
                      <div class="card-body">
                        <div class="form-group">
                          <label for="exampleInputEmail1">اسم المحل</label><br>
                          @error('name')
                            <label class="text-danger">{{ $message }}</label><br>
                          @enderror
                          <input type="text" name="name" class="form-control" id="exampleInputEmail1" placeholder="ادخل الاسم">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">رقم الهاتف</label><br>
                                @error('phone')
                            <label class="text-danger">{{ $message }}</label><br>
                            @enderror
                            <input type="text" name="phone" class="form-control" id="exampleInputEmail1" placeholder="09X-XXXXXXX">
                          </div>
                      </div>
                      <!-- /.card-body -->
      
                      <div class="card-footer">
                        <button type="submit" class="btn btn-primary">حفظ <i class="fa-solid fa-floppy-disk"></i></button>
                      </div>
                    </form>
                  </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
            </div>
        </div>
        </div>
    </div>

@endsection

@section('my_scripts')

@if($errors->get('name') || $errors->get('phone'))
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

@if (Session::has('massege'))
        <script>
            function massge() {
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: "{{ session('massege') }}",
                    showConfirmButton: false,
                    timer: 1500
                })
            }
            window.onload = massge;
        </script>
    @endif

@endsection