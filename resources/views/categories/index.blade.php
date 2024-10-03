@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ __('Categories') }}</h1>
    <div class="row">
        @foreach ($categories as $category)
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">{{ $category->getSlug() }}</h5>
                        <p class="card-text">
                            {{ __('Slug:') }} {{ $category->getSlug() }}
                        </p>
                        <a href="{{ $category->getUrl() }}" class="btn btn-primary">{{ __('View Subcategories') }}</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
