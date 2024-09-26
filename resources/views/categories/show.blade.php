<x-app-layout>
    <div class="container mx-auto px-4 sm:px-6 lg:px-32 mt-8">
        <!-- Breadcrumb -->
        <nav class="breadcrumb mb-4">
            @foreach ($breadcrumb as $crumb)
                <a href="{{ route('categories.show', $crumb['full_path']) }}" class="text-blue-700 hover:underline">
                    {{ $crumb['name'] }}
                </a>
                @if (!$loop->last)
                    >
                @endif
            @endforeach
        </nav>

        <!-- Display the current category's name -->
        <h1 class="text-2xl font-bold mb-4">{{ $category->name }}</h1>

        <!-- Check if the category has subcategories -->
        @if($subcategories->isNotEmpty())
            <ul class="grid grid-cols-1 gap-4 lg:grid-cols-2 lg:gap-6">
                @foreach($subcategories as $subcategory)
                    <li class="text-gray-700">
                        <a href="{{ route('categories.show', implode('/', array_merge($slugs, [$subcategory->slug]))) }}" class="text-black hover:text-blue-700">
                            {{ $subcategory->name }}
                        </a>
                    </li>
                @endforeach
            </ul>
        @else
            <p>No subcategories available.</p>
        @endif
    </div>
</x-app-layout>
