@extends('_layouts.default')

@section('page_name')
    قائمة المستخدمين
@endsection


@section('page_content')
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
    <div class="card co">
        <div class="card-header">
        <h3 class="card-title">الموظفين <i class="fa-solid fa-users"></i></h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
        <table class="table table-bordered datatable">
            <thead>                  
            <tr>
                <th style="width: 10px">#</th>
                <th class="text-center">الاسم</th>
                <th class="text-center">رقم الهاتف</th>
                <th class="text-center">صورة شخصية</th>
                <th class="text-center">مدين</th>
                <th class="text-center">التوريد</th>
                <th class="text-center">الرصيد</th>
                <th class="text-center">اجراء</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($users as $u)
            <tr>
                <td class="text-center">{{$u->id}}</td>
                <td class="text-center">{{$u->name}}</td>
                <td class="text-center">{{$u->phone}}</td>
                <td class="text-center"><img src="{{asset('images/user_photos/')}}/{{ $u->photo }}" width="50" height="50" class="img-circle elevation-2" alt="User Image"></td>
                <td class="text-center">{{$u->balance}}</td>
                @if ($u->role == '1')
                <td class="text-center">{{$u->store_balance}}</td>
                <td class="text-center">{{$u->portal_balance}}</td>
                @else
                <td class="text-center"><i class="fa-regular fa-note-sticky"></i></td>
                <td class="text-center"><i class="fa-regular fa-note-sticky"></i></td>
                @endif
                
                <td class="text-center">
                    <a href="{{ route('user.edit', $u->id) }}" class="btn mr-1 btn-warning">تعديل <i class="fa-solid fa-pen-to-square"></i></a>
                    @if (auth()->user()->role == 3 && request()->is('user'))
                        <a href="{{ route('user.user_deposet_form', $u->id) }}" class="btn mr-1 btn-success">ايصال قبض <i class="fa-solid fa-money-bill"></i></a>
                        <a href="{{ route('reports.get_repo_stores_balance', $u->id) }}" class="btn mr-1 btn-primary">ديون المحلات <i class="fa-regular fa-address-book"></i></a>
                    @endif
                    @if ((auth()->user()->role == 3 && request()->is('admins')) || auth()->user()->role == 2 && request()->is('user'))
                        <a href="{{ route('user.user_dissmisal_form', $u->id) }}" class="btn mr-1 btn-danger">ايصال صرف <i class="fa-solid fa-money-bill-transfer"></i> </a>
                    @endif
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
        </div>
        <!-- /.card-body -->
        
    </div>

@endsection

@section('my_scripts')

@error('not_found')
<script>
    function massge() {
        Swal.fire({
            position: 'top-end',
            icon: 'error',
            title: "لا يوجد محلات لدى المندوب",
            showConfirmButton: false,
            timer: 2000
        })
    }
    window.onload = massge;
</script>
@enderror

<script>
    $('button[type="submit"]').on('click', function(e) {
e.preventDefault();

Swal.fire({
    title: 'هل انت متأكد من أنك ترغب في حذف المستخدم ؟',
    text: 'لا يمكن التراجع عن حذف المستخدم',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#3085d6',
    confirmButtonText: 'نعم قم بالحذف',
    cancelButtonText: 'الغاء'
}).then((result) => {
    if (result.isConfirmed) {
        $(this).closest('form').submit();
    }
});
});
</script>

@endsection