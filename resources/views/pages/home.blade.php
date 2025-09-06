<x-layouts.public-app>
    @foreach ($posts as $post)
        <article class="bg-white rounded-lg shadow-sm border p-6 hover:shadow-md transition-shadow mb-8">
            <div class="flex items-center text-sm text-gray-500 mb-3">
                <time datetime="{{ $post->created_at->format('Y-m-d') }}">{{ $post->created_at->format('F d,Y') }}</time>
                <span class="mx-2">•</span>
                <span>5 min read</span>
            </div>
            <h2 class="text-2xl font-bold text-gray-900 mb-3">
                <a href="{{ route('posts.show', $post->id) }}" class="hover:text-blue-600">{{ $post->title }}
                </a>
            </h2>
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-2">
                    @foreach ($post->tags as $tag)
                        <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded">{{ $tag->name }}</span>
                    @endforeach
                </div>
                <a href="{{ route('posts.show', $post->id) }}" class="text-blue-600 hover:text-blue-800 font-medium">
                    Read more →
                </a>
            </div>
        </article>
    @endforeach


    <!-- Add as many articles as you want by duplicating above block -->

    <div class="mt-8">
        <a href="{{ route('posts.index') }}" class="text-blue-600 hover:text-blue-800 font-medium">
            View all posts →
        </a>
    </div>
</x-layouts.public-app>
