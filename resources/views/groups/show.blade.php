@extends('layouts.master')
@section('content')
    <div class="page-header">
        <h3 class="page-title">Cấp quyền cho: {{ $group->name }}</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
                <li class="breadcrumb-item active" aria-current="page"> Cấp quyền </li>
            </ol>
        </nav>
    </div>
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <form method="post" action="{{ route('groups.saveRoles', $group->id) }}">
                @csrf
                @method('PUT')
                <div class="card">
                    <div class="card-header">
                        <label class="btn btn-info">
                            <input id='checkAll' type="checkbox">
                            Chọn tất cả
                        </label>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach ($all_roles as $group_name => $roles)
                                <div class="col-lg-6 mb-3">
                                    <ul class="list-group">
                                        <li class="list-group-item active text-uppercase">
                                            <input type="checkbox" class="checker" value="{{ $group_name }}">
                                            <span class="ml-2">{{ trans($group_name) }}</span>
                                        </li>
                                        @foreach ($roles as $key => $role)
                                            <?php
                                            if ($key < 0) {
                                                continue;
                                            }
                                            ?>
                                            <li class="list-group-item">
                                                <input type="checkbox" @checked(in_array($role->id, $active_roles)) name="roles[]"
                                                    class="ml-0 form-check-input check-role {{ $role->group_name }}"
                                                    value="{{ $role->id }}">

                                                <span class="ml-4">
                                                    {{ trans($role->name) }}
                                                </span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endforeach
                        </div>
                        <div class="form-actions">
                            <a href="{{ route('groups.index') }}" class="btn btn-secondary float-right">Hủy</a>
                            <input type="submit" class="btn btn-info ml-auto" value="Lưu">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script>
        $('#checkAll').click(function() {
            console.log(this.checked)
            $('.check-role').prop('checked', this.checked);
        });
        document.querySelectorAll('.checker').forEach(function(el) {
            el.onclick = function() {
                $('.' + el.value).prop('checked', this.checked);
            }
        })
    </script>
@endsection
