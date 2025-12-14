<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>

    <!-- TAILWIND CDN RESMI -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- OPTIONAL: Custom Tailwind Config -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: "#D31119",
                    }
                }
            }
        };
    </script>
</head>

<body class="bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen">

    <div class="min-h-screen py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto">
            
            <!-- Header Card -->
            <div class="bg-gradient-to-r from-primary to-red-600 rounded-t-3xl p-8 shadow-xl">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-sm">
                        <svg class="w-9 h-9 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-3xl font-bold text-white mb-1">Edit Profile</h2>
                        <p class="text-red-100 text-sm">Update your personal information</p>
                    </div>
                </div>
            </div>

            <!-- Form Card -->
            <div class="bg-white shadow-2xl rounded-b-3xl overflow-hidden p-6 max-w-xl mx-auto mt-12">
                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data"
                    x-data="{ previewUrl: '{{ auth()->user()->photo ? asset('storage/profile/' . auth()->user()->photo) : '' }}' }">
                @csrf
                @method('PUT')

                    <div class="p-8 space-y-6">
                        
                        <!-- Profile Photo Section -->
                        <div class="bg-gradient-to-br from-red-50 to-rose-50 rounded-2xl p-6 border-2 border-red-100">
                            <label class="block text-sm font-semibold text-gray-700 mb-4 flex items-center gap-2">
                                <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                Profile Photo
                            </label>

                            <div class="flex flex-col sm:flex-row items-center gap-6">
                                <!-- Photo Preview -->
                                <div class="relative group">
                                    <div class="size-32 rounded-2xl bg-gradient-to-br from-red-100 to-red-200 border-4 border-white shadow-xl 
                                        flex items-center justify-center overflow-hidden">
                                        <template x-if="previewUrl">
                                            <img :src="previewUrl" class="size-full object-cover">
                                        </template>
                                        <template x-if="!previewUrl">
                                            <svg class="size-16 text-red-300" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M12 12a5 5 0 1 0-5-5 5 5 0 0 0 5 5Zm0 2c-3.33 0-10 1.67-10 5v1h20v-1c0-3.33-6.67-5-10-5Z" />
                                            </svg>
                                        </template>
                                    </div>
                                    <div class="absolute inset-0 bg-black/40 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                    </div>
                                </div>

                                <!-- Upload Button -->
                                <div class="flex-1 text-center sm:text-left">
                                    <label class="inline-flex items-center gap-2 cursor-pointer px-6 py-3 bg-gradient-to-r from-primary to-red-600 text-white font-semibold
                                           rounded-xl shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-300">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                        </svg>
                                        Choose Photo
                                        <input type="file" name="photo" class="hidden" accept="image/*"
                                               @change="previewUrl = URL.createObjectURL($event.target.files[0])">
                                    </label>
                                    <p class="text-xs text-gray-500 mt-2">JPG, PNG or GIF (MAX. 2MB)</p>
                                </div>
                            </div>
                        </div>

                        <!-- Form Fields -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            
                            <!-- Full Name -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    Full Name
                                </label>
                                <div class="relative">
                                    <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}"
                                        class="w-full pl-11 pr-4 py-3 rounded-xl border-2 border-gray-200 shadow-sm
                                        focus:border-primary focus:ring-4 focus:ring-red-500/20 transition-all outline-none"
                                        placeholder="Enter your full name">
                                    <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <!-- Phone Number -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                    Phone Number
                                </label>
                                <div class="relative">
                                    <input type="tel" name="notelp" value="{{ old('notelp', auth()->user()->notelp) }}"
                                        class="w-full pl-11 pr-4 py-3 rounded-xl border-2 border-gray-200 shadow-sm
                                        focus:border-primary focus:ring-4 focus:ring-red-500/20 transition-all outline-none"
                                        placeholder="+62 812 3456 7890">
                                    <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <!-- Institution -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                    Institution
                                </label>
                                <div class="relative">
                                    <input type="text" name="institution" value="{{ old('institution', auth()->user()->institution) }}"
                                        class="w-full pl-11 pr-4 py-3 rounded-xl border-2 border-gray-200 shadow-sm
                                        focus:border-primary focus:ring-4 focus:ring-red-500/20 transition-all outline-none"
                                        placeholder="Your institution name">
                                    <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="bg-gray-50 px-8 py-6 border-t border-gray-200 flex flex-col sm:flex-row justify-end gap-3">
                        <button type="reset"
                            class="px-6 py-3 text-gray-700 font-semibold rounded-xl border-2 border-gray-300 
                            hover:bg-gray-100 hover:border-gray-400 transition-all duration-300">
                            <span class="flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Cancel
                            </span>
                        </button>

                        <button type="submit"
                            class="px-8 py-3 bg-gradient-to-r from-primary to-red-600 text-white font-bold rounded-xl 
                            shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-300">
                            <span class="flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Save Changes
                            </span>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Info Card -->
            <div class="mt-6 bg-blue-50 border-l-4 border-blue-500 rounded-lg p-4">
                <div class="flex items-start gap-3">
                    <svg class="w-6 h-6 text-blue-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <h4 class="text-sm font-semibold text-blue-900 mb-1">Profile Information</h4>
                        <p class="text-xs text-blue-700">Make sure your profile information is up to date. This information will be used for research proposals and communications.</p>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Success Alert -->
    @if (session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: '{{ session('success') }}',
            confirmButtonColor: '#D31119',
            confirmButtonText: 'OK',
            timer: 3000,
            timerProgressBar: true,
            showClass: {
                popup: 'animate__animated animate__fadeInDown'
            },
            hideClass: {
                popup: 'animate__animated animate__fadeOutUp'
            }
        });
    </script>
    @endif

    <!-- Alpine.js for image preview -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

</body>

</html>