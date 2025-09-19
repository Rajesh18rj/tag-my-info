@extends('layouts.new-layout')

@section('title', $profile->exists ? 'Edit Profile' : 'Create Profile')

@section('content')
    <h1 class="text-3xl font-bold text-red-600 mb-6">
        {{ $profile->exists ? 'Edit Profile' : 'Create New Profile' }}
    </h1>

    @if($profile->exists)
        <div class="mb-6">
            <a href="{{ route('profiles.link-qr', $profile->id) }}"
               class="inline-flex items-center gap-2 bg-blue-600 px-4 py-2 rounded-lg text-white font-semibold shadow hover:bg-blue-700 transition">
                <i class="fas fa-link"></i>
                <span>Link to QR</span>
            </a>
        </div>
    @endif


    <form action="{{ $profile->exists ? route('profiles.update', $profile) : route('profiles.store') }}" method="POST" class="space-y-6 max-w-3xl " id="profileForm">
        @csrf
        @if($profile->exists)
            @method('PUT')
        @endif

        <div class="mb-6">
            <label for="profileType" class="block mb-2 font-semibold text-gray-700 text-lg">Profile Type</label>
            <div class="relative">
                <select name="type" id="profileType" required
                        class="w-full appearance-none rounded-lg border border-gray-300 bg-white px-4 py-3 pr-10 text-gray-800 font-medium shadow-sm
                   focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition duration-300">
                    <option value="">-- Select Type --</option>
                    <option value="Human" {{ old('type', $profile->type) == 'Human' ? 'selected' : '' }}>Human</option>
                    <option value="Pet" {{ old('type', $profile->type) == 'Pet' ? 'selected' : '' }}>Pet</option>
                    <option value="Valuables" {{ old('type', $profile->type) == 'Valuables' ? 'selected' : '' }}>Valuables</option>
                </select>
                <!-- Custom down arrow icon -->
                <div class="pointer-events-none absolute inset-y-0 right-3 flex items-center">
                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.24a.75.75 0 01-1.06 0L5.21 8.27a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                    </svg>
                </div>
            </div>
            @error('type')
            <p class="mt-1 text-sm font-medium text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Human Fields -->
            @include('profiles.partials.human')

        <!-- Pet Fields -->
            @include('profiles.partials.pet')

        <!-- Valuables Fields -->
            @include('profiles.partials.valuable')

        <div>
            <button type="submit"
                    class="bg-red-600 px-6 py-2 mb-4 rounded-2xl text-white text-lg font-semibold hover:bg-red-700 transition">
                {{ $profile->exists ? 'Update' : 'Create' }} Profile
            </button>
        </div>
    </form>

    <!-- For Emergency Contacts Pop-up -->
    @if($profile->id && ($profile->type == 'Human'))
        @include('profiles.modals.emergency_contact')
    @endif

    <!-- For Pet Owner Pop-up -->
    @if($profile->id && ($profile->type == 'Pet'))
        @include('profiles.modals.pet-owner')
    @endif

    <!-- For Allergy Pop-up -->
    @if($profile->id && ($profile->type == 'Human' || $profile->type == 'Pet'))
        @include('profiles.modals.allergy1')
    @endif

    <!-- For Medication Pop-up -->
    @if($profile->id && ($profile->type == 'Human' || $profile->type == 'Pet'))
        @include('profiles.modals.medications')
    @endif

    <!-- For Health Insurance Pop-up -->
    @if($profile->id && ($profile->type == 'Human'))
        @include('profiles.modals.health-insurance')
    @endif

    <!-- For Vet Details Pop-up -->
    @if($profile->id && ($profile->type == 'Pet'))
        @include('profiles.modals.vet-details')
    @endif

    <!-- For Vital Medical Condition Pop-up -->
    @if($profile->id && ($profile->type == 'Pet'))
        @include('profiles.modals.instruction')
    @endif

    <!-- For Vital Medical Condition Pop-up -->
    @if($profile->id && ($profile->type == 'Human'))
        @include('profiles.modals.vital-medical-condition')
    @endif

@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const typeSelect = document.getElementById('profileType');
            const humanFields = document.getElementById('HumanFields');
            const petFields = document.getElementById('PetFields');
            const valuablesFields = document.getElementById('ValuablesFields');

            function showFields(type) {
                humanFields.classList.add('hidden');
                petFields.classList.add('hidden');
                valuablesFields.classList.add('hidden');
                if (type === 'Human') {
                    humanFields.classList.remove('hidden');
                } else if (type === 'Pet') {
                    petFields.classList.remove('hidden');
                } else if (type === 'Valuables') {
                    valuablesFields.classList.remove('hidden');
                }
            }

            // Initial display
            showFields(typeSelect.value);

            typeSelect.addEventListener('change', () => {
                showFields(typeSelect.value);
            });
        });
    </script>
@endsection
