{{-- Clickable image --}}
<div class="container p-0">
    <a href="{{ route('post.show', $post->id) }}">
        <img src="{{ $post->image }}" alt="post id {{ $post->id }}" class="w-100">
    </a>
</div>
<div class="card-body">
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
    <p class="text-uppercase text-muted xsmall">{{ date('M j, Y', strtotime($post->created_at)) }}</p>
    {{--
        date(format, unix time)
        date('M j, Y', strtotime('2023-06-01 12:09:11'))
        date('M j, Y', 1685623935)
        Jun 06, 2023
    --}}
    @include('users.posts.contents.comments')
</div>
