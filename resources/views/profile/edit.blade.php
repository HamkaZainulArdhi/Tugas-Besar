<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                <i class="fa-solid fa-user text-white text-lg"></i>
            </div>
            <div>
                <h2 class="font-bold text-2xl text-gray-900">
                    {{ __('Profile Settings') }}
                </h2>
                <p class="text-sm text-gray-600 mt-1">Kelola informasi profil dan keamanan akun Anda</p>
            </div>
        </div>
    </x-slot>

    <div class="py-5">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Profile Information -->
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl border border-white/40 shadow-lg overflow-hidden">
                <div class="max-w-xl p-6">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- Update Password -->
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl border border-white/40 shadow-lg overflow-hidden">
                <div class="max-w-xl p-6">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- Delete Account -->
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl border border-white/40 shadow-lg overflow-hidden">
                <div class="max-w-xl p-6">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
