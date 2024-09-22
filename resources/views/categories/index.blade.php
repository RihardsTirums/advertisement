@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-6 lg:px-32 xl:px-48"> <!-- More padding on large screens for ads -->
        <h1 class="text-2xl font-bold text-center mb-6">{{ __('navigation.categories') }}</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6"> <!-- 3 columns on large, 4 on extra-large -->
            @foreach($categories as $category)
                <div class="bg-white shadow-md rounded-lg p-6 w-full lg:w-80 xl:w-72 mx-auto lg:mx-4"> <!-- Adjust card width and spacing -->
                    <div class="flex items-center justify-between">
                        <h2 class="text-xl font-semibold mb-4 border-b-2 border-gray-400 inline-block w-full">
                            {{ $category->name }}
                        </h2>
                        <!-- Make the icon bigger -->
                        <img src="{{ asset($category->getIconPath()) }}" alt="{{ $category->name }}" class="w-10 h-10 ml-2"/> <!-- Adjust icon size -->
                    </div>

                    @if($category->children->isNotEmpty())
                        <ul class="list-inside"> <!-- Removed 'list-disc' to eliminate dots -->
                            @foreach($category->children as $subcategory)
                                <li class="text-gray-700">{{ $subcategory->name }}</li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-gray-500">No subcategories available.</p>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
@endsection
