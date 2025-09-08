@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        <h2>إضافة كورس جديد</h2>

        <form action="{{ route('admin.courses.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label>عنوان الكورس</label>
                <input type="text" name="title" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>الوصف</label>
                <textarea name="description" class="form-control" rows="4" required></textarea>
            </div>

            <div class="mb-3">
                <label>السعر</label>
                <input type="number" step="0.01" name="price" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>صورة الكورس (اختياري)</label>
                <input type="file" name="image" class="form-control">
            </div>

            <button class="btn btn-success">حفظ الكورس</button>
        </form>
    </div>
@endsection
