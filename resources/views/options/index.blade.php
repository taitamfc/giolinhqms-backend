@extends('layouts.master')
@section('content')
<div class="col-lg-12">
    @if (session('success'))
    <div class="alert alert-success" role="alert">
        {{ session('success') }}
    </div>
    @endif
    @if (session('error'))
    <div class="alert alert-danger" role="alert">
        {{ session('error') }}
    </div>
    @endif
    <!-- .card -->
    @foreach ($all_options as $group_name => $options)
    <div class="card card-fluid">
        <h6 class="card-header"> {{ $group_labels[$group_name] }} </h6>
        <div class="card-body">
            <form method="post" action="{{ route('options.update') }}">
                @csrf

                @foreach ($options as $option)
                <div class="form-row">
                    <label class="col-md-3">{{$option->option_label}}</label>
                    <div class="col-md-9 mb-3">
                        <input type="text" class="form-control" name="{{$option->option_name}}"
                            value="{{$option->option_value}}">
                    </div>
                </div>
                @endforeach
                <hr>
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary ml-auto">Cập Nhật</button>
                </div>
            </form>
        </div>
    </div>
    @endforeach
</div>
@endsection