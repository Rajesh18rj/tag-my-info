@props([
    'id' => 'spinner',
    'overlay' => true,
    'text' => 'Loading...'
])
<div id="{{ $id }}"
     class="{{ $overlay ? 'spinner-overlay' : 'spinner-inline' }}"
     role="status"
     aria-live="polite"
     aria-hidden="true"
     aria-label="Loading content">
    <div class="spinner-container" aria-busy="true">
        <svg class="spinner-svg" viewBox="0 0 64 64" aria-hidden="true" focusable="false">
            <defs>
                <linearGradient id="ringGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                    <stop offset="0%" stop-color="#ef4444"/>
                    <stop offset="100%" stop-color="#9ca3af"/>
                </linearGradient>
                <linearGradient id="ringGradient2" x1="100%" y1="0%" x2="0%" y2="100%">
                    <stop offset="0%" stop-color="#9ca3af"/>
                    <stop offset="100%" stop-color="#ef4444"/>
                </linearGradient>
            </defs>
            <circle class="spinner-ring ring1" cx="32" cy="32" r="28" stroke="url(#ringGradient)" />
            <circle class="spinner-ring ring2" cx="32" cy="32" r="22" stroke="url(#ringGradient2)" />
            <circle class="spinner-dot" cx="32" cy="6" r="5" />
            <circle class="spinner-dot dot2" cx="32" cy="6" r="3.5" />
        </svg>
        @if($text)
            <div class="spinner-text">{{ $text }}</div>
        @endif
    </div>
</div>

<style>
    :root {
        --red: #ef4444;
        --red-light: #f87171;
        --gray: #9ca3af;
        --gray-dark: #374151;
        --white: #ffffff;
        --background-overlay: rgba(55, 65, 81, 0.85); /* dark gray semi-transparent */
    }

    /* Overlay style */
    .spinner-overlay {
        position: fixed;
        inset: 0;
        background: var(--background-overlay);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 10000;
    }

    /* Inline style */
    .spinner-inline {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        position: relative;
        vertical-align: middle;
    }

    .spinner-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.6rem;
        min-width: 90px;
        user-select: none;
    }

    /* SVG container */
    .spinner-svg {
        width: 64px;
        height: 64px;
        overflow: visible;
    }

    /* Spinner ring */
    .spinner-ring {
        fill: none;
        stroke-linecap: round;
        stroke-width: 5;
        filter: drop-shadow(0 0 4px var(--gray));
        transform-origin: center;
        animation-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    }
    .ring1 {
        animation: spin-clockwise 2.5s linear infinite;
    }
    .ring2 {
        stroke-width: 3;
        filter: drop-shadow(0 0 6px var(--red-light));
        animation: spin-counterclockwise 1.8s linear infinite;
    }

    /* Pulsating dots */
    .spinner-dot {
        fill: var(--red);
        filter: drop-shadow(0 0 8px var(--red-light));
        transform-origin: 32px 32px;
        animation: pulse-scale 1.5s ease-in-out infinite;
    }
    .dot2 {
        fill: var(--gray);
        r: 3.5;
        animation: pulse-scale 1.2s ease-in-out infinite alternate;
    }

    /* Loading text */
    .spinner-text {
        font-size: 1.05rem;
        font-weight: 700;
        color: var(--white);
        opacity: 0;
        animation: fade-in 1.2s ease forwards 0.6s;
        text-align: center;
        user-select: none;
        text-shadow: 0 0 6px var(--red-light);
    }

    /* Animations */
    @keyframes spin-clockwise {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    @keyframes spin-counterclockwise {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(-360deg); }
    }
    @keyframes pulse-scale {
        0%, 100% { transform: scale(0.7); opacity: 0.7; }
        50% { transform: scale(1.3); opacity: 1; }
    }
    @keyframes fade-in {
        to { opacity: 1; }
    }

    /* Reduced motion support */
    @media (prefers-reduced-motion: reduce) {
        .spinner-ring, .spinner-dot {
            animation: none !important;
            filter: none !important;
        }
        .spinner-text {
            animation: none !important;
            opacity: 1 !important;
        }
    }

</style>

<script>
    function showSpinner(id = 'spinner') {
        const el = document.getElementById(id);
        if (!el) return;
        el.style.display = el.classList.contains('spinner-overlay') ? 'flex' : 'inline-flex';
        el.setAttribute('aria-hidden', 'false');
    }
    function hideSpinner(id = 'spinner') {
        const el = document.getElementById(id);
        if (!el) return;
        el.style.display = 'none';
        el.setAttribute('aria-hidden', 'true');
    }
    document.addEventListener('DOMContentLoaded', function() {
        const el = document.getElementById('{{ $id }}');
        if(el) el.style.display = 'none';
    });
</script>
