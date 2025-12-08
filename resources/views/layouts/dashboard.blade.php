@extends('layouts.base')

@section('layout-content')
    @include('components.topbar')
    @include('components.sidebar')

    <div class="p-4 md:ml-64 h-auto mt-16">
        <h1 class="text-2xl font-bold text-center mb-6">@yield('heading')</h1>
        @yield('content')
    </div>
@endsection