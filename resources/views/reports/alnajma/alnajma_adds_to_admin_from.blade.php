@extends('_layouts.default')

@section('page_name')
    المشرفين
@endsection

@section('page_content')

<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">الاضافات للمشرف</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    <form role="form" action="{{route('reports.alnajma_adds_to_admin')}}" method="POST" enctype="multipart/form-data">
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
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label>المشرف</label><br>
                    @error('repo')
                        <label class="text-danger">{{ $message }}</label><br>
                    @enderror
                    <select class="js-example-basic-single" name="admin">
                        @foreach ($admin as $r)
                            <option value="{{ $r->id }}">{{ $r->name }}</option>
                        @endforeach
                    </select>
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

    @error('big_ammount')
<script>
    function massge() {
        Swal.fire({
        position: 'top-end',
        icon: 'error',
        title: "{{ $errors->first('big_ammount') }}",
        showConfirmButton: false,
        timer: 1500
    })
}
window.onload = massge;
</script>
@enderror
@endsection