@extends('layouts.public')

@section('title', $page->title . ' - Dinas Kesehatan Kota Kediri')

@section('content')
    <div class="container mx-auto px-4 py-8 max-w-4xl">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="p-6 md:p-8">
                {{-- Title --}}
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6 leading-tight">
                    {{ $page->title }}
                </h1>

                {{-- Content --}}
                <div class="prose prose-lg max-w-none text-gray-700">
                    {!! $page->content !!}
                </div>
                
                {{-- Back Button --}}
                <div class="mt-8 pt-6 border-t border-gray-100">
                    <a href="{{ url('/') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
