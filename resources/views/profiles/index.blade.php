@extends('layouts.new-layout')

@section('title', 'Profiles')

@section('content')
    <div class="flex justify-between items-center mb-6 mt-10 flex-wrap max-w-5xl mx-auto">
        <h1 class="flex items-center gap-3 text-2xl sm:text-2xl xs:text-xl uppercase font-bold text-red-600 drop-shadow-sm tracking-wide mb-6">
    <span class="p-2 bg-red-100 text-red-700 rounded-xl shadow-sm">
        <i class="fa-solid fa-user-group"></i>
    </span>
            My Profiles
        </h1>


        <a href="{{ route('profiles.create') }}"
           class="inline-flex items-center gap-2 rounded-lg bg-red-600 text-white px-5 py-2.5
          hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2
          transition-colors">
            <i class="fa-solid fa-plus text-sm"></i>
            <span class="text-sm font-medium">Create New Profile</span>
        </a>

    </div>


    <table class="table-auto mx-auto max-w-5xl w-full border-collapse border border-gray-300 rounded-lg overflow-hidden shadow-lg">
        <thead class="bg-red-600 text-white">
        <tr>
            <th class="border border-red-700 px-4 py-2 text-center">Type</th>
            <th class="border border-red-700 px-4 py-2 text-center">Name</th>
            <th class="border border-red-700 px-4 py-2 text-center">Actions</th>
        </tr>
        </thead>
        <tbody>
        @forelse ($profiles as $profile)
            <tr class="hover:bg-red-50 transition">
                <td class="border border-red-300 px-4 py-2 font-semibold text-red-700 text-center">{{ $profile->type }}</td>
                <td class="border border-red-300 px-4 py-2 text-center">
                    {{ $profile->first_name }}{{ $profile->last_name ? ' ' . $profile->last_name : '' }}
                    @if($profile->breed_name) ({{ $profile->breed_name }}) @endif
                </td>
                <td class="border border-red-300 px-4 py-2 text-center flex justify-center gap-6">
                    <a href="{{ route('profiles.edit', $profile) }}"
                       class="text-red-600 hover:text-red-800 transition transform hover:scale-110"
                       title="Edit Profile" aria-label="Edit Profile">
                        <i class="fas fa-edit fa-lg"></i>
                    </a>
                    <form action="{{ route('profiles.destroy', $profile) }}" method="POST" class="delete-profile inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="text-red-600 hover:text-red-800 transition transform hover:scale-110 bg-transparent border-0 p-0"
                                title="Delete Profile" aria-label="Delete Profile">
                            <i class="fas fa-trash-alt fa-lg"></i>
                        </button>
                    </form>

                </td>

            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-center text-gray-500 py-6">No profiles found.</td>
            </tr>
        @endforelse
        </tbody>
    </table>

    <div class="mt-6">
        {{ $profiles->links() }}
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const deleteForms = document.querySelectorAll('.delete-profile');

            deleteForms.forEach(form => {
                form.addEventListener('submit', function (e) {
                    e.preventDefault(); // prevent default form submission

                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Yes, delete it!',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit(); // submit form if confirmed
                        }
                    });
                });
            });
        });
    </script>

@endsection
