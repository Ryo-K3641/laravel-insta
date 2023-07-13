@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')

    {{-- @include('users.profile.show')
        <form action="{{ route('update', $user->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <div class="col-8 mt-2 mb-3">
                <label for="name" class="form-label text-muted">User name</label>
                <input type="text" name="name" id="name" class="form-control" value = "{{ old('name', $user->name) }}">

                @error('name')
                <p class="text-danger small">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="btn btn-secondary px-5">✓Update</button>
        </form> --}}

        <div class="row justify-content-center">
            <div class="col-8">
                <form action="{{route('profile.update')}}" method="post" class="bg-white shadow rounded-3 p-5" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <h2 class="h3 fw-light text-muted">Update Profile</h2>
                    <div class="row mb-2">
                        <div class="col-4">
                            @if ($user->avatar)
                                <img src="{{$user->avatar}}" alt="{{$user->avatar}}" class="img-thumbnail rounded-circle d-block mx-auto avatar-lg">
                            @else
                                <i class="fa-solid fa-circle-user text-secondary d-block text-center icon-lg"></i>
                            @endif
                        </div>
                        <div class="col-auto align-self-end">
                            <input type="file" name="avatar" id="avatar" class="form-control form-control-sm mt-1" aria-labelledby="avatar-info">

                            <div class="form-text" id="avatar-info">
                                Acceptable format is jpg,jpeg, png and giff only.<br>
                                Maximum file size: 1048kb
                            </div>
                            {{-- Error Message Area --}}
                        </div>
                    </div>
                    <div class="row mb-2">
                        <label for="name" class="form-label fw-bold">Name</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{old('name', $user->name)}}" autofocus>
                        {{-- Error Message Area --}}
                    </div>
                    <div class="row mb-2">
                        <label for="email" class="form-label fw-bold">Email address</label>
                        <input type="email" name="email" id="email" class="form-control" value="{{old('email', $user->email)}}"> 
                        {{-- Error Message Area --}}
                    </div>
                    <div class="row mb-2">
                        <label for="intro" class="form-label fw-bold">Introduction</label>
                        <textarea name="introduction" id="introduction" rows="5" class="form-control" placeholder="Describe yourself">{{old('introduction', $user->introduction)}}</textarea>
                        {{-- Error Message Area --}}
                    </div>
                    <button type="submit" class="btn btn-warning px-5">Save</button>
                </form>
            </div>
        </div>
@endsection