@extends('layouts.auth')

@section('title', 'تسجيل الدخول')

@section('content')
<div class="auth-body">
    <div class="auth-container">
        <div class="auth-header">
            <h2><i class="fas fa-graduation-cap me-2"></i>أكاديمية المهارات</h2>
            <p>لوحة تسجيل الدخول</p>
        </div>
        
        <div class="auth-content">
            <form method="POST" action="{{ route('login') }}" class="auth-form">
                @csrf
                
                <div class="mb-3">
                    <label for="email" class="form-label">البريد الإلكتروني</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="password" class="form-label">كلمة المرور</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required autocomplete="current-password">
                    @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                
                <div class="auth-options">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember">تذكرني</label>
                    </div>
                    
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}">نسيت كلمة المرور؟</a>
                    @endif
                </div>
                
                <button type="submit" class="btn btn-auth">تسجيل الدخول</button>
            </form>
        </div>
        
        <div class="auth-footer">
            <p>ليس لديك حساب؟ <a href="{{ route('register') }}">إنشاء حساب جديد</a></p>
        </div>
    </div>
</div>
@endsection