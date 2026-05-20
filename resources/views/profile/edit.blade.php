<x-app-layout>
    <x-breadcrumbs :items="[['label' => __('messages.profile')]]" />
    <div class="mb-8">
        <h1 class="font-display text-h1 text-primary">{{ __('messages.profile') }}</h1>
    </div>

    <div class="space-y-6 max-w-2xl">
        <div class="card-hover">
            @include('profile.partials.update-profile-information-form')
        </div>

        <div class="card-hover">
            @include('profile.partials.update-password-form')
        </div>

        <div class="card-hover">
            @include('profile.partials.delete-user-form')
        </div>
    </div>
</x-app-layout>
