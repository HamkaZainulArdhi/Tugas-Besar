<section>
    <header class="mb-6">
        <div class="flex items-center space-x-3 mb-2">
            <div class="w-8 h-8 bg-gradient-to-r from-blue-100 to-indigo-100 rounded-lg flex items-center justify-center">
                <i class="fa-solid fa-lock text-blue-600"></i>
            </div>
            <h2 class="text-lg font-semibold text-gray-900">
                {{ __('Update Password') }}
            </h2>
        </div>
        <p class="text-sm text-gray-600">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="space-y-6">
        @csrf
        @method('put')

        <div>
            <x-input-label for="update_password_current_password" :value="__('Current Password')" />
            <x-text-input id="update_password_current_password" 
                         name="current_password" 
                         type="password" 
                         class="mt-1 block w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500" 
                         autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password" :value="__('New Password')" />
            <x-text-input id="update_password_password" 
                         name="password" 
                         type="password" 
                         class="mt-1 block w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500" 
                         autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="update_password_password_confirmation" 
                         name="password_confirmation" 
                         type="password" 
                         class="mt-1 block w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500" 
                         autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" 
                    class="px-4 py-2 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-xl hover:from-blue-600 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200 flex items-center">
                <i class="fa-solid fa-save mr-2"></i>
                {{ __('Save') }}
            </button>

            @if (session('status') === 'password-updated')
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
