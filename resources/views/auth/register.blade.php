@extends('layouts.auth')

@section('title', 'إنشاء حساب جديد')

@section('content')
<div class="auth-body">
    <div class="auth-decoration decoration-1"></div>
    <div class="auth-decoration decoration-2"></div>
    
    <div class="auth-container register-container">
        <div class="auth-header">
            <h2><i class="fas fa-user-plus me-2"></i>إنشاء حساب جديد</h2>
            <p>انضم إلى أكاديمية المهارات الرقمية وابدأ رحلة التعلم</p>
        </div>
        
        <div class="auth-content">
            <div class="auth-progress">
                <div class="auth-progress-bar" id="form-progress"></div>
            </div>
            
            <form method="POST" action="{{ route('register') }}" class="auth-form" id="register-form">
                @csrf
                
                <div class="form-group">
                    <label for="name" class="form-label">الاسم الكامل</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="أدخل اسمك الكامل">
                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="email" class="form-label">البريد الإلكتروني</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="example@email.com">
                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- حقل رقم الهاتف الجديد -->
                <div class="form-group">
                    <label for="phone" class="form-label">رقم الهاتف</label>
                    <input type="tel" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone') }}" required autocomplete="tel" placeholder="مثال: 01XXXXXXXX" pattern="[0-9]{11}" title="يجب إدخال 11 أرقام بدون مسافات أو رموز">
                    @error('phone')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                    <small class="form-text text-muted">يجب أن يتكون رقم الهاتف من 11 أرقام (بدون مسافات أو رموز)</small>
                </div>
                
                <div class="form-group password-toggle">
                    <label for="password" class="form-label">كلمة المرور</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required autocomplete="new-password" placeholder="أدخل كلمة مرور قوية">
                    <span class="password-toggle-icon" onclick="togglePassword('password')">
                        <i class="fas fa-eye"></i>
                    </span>
                    @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                    <div class="password-strength" id="password-strength">قوة كلمة المرور: <span id="password-strength-text">ضعيفة</span></div>
                </div>
                
                <div class="form-group password-toggle">
                    <label for="password-confirm" class="form-label">تأكيد كلمة المرور</label>
                    <input type="password" class="form-control" id="password-confirm" name="password_confirmation" required autocomplete="new-password" placeholder="أعد إدخال كلمة المرور">
                    <span class="password-toggle-icon" onclick="togglePassword('password-confirm')">
                        <i class="fas fa-eye"></i>
                    </span>
                    <div class="password-match" id="password-match" style="display: none; color: var(--danger); font-size: 0.8rem; margin-top: 5px;">كلمات المرور غير متطابقة</div>
                </div>
                
                <div class="terms-check">
                    <input type="checkbox" class="form-check-input" id="terms" required>
                    <label class="form-check-label" for="terms">
                        أوافق على <a href="#">الشروط والأحكام</a> و <a href="#">سياسة الخصوصية</a>
                    </label>
                </div>
                
                <button type="submit" class="btn btn-auth" id="register-btn">
                    <span class="btn-text">إنشاء حساب</span>
                    <div class="btn-loading" style="display: none;">
                        <i class="fas fa-spinner fa-spin"></i> جاري إنشاء الحساب...
                    </div>
                </button>
            </form>
        </div>
        
        <div class="auth-footer">
            <p>لديك حساب بالفعل؟ <a href="{{ route('login') }}">تسجيل الدخول</a></p>
        </div>
    </div>
</div>

@section('scripts')
<script>
    function togglePassword(inputId) {
        const passwordInput = document.getElementById(inputId);
        const icon = passwordInput.nextElementSibling.querySelector('i');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
    
    // التحقق من قوة كلمة المرور
    document.getElementById('password').addEventListener('input', function() {
        const password = this.value;
        const strengthText = document.getElementById('password-strength-text');
        const strengthBar = document.getElementById('form-progress');
        let strength = 0;
        
        if (password.length >= 8) strength += 25;
        if (password.match(/[a-z]/) && password.match(/[A-Z]/)) strength += 25;
        if (password.match(/\d/)) strength += 25;
        if (password.match(/[^a-zA-Z\d]/)) strength += 25;
        
        strengthBar.style.width = strength + '%';
        
        if (strength < 50) {
            strengthText.textContent = 'ضعيفة';
            strengthText.style.color = 'var(--danger)';
            strengthBar.style.background = 'var(--danger)';
        } else if (strength < 75) {
            strengthText.textContent = 'متوسطة';
            strengthText.style.color = 'var(--warning)';
            strengthBar.style.background = 'var(--warning)';
        } else {
            strengthText.textContent = 'قوية';
            strengthText.style.color = 'var(--success)';
            strengthBar.style.background = 'var(--success)';
        }
    });
    
    // التحقق من تطابق كلمات المرور
    document.getElementById('password-confirm').addEventListener('input', function() {
        const password = document.getElementById('password').value;
        const confirmPassword = this.value;
        const matchMessage = document.getElementById('password-match');
        
        if (confirmPassword && password !== confirmPassword) {
            matchMessage.style.display = 'block';
        } else {
            matchMessage.style.display = 'none';
        }
    });

    // تنسيق رقم الهاتف تلقائياً
    document.getElementById('phone').addEventListener('input', function(e) {
        // إزالة أي محارف غير رقمية
        let value = e.target.value.replace(/\D/g, '');
        
        // تحديد الحد الأقصى لطول رقم الهاتف (  11 أرقام)
        if (value.length > 11) {
            value = value.substring(0, 11);
        }
        
        // تحديث قيمة الحقل بالأرقام فقط
        e.target.value = value;
        
        // إظهار تلميح بصيغة 01X XXX XXXX عند الكتابة
        if (value.length > 0) {
            e.target.setAttribute('placeholder', '01X XXX XXXX');
        } else {
            e.target.setAttribute('placeholder', 'مثال: 01XXXXXXXX');
        }
    });
    
    // التحقق من صحة رقم الهاتف قبل الإرسال
    document.getElementById('register-form').addEventListener('submit', function(e) {
        const phoneInput = document.getElementById('phone');
        const phoneValue = phoneInput.value.replace(/\D/g, '');
        
        // التحقق من أن رقم الهاتف يحتوي على 11 أرقام
        if (phoneValue.length !== 11) {
            e.preventDefault();
            alert('رقم الهاتف يجب أن يتكون من 11 أرقام');
            phoneInput.focus();
            return false;
        }
        
        // التحقق من أن رقم الهاتف يبدأ بـ 01
        if (!phoneValue.startsWith('01')) {
            e.preventDefault();
            alert('رقم الهاتف يجب أن يبدأ بـ 01');
            phoneInput.focus();
            return false;
        }
        
        // إظهار تأثير التحميل
        const btn = document.getElementById('register-btn');
        btn.disabled = true;
        btn.querySelector('.btn-text').style.display = 'none';
        btn.querySelector('.btn-loading').style.display = 'block';
    });
</script>
@endsection
@endsection