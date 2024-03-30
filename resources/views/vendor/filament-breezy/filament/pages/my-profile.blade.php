<x-filament::page>
    <div class="space-y-6 divide-y divide-gray-900/10 dark:divide-white/10">
        @if(auth()->user()->company_id)
            Company: <b>{{ auth()->user()->company->name  }}</b>
        @endif
        @foreach ($this->getRegisteredMyProfileComponents() as $component)
            @unless(is_null($component))
                @livewire($component)
            @endunless
        @endforeach
    </div>
</x-filament::page>
