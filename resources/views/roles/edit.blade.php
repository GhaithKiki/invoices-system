@extends('layouts.master')

@section('css')
<!-- Internal Font Awesome -->
<link href="{{ URL::asset('assets/plugins/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
<!-- Internal treeview -->
<link href="{{ URL::asset('assets/plugins/treeview/treeview-rtl.css') }}" rel="stylesheet" type="text/css" />
<style>
    /* Add your custom CSS styles here */
</style>
@endsection

@section('title')
تعديل الصلاحيات - مورا سوفت للإدارة القانونية
@stop

@section('page-header')
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">الصلاحيات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تعديل الصلاحيات</span>
        </div>
    </div>
</div>
@endsection

@section('content')
@if ($errors->any())
<div class="alert alert-danger">
    <button aria-label="Close" class="close" data-dismiss="alert" type="button">
        <span aria-hidden="true">&times;</span>
    </button>
    <strong>خطأ</strong>
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <form method="POST" action="{{ route('roles.update', $role->id) }}">
                @csrf
                @method('PATCH')

                <div class="form-group">
                    <label for="name">اسم الصلاحية</label>
                    <input type="text" id="name" name="name" class="form-control" placeholder="أدخل اسم الصلاحية">
                </div>

                <div class="form-group">
                    <ul id="treeview1">
                        <li><a href="#">الصلاحيات</a>
                            <ul>
                                @foreach($permissions as $value)
                                <li>
                                    <label>
                                        <input type="checkbox" name="permissions[]" value="{{ $value->id }}" class="name" {{ in_array($value->id, $rolePermissions) ? 'checked' : '' }}>
                                        {{ $value->name }}
                                    </label>
                                </li>
                                @endforeach
                            </ul>
                        </li>
                    </ul>
                </div>

                <div class="form-group text-center">
                    <button type="submit" class="btn btn-primary">تحديث</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
<!-- Internal Treeview js -->
<script src="{{ URL::asset('assets/plugins/treeview/treeview.js') }}"></script>
@endsection