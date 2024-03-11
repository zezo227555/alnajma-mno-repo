@extends('_layouts.default')

@section('page_name')
    المستخدمين
@endsection

@section('page_content')
    <div class="card">
        <div class="card-header">
        <h3 class="card-title">بيانات الموظف</h3>
        </div>
        <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                <div class="text-center">
                    <img class="profile-user-img img-fluid img-circle" src="{{asset('images/user_photos/')}}/{{$user->photo}}" alt="User profile picture">
                </div>

                <h3 class="profile-username text-center">{{$user->name}}</h3>

                <p class="text-muted text-center">{{$user->role}}</p>

                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                    <b>تاريخ التسجيل</b> <a class="float-right">{{ $user->created_at }}</a>
                    </li>
                    <li class="list-group-item">
                    <b>تاريخ اخر تعديل</b> <a class="float-right">{{$user->updated_at}}</a>
                    </li>
                    <li class="list-group-item">
                    <b>اسم المستخدم</b> <a class="float-right">{{ $user->username }}</a>
                    </li>
                </ul>

            <a href="{{ route('user.index') }}" class="btn btn-primary btn-block"><b>رجوع الى القائمة</b></a>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
@endsection