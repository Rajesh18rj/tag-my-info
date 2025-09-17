<nav class="w-full bg-black py-2 px-4">
    <div class="mx-auto max-w-7xl flex items-center justify-between">
        <!-- Left: Logo -->
        <div class="flex-shrink-0">
            <a href="/" class="flex items-center">
                <img src="{{ asset('images/logo4.png') }}" alt="Logo" class="w-40">
            </a>
        </div>

        <!-- Center: Navigation Links -->
        <div class="hidden md:flex space-x-10 flex-grow justify-center">
            <a href="/"
               class="font-medium hover:text-red-500 {{ Request::is('/') ? 'text-red-500' : 'text-white' }}">
                Home
            </a>
            <a href="#"
               class="font-medium hover:text-red-500 {{ Request::is('shop') ? 'text-red-500' : 'text-white' }}">
                Shop
            </a>

            <a href="#"
               class="font-medium hover:text-red-500 {{ Request::is('about-us') ? 'text-red-500' : 'text-white' }}">
                About Us
            </a>

            <a href="#"
               class="font-medium hover:text-red-500 {{ Request::is('faq') ? 'text-red-500' : 'text-white' }}">
                FAQ
            </a>

            <a href="#"
               class="font-medium hover:text-red-500 {{ Request::is('setup-tag') ? 'text-red-500' : 'text-white' }}">
                Setup Tag
            </a>

            <a href="#"
               class="font-medium hover:text-red-500 {{ Request::is('contact-us') ? 'text-red-500' : 'text-white' }}">
                Contact Us
            </a>

        </div>

        <!-- Right: Login/Register -->
        <div class="hidden md:flex space-x-4 items-center flex-shrink-0">
            <a href="{{ route('login') }}" class="bg-red-500 text-white px-4 py-2 rounded-md font-semibold hover:bg-red-600">Login</a>
            <a href="{{ route('register') }}" class="bg-red-500 text-white px-4 py-2 rounded-md font-semibold hover:bg-red-600">Register</a>
        </div>

        <!-- Hamburger Button (Mobile) -->
        <button id="mobile-menu-btn" class="md:hidden text-white focus:outline-none">
            <!-- Hamburger Icon -->
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="md:hidden hidden flex flex-col items-center pt-4 space-y-4">
        <a href="#" class="block w-full text-center text-white font-medium hover:text-red-500">Home</a>
        <a href="#" class="block w-full text-center text-white font-medium hover:text-red-500">Shop</a>
        <a href="#" class="block w-full text-center text-white font-medium hover:text-red-500">About Us</a>
        <a href="#" class="block w-full text-center text-white font-medium hover:text-red-500">FAQ</a>
        <a href="#" class="block w-full text-center text-white font-medium hover:text-red-500">Setup Tag</a>
        <a href="#" class="block w-full text-center text-white font-medium hover:text-red-500">Contact Us</a>
        <a href="{{ route('login') }}" class="block w-1/3 bg-red-500 text-white px-4 py-2 rounded-md font-semibold hover:bg-red-600 text-center">Login</a>
        <a href="{{ route('register') }}" class="block w-1/3 bg-red-500 text-white px-4 py-2 rounded-md font-semibold hover:bg-red-600 text-center">Register</a>
    </div>


</nav>
<script>
    document.getElementById('mobile-menu-btn').onclick = function () {
        const menu = document.getElementById('mobile-menu');

        menu.classList.toggle('hidden');
    };
</script>

