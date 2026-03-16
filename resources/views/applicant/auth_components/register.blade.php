@extends('applicant.auth_layouts.main')

@section('title', 'Login Portal For User | ' . config('config-system.app_name'))

@section('content')
    <style>
        /* Captcha image fade */
        .captcha-image {
            display: inline-block;
            transition: opacity 0.3s ease;
        }

        .fade-out {
            opacity: 0;
        }

        .fade-in {
            opacity: 1;
        }

        /* Loader */
        .captcha-loader {
            width: 28px;
            height: 28px;
            border: 3px solid #e5e7eb;
            border-top: 3px solid #6366f1;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        /* Refresh button */
        .captcha-refresh-btn {
            cursor: pointer;
            transition: transform 0.25s ease;
        }


        /* Spinner animation */
        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        .d-none {
            display: none;
        }
    </style>
    <div class="glass-form">
        <!-- Administration Header with Logo and Title -->
        <div class="administration-header">
            <!-- Left Side: App Title -->
            <div class="administration-title">
                <h1>{{ config('config-system.app_name') }}</h1>
            </div>

            <!-- Right Side: Logo -->
            <div class="administration-logo">
                <img src="{{ asset(config('config-system.logo')) }}" alt="{{ config('config-system.app_name') }} Logo"
                    class="img-fluid" loading="lazy" width="60" height="60">
            </div>
        </div>

        <!-- Welcome Message -->
        <div class="page-header">
            <p>Please sign in to access your dashboard</p>
        </div>

        <!-- Error Alert -->
        @if (session('LoginError'))
            <div class="alert alert-danger" role="alert">
                {{ session('LoginError') }}
            </div>
        @endif

        <!-- Success Alert (if needed) -->
        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <!-- Login Form -->
        <form action="{{ route('login.submit') }}" method="POST" autocomplete="on">
            @csrf

            <!-- Email/Username Field -->
            <div class="form-group">
                <label class="form-label" for="username">
                    Username (E-mail) <span class="text-danger">*</span>
                </label>
                <div class="input-group">
                    <div class="input-group-text" aria-label="User icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                    </div>
                    <input type="email" name="username" class="form-control @error('username') is-invalid @enderror"
                        id="username" placeholder="Enter your email address" value="{{ old('username') }}" required
                        autocomplete="email" aria-label="Username or Email" aria-required="true">
                </div>
                @error('username')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- Password Field -->
            <div class="form-group">
                <label class="form-label" for="password">
                    Password <span class="text-danger">*</span>
                </label>
                <div class="input-group">
                    <div class="input-group-text" aria-label="Lock icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                        </svg>
                    </div>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                        id="password" placeholder="Enter your password" required autocomplete="current-password"
                        aria-label="Password" aria-required="true">

                    <!-- Toggle Password Visibility Button -->
                    <button type="button" id="togglePassword" class="input-group-text"
                        aria-label="Toggle password visibility">
                        <!-- Eye Icon (Show Password) -->
                        <svg id="eyeOpen" style="display: none;" xmlns="http://www.w3.org/2000/svg" width="20"
                            height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg>

                        <!-- Eye Slash Icon (Hide Password) -->
                        <svg id="eyeSlash" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path
                                d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24">
                            </path>
                            <line x1="1" y1="1" x2="23" y2="23"></line>
                        </svg>
                    </button>
                </div>
                @error('password')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- Add this message container near your CAPTCHA field -->
            <div class="form-group mt-3">
                <label class="form-label">
                    Captcha <span class="text-danger">*</span>
                </label>

                <div class="input-group captcha-group">
                    <!-- Captcha Image -->
                    <span class="input-group-text p-1 bg-white">
                        <span id="captcha-img" class="captcha-image">

                        </span>

                        <!-- Loader -->
                        <span id="captcha-loader" class="captcha-loader d-none"></span>
                    </span>

                    <!-- Captcha Input -->
                    <input type="text" name="captcha" class="form-control" placeholder="Enter captcha"
                        maxlength="5" required aria-label="Captcha input">

                    <!-- Refresh Button -->
                    <button type="button" class="input-group-text captcha-refresh-btn" id="reload-captcha"
                        aria-label="Refresh captcha" title="Refresh CAPTCHA">
                        &#x21bb;
                    </button>
                </div>

                <!-- Message container for CAPTCHA validation -->
                <div id="captcha-message" class="captcha-message mt-2" style="display: none;"></div>

                @error('captcha')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>


            <!-- Remember Me Checkbox (Optional) -->
            {{-- Uncomment if you want a Remember Me option
            <div class="form-group">
                <div class="form-check">
                    <input class="form-check-input" 
                        type="checkbox" 
                        name="remember" 
                        id="remember"
                        {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label" for="remember">
                        Remember me
                    </label>
                </div>
            </div>
            --}}

            <!-- Sign In Button -->
            <div class="form-group mt-4">
                <button type="submit" class="btn btn-primary w-100">
                    <span>Sign In</span>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M12.2929 4.29289C12.6834 3.90237 13.3166 3.90237 13.7071 4.29289L20.7071 11.2929C21.0976 11.6834 21.0976 12.3166 20.7071 12.7071L13.7071 19.7071C13.3166 20.0976 12.6834 20.0976 12.2929 19.7071C11.9024 19.3166 11.9024 18.6834 12.2929 18.2929L17.5858 13H4C3.44772 13 3 12.5523 3 12C3 11.4477 3.44772 11 4 11H17.5858L12.2929 5.70711C11.9024 5.31658 11.9024 4.68342 12.2929 4.29289Z"
                            fill="currentColor">
                        </path>
                    </svg>
                </button>
            </div>
        </form>

        <!-- Forgot Password Link -->
        <div class="text-center mt-3">
            <a href="{{ route('forgot-password') }}" class="text-decoration-none" aria-label="Forgot password link">
                <svg fill="currentColor" height="16px" width="16px" viewBox="0 0 512 512"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M499.5,385.4L308.9,57.2c-31.8-52.9-74.1-52.9-105.9,0L12.5,385.4c-31.8,52.9,0,95.3,63.5,95.3h360 C499.5,480.7,531.3,438.3,499.5,385.4z M298.4,438.3h-84.7v-84.7h84.7V438.3z M298.4,311.3h-84.7V120.7h84.7V311.3z">
                    </path>
                </svg>
                <span>Forgot Password?</span>
            </a>
        </div>

        <!-- Additional Links (Optional) -->
        {{-- Uncomment if you need registration or help links
    <div class="form-group text-center mt-2">
        <small class="text-muted">
            Don't have an account? 
            <a href="{{ route('register') }}" class="text-primary">Sign up</a>
        </small>
    </div>
    --}}
    </div>
@endsection
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');
            const eyeOpen = document.getElementById('eyeOpen');
            const eyeSlash = document.getElementById('eyeSlash');

            if (togglePassword && passwordInput && eyeOpen && eyeSlash) {
                togglePassword.addEventListener('click', function() {
                    // Toggle password visibility
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);

                    // Toggle icon visibility
                    if (type === 'text') {
                        eyeOpen.style.display = 'block';
                        eyeSlash.style.display = 'none';
                    } else {
                        eyeOpen.style.display = 'none';
                        eyeSlash.style.display = 'block';
                    }
                });
            }
        });
    </script>
    <script>
        // captcha.js

        class CaptchaManager {
            constructor() {
                this.captchaCode = '';
                this.formSubmitTime = null;
                this.minTimeToSubmit = 3000; // Minimum 3 seconds to fill the form
                this.fontsDirectory = '/assets/fonts/';
                this.bgsDirectory = '/assets/backgrounds/';
                this.fontFile = 'arial.ttf'; // Your specific font
                this.backgroundFile = 'captcha-bg.jpg'; // Your specific background
                // Font colors array - each character gets a different color
                this.fontColors = [
                    '#000080', // Navy Blue
                    '#006400', // Dark Green
                    '#FF0000', // Red
                    '#e99903', // Orange
                    '#000000' // Black
                ];
                this.messageTimeout = null;

                this.init();
            }

            async init() {
                // Generate initial CAPTCHA
                this.generateCaptcha();

                // Set form submit time
                this.setFormSubmitTime();

                // Add event listeners
                this.addEventListeners();

                // Set background image and font for captcha box
                await this.setCaptchaStyle();

                // Create message container if it doesn't exist
                this.createMessageContainer();
            }

            createMessageContainer() {
                // Check if message container already exists
                let messageContainer = document.getElementById('captcha-message');

                if (!messageContainer) {
                    // Create message container
                    messageContainer = document.createElement('div');
                    messageContainer.id = 'captcha-message';
                    messageContainer.className = 'captcha-message mt-2';
                    messageContainer.style.display = 'none';

                    // Find where to insert the message (after the input group)
                    const captchaGroup = document.querySelector('.captcha-group');
                    if (captchaGroup && captchaGroup.parentNode) {
                        captchaGroup.parentNode.insertBefore(messageContainer, captchaGroup.nextSibling);
                    }
                }

                this.messageContainer = messageContainer;
            }

            showMessage(message, type = 'error') {
                // Clear any existing timeout
                if (this.messageTimeout) {
                    clearTimeout(this.messageTimeout);
                }

                // Set message content and style
                if (this.messageContainer) {
                    this.messageContainer.textContent = message;
                    this.messageContainer.style.display = 'block';
                    this.messageContainer.style.padding = '8px 12px';
                    this.messageContainer.style.borderRadius = '4px';
                    this.messageContainer.style.fontSize = '14px';

                    if (type === 'error') {
                        this.messageContainer.style.backgroundColor = '#f8d7da';
                        this.messageContainer.style.color = '#721c24';
                        this.messageContainer.style.border = '1px solid #f5c6cb';
                    } else if (type === 'success') {
                        this.messageContainer.style.backgroundColor = '#d4edda';
                        this.messageContainer.style.color = '#155724';
                        this.messageContainer.style.border = '1px solid #c3e6cb';
                    } else if (type === 'warning') {
                        this.messageContainer.style.backgroundColor = '#fff3cd';
                        this.messageContainer.style.color = '#856404';
                        this.messageContainer.style.border = '1px solid #ffeeba';
                    }

                    // Auto hide message after 5 seconds
                    this.messageTimeout = setTimeout(() => {
                        this.hideMessage();
                    }, 5000);
                }
            }

            hideMessage() {
                if (this.messageContainer) {
                    this.messageContainer.style.display = 'none';
                    this.messageContainer.textContent = '';
                }
            }

            generateCaptcha() {
                // Generate random 5-character CAPTCHA with mixed characters (including lowercase)
                const characters = 'ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz23456789';
                let captcha = '';
                for (let i = 0; i < 5; i++) {
                    captcha += characters.charAt(Math.floor(Math.random() * characters.length));
                }
                this.captchaCode = captcha;

                // Update CAPTCHA display with colored characters
                this.displayColoredCaptcha();

                // Store CAPTCHA in session storage for validation
                sessionStorage.setItem('captchaCode', this.captchaCode);
                sessionStorage.setItem('captchaTimestamp', Date.now().toString());

                return this.captchaCode;
            }

            displayColoredCaptcha() {
                const captchaImg = document.getElementById('captcha-img');
                if (!captchaImg) return;

                // Clear existing content
                captchaImg.innerHTML = '';

                // Split the captcha code into characters
                const characters = this.captchaCode.split('');

                // Create a span for each character with different color
                characters.forEach((char, index) => {
                    const span = document.createElement('span');
                    span.textContent = char;

                    // Apply color from fontColors array (cycle through colors)
                    const colorIndex = index % this.fontColors.length;
                    span.style.color = this.fontColors[colorIndex];

                    // Add random rotation for authentic CAPTCHA look
                    span.style.display = 'inline-block';
                    span.style.transform = `rotate(${Math.random() * 10 - 5}deg)`;
                    span.style.margin = '0 2px';
                    span.style.fontWeight = 'bold';
                    span.style.textShadow = '1px 1px 2px rgba(0,0,0,0.2)';

                    // Add slight variation in font size
                    span.style.fontSize = '33px';

                    captchaImg.appendChild(span);
                });
            }

            async setCaptchaStyle() {
                const captchaImg = document.getElementById('captcha-img');
                if (!captchaImg) return;

                // Load your specific font (arial.ttf)
                try {
                    const fontFace = new FontFace('CaptchaFont', `url(${this.fontsDirectory}${this.fontFile})`);
                    const font = await fontFace.load();
                    document.fonts.add(font);
                    // Apply font to captcha container
                    captchaImg.style.fontFamily = 'CaptchaFont, Arial, sans-serif';
                } catch (error) {
                    console.log('Failed to load custom font, using Arial');
                    captchaImg.style.fontFamily = 'Arial, monospace';
                }

                // Set background image
                const backgroundUrl = `${this.bgsDirectory}${this.backgroundFile}`;

                // Check if background image exists and load it
                const img = new Image();
                img.onload = () => {
                    // Background image loaded successfully
                    captchaImg.style.backgroundImage = `url('${backgroundUrl}')`;
                    captchaImg.style.backgroundColor = 'transparent'; // Remove background color since image loaded
                };

                img.onerror = () => {
                    // Background image failed to load, use background color instead
                    console.log('Background image not found, using background color');
                    captchaImg.style.backgroundImage = 'none';
                    captchaImg.style.backgroundColor = '#f0f0f0'; // Fallback light gray background
                };

                img.src = backgroundUrl;

                // Apply CAPTCHA container styling
                captchaImg.style.backgroundSize = 'cover';
                captchaImg.style.backgroundPosition = 'center';
                captchaImg.style.backgroundRepeat = 'no-repeat';
                captchaImg.style.backgroundBlendMode = 'overlay';
                captchaImg.style.display = 'flex';
                captchaImg.style.justifyContent = 'center';
                captchaImg.style.alignItems = 'center';
                captchaImg.style.padding = '10px 15px';
                captchaImg.style.borderRadius = '5px';
                captchaImg.style.minWidth = '150px';
                captchaImg.style.height = '60px';
                captchaImg.style.textAlign = 'center';
                captchaImg.style.lineHeight = '1.4';
                captchaImg.style.position = 'relative';
                captchaImg.style.overflow = 'hidden';
                captchaImg.style.border = '2px solid #ddd';

                // Add noise effect overlay
                this.addNoiseEffect(captchaImg);
            }

            addNoiseEffect(element) {
                // Remove any existing noise style
                const existingStyle = document.getElementById('captcha-noise-style');
                if (existingStyle) {
                    existingStyle.remove();
                }

                // Create a canvas for noise effect
                const canvas = document.createElement('canvas');
                const ctx = canvas.getContext('2d');

                // Set canvas size
                canvas.width = element.offsetWidth || 200;
                canvas.height = element.offsetHeight || 60;

                // Draw noise
                const imageData = ctx.createImageData(canvas.width, canvas.height);
                const data = imageData.data;

                for (let i = 0; i < data.length; i += 4) {
                    // Add random noise
                    const noise = Math.random() * 50;
                    data[i] = noise; // R
                    data[i + 1] = noise; // G
                    data[i + 2] = noise; // B
                    data[i + 3] = 20; // A (very low opacity)
                }

                ctx.putImageData(imageData, 0, 0);

                // Convert canvas to data URL and set as overlay
                const noiseDataUrl = canvas.toDataURL();

                // Create a style element for noise overlay
                const style = document.createElement('style');
                style.id = 'captcha-noise-style';
                style.textContent = `
            #captcha-img {
                position: relative;
                overflow: hidden;
            }
            #captcha-img::after {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-image: url('${noiseDataUrl}');
                opacity: 0.2;
                pointer-events: none;
                mix-blend-mode: multiply;
                z-index: 1;
            }
            #captcha-img span {
                position: relative;
                z-index: 2;
            }
        `;
                document.head.appendChild(style);
            }

            setFormSubmitTime() {
                this.formSubmitTime = Date.now();
                sessionStorage.setItem('formLoadTime', this.formSubmitTime.toString());
            }

            validateCaptcha(inputCaptcha) {
                const storedCaptcha = sessionStorage.getItem('captchaCode');
                // Case-sensitive comparison (exact match)
                return inputCaptcha === storedCaptcha;
            }

            validateSubmitTime() {
                const loadTime = parseInt(sessionStorage.getItem('formLoadTime'));
                const currentTime = Date.now();
                const timeDiff = currentTime - loadTime;

                // Check if form was submitted too quickly (possible bot)
                return timeDiff >= this.minTimeToSubmit;
            }

            refreshCaptcha() {
                // Show loader
                const loader = document.getElementById('captcha-loader');
                const captchaImg = document.getElementById('captcha-img');

                if (loader) loader.classList.remove('d-none');
                if (captchaImg) {
                    captchaImg.style.opacity = '0.5';
                }

                // Hide any existing messages
                this.hideMessage();

                // Simulate network delay for realistic refresh
                setTimeout(() => {
                    this.generateCaptcha();

                    // Hide loader
                    if (loader) loader.classList.add('d-none');
                    if (captchaImg) {
                        captchaImg.style.opacity = '1';

                        // Add animation effect
                        captchaImg.style.transform = 'scale(1.05)';
                        setTimeout(() => {
                            captchaImg.style.transform = 'scale(1)';
                        }, 200);
                    }
                }, 500);
            }

            addEventListeners() {
                // Refresh CAPTCHA button
                const refreshBtn = document.getElementById('reload-captcha');
                if (refreshBtn) {
                    refreshBtn.addEventListener('click', (e) => {
                        e.preventDefault();
                        this.refreshCaptcha();
                    });
                }

                // Form submit validation
                const form = document.querySelector('form');
                if (form) {
                    form.addEventListener('submit', (e) => {
                        e.preventDefault(); // Prevent actual submit for validation

                        const captchaInput = document.querySelector('input[name="captcha"]');

                        // Check if CAPTCHA is empty
                        if (!captchaInput.value) {
                            this.showMessage('Please enter the CAPTCHA code.', 'warning');
                            captchaInput.focus();
                            return;
                        }

                        // Validate submit time first
                        if (!this.validateSubmitTime()) {
                            this.showMessage('Form submitted too quickly. Please take your time.', 'warning');
                            this.refreshCaptcha();
                            captchaInput.value = '';
                            return;
                        }

                        // Validate CAPTCHA (case-sensitive)
                        if (!this.validateCaptcha(captchaInput.value)) {
                            // Show invalid message WITHOUT refreshing
                            this.showMessage('Invalid CAPTCHA. Please try again. (Case-sensitive)', 'error');
                            captchaInput.value = '';
                            captchaInput.focus();
                            return;
                        }

                        // If all validations pass, show success message and submit the form
                        this.showMessage('CAPTCHA validated successfully! Submitting form...', 'success');

                        // Small delay to show success message before submitting
                        setTimeout(() => {
                            form.submit();
                        }, 500);
                    });
                }

                // Add input animation and real-time validation hint
                const captchaInput = document.querySelector('input[name="captcha"]');
                if (captchaInput) {
                    captchaInput.addEventListener('input', (e) => {
                        const captchaImg = document.getElementById('captcha-img');
                        const inputValue = e.target.value;

                        // Pulse animation when input length reaches 5
                        if (inputValue.length === 5) {
                            captchaImg.style.animation = 'pulse 0.5s';
                            setTimeout(() => {
                                captchaImg.style.animation = '';
                            }, 500);
                        }
                    });

                    // Add focus event to clear messages
                    captchaInput.addEventListener('focus', () => {
                        this.hideMessage();
                    });

                    // Add blur event for validation hint
                    captchaInput.addEventListener('blur', (e) => {
                        if (e.target.value.length > 0 && e.target.value.length < 5) {
                            this.showMessage('CAPTCHA must be 5 characters.', 'warning');
                        }
                    });
                }
            }
        }

        // Add CSS animations
        const style = document.createElement('style');
        style.textContent = `
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.1); }
        100% { transform: scale(1); }
    }
    
    .captcha-image {
        position: relative;
        overflow: hidden;
        min-width: 150px;
        text-align: center;
        transition: all 0.3s ease;
        background-blend-mode: overlay;
        border: 2px solid #ddd;
    }
    
    .captcha-image::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
        animation: shine 3s infinite;
        pointer-events: none;
        z-index: 3;
    }
    
    @keyframes shine {
        to {
            left: 200%;
        }
    }
    
    .captcha-loader {
        width: 20px;
        height: 20px;
        border: 3px solid #f3f3f3;
        border-top: 3px solid #3498db;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        display: inline-block;
        margin-left: 10px;
    }
    
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    
    .captcha-refresh-btn {
        cursor: pointer;
        transition: transform 0.3s ease;
        background: #f8f9fa;
        border: 1px solid #ced4da;
    }

    
    .captcha-message {
        transition: opacity 0.3s ease;
    }
`;

        document.head.appendChild(style);

        // Initialize CAPTCHA manager when DOM is loaded
        document.addEventListener('DOMContentLoaded', () => {
            new CaptchaManager();
        });
    </script>
@endpush
