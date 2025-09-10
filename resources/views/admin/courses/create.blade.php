@extends('admin.layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">إضافة كورس جديد</h2>
        <a href="{{ route('admin.courses.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i> رجوع
        </a>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <form action="{{ route('admin.courses.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="title" class="form-label">عنوان الكورس <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                   id="title" name="title" value="{{ old('title') }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">وصف الكورس <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="5" required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="price" class="form-label">السعر (ج.م) <span class="text-danger">*</span></label>
                                    <input type="number" step="0.01" min="0" class="form-control @error('price') is-invalid @enderror" 
                                           id="price" name="price" value="{{ old('price', 0) }}" required>
                                    @error('price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="duration" class="form-label">المدة (ساعات)</label>
                                    <input type="number" min="1" class="form-control @error('duration') is-invalid @enderror" 
                                           id="duration" name="duration" value="{{ old('duration') }}">
                                    @error('duration')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="image" class="form-label">صورة الكورس</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                   id="image" name="image" accept="image/*">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">الصيغ المسموحة: JPG, PNG, GIF. الحجم الأقصى: 2MB</div>
                        </div>

                        <div class="mb-3">
                            <label for="category_id" class="form-label">التصنيف <span class="text-danger">*</span></label>
                            <select class="form-select @error('category_id') is-invalid @enderror" 
                                    id="category_id" name="category_id" required>
                                <option value="">اختر التصنيف...</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="trainer_id" class="form-label">المدرب</label>
                            <select class="form-select @error('trainer_id') is-invalid @enderror" 
                                    id="trainer_id" name="trainer_id">
                                <option value="">اختر المدرب...</option>
                                @foreach($trainers as $trainer)
                                    <option value="{{ $trainer->id }}" {{ old('trainer_id') == $trainer->id ? 'selected' : '' }}>
                                        {{ $trainer->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('trainer_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="instructor_name" class="form-label">أو اسم المدرب</label>
                            <input type="text" class="form-control @error('instructor_name') is-invalid @enderror" 
                                   id="instructor_name" name="instructor_name" value="{{ old('instructor_name') }}">
                            @error('instructor_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="level" class="form-label">المستوى</label>
                            <select class="form-select @error('level') is-invalid @enderror" 
                                    id="level" name="level">
                                <option value="">اختر المستوى...</option>
                                <option value="beginner" {{ old('level') == 'beginner' ? 'selected' : '' }}>مبتدئ</option>
                                <option value="intermediate" {{ old('level') == 'intermediate' ? 'selected' : '' }}>متوسط</option>
                                <option value="advanced" {{ old('level') == 'advanced' ? 'selected' : '' }}>متقدم</option>
                            </select>
                            @error('level')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="requires_approval" 
                                   name="requires_approval" value="1" {{ old('requires_approval', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="requires_approval">يتطلب موافقة للتسجيل</label>
                        </div>
                    </div>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i> حفظ الكورس
                    </button>
                    <a href="{{ route('admin.courses.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times me-2"></i> إلغاء
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const trainerSelect = document.getElementById('trainer_id');
        const instructorNameInput = document.getElementById('instructor_name');
        
        // عند تغيير اختيار المدرب، مسح اسم المدرب اليدوي
        trainerSelect.addEventListener('change', function() {
            if (this.value) {
                instructorNameInput.value = '';
            }
        });
        
        // عند كتابة اسم المدرب، مسح اختيار المدرب من القائمة
        instructorNameInput.addEventListener('input', function() {
            if (this.value) {
                trainerSelect.value = '';
            }
        });
    });
</script>
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
        $('#description').summernote({
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
            placeholder: 'أدخل وصف الكورس هنا...',
            callbacks: {
                onInit: function() {
                    console.log('Summernote is initialized');
                }
            }
        });
    });
</script>
@endsection