<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <img src="{{ asset('VT-logo.jpeg') }}" alt="VT Logo" class="w-24 h-24 mx-auto">
           
        </x-slot>

        <div class="mb-4 text-sm text-gray-600">
            {{ __('Aizmirsi paroli? Ieraksti e-pastu un izveido jaunu paroli!') }}
        </div>

        @session('status')
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ $value }}
            </div>
        @endsession

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="block">
                <x-label for="email" value="{{ __('E-pasts') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button>
                    {{ __('E-pasta paroles atiestatīšanas saite') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>
