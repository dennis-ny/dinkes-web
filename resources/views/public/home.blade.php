@extends('layouts.public')

@section('title', 'Beranda - Dinas Kesehatan Kota Kediri')

@section('content')
    <div class="min-h-screen">
        <x-jumbotron :sliders="$sliders" />
        
        <x-announcement-banner :announcements="$announcements" />

        <x-home-content 
            :latestNews="$latestNews" 
            :popularNews="$popularNews" 
            :latestArticles="$latestArticles" 
            :popularArticles="$popularArticles" 
        />
        
        <x-contact-section />
    </div>
@endsection