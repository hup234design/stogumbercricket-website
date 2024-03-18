<x-app-layout>

{{--    @section('heading')--}}
{{--        <div class="w-full bg-yellow-300 h-96  flex items-center justify-center">--}}
{{--            <span class="text-5xl font-black uppercase text-shadow">--}}
{{--                {{ $page->title }}--}}
{{--            </span>--}}
{{--        </div>--}}
{{--    @stop--}}

    @section('title')
    @stop

    <x-page-content :page="$page" />

</x-app-layout>
