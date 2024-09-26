<x-app-layout>
    <div class="container mx-auto px-4 sm:px-6 lg:px-32 mt-8">
        <div class="grid grid-cols-1 gap-4 lg:grid-cols-4 lg:gap-6">
            @foreach($categories as $category)
                @php
                    $nameField = "name_{$locale}";
                    $slugField = "slug_{$locale}";
                @endphp

                <div class="bg-white p-3 shadow-md rounded-md">
                    <h2 class="text-md font-bold mb-2">
                        <!-- Category link -->
                        <a href="{{ route('categories.show', ['path' => $category->{$slugField}]) }}" class="text-black hover:text-blue-700">
                            {{ $category->{$nameField} }}
                        </a>
                    </h2>

                    <!-- Display subcategories if they exist -->
                    @if($category->children->isNotEmpty())
                        <ul class="pl-4">
                            @foreach($category->children as $subcategory)
                                @php
                                    $subcategorySlug = $subcategory->{$slugField};
                                @endphp
                                <li class="text-gray-700">
                                    <!-- Subcategory link -->
                                    <a href="{{ route('categories.show', ['path' => $category->{$slugField} . '/' . $subcategorySlug]) }}" class="text-black hover:text-blue-700">
                                        {{ $subcategory->{$nameField} }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
