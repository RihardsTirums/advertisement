@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-6 text-center">{{ $category->{$category->getNameField()} }}</h1>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($category->children as $subcategory)
                <div class="bg-white shadow-md rounded-lg overflow-hidden transform transition hover:scale-105 duration-300">
                    <a href="{{ route('categories.show', ['path' => request()->path() . '/' . $subcategory->{$subcategory->getSlugField()}]) }}">
                        <div class="px-6 py-4">
                            <h2 class="text-lg font-semibold text-gray-800">
                                {{ $subcategory->{$subcategory->getNameField()} }}
                            </h2>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@endsection
