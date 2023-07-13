@extends('layouts.app')

@section('title', 'Show Post')

@section('content')

    {{-- <style>
        .col-4{
            overflow-y: scroll;
        }
        .card-body{
            position: absolute;
            top:65px;
        }
    </style> --}}

    <div class="row border shadow">
        <div class="col p-0 border-end">
            <img src="{{ $post->image }}" alt="post id {{ $post->id }}" class="w-100">
        </div>
        <div class="col-4 px-0 bg-white">
            <div class="card border-0">
                {{-- card-header bg-white py-3 --}}
                <div class="card-header bg-white py-3">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <a href="{{route('profile.show', $post->user->id)}}">
                                @if ($post->user->avatar)
                                    <img src="{{$post->user->avatar}}" alt="{{$post->user->avatar}}" class="rounded-circle avatar-sm">
                                @else
                                    <i class="fa-solid fa-circle-user text-secondary icon-sm"></i>
                                @endif
                            </a>
                        </div>
                        <div class="col ps-0">
                            <a href="{{ route('profile.show', ['id' => $post->user->id]) }}" class="text-decoration-none text-dark">{{$post->user->name}}</a>
                        </div>
                        <div class="col-auto">
                            @if (Auth::user()->id  === $post->user->id)
                                <div class="dropdown">
                                    <button class="btn btn-sm shadow-none" data-bs-toggle="dropdown">
                                        <i class="fa-solid fa-ellipsis"></i>
                                    </button>

                                    <div class="dropdown-menu">
                                        <a href="{{ route('post.edit', $post->id) }}" class="dropdown-item">
                                            <i class="fa-regular fa-pen-to-square"></i> Edit
                                        </a>
                                        <button class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#delete-post-{{ $post->id }}">
                                            <i class="fa-regular fa-trash-can"></i> Delete
                                        </button>
                                    </div>
                                    @include('users.posts.contents.modals.delete')
                                </div>
                            @else
                                <form action="#" method="post">
                                    @csrf
                                    <button type="submit" class="border-0 bg-transparent p-0 text-primary">Follow</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
                {{-- card-body w-100 --}}
                <div class="card-body w-100">
                    {{-- heart button + no. of likes + categories --}}
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <form action="#" method="post">
                                @csrf
                                <button type="submit" class="btn btn-sm p-0"><i class="fa-regular fa-heart"></i></button>
                            </form>
                        </div>
                        <div class="col-auto px-0">
                            <span>3</span>
                        </div>
                        <div class="col text-end">
                            @foreach ($post->categoryPost as $category_post)
                                <div class="badge bg-secondary bg-opacity-50">
                                    {{ $category_post->category->name }}
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- owner + description --}}
                    <a href="{{route('profile.show', $post->user->id)}}" class="text-decoration-none text-dark fw-bold">{{ $post->user->name }}</a>
                    &nbsp;
                    <p class="d-inline fw-light">{{ $post->description }}</p>
                    <p class="text-uppercase text-muted xsmall">{{ date('M d, Y', strtotime($post->created_at)) }}</p>
                </div>
            </div>

            <div class="p-2" style="height: 200px; overflow-y:scroll;">
                {{-- Show All Comments Here --}}
                @if ($post->comments->isNotEmpty())
                    <hr>
                    <ul class="list-group">
                        @foreach ( $post->comments as $comment )
                            <li class="list-group-item border-0 p-0">
                                <a href="#" class="text-decoration-none text-dark fw-bold">{{$comment->user->name}}</a>
                                &nbsp;
                                <p class="d-inline fw-light">{{$comment->body}}</p>

                                <form action="{{route('comment.destroy', $comment->id)}}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <span class="text-uppercase text-muted xsmall">{{date('M d, Y', strtotime($comment->created_at))}}</span>

                                    {{-- Create delete button. If the auth user is the OWNER OF THE COMMENT, show the delete button --}}
                                    @if (Auth::user()->id === $comment->user->id)
                                        &middot;
                                        <button type="submit" class="border-0 bg-transparent text-danger p-0">Delete</button>
                                    @endif

                                </form>
                            </li>
                        @endforeach
                    </ul>
                @endif

                {{-- Comment Form --}}
                <form action="{{route('comment.store', $post->id)}}" method="post">
                    @csrf
                    <div class="input-group">
                        <textarea name="comment_body{{$post->id}}" class="form-control form-control-sm" placeholder="Add comment...">{{old('comment_body' . $post->id)}}</textarea>
                        @error('comment_body' . $post->id)
                            <p class="text-danger small">{{$message}}</p>
                        @enderror
                        <button type="submit" class="btn btn-outline-secondary btn-sm">Post</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
