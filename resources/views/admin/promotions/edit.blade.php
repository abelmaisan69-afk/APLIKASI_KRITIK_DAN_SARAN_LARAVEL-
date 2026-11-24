@extends('layouts.admin')

@section('title', 'Edit Promo')

@section('content')
<form method="POST" action="{{ route('admin.promotions.update', $promotion) }}" enctype="multipart/form-data">
    @csrf @method('PUT')
    @include('admin.promotions._form')
</form>
@endsection
