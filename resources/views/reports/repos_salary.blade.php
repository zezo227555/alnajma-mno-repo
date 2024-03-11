@extends('_layouts.default')

@section('page_name')
    المندوبين
@endsection

@section('page_content')

<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">مرتبات المندوبين <i class="fa-solid fa-money-bill"></i></h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    <form role="form" action="{{route('reports.repos_salary')}}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="card-body">
        <div class="form-group">
            <label>المندوب</label><br>
            @error('repo')
                <label class="text-danger">{{ $message }}</label><br>
            @enderror
            <select class="js-example-basic-single" name="repo">
                @foreach ($repo as $r)
                    <option value="{{ $r->id }}">{{ $r->name }}</option>
                @endforeach
            </select>
        </div>
            <div class="form-group">
                <label>مرتب شهر</label><br>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="far fa-calendar-alt"></i>
                        </span>
                    </div>
                    <input name="month" type="month" class="form-control float-right" id="reservation">
                </div>
                <!-- /.input group -->
            </div>
    <div class="card-footer mt-5">
        <button type="submit" class="btn btn-block btn-primary">بحث <i class="fa-solid fa-magnifying-glass"></i></button>
    </div>
    </form>
</div>
</div>

@endsection

@section('my_scripts')
    @if (Session::has('message'))
    <script>
        function massge() {
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: "{{ session('message') }}",
                showConfirmButton: false,
                timer: 1500
            })
        }
        window.onload = massge;
    </script>
    @endif
@endsection