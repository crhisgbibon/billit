<x-guest-layout>
  <x-slot name="appTitle">
    {{ __('log in') }}
  </x-slot>

  <x-slot name="appName">
    {{ __('log in') }}
  </x-slot>
  <x-auth-card>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
      @csrf

      <!-- Email Address -->
      <div>
        <x-input-label for="email" :value="__('email')" />

        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />

        <x-input-error :messages="$errors->get('email')" class="mt-2" />
      </div>

      <!-- Password -->
      <div class="mt-4">
        <x-input-label for="password" :value="__('password')" />

        <x-text-input id="password" class="block mt-1 w-full"
                        type="password"
                        name="password"
                        required autocomplete="current-password" />

        <x-input-error :messages="$errors->get('password')" class="mt-2" />
      </div>

      <!-- Remember Me -->
      <div class="block mt-4">
        <label for="remember_me" class="inline-flex items-center">
          <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-black shadow-sm focus:ring-indigo-500" name="remember">
          <span class="ml-2 text-sm text-gray-600">{{ __('remember me') }}</span>
        </label>
      </div>

      <div class="flex items-center justify-evenly mt-4">

        @if (Route::has('register'))
          <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('register') }}">
            {{ __('register') }}
          </a>
        @endif

        @if (Route::has('password.request'))
          <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
            {{ __('reset password') }}
          </a>
        @endif

        <x-primary-button class="ml-3">
          {{ __('log in') }}
        </x-primary-button>
      </div>
    </form>
  </x-auth-card>
</x-guest-layout>
