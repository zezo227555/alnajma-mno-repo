@extends('_layouts.default')

@section('page_name')
الشحنات و الايداعات
@endsection

@section('page_action')
    <a href="{{route('user.repos_account', auth()->user()->id)}}" class="btn btn-secondary btn-block">رجوع للسابق</a>
@endsection

@section('page_content')
    
    <div class="card co">
        <div class="card-header">
        <h3 class="card-title">تقرير الشحنات و الايداعات من المالية</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
        <table class="table table-bordered datatable">
            <thead>                  
            <tr>
                <th style="width: 10px">#</th>
                <th>القيمة</th>
                <th>النوع</th>
                <th>التاريخ</th>
                <th>مرفقات الايداع</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($deposet_dissmisal as $u)
            <tr>
                <td>{{$u->id}}</td>
                <td>{{$u->ammount}}</td>
                <td>{{$u->created_at}}</td>
                @if ($u->type == 1)
                    <td><button class="btn btn-success">ايداع</button></td>
                @else
                    <td><button class="btn btn-danger">دين</button></td>
                @endif
                @if (isset($u->file))
                    <td><a href="{{asset('deposet_files/repo_files')}}/{{ $u->file }}" class="btn btn-info">ملف الايداع</a></td>
                @else
                    <td><a href="#" class="btn btn-warning">لا يوجد مرفق</a></td>
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