<div class="fixed bottom-0 left-1/2 transform -translate-x-1/2 w-full max-w-sm">
    <div class="bg-[#f7f4f2] border border-[#a6705d]/40 rounded-lg shadow-lg px-8 py-3 flex justify-between items-center">

        <!-- Home Button -->
        <button class="flex flex-col items-center text-[#a6705d] hover:text-[#824f3d] transition">
            <i class="fas fa-home text-xl"></i>
            <span class="text-xs mt-1">Home</span>
        </button>

        <!-- Hamburger Button -->
        <button id="hamburgerBtn" class="flex flex-col items-center text-[#a6705d] hover:text-[#824f3d] transition">
            <i class="fas fa-bars text-xl"></i>
            <span class="text-xs mt-1">Menu</span>
        </button>

    </div>

    <script>
        const menuBtn = document.querySelector('#hamburgerBtn');
        const sideMenu = document.getElementById('sideMenu');
        const overlay = document.getElementById('menuOverlay');

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

        function scrollToSection(id) {
            document.getElementById(id).scrollIntoView({ behavior: 'smooth', block: 'start' });
            toggleMenu();
        }

    </script>

</div>
