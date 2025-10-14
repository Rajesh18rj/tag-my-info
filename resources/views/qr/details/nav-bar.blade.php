<div class="fixed bottom-0 left-1/2 transform -translate-x-1/2 w-full max-w-sm">
    <div class="bg-[#f7f4f2] border border-[#a6705d]/40 shadow-lg px-8 py-3 flex justify-between items-center">

        <!-- Home Button -->
        <button onclick="scrollToTop()"
                class="flex flex-col items-center text-[#a6705d] hover:text-[#824f3d] transition">
            <i class="fas fa-home text-xl"></i>
            <span class="text-xs mt-1">Home</span>
        </button>

        @if($ptype == 'human')
        <!-- Emergency Contact Button -->
        <button onclick="scrollToEmergency()"
                class="flex flex-col items-center text-[#a6705d] hover:text-[#824f3d] transition">
            <i class="fas fa-address-book text-xl"></i>
            <span class="text-xs mt-1">Emergency Contact</span>
        </button>
        @endif

        @if($ptype == 'pet')
            <!-- Pet Owner Button -->
            <button onclick="scrollToPetOwner()"
                    class="flex flex-col items-center text-[#a6705d] hover:text-[#824f3d] transition">
                <i class="fas fa-address-book text-xl"></i>
                <span class="text-xs mt-1">Pet Owners</span>
            </button>
        @endif

        <!-- Hamburger Button -->
        <button id="hamburgerBtn" class="flex flex-col items-center text-[#a6705d] hover:text-[#824f3d] transition">
            <i class="fas fa-bars text-xl"></i>
            <span class="text-xs mt-1">Menu</span>
        </button>
    </div>

<!---------------------- For Human ---------------------------------------->
    @if($ptype == 'human')
        <!-- Overlay -->
        <div id="menuOverlay" class="fixed inset-0 bg-black/40 hidden z-40 transition-opacity duration-300"></div>

        <!-- Side Menu -->
        <div id="sideMenu" class="fixed bottom-20 left-1/2 -translate-x-1/2 w-full max-w-sm
    bg-white rounded-2xl shadow-2xl border border-[#a6705d]/20 p-5 hidden z-50
    transform transition-all duration-300 ease-out opacity-0 translate-y-5">

            <!-- Header -->
            <div class="relative mb-4">
                <h3 class="text-[#a6705d] font-semibold text-lg tracking-wide text-center">
                    Quick Navigation
                </h3>
                <button id="closeMenuBtn"
                        class="absolute right-0 top-0 text-gray-500 hover:text-red-500 transition">
                    <i class="fas fa-circle-xmark text-3xl"></i>
                </button>
            </div>

            <!-- Menu List -->
            <ul class="space-y-3 text-sm">
                <li>
                    <button onclick="scrollToSection('emergency')"
                            class="w-full flex items-center gap-3 px-4 py-3 rounded-xl
                bg-[#fafafa] text-gray-700 font-medium shadow-sm
                hover:bg-[#f1edea] active:scale-95 transition">
                        <i class="fas fa-phone-volume text-[#a6705d] text-lg"></i>
                        Emergency Contacts
                    </button>
                </li>
                <li>
                    <button onclick="scrollToSection('additional')"
                            class="w-full flex items-center gap-3 px-4 py-3 rounded-xl
                bg-[#fafafa] text-gray-700 font-medium shadow-sm
                hover:bg-[#f1edea] active:scale-95 transition">
                        <i class="fas fa-file-alt text-[#a6705d] text-lg"></i>
                        Additional Information
                    </button>
                </li>

                @if($profile->allergies && $profile->allergies->isNotEmpty())
                <li>
                    <button onclick="scrollToSection('allergies')"
                            class="w-full flex items-center gap-3 px-4 py-3 rounded-xl
                bg-[#fafafa] text-gray-700 font-medium shadow-sm
                hover:bg-[#f1edea] active:scale-95 transition">
                        <i class="fas fa-hand text-[#a6705d] text-lg"></i>
                        Allergies
                    </button>
                </li>
                @endif

                @if($profile->medications && $profile->medications->isNotEmpty())
                <li>
                    <button onclick="scrollToSection('medications')"
                            class="w-full flex items-center gap-3 px-4 py-3 rounded-xl
                bg-[#fafafa] text-gray-700 font-medium shadow-sm
                hover:bg-[#f1edea] active:scale-95 transition">
                        <i class="fas fa-pills text-[#a6705d] text-lg"></i>
                        Medications
                    </button>
                </li>
                @endif

                @if($profile->healthInsurances && $profile->healthInsurances->isNotEmpty())
                <li>
                    <button onclick="scrollToSection('insurance')"
                            class="w-full flex items-center gap-3 px-4 py-3 rounded-xl
                bg-[#fafafa] text-gray-700 font-medium shadow-sm
                hover:bg-[#f1edea] active:scale-95 transition">
                        <i class="fas fa-hospital-user text-[#a6705d] text-lg"></i>
                        Health Insurances
                    </button>
                </li>
                @endif

                @if($profile->vitalMedicalConditions && $profile->vitalMedicalConditions->isNotEmpty())
                <li>
                    <button onclick="scrollToSection('conditions')"
                            class="w-full flex items-center gap-3 px-4 py-3 rounded-xl
                bg-[#fafafa] text-gray-700 font-medium shadow-sm
                hover:bg-[#f1edea] active:scale-95 transition">
                        <i class="fas fa-heartbeat text-[#a6705d] text-lg"></i>
                        Vital Medical Conditions
                    </button>
                </li>
                @endif
            </ul>
        </div>
    @endif

    <!---------------------- For Pet ---------------------------------------->
    @if($ptype == 'pet')
        <!-- Overlay -->
        <div id="menuOverlay" class="fixed inset-0 bg-black/40 hidden z-40 transition-opacity duration-300"></div>

        <!-- Side Menu -->
        <div id="sideMenu" class="fixed bottom-20 left-1/2 -translate-x-1/2 w-full max-w-sm
    bg-white rounded-2xl shadow-2xl border border-[#a6705d]/20 p-5 hidden z-50
    transform transition-all duration-300 ease-out opacity-0 translate-y-5">

            <!-- Header -->
            <div class="relative mb-4">
                <h3 class="text-[#a6705d] font-semibold text-lg tracking-wide text-center">
                    Quick Navigation
                </h3>
                <button id="closeMenuBtn"
                        class="absolute right-0 top-0 text-gray-500 hover:text-red-500 transition">
                    <i class="fas fa-circle-xmark text-3xl"></i>
                </button>
            </div>

            <!-- Menu List -->
            <ul class="space-y-3 text-sm">
                <li>
                    <button onclick="scrollToSection('pet-owners')"
                            class="w-full flex items-center gap-3 px-4 py-3 rounded-xl
                bg-[#fafafa] text-gray-700 font-medium shadow-sm
                hover:bg-[#f1edea] active:scale-95 transition">
                        <i class="fas fa-phone-volume text-[#a6705d] text-lg"></i>
                        Pet Owners
                    </button>
                </li>
                <li>
                    <button onclick="scrollToSection('additional')"
                            class="w-full flex items-center gap-3 px-4 py-3 rounded-xl
                bg-[#fafafa] text-gray-700 font-medium shadow-sm
                hover:bg-[#f1edea] active:scale-95 transition">
                        <i class="fas fa-file-alt text-[#a6705d] text-lg"></i>
                        Additional Information
                    </button>
                </li>

                @if($profile->allergies && $profile->allergies->isNotEmpty())
                <li>
                    <button onclick="scrollToSection('allergies')"
                            class="w-full flex items-center gap-3 px-4 py-3 rounded-xl
                bg-[#fafafa] text-gray-700 font-medium shadow-sm
                hover:bg-[#f1edea] active:scale-95 transition">
                        <i class="fas fa-hand text-[#a6705d] text-lg"></i>
                        Allergies
                    </button>
                </li>
                @endif


                @if($profile->medications && $profile->medications->isNotEmpty())
                <li>
                    <button onclick="scrollToSection('medications')"
                            class="w-full flex items-center gap-3 px-4 py-3 rounded-xl
                bg-[#fafafa] text-gray-700 font-medium shadow-sm
                hover:bg-[#f1edea] active:scale-95 transition">
                        <i class="fas fa-pills text-[#a6705d] text-lg"></i>
                        Medications
                    </button>
                </li>
                @endif

                @if($profile->vetDetails && $profile->vetDetails->isNotEmpty())
                <li>
                    <button onclick="scrollToSection('vet-details')"
                            class="w-full flex items-center gap-3 px-4 py-3 rounded-xl
                bg-[#fafafa] text-gray-700 font-medium shadow-sm
                hover:bg-[#f1edea] active:scale-95 transition">
                        <i class="fas fa-hospital-user text-[#a6705d] text-lg"></i>
                        Vet Details
                    </button>
                </li>
                @endif

                @if($profile->instructions && $profile->instructions->isNotEmpty())
                <li>
                    <button onclick="scrollToSection('instructions')"
                            class="w-full flex items-center gap-3 px-4 py-3 rounded-xl
                bg-[#fafafa] text-gray-700 font-medium shadow-sm
                hover:bg-[#f1edea] active:scale-95 transition">
                        <i class="fas fa-clipboard-list text-[#a6705d] text-lg"></i>
                        Instructions
                    </button>
                </li>
                @endif

            </ul>
        </div>
    @endif


    <script>
        const menuBtn = document.querySelector('#hamburgerBtn');
        const sideMenu = document.getElementById('sideMenu');
        const overlay = document.getElementById('menuOverlay');
        const closeMenuBtn = document.getElementById('closeMenuBtn'); //this for close modal


        function toggleMenu() {
            const isOpen = !sideMenu.classList.contains('hidden');

            if (isOpen) {
                // Close animation
                sideMenu.classList.add("opacity-0", "translate-y-5");
                overlay.classList.add("opacity-0");
                setTimeout(() => {
                    sideMenu.classList.add("hidden");
                    overlay.classList.add("hidden");
                }, 300);
            } else {
                // Open animation
                sideMenu.classList.remove("hidden");
                overlay.classList.remove("hidden");

                setTimeout(() => {
                    sideMenu.classList.remove("opacity-0", "translate-y-5");
                    overlay.classList.remove("opacity-0");
                }, 10);
            }
        }

        menuBtn.addEventListener('click', toggleMenu);
        overlay.addEventListener('click', toggleMenu);
        closeMenuBtn.addEventListener('click', toggleMenu);


        function scrollToSection(id) {
            document.getElementById(id).scrollIntoView({ behavior: 'smooth', block: 'start' });
            toggleMenu();
        }

    </script>

    <script>
        // NEW: emergency-only scroll (won’t open/close menu)
        function scrollToEmergency() {
            const el = document.getElementById('emergency');
            if (!el) return;
            el.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    </script>

    <script>
        // NEW: petOwner-only scroll (won’t open/close menu)
        function scrollToPetOwner() {
            const el = document.getElementById('pet-owners');
            if (!el) return;
            el.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    </script>

    <script>
        function scrollToTop() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    </script>


</div>
