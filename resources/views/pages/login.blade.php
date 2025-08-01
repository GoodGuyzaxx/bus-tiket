@extends('layouts.login')

@section('title')
    Login
@endsection

@section('content')
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: #f8fafc;
            min-height: 100vh;
            color: #334155;
        }

        .my-login-page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .card-wrapper {
            width: 100%;
            max-width: 400px;
        }

        .card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            border: 1px solid #e2e8f0;
            overflow: hidden;
        }

        .card-body {
            padding: 2.5rem 2rem;
        }

        .card-title {
            font-size: 1.875rem;
            font-weight: 700;
            color: #1e293b;
            text-align: center;
            margin-bottom: 2rem;
            letter-spacing: -0.025em;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            color: #374151;
            margin-bottom: 0.5rem;
        }

        .form-control {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1.5px solid #d1d5db;
            border-radius: 8px;
            font-size: 1rem;
            background: white;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
            outline: none;
            position: relative;
            z-index: 1;
        }

        .form-control:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .form-control.is-invalid {
            border-color: #ef4444;
        }

        .form-control.is-invalid:focus {
            border-color: #ef4444;
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
        }

        .password-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .password-wrapper .form-control {
            padding-right: 3rem;
        }

        .password-toggle {
            position: absolute;
            right: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #6b7280;
            cursor: pointer;
            padding: 0.25rem;
            border-radius: 4px;
            transition: color 0.2s ease;
            z-index: 2;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .password-toggle:hover {
            color: #374151;
        }

        .btn-login {
            width: 100%;
            background: #3b82f6;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 0.75rem 1rem;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            margin-top: 0.5rem;
        }

        .btn-login:hover {
            background: #2563eb;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
        }

        .btn-login:active {
            transform: translateY(0);
            box-shadow: 0 2px 4px rgba(59, 130, 246, 0.4);
        }

        .invalid-feedback {
            color: #ef4444;
            font-size: 0.875rem;
            margin-top: 0.25rem;
            display: block;
        }

        /* Responsive design */
        @media (max-width: 640px) {
            .card-wrapper {
                margin: 1rem;
            }

            .card-body {
                padding: 2rem 1.5rem;
            }

            .card-title {
                font-size: 1.5rem;
            }
        }

        /* Loading state */
        .btn-login.loading {
            position: relative;
            color: transparent;
            pointer-events: none;
        }

        .btn-login.loading::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 20px;
            height: 20px;
            margin: -10px 0 0 -10px;
            border: 2px solid transparent;
            border-top: 2px solid white;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Ensure inputs work properly */
        input[type="email"],
        input[type="password"],
        input[type="text"] {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            background-color: white;
        }

        input[type="email"]:focus,
        input[type="password"]:focus,
        input[type="text"]:focus {
            outline: none;
        }
    </style>

    <!-- ======= main ======= -->
    <section class="my-login-page">
        <div class="container">
            <div class="row justify-content-center">
                <div class="card-wrapper">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Sign In</h4>
                            <form action="{{route('login.submit')}}" method="POST" novalidate="" id="loginForm">
                                @csrf

                                <div class="form-group">
                                    <label for="email" class="form-label">Email</label>
                                    <input
                                        id="email"
                                        type="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        name="email"
                                        value="{{ old('email') }}"
                                        required
                                        autofocus
                                        placeholder="Enter your email"
                                        autocomplete="email"
                                    />
                                    @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="password" class="form-label">Password</label>
                                    <div class="password-wrapper">
                                        <input
                                            id="password"
                                            type="password"
                                            class="form-control @error('password') is-invalid @enderror"
                                            name="password"
                                            required
                                            placeholder="Enter your password"
                                            autocomplete="current-password"
                                        />
                                        <button type="button" class="password-toggle" onclick="togglePassword()">
                                            <svg id="eye-open" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                                <circle cx="12" cy="12" r="3"></circle>
                                            </svg>
                                            <svg id="eye-closed" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display: none;">
                                                <path d="m9.88 9.88a3 3 0 1 0 4.24 4.24"></path>
                                                <path d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 11 8 11 8a13.16 13.16 0 0 1-1.67 2.68"></path>
                                                <path d="M6.61 6.61A13.526 13.526 0 0 0 1 12s4 8 11 8a9.74 9.74 0 0 0 5.39-1.61"></path>
                                                <line x1="2" y1="2" x2="22" y2="22"></line>
                                            </svg>
                                        </button>
                                    </div>
                                    @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-login" id="loginBtn">
                                    Sign In
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        // Password toggle functionality
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeOpen = document.getElementById('eye-open');
            const eyeClosed = document.getElementById('eye-closed');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeOpen.style.display = 'none';
                eyeClosed.style.display = 'block';
            } else {
                passwordInput.type = 'password';
                eyeOpen.style.display = 'block';
                eyeClosed.style.display = 'none';
            }
        }

        // Form submission with loading state
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const btn = document.getElementById('loginBtn');
            btn.classList.add('loading');

            // Remove loading state if form validation fails
            setTimeout(() => {
                if (!this.checkValidity()) {
                    btn.classList.remove('loading');
                }
            }, 100);
        });

        // Simple validation feedback
        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll('.form-control');

            inputs.forEach(input => {
                input.addEventListener('input', function() {
                    if (this.classList.contains('is-invalid') && this.value.trim() !== '') {
                        this.classList.remove('is-invalid');
                        const feedback = this.parentNode.querySelector('.invalid-feedback');
                        if (feedback) {
                            feedback.style.display = 'none';
                        }
                    }
                });
            });
        });
    </script>
@endsection
