<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div
                class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden mb-6">

                <!-- Header -->
                <div
                    class="p-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-green-400 via-blue-500 to-purple-600 flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-white">Posts</h3>
                    <x-button type="primary" tag="a" href="{{ route('admin.posts.create') }}"
                        class="bg-green-600 hover:bg-green-700 text-white shadow-md">
                        Add Post
                    </x-button>
                </div>

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gradient-to-r from-purple-500 to-indigo-600">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-sm font-bold text-white uppercase tracking-wider w-2/6">
                                    Title</th>
                                <th
                                    class="px-6 py-3 text-left text-sm font-bold text-white uppercase tracking-wider w-1/6">
                                    Author</th>
                                <th
                                    class="px-6 py-3 text-left text-sm font-bold text-white uppercase tracking-wider w-1/6">
                                    Category</th>
                                <th
                                    class="px-6 py-3 text-left text-sm font-bold text-white uppercase tracking-wider w-2/6">
                                    Tags</th>
                                <th
                                    class="px-6 py-3 text-left text-sm font-bold text-white uppercase tracking-wider w-1/6">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach ($posts as $post)
                                <tr
                                    class="{{ $loop->iteration % 2 == 0 ? 'bg-gray-50 dark:bg-gray-900' : 'bg-white dark:bg-gray-800' }} hover:bg-yellow-100 dark:hover:bg-gray-700 transition">
                                    <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">{{ $post->title }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">{{ $post->user->name }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">
                                        {{ $post->category->name }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">
                                        <div class="flex flex-wrap gap-2">
                                            @foreach ($post->tags as $tag)
                                                <span
                                                    class="bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-md px-2 py-1 text-xs">
                                                    {{ $tag->name }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex justify-end space-x-2">
                                            <a href="{{ route('admin.posts.edit', $post->id) }}"
                                                class="inline-flex items-center px-3 py-1 text-sm font-medium text-white bg-blue-500 rounded-lg hover:bg-blue-600 transition">
                                                Edit
                                            </a>
                                            <form action="{{ route('admin.posts.destroy', $post->id) }}" method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this post?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="inline-flex items-center px-3 py-1 text-sm font-medium text-white bg-red-500 rounded-lg hover:bg-red-600 transition">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Pagination -->
                    <div class="mt-4 px-6 py-4">
                        {{ $posts->links() }}
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
<x-alert />
