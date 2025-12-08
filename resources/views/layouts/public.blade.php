@extends('layouts.base')

@section('layout-content')
    @include('components.navbar')

    <div class="min-h-screen h-auto pt-20 md:pt-16">
        @yield('content')
    </div>

    @include('components.footer')
@endsection