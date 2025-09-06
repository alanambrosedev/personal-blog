<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div
                class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden mb-6">
                <form action="{{ route('admin.posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="p-6">
                        <div class="space-y-6">
                            <h3
                                class="text-lg font-medium text-gray-800 dark:text-gray-200 border-b border-gray-200 dark:border-gray-700 pb-2">
                                Edit Post</h3>

                            <div>
                                <x-input-label for="title" value="Title" />
                                <x-text-input id="title" name="title" placeholder="Enter title" class="w-full"
                                    value="{{ $post->title }}" />
                                <x-input-error :messages="$errors->get('title')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="post" value="Content" />
                                <x-textarea-input id="post" name="post" placeholder="Enter content"
                                    class="w-full">{{ $post->post }}</x-textarea-input>
                                <x-input-error :messages="$errors->get('post')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="category" value="Category" />
                                <x-select-input id="category" name="category" placeholder="Enter category"
                                    :options="$categories" class="w-full" value="{{ $post->category_id }}" />
                                <x-input-error :messages="$errors->get('category')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="image" value="Image" />
                                <x-file-input id="image" name="image" type="file" placeholder="Enter image"
                                    class="w-full" value="{{ $post->image }}" />
                                <x-input-error :messages="$errors->get('image')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="tags" value="Tags" />
                                <x-text-input id="tags" name="tags" placeholder="Enter tags" class="w-full"
                                    value="{{ $post->tags->implode('name', ', ') }}" />
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    Separate tags with commas
                                </p>
                                <x-input-error :messages="$errors->get('tags')" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="p-6 border-t border-gray-200 dark:border-gray-700">
                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('admin.posts.index') }}"
                                class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Cancel
                            </a>
                            <x-button type="primary" tag="button" buttonType="submit">
                                Update Post
                            </x-button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
