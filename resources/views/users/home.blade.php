@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <div class="row gx-5">
        <div class="col-8 bg-light">
            @forelse ($all_posts as $post)
                <div class="card mb-4">
                    @include('users.posts.contents.title')
                    @include('users.posts.contents.body')
                </div>
            @empty
                {{-- This page will only show/display to new registered user  --}}
                <div class="text-center">
                    <h2>Share Photos</h2>
                    <p class="text-muted">When you share photos, they'll appear on your profile.</p>
                    <a href="{{route('post.create')}}" class="text-decoration-none">Share Your First Photo / Create Post</a>
                </div>
            @endforelse
        </div>
        <div class="col-4 bg-secondary">
            {{-- Profile Overview --}}
            <div class="row align-items-center mb-5 bg-white shadow-sm rounded-3 py-3">
                <div class="col-auto">
                    <a href="{{route('profile.show', Auth::user()->id)}}">
                        @if (Auth::user()->avatar)
                            <img src="{{Auth::user()->avatar}}" alt="{{Auth::user()->name}}" class="img-thumbnail rounded-circle d-block mx-auto avatar-md">
                        @else
                            <i class="fa-solid fa-circle-user d-block text-center icon-md"></i>
                        @endif  
                    </a>
                </div>
                <div class="col ps-0">
                    <a href="{{route('profile.show', Auth::user()->id)}}" class="text-decoration-none fw-bold">{{Auth::user()->name}}</a>
                    <p class="text-muted mb-0">{{Auth::user()->email}}</p>
                </div>
            </div>

            {{-- Suggestions Area --}}
            Suggestions
        </div>
    </div>
@endsection
