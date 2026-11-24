@extends('layouts.admin')

@section('title', 'Tambah Promo')

@section('content')
<form method="POST" action="{{ route('admin.promotions.store') }}" enctype="multipart/form-data">
    @csrf
    @include('admin.promotions._form')
</form>
@endsection
