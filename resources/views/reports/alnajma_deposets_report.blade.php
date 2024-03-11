@extends('_layouts.default')

@section('page_name')
الشحنات و اذونات الصرف
@endsection

@section('page_action')
    <a href="{{route('user.all_accounters', auth()->user()->id)}}" class="btn btn-secondary btn-block">رجوع للسابق</a>
@endsection

@section('page_content')
    
    <div class="card co">
        <div class="card-header">
        <h3 class="card-title">تقرير الشحنات و الايداعات</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
        <table class="table table-bordered text-center datatable">
            <thead>
            <tr>
                <th>القيمة</th>
                <th>النوع</th>
                <th>التاريخ</th>
                <th>مرفقات الايداع</th>
                <th>اجراء</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($deposet_dissmisal as $u)
            <tr>
                <td>{{$u->ammount}}</td>
                @if ($u->type == 1)
                    <td><span class="btn btn-success w-75">ايداع <i class="fa-solid fa-money-bill-trend-up"></i></span></td>
                @elseif(($u->user_id != $u->repo_id) && $u->type == 0)
                    <td><span class="btn btn-danger w-75">دين للمشرف <i class="fa-solid fa-money-bill-transfer"></i></span></td>
                @else
                    <td><span class="btn btn-danger w-75">صرف نقدي</span></td>
                @endif
                <td>{{$u->created_at}}</td>
                @if (isset($u->file))
                    <td><a href="{{asset('deposet_files/')}}/{{ $u->file }}" class="btn btn-info w-75">ملف الايداع <i class="fa-solid fa-file"></i></a></td>
                @else
                    <td><a href="#" class="btn btn-warning w-75">لا يوجد مرفق <i class="fa-solid fa-file-excel"></i></a></td>
                @endif
                <td><a href="{{route('reports.alnajma.edit_alnajma_adds_form', $u->id)}}" class="btn btn-warning w-75">تعديل <i class="fa-solid fa-pen-to-square"></i></a></td>
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