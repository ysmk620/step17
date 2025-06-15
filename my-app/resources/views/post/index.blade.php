<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            一覧表示
        </h2>
    </x-slot>
    <div class="max-w-7xl mx-auto px-4">
        @if(session('message'))
        <div class="text-red-600 font-bold">
            {{session('message')}}
        </div>
        @endif
        @foreach($posts as $post)
        <div class="mt-4 p-8 bg-white w-full rounded-2xl">
            <h1 class="p-4 text-lg font-semibold">
                件名：
                <a href="{{route('post.show',$post)}}" class="text-blue-600">
                    {{$post->title}}
                </a>
            </h1>
            <hr class="w-full">
            <p class="mt-4 p-4">
                {{$post->body}}
            </p>
            <div class="p-4 text-sm font-semibold">
                <p>
                    {{$post->created_at}} / {{$post->user->name}}
                </p>
            </div>
            <div class="p-4">
                <form method="POST" action="{{ route('post.like', $post) }}">
                    @csrf
                    @php
                    $liked = $post->isLikedBy(auth()->user());
                    @endphp
                    <button type="submit" class="{{ $liked ? 'text-red-600 font-bold' : 'text-blue-600' }} hover:underline">
                        {{ $liked ? 'いいね済み' : 'いいね' }}
                    </button>
                </form>
                <p class="text-sm text-gray-600">
                    いいね数：{{ $post->likes_count }}
                </p>
            </div>
        </div>
        @endforeach
        <div class="mb-4">
            {{$posts->links()}}
        </div>
    </div>
</x-app-layout>