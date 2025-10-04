@extends('layouts.new-layout')

@section('title', $profile->exists ? 'Edit Profile' : 'Create Profile')

@section('content')
    <h1 class="text-2xl font-bold text-red-600 mb-10 mt-6 flex max-w-4xl mx-auto items-center gap-3">
        @if($profile->exists)
            <i class="fas fa-user-edit text-gray-700"></i>
            Edit Profile
        @else
            <i class="fas fa-user-plus text-gray-700"></i>
            Create New Profile
        @endif
    </h1>


    @if($profile->exists)
        <div class="mb-6 flex justify-between max-w-4xl mx-auto ">
            <a href="{{ route('profiles.link-qr', $profile->id) }}"
               class="inline-flex items-center gap-2 bg-blue-600 px-4 py-2 rounded-lg text-white font-semibold shadow hover:bg-blue-700 transition">
                <i class="fas fa-link"></i>
                <span>Link to QR</span>
            </a>

            <!-- Public Toggle Button -->
            <button type="button"
                    id="togglePublicBtn"
                    data-id="{{ $profile->id }}"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-lg font-semibold shadow transition
                       {{ $profile->is_public ? 'bg-green-600 text-white hover:bg-green-700' : 'bg-gray-400 text-white hover:bg-gray-500' }}">
                <i class="fas {{ $profile->is_public ? 'fa-eye' : 'fa-eye-slash' }}"></i>
                <span>{{ $profile->is_public ? 'Public' : 'Private' }}</span>
            </button>
        </div>
    @endif

    @if($profile->exists)
        <!-- TABS Navigation -->
        <div class="mb-2">
            <nav class="flex gap-2 bg-gray-100 p-2 rounded-xl shadow-inner max-w-4xl mx-auto">
                <button type="button"
                        class="tablinks px-6 py-2 rounded-xl font-semibold text-gray-700 border-b-4 border-transparent hover:border-red-400 hover:text-red-700 transition focus:outline-none"
                        onclick="openTab(event, 'profile-details')" id="defaultOpen">
                    <i class="fas fa-id-card-alt text-red-600"></i> Profile Details
                </button>
                <button type="button"
                        class="tablinks px-6 py-2 rounded-xl font-semibold text-gray-700 border-b-4 border-transparent hover:border-red-400 hover:text-red-700 transition focus:outline-none"
                        onclick="openTab(event, 'additional-info')">
                    <i class="fas fa-plus-circle text-red-600"></i> Additional Info
                </button>
            </nav>
        </div>

        <div class="rounded-2xl shadow-lg bg-white p-4 max-w-4xl mx-auto mt-0">
            <!-- Profile Details Tab -->
            <div id="profile-details" class="tabcontent">
                <form action="{{ route('profiles.update', $profile) }}" method="POST" enctype="multipart/form-data"
                      class="space-y-6 max-w-7xl " id="profileForm">
                    @csrf
                    @method('PUT')

                    <div class="mb-6">
                        <label for="profileType" class="block mb-2 font-semibold text-gray-700 text-lg">Profile Type</label>
                        <div class=" relative">
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

                    <!-- Profiles Image Section -->
                    @include('profiles.profiles-image-section')

            <!--------- Partials--------------->

                    <!-- Human Fields -->
                    @include('profiles.partials.human')

                    <!-- Pet Fields -->
                    @include('profiles.partials.pet')

                    <!-- Valuables Fields -->
                    @include('profiles.partials.valuable')

                    <div>
                        <button type="submit"
                                class="bg-red-600 px-6 py-2 mb-4 rounded-2xl text-white text-lg font-semibold hover:bg-red-700 transition">
                            Update Profile
                        </button>
                    </div>
                </form>
            </div>

            <!-- Additional Info Tab -->
            <div id="additional-info" class="tabcontent hidden">

        <!--------------------- Additional Information Section ------------------------------------->

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

                <!-- For Instructions Pop-up -->
                @if($profile->id && ($profile->type == 'Pet'))
                    @include('profiles.modals.instruction')
                @endif

                <!-- For Vital Medical Condition Pop-up -->
                @if($profile->id && ($profile->type == 'Human'))
                    @include('profiles.modals.vital-medical-condition')
                @endif
            </div>
        </div>
    @else
        <!-- Create Profile Form (no tabs) -->
        <form action="{{ route('profiles.store') }}" method="POST" enctype="multipart/form-data"
              class="space-y-6 max-w-4xl mx-auto " id="profileForm">
            @csrf
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

            <!-- Profiles Image Section -->
            @include('profiles.profiles-image-section')

    <!--------- Partials--------------->

            <!-- Human Fields -->
            @include('profiles.partials.human')

            <!-- Pet Fields -->
            @include('profiles.partials.pet')

            <!-- Valuables Fields -->
            @include('profiles.partials.valuable')

            <div>
                <button type="submit"
                        class="bg-red-600 px-6 py-2 mb-4 rounded-2xl text-white text-lg font-semibold hover:bg-red-700 transition">
                    Create Profile
                </button>
            </div>
        </form>
    @endif
@endsection

@section('scripts')
    <script>
        // Tab logic: Show/Hide tab panels and update tab styles
        function openTab(evt, tabName) {
            var tabcontent = document.getElementsByClassName("tabcontent");
            for (var i = 0; i < tabcontent.length; i++) {
                tabcontent[i].classList.add('hidden');
            }
            var tablinks = document.getElementsByClassName("tablinks");
            for (var i = 0; i < tablinks.length; i++) {
                tablinks[i].classList.remove('border-red-600','text-red-600','bg-white','shadow-md');
                tablinks[i].classList.add('border-transparent', 'text-gray-700');
            }
            document.getElementById(tabName).classList.remove('hidden');
            evt.currentTarget.classList.add('border-red-600','text-red-600','bg-white','shadow-md');
            evt.currentTarget.classList.remove('border-transparent', 'text-gray-700');
        }
        // Open first tab by default (only when editing)
        document.addEventListener("DOMContentLoaded", function() {
            var defaultTab = document.getElementById("defaultOpen");
            if (defaultTab) {
                defaultTab.click();
            }
        });

        // Existing JS for profile type dynamic fields
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

    <!----- For Toggle Bar ---->
    <script>
        document.getElementById('togglePublicBtn')?.addEventListener('click', function () {
            const btn = this;
            const profileId = btn.dataset.id;

            fetch(`/profiles/${profileId}/toggle-public`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        if (data.is_public) {
                            btn.classList.remove('bg-gray-400', 'hover:bg-gray-500');
                            btn.classList.add('bg-green-600', 'hover:bg-green-700');
                            btn.innerHTML = '<i class="fas fa-eye"></i> <span>Public</span>';
                        } else {
                            btn.classList.remove('bg-green-600', 'hover:bg-green-700');
                            btn.classList.add('bg-gray-400', 'hover:bg-gray-500');
                            btn.innerHTML = '<i class="fas fa-eye-slash"></i> <span>Private</span>';
                        }
                    }
                })
                .catch(err => console.error(err));
        });
    </script>
@endsection
