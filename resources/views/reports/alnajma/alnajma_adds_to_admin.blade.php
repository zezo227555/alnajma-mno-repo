@extends('_layouts.default')

@section('page_name')
الاضافات للمشرف
@endsection

@section('page_action')
    <a href="{{route('reports.alnajma_adds_to_admin_form', auth()->user()->id)}}" class="btn btn-secondary btn-block">رجوع للسابق</a>
@endsection

@section('page_content')
    
    <div class="card">
        <div class="card-header">
        <h3 class="card-title">تقرير الشحنات للمشرف</h3>
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
                <th>اجراء</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($deposet as $u)
            <tr>
                <td>{{$u->id}}</td>
                <td>{{$u->ammount}}</td>
                <td>{{$u->info}}</td>
                <td>{{$u->created_at}}</td>
                <td><a href="{{route('reports.alnajma.edit_admin_dissmisal_form', $u->id)}}" class="btn btn-warning">تعديل</a></td>
            </tr>
            @endforeach
            </tbody>
        </table>
        </div>
        <!-- /.card-body -->
        >
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