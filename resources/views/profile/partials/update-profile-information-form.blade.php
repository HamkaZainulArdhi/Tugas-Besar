<section>
    <header class="mb-6">
        <div class="flex items-center space-x-3 mb-2">
            <div class="w-8 h-8 bg-gradient-to-r from-blue-100 to-indigo-100 rounded-lg flex items-center justify-center">
                <i class="fa-solid fa-user text-blue-600"></i>
            </div>
            <h2 class="text-lg font-semibold text-gray-900">
                {{ __('Profile Information') }}
            </h2>
        </div>
        <p class="text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" 
                         name="name" 
                         type="text" 
                         class="mt-1 block w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500" 
                         :value="old('name', $user->name)" 
                         required 
                         autofocus 
                         autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" 
                         name="email" 
                         type="email" 
                         class="mt-1 block w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500" 
                         :value="old('email', $user->email)" 
                         required 
                         autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-2 text-sm">
                    <p class="text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" 
                                class="text-blue-600 hover:text-blue-800 underline underline-offset-2">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 text-green-600">
                            <i class="fa-solid fa-check mr-1"></i>
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" 
                    class="px-4 py-2 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-xl hover:from-blue-600 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200 flex items-center">
                <i class="fa-solid fa-save mr-2"></i>
                {{ __('Save') }}
            </button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }"
                   x-show="show"
                   x-transition
                   x-init="setTimeout(() => show = false, 2000)"
                   class="text-sm text-green-600">
                    <i class="fa-solid fa-check mr-1"></i>
                    {{ __('Saved.') }}
                </p>
            @endif
        </div>
    </form>
</section>
