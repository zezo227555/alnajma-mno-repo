@extends('_layouts.default')

@section('page_name')
كشف حساب المحل
@endsection

@section('page_info')
<span class="btn btn-info">رصيد المحل {{$store->balance}}</span>
@endsection
@if (auth()->user()->role == 1)
    @section('page_action')
        <a href="{{route('reports.store_account_form', auth()->user()->id)}}" class="btn btn-secondary btn-block">رجوع للسابق</a>
    @endsection
@endif

@section('page_content')
    
    <div class="card">
        <div class="card-header">
        <h3 class="card-title">كشف حساب للمحل <span class="btn btn-info">{{$store->name}}</span></h3>
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
                @if (auth()->user()->role == 1)
                    <th>اجراء</th>
                @endif
            </tr>
            </thead>
            <tbody>
                @foreach ($receipt as $u)
                    <tr>
                        <td>{{$u->id}}</td>
                        <td>{{$u->ammount}}</td>
                        @if ($u->type == 0)
                            <td><span class="btn btn-danger">صرف</span></td>
                        @else
                            <td><span class="btn btn-success">قبض</span></td>
                        @endif
                        <td>{{$u->info}}</td>
                        <td>{{$u->created_at}}</td>
                        @if (auth()->user()->role == 1)
                            <td><a href="{{route('reports.repo.edit_store_dissmisal_deposet_form', $u->id)}}" class="btn btn-warning">تعديل</a></td>
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