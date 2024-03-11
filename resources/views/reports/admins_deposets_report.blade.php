@extends('_layouts.default')

@section('page_name')
الاضافات من المالية
@endsection

@section('page_action')
    <a href="{{route('admins.admins_account', auth()->user()->id)}}" class="btn btn-secondary btn-block">رجوع للسابق <i class="fa-solid fa-rotate-left"></i></a>
@endsection

@section('page_content')
    
    <div class="card co">
        <div class="card-header">
        <h3 class="card-title">تقرير الشحنات و الايداعات من المالية</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
        <table class="table table-bordered text-center datatable">
            <thead>                  
            <tr>
                <th style="width: 10px">#</th>
                <th>القيمة</th>
                <th>الوصف</th>
                <th>التاريخ</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($deposet_dissmisal as $u)
            <tr>
                <td>{{$u->id}}</td>
                <td>{{$u->ammount}}</td>
                <td>{{$u->info}}</td>
                <td>{{$u->created_at}}</td>
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