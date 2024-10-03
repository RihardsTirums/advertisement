@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $category->getName() }}</h1>

    @if ($category->children->count())
        <div class="row">
            <h3>{{ __('Subcategories') }}</h3>
            @foreach ($category->children as $subcategory)
                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title">{{ $subcategory->getName() }}</h5>
                            <p class="card-text">
                                {{ __('Slug:') }} {{ $subcategory->getSlug() }}
                            </p>
                            <a href="{{ $subcategory->getUrl() }}" class="btn btn-primary">{{ __('View Subcategory') }}</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p>{{ __('No subcategories available for this category.') }}</p>
    @endif
</div>
@endsection
