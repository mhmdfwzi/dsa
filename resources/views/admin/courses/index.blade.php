@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        <h2>إدارة الكورسات</h2>

        <a href="{{ route('admin.courses.create') }}" class="btn btn-success mb-3">إضافة كورس جديد</a>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>العنوان</th>
                    <th>الوصف</th>
                    <th>السعر</th>
                    <th>صورة</th>
                    <th>إجراءات</th>
                </tr>
            </thead>
            <tbody>
                @foreach($courses as $course)
                <tr>
                    <td>{{ $course->title }}</td>
                    <td>{{ Str::limit($course->description, 50) }}</td>
                    <td>{{ $course->formatted_price }}</td>
                    <td>
                        <img src="{{ $course->image_url }}" alt="صورة" width="80">
                    </td>
                    <td>
                        <a href="{{ route('admin.courses.edit', $course) }}" class="btn btn-sm btn-primary">تعديل</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
