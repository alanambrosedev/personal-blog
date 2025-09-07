<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div
                class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700 overflow-hidden mb-6">
                <!-- Header -->
                <div
                    class="p-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-green-400 via-blue-500 to-purple-600 flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-white">Tags</h3> <x-button type="primary" tag="a"
                        href="{{ route('admin.tags.create') }}"
                        class="bg-green-600 hover:bg-green-700 text-white shadow-md"> Add Tag </x-button>
                </div> <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gradient-to-r from-purple-500 to-indigo-600">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-sm font-bold text-white uppercase tracking-wider w-2/6">
                                    Name </th>
                                <th
                                    class="px-6 py-3 text-left text-sm font-bold text-white uppercase tracking-wider w-2/6">
                                    Created At </th>
                                <th
                                    class="px-6 py-3 text-left text-sm font-bold text-white uppercase tracking-wider w-2/6">
                                    Updated At </th>
                                <th
                                    class="px-6 py-3 text-right text-sm font-bold text-white uppercase tracking-wider w-1/6">
                                    Actions </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach ($tags as $tag)
                                <tr
                                    class="{{ $loop->iteration ? 'bg-gray-50 dark:bg-gray-900' : 'bg-white dark:bg-gray-800' }} hover:bg-yellow-100 dark:hover:bg-gray-700 transition">
                                    <!-- Name -->
                                    <td class="px-6 py-4 text-lg font-bold text-gray-900 dark:text-white">
                                        {{ $tag->name }} </td> <!-- Created At -->
                                    <td class="px-6 py-4 text-sm"> <span
                                            class="inline-flex items-center px-3 py-1 rounded-full bg-blue-100 text-blue-800 font-semibold">
                                            {{ $tag->created_at->format('M d, Y') }} </span> </td>
                                    <!-- Updated At -->
                                    <td class="px-6 py-4 text-sm"> <span
                                            class="inline-flex items-center px-3 py-1 rounded-full bg-blue-100 text-blue-800 font-semibold">
                                            {{ $tag->updated_at->format('M d, Y') }} </span> </td> <!-- Actions -->
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex justify-end space-x-2"> <!-- Edit --> <a
                                                href="{{ route('admin.tags.edit', $tag->id) }}"
                                                class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-500 rounded-lg shadow hover:bg-blue-600 transition">
                                                Edit </a> <!-- Delete -->
                                            <form action="{{ route('admin.tags.destroy', $tag->id) }}" method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this tag?')">
                                                @csrf @method('DELETE') <button type="submit"
                                                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-red-500 rounded-lg shadow hover:bg-red-600 transition">
                                                    Delete </button> </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-4">
                    {{ $tags->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<x-alert />
