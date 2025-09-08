@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <h2 class="mt-4 mb-4 fw-bold">تقرير الكورسات</h2>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>الرقم</th>
                <th>اسم الكورس</th>
                <th>الوصف</th>
                <th>عدد الطلاب</th>
                <th>تاريخ الإضافة</th>
            </tr>
        </thead>
        <tbody>
            @forelse($courses as $course)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $course->title }}</td>
                    <td>{{ Str::limit($course->description, 50) }}</td>
                    <td>{{ $course->students->count() }}</td>
                    <td>{{ $course->created_at->format('Y-m-d') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">لا يوجد كورسات حالياً.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
