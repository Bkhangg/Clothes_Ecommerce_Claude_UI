<x-guest-layout>
    <h1 class="font-display text-h1 text-primary mb-6">{{ __('messages.sign_up') }}</h1>

    <p class="text-body text-secondary text-sm mb-6 leading-relaxed">
        {{ __('messages.verify_email_desc') }}
    </p>

    @if (session('status') == 'verification-link-sent')
        <p class="text-sm text-tertiary mb-6">
            {{ __('messages.verification_link_sent') }}
        </p>
    @endif

    <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-4">
        <form method="POST" action="{{ route('verification.send') }}" class="w-full sm:w-auto">
            @csrf
            <button type="submit" class="btn-primary w-full">{{ __('messages.resend_verification_email') }}</button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full sm:w-auto btn-secondary">{{ __('messages.log_out') }}</button>
        </form>
    </div>
</x-guest-layout>