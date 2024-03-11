@extends('_layouts.default')

@section('page_name')
    المستخدمين
@endsection

@section('page_content')

<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">كشف حساب النجمة</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    <form role="form" action="{{route('user.alnajma_deposet_search')}}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="card-body">
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label>من تاريخ</label><br>
                    @error('date_from')
                        <label class="text-danger">{{ $message }}</label><br>
                    @enderror
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="far fa-calendar-alt"></i>
                            </span>
                        </div>
                        <input name="date_from" type="datetime-local" class="form-control float-right" id="reservation">
                    </div>
                    <!-- /.input group -->
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>الى تاريخ</label><br>
                    @error('date_to')
                        <label class="text-danger">{{ $message }}</label><br>
                    @enderror
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="far fa-calendar-alt"></i>
                            </span>
                        </div>
                        <input name="date_to" type="datetime-local" class="form-control float-right" id="reservation">
                    </div>
                    <!-- /.input group -->
                </div>
            </div>
        </div>
    <!-- /.card-body -->

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