@extends('admin.layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center py-3">
        <h2 class="fw-bold mb-0">تعديل بيانات المدرب</h2>
        <a href="{{ route('admin.trainers.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i> رجوع
        </a>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <form action="{{ route('admin.trainers.update', $trainer->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <!-- العمود الأول -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">الاسم الكامل <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name', $trainer->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">البريد الإلكتروني <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email', $trainer->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label">رقم الهاتف <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                   id="phone" name="phone" value="{{ old('phone', $trainer->phone) }}" required>
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="expertise" class="form-label">التخصص <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('expertise') is-invalid @enderror" 
                                   id="expertise" name="expertise" value="{{ old('expertise', $trainer->expertise) }}" required>
                            @error('expertise')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- العمود الثاني -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="password" class="form-label">كلمة المرور (اتركه فارغاً إذا لم تريد التغيير)</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                   id="password" name="password">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">تأكيد كلمة المرور</label>
                            <input type="password" class="form-control" 
                                   id="password_confirmation" name="password_confirmation">
                        </div>

                        <div class="mb-3">
                            <label for="profile_photo" class="form-label">صورة الملف الشخصي</label>
                            @if($trainer->profile_photo_path)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $trainer->profile_photo_path) }}" alt="صورة المدرب" class="img-thumbnail" width="100">
                                </div>
                            @endif
                            <input type="file" class="form-control @error('profile_photo') is-invalid @enderror" 
                                   id="profile_photo" name="profile_photo" accept="image/*">
                            @error('profile_photo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">الصيغ المسموحة: JPG, PNG, GIF. الحجم الأقصى: 2MB</div>
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="is_approved" name="is_approved" value="1" {{ $trainer->is_approved ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_approved">تفعيل المدرب</label>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="bio" class="form-label">نبذة عن المدرب</label>
                    <textarea class="form-control @error('bio') is-invalid @enderror" 
                              id="bio" name="bio" rows="6">{{ old('bio', $trainer->bio) }}</textarea>
                    @error('bio')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i> حفظ التعديلات
                    </button>
                    <a href="{{ route('admin.trainers.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times me-2"></i> إلغاء
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
<style>
    .note-editor.note-frame {
        border: 1px solid #dee2e6;
        border-radius: 0.375rem;
        margin-top: 5px;
    }
    
    .note-editor.note-frame .note-toolbar {
        background-color: #f8f9fa;
        border-bottom: 1px solid #dee2e6;
        border-radius: 0.375rem 0.375rem 0 0;
        padding: 5px;
    }
    
    .note-btn {
        border: 1px solid #d1d5db;
        background: white;
        margin: 0 2px;
    }
    
    .note-btn:hover {
        background-color: #e9ecef;
    }
</style>
@endsection

@section('scripts')
<!-- jQuery مطلوب لـ Summernote -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Summernote Editor -->
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
<!-- اللغة العربية لـ Summernote -->
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/lang/summernote-ar-AR.min.js"></script>

<script>
    $(document).ready(function() {
        // تهيئة محرر Summernote
        $('#bio').summernote({
            lang: 'ar-AR', // اللغة العربية
            height: 200,   // الارتفاع
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'clear']],
                ['fontname', ['fontname']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ],
            placeholder: 'أدخل نبذة عن المدرب هنا...',
            callbacks: {
                onInit: function() {
                    console.log('Summernote is initialized');
                }
            }
        });
    });
</script>
@endsection