@extends('_layouts.default')

@section('page_name')
الاضافات من المشرف
@endsection

@section('page_action')
@endsection

@section('page_content')
    
    <div class="card">
        <div class="card-header">
        <h3 class="card-title">تقرير الشحنات للمندوب</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
        <table class="table table-bordered text-center datatable">
            <thead>                  
            <tr>
                <th>المندوب</th>
                <th>القيمة</th>
                <th>الوصف</th>
                <th>التاريخ</th>
                <th>اجراء</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($deposet_dissmisal as $u)
            <tr>
                <td>{{$u->user->name}}</td>
                <td>{{$u->ammount}}</td>
                <td>{{$u->info}}</td>
                <td>{{$u->created_at}}</td>
                <td><a href="{{route('reports.admin.edit_repo_dissmisal_form', $u->id)}}" class="btn btn-warning">تعديل <i class="fa-solid fa-pen-to-square"></i></a></td>
            </tr>
            @endforeach
            </tbody>
        </table>
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