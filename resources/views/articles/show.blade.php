@extends('layouts.app')

@section('title', $article->title)

@section('content')
    <h1 class="text-3xl font-bold mb-6">{{ $article->title }}</h1>

    <!-- Display the Featured Image -->
    @if($article->featured_image)
        <img src="{{ asset('storage/' . $article->featured_image) }}" alt="{{ $article->title }}" class="mb-6 w-full h-auto object-cover">
    @endif

    <!-- Article Metadata: Views -->
    <div class="text-sm text-gray-500 mb-4">
        <span>{{ $article->views }} {{ Str::plural('view', $article->views) }}</span>
    </div>

    <!-- Article Content -->
    <div class="prose">
        {!! nl2br(e($article->content)) !!}
    </div>

 
@endsection
