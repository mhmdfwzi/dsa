@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <h2 class="mt-4 mb-4 fw-bold">تقرير الطلاب المسجلين في كل كورس</h2>

    @forelse ($courses as $course)
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                {{ $course->title }} ({{ $course->students->count() }} طالب)
            </div>
            <div class="card-body">
                @if ($course->students->count() > 0)
                    <table class="table table-bordered table-striped mb-0">
                        <thead>
                            <tr>
                                <th>الرقم</th>
                                <th>اسم الطالب</th>
                                <th>البريد الإلكتروني</th>
                                <th>تاريخ التسجيل</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($course->students as $student)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $student->name }}</td>
                                    <td>{{ $student->email }}</td>
                                    <td>
                                        {{
                                            $student->pivot->created_at
                                                ? $student->pivot->created_at->format('Y-m-d')
                                                : 'غير متاح'
                                        }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p>لا يوجد طلاب مسجلين في هذا الكورس.</p>
                @endif
            </div>
        </div>
    @empty
        <p>لا يوجد كورسات حالياً.</p>
    @endforelse
</div>
@endsection
