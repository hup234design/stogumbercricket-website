<x-posts-layout>

    <p class="text-gray-600 mb-4 font-semibold">{{ $page->publish_at->format('l jS F Y') }}</p>

    <x-page-content :page="$page" />

</x-posts-layout>
