@extends('layouts.base')

@section('layout-content')
    @include('components.navbar')

    <div class="min-h-screen h-auto pt-18 md:pt-14">
        @yield('content')
    </div>

    @include('components.footer')
@endsection