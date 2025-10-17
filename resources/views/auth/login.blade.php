@extends('layout.auth')

@section('title', 'Login - BZ IT Solutions')

@section('content')
    <div class="min-h-screen flex flex-col relative"
        style="background: url('{{ asset('assets/img/login/login-bg.jpg') }}') no-repeat center/cover; background-attachment: scroll;">
        <!-- Overlay Gradient -->
        <div class="absolute inset-0"
            style="background: linear-gradient(to right, rgba(239, 238, 238, 1), rgba(255, 255, 255, 0.8), rgba(255, 255, 255, 0));">
        </div>

        <!-- Main Content -->
        <div class="flex-grow relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-0 min-h-screen md:px-24">

                <!-- Empty left space (col-1) - hidden on mobile -->
                <div class="hidden md:block md:col-span-1"></div>

                <!-- Welcome Section (col-2 toY col-7) -->
                <div class="col-span-1 md:col-span-6 flex items-center justify-center p-8 md:p-0 js-anim-welcome">
                    <div class="w-full space-y-6 ani-fade" style="--ani-delay:80ms">
                        <div class="space-y-3">
                            <div class="inline-block">
                                <span
                                    class="px-3 py-1 rounded-full bg-primary/10 text-primary text-xs font-semibold">Welcome
                                    Back 👋</span>
                            </div>
                            <h3 class="text-4xl md:text-5xl font-light" style="color: #2B2B2B;">Welcome to</h3>
                            <h2 class="text-5xl md:text-7xl font-bold text-primary tracking-tight leading-tight">
                                BZ IT<br />Solutions
                            </h2>
                        </div>
                        <p class="text-base md:text-lg font-light max-w-lg leading-relaxed" style="color: #666;">
                            Access your secure portal to manage inventory, track sales,
                            and streamline your business operations efficiently.
                        </p>

                        <!-- Feature List -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-4">
                            <div class="flex items-center gap-3 js-anim-feature" style="--ani-delay:160ms">
                                <div
                                    class="h-8 w-8 rounded-lg bg-primary/10 flex-shrink-0 flex items-center justify-center mt-0.5">
                                    <svg class="h-4 w-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                                <span class="text-sm" style="color: #2B2B2B;">Real-Time Inventory Management</span>
                            </div>
                            <div class="flex items-center gap-3 js-anim-feature" style="--ani-delay:240ms">
                                <div
                                    class="h-8 w-8 rounded-lg bg-primary/10 flex-shrink-0 flex items-center justify-center mt-0.5">
                                    <svg class="h-4 w-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                                <span class="text-sm" style="color: #2B2B2B;">Point of Sales System</span>
                            </div>
                            <div class="flex items-center gap-3 js-anim-feature" style="--ani-delay:320ms">
                                <div
                                    class="h-8 w-8 rounded-lg bg-primary/10 flex-shrink-0 flex items-center justify-center mt-0.5">
                                    <svg class="h-4 w-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                                <span class="text-sm" style="color: #2B2B2B;">Service Automation Process</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Login Form Section (col-8 to col-11) -->
                <div class="col-span-1 md:col-span-4 flex items-center justify-center p-8 md:p-0">
                    <div class="w-full max-w-md">
                        <div class="bg-white rounded-lg shadow-2xl p-8 backdrop-blur-sm ani-pop js-anim-form"
                            style="box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1); --ani-delay:200ms">
                            <div class="mb-4">
                                <h3 class="text-2xl md:text-3xl font-bold text-primary mb-2">Sign In</h3>
                                <p class="text-sm" style="color: #666;">Access your dashboard securely</p>
                            </div>

                            <div class="space-y-5">
                                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                                    @csrf
                                    <!-- Username Input -->
                                    <div class="space-y-2">
                                        <label for="username" class="block text-xs md:text-sm font-semibold"
                                            style="color: #2B2B2B;">Username</label>
                                        <input type="text" id="username" name="username" required autocomplete="username"
                                            class="w-full px-4 py-3 rounded-lg border-2 transition-all duration-200 font-poppins text-xs md:text-sm"
                                            style="border-color: #E0E0E0; color: #2B2B2B;" placeholder="Enter your username"
                                            onfocus="this.style.borderColor='#2F7D6D';"
                                            onblur="this.style.borderColor='#E0E0E0';">
                                    </div>

                                    <!-- Password Input -->
                                    <div class="space-y-2">
                                        <label for="password" class="block text-xs md:text-sm font-semibold"
                                            style="color: #2B2B2B;">Password</label>
                                        <input type="password" id="password" name="password" required
                                            autocomplete="current-password"
                                            class="w-full px-4 py-3 rounded-lg border-2 transition-all duration-200 font-poppins text-xs md:text-sm"
                                            placeholder="Enter your password" onfocus="this.style.borderColor='#2F7D6D';"
                                            onblur="this.style.borderColor='#E0E0E0';">
                                    </div>

                                    <!-- Remember Me Checkbox -->
                                    <div class="flex items-center gap-4">
                                        <div class="flex items-start mb-3 font-poppins">
                                            <input id="terms" type="checkbox" name="terms" value="1" required class="mt-1 h-4 w-4 appearance-none rounded border border-gray-300 cursor-pointer 
                                                     transition-all duration-200 ease-in-out
                                                     checked:bg-[#2F7D6D] checked:border-[#2F7D6D]
                                                     checked:[&:after]:content-['✔'] checked:[&:after]:text-white 
                                                     checked:[&:after]:text-[10px] checked:[&:after]:flex checked:[&:after]:items-center 
                                                     checked:[&:after]:justify-center focus:ring-2 focus:ring-primary" />
                                            <label for="terms" class="ml-2 text-sm text-gray-700">
                                                I agree to
                                                <a href="#" class="text-primary font-semibold hover:underline">Terms of
                                                    Service</a>
                                                and
                                                <a href="#" class="text-primary font-semibold hover:underline">Privacy
                                                    Policy</a>
                                            </label>
                                        </div>
                                    </div>

                                    <!-- Sign In Button -->
                                    <button type="submit"
                                        class="w-full bg-primary hover:bg-primary/90 text-white font-semibold py-3 px-6 rounded-lg transition-all duration-300 transform hover:scale-[1.02] active:scale-95 shadow-lg hover:shadow-xl font-poppins ani-fade"
                                        style="--ani-delay:520ms">
                                        Sign In
                                    </button>

                                    <!-- Need Help divider -->
                                    <div class="flex items-center gap-4 my-4">
                                        <div class="flex-1 border-t border-gray-200"></div>
                                        <div class="text-xs text-gray-500 px-2">Need Help?</div>
                                        <div class="flex-1 border-t border-gray-200"></div>
                                    </div>

                                    <!-- Contact Support Button (outlined secondary) -->
                                    <div class="text-center">
                                        <a href="tel:+1234567890"
                                            class="inline-flex items-center gap-2 px-4 py-2 border rounded-lg text-sm font-medium transition-colors duration-200 hover:bg-gray-50"
                                            style="border-color: rgba(47,125,109,0.2); color: #2F7D6D;">
                                            <!-- Phone icon -->
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M22 16.92v3a2 2 0 01-2.18 2 19.86 19.86 0 01-8.63-3.07A19.51 19.51 0 014.11 9.81 19.86 19.86 0 011 1.18 2 2 0 013 0h3a2 2 0 012 1.72c.12.81.3 1.6.55 2.35a2 2 0 01-.45 2.11L7 8a16 16 0 007 7l1.82-1.11a2 2 0 012.11-.45c.75.25 1.54.43 2.35.55A2 2 0 0122 16.92z" />
                                            </svg>
                                            Contact Support
                                        </a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Empty right space (col-12) - hidden on mobile -->
                <div class="hidden md:block md:col-span-1"></div>

            </div>
        </div>

        <!-- Footer -->
        <footer class="mt-auto relative z-10 mx-0 backdrop-blur-lg ani-fade-slow"
            style="--ani-delay:640ms; background: radial-gradient(ellipse at center, rgba(255, 255, 255, 1) 0%, rgba(255, 255, 255, 0.95) 40%, rgba(47, 125, 109, 0.05) 100%); border-top: 1px solid rgba(47, 125, 109, 0.15);">
            <!-- Wavy Divider -->
            <svg class="w-full h-auto" viewBox="0 0 1200 100" preserveAspectRatio="none" style="display: block;">
                <defs>
                    <linearGradient id="waveGradient" x1="0%" y1="0%" x2="0%" y2="100%">
                        <stop offset="0%" style="stop-color: #2F7D6D; stop-opacity: 1" />
                        <stop offset="100%" style="stop-color: #2F7D6D; stop-opacity: 0.8" />
                    </linearGradient>
                </defs>
                <path d="M0,30 Q300,10 600,30 T1200,30 L1200,0 L0,0 Z" fill="url(#waveGradient)" />
                <path d="M0,40 Q300,20 600,40 T1200,40 L1200,30 Q600,50 0,30 Z" fill="#2F7D6D" opacity="0.5" />
            </svg>
            <div class="w-full">
                <!-- Main Content Section -->
                <div class="max-w-7xl mx-auto py-10 md:py-5 px-4 md:px-8 lg:px-12">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12 lg:gap-16 justify-center">
                        <!-- Company Info & Badges -->
                        <div class="col-span-1 text-center md:text-left">
                            <div class="flex md:flex-row flex-col items-center md:items-start gap-4 mb-8">
                                <img src="{{ asset('assets/img/logo/bz-logo-green.png') }}" alt="BZ IT Solutions"
                                    class="h-24 w-auto object-contain flex-shrink-0">
                                <div>
                                    <h5 class="text-primary font-bold text-lg mb-2">BZ IT Solutions</h5>
                                    <p class="text-sm leading-relaxed mb-3" style="color: #2B2B2B;">Affordable Computer and
                                        CCTV store that caters Mindanao.</p>
                                </div>
                            </div>

                            <!-- Badges -->
                            <div class="flex flex-wrap gap-2.5 justify-center md:justify-start">
                                <span
                                    class="inline-flex items-center gap-2 bg-primary/10 text-primary px-3 py-1.5 rounded-full text-xs font-semibold border border-primary/20 hover:bg-primary/20 transition-colors duration-200">
                                    <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Secure & Trusted
                                </span>
                                <span
                                    class="inline-flex items-center gap-2 bg-primary/10 text-primary px-3 py-1.5 rounded-full text-xs font-semibold border border-primary/20 hover:bg-primary/20 transition-colors duration-200">
                                    <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Premium Services
                                </span>
                                <span
                                    class="inline-flex items-center gap-2 bg-primary/10 text-primary px-3 py-1.5 rounded-full text-xs font-semibold border border-primary/20 hover:bg-primary/20 transition-colors duration-200">
                                    <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.381-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    Excellent After Sales Support
                                </span>
                            </div>
                        </div>

                        <!-- Contact Information -->
                        <div class="col-span-1 md:col-span-1 lg:col-span-1 text-center md:text-left">
                            <h6 class="font-semibold text-sm mb-6 uppercase tracking-wide" style="color: #2B2B2B;">Contact
                                Us</h6>
                            <div class="space-y-5">
                                <div>
                                    <p class="text-xs uppercase tracking-wider font-medium mb-1.5" style="color: #666;">
                                        Email</p>
                                    <a href="mailto:bzitsolutionsdvo@gmail.com"
                                        class="text-sm text-primary hover:text-primary/80 transition-colors break-all font-medium">bzitsolutionsdvo@gmail.com</a>
                                </div>
                                <div>
                                    <p class="text-xs uppercase tracking-wider font-medium mb-2" style="color: #666;">
                                        Locations</p>
                                    <p class="text-xs leading-relaxed" style="color: #666;">Davao • Gensan • Koronadal</p>
                                </div>
                            </div>
                        </div>

                        <!-- Social Media -->
                        <div class="col-span-1 md:col-span-1 lg:col-span-1 text-center md:text-left">
                            <h6 class="font-semibold text-sm mb-6 uppercase tracking-wide" style="color: #2B2B2B;">Follow Us
                            </h6>
                            <div class="flex flex-wrap gap-3 justify-center md:justify-start">
                                <a href="#" title="Facebook"
                                    class="h-12 w-12 rounded-full bg-primary/10 border-2 border-primary/30 hover:border-primary/60 text-primary hover:text-primary hover:bg-primary/20 flex items-center justify-center transition-all duration-300 hover:shadow-lg hover:scale-110 group">
                                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5c-.563-.074-1.396-.236-2.545-.236-2.564 0-4.455 1.565-4.455 4.432v1.804z" />
                                    </svg>
                                </a>
                                <a href="#" title="Instagram"
                                    class="h-12 w-12 rounded-full bg-primary/10 border-2 border-primary/30 hover:border-primary/60 text-primary hover:text-primary hover:bg-primary/20 flex items-center justify-center transition-all duration-300 hover:shadow-lg hover:scale-110 group">
                                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.69.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zM5.838 12a6.162 6.162 0 1112.324 0 6.162 6.162 0 01-12.324 0zM12 16a4 4 0 110-8 4 4 0 010 8zm4.965-10.322a1.44 1.44 0 110 2.881 1.44 1.44 0 010-2.881z" />
                                    </svg>
                                </a>
                                <a href="#" title="Twitter"
                                    class="h-12 w-12 rounded-full bg-primary/10 border-2 border-primary/30 hover:border-primary/60 text-primary hover:text-primary hover:bg-primary/20 flex items-center justify-center transition-all duration-300 hover:shadow-lg hover:scale-110 group">
                                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2s9 5 20 5a9.5 9.5 0 00-9-5.5c4.75 2.25 7-7 7-7s-1.5 4.5-4 6.5z" />
                                    </svg>
                                </a>
                            </div>
                            <p class="text-xs mt-4" style="color: #666;">Follow us for updates and latest offerings</p>
                        </div>
                    </div>
                </div>

                <!-- Divider Line -->
                <div class="border-t border-gray-200"></div>

                <!-- Bottom Section -->
                <div class="max-w-7xl mx-auto py-8 px-4 md:px-8 lg:px-12">
                    <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                        <p class="text-xs text-center md:text-left" style="color: #666;">
                            &copy; 2025 BZ IT Solutions. All rights reserved.
                        </p>
                        <div class="flex gap-6 text-xs">
                            <a href="#" class="text-primary hover:underline transition-colors">Privacy Policy</a>
                            <span style="color: #ddd;">•</span>
                            <a href="#" class="text-primary hover:underline transition-colors">Terms of Service</a>
                            <span style="color: #ddd;">•</span>
                            <span style="color: #999;">v1.0.0</span>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
@endsection