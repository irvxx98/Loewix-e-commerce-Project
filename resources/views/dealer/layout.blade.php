@extends('layouts.app')

@section('content')
<div class="container my-4">
    <div class="row g-4">
        <div class="col-lg-3">
            @include('dealer.sidebar')
        </div>
        <div class="col-lg-9">
            @yield('dealer_content')
        </div>
    </div>
</div>
@endsection