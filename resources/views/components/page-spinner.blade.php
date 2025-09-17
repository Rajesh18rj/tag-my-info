<!---Spinner Section-->
<div id="pageSpinner" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden space-x-3">
    <div class="w-5 h-5 rounded-full bg-red-600 animate-pulse"></div>
    <div class="w-5 h-5 rounded-full bg-white animate-pulse animation-delay-150"></div>
    <div class="w-5 h-5 rounded-full bg-red-600 animate-pulse animation-delay-300"></div>
</div>

<style>
    .animation-delay-150 { animation-delay: 0.15s; }
    .animation-delay-300 { animation-delay: 0.3s; }
</style>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        const spinner = document.getElementById('pageSpinner');

        window.addEventListener('pageshow', function(event) {
            const spinner = document.getElementById('pageSpinner');
            spinner.classList.add('hidden');
        });

        // Show spinner on form submit
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function () {
                spinner.classList.remove('hidden');
            });
        });

        // Show spinner on link click (only for internal links)
        document.querySelectorAll('a[href]').forEach(link => {
            // Only add spinner for internal navigation
            if (link.hostname === window.location.hostname) {
                link.addEventListener('click', function () {
                    spinner.classList.remove('hidden');
                });
            }
        });
    });
</script>
