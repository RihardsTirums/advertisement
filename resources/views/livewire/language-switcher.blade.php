<div>
    <div class="dropdown">
        <button class="btn btn-secondary dropdown-toggle" type="button" id="languageDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            {{ $locales[$currentLocale]['native'] }}
        </button>
        <div class="dropdown-menu" aria-labelledby="languageDropdown">
            @foreach ($locales as $localeCode => $properties)
                <a
                    class="dropdown-item {{ $localeCode === $currentLocale ? 'active' : '' }}"
                    wire:click.prevent="switchLanguage('{{ $localeCode }}')"
                    href="#"
                >
                    {{ $properties['native'] }}
                </a>
            @endforeach
        </div>
    </div>
</div>
