@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <h1 class="text-2xl font-bold text-center mb-6">Categories</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($categories as $category)
                <div class="bg-white shadow-md rounded-lg p-6">
                    <h2 class="text-xl font-semibold mb-4">{{ $category['name_en'] }}</h2>

                    @if(!empty($category['children']))
                        <ul class="list-disc list-inside">
                            @foreach($category['children'] as $subcategory)
                                <li class="text-gray-700">{{ $subcategory['name_en'] }}</li>
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
