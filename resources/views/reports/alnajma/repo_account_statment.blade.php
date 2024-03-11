@extends('_layouts.default')

@section('page_name')
المندوبين
@endsection


@section('page_content')
    
    <div class="card">
        <div class="card-header">
        <h3 class="card-title">كشف حساب للمندوب <span class="btn btn-info">{{$repo->name}} <i class="fa-solid fa-user"></i></span></h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
        <table class="table table-bordered text-center datatable">
            <thead>                  
            <tr>
                <th style="width: 10px">#</th>
                <th>القيمة</th>
                <th>النوع</th>
                <th>الوصف</th>
                <th>التاريخ</th>
                <th>مرفقات</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($deposet as $u)
            <tr>
                <td>{{$u->id}}</td>
                <td>{{$u->ammount}}</td>
                @if ($u->type == 0)
                    <td><span class="btn btn-danger">صرف <i class="fa-solid fa-money-bill-transfer"></i></span></td>
                @else
                    <td><span class="btn btn-success">ايداع <i class="fa-solid fa-money-bill-trend-up"></i></span></td>
                @endif
                <td>{{$u->info}}</td>
                <td>{{$u->created_at}}</td>
                @if (isset($u->file))
                    <td><a href="{{asset('deposet_files/repo_files')}}/{{ $u->file }}" class="btn btn-info">ملف الايداع <i class="fa-solid fa-file"></i></a></td>
                @else
                    <td><a href="#" class="btn btn-warning">لا يوجد مرفق <i class="fa-solid fa-file-excel"></i></a></td>
                @endif
            </tr>
            @endforeach
            </tbody>
        </table>
        </div>
        <!-- /.card-body -->
        
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