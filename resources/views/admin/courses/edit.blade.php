@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        <h2>تعديل الكورس</h2>

        <form action="{{ route('admin.courses.update', $course) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label>عنوان الكورس</label>
                <input type="text" name="title" class="form-control" value="{{ $course->title }}" required>
            </div>

            <div class="mb-3">
                <label>الوصف</label>
                <textarea name="description" class="form-control" rows="4" required>{{ $course->description }}</textarea>
            </div>

            <div class="mb-3">
                <label>السعر</label>
                <input type="number" step="0.01" name="price" class="form-control" value="{{ $course->price }}" required>
            </div>

            <div class="mb-3">
                <label>الصورة الحالية</label><br>
                <img src="{{ $course->image_url }}" width="100">
            </div>

            <div class="mb-3">
                <label>تغيير الصورة</label>
                <input type="file" name="image" class="form-control">
            </div>

            <button class="btn btn-primary">تحديث الكورس</button>
        </form>
    </div>
@endsection
