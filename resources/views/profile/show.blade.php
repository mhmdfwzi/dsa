@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-4">حساب الطالب: {{ auth()->user()->name }}</h2>

        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">بياناتك الشخصية</h5>
                <p><strong>الاسم:</strong> {{ auth()->user()->name }}</p>
                <p><strong>البريد الإلكتروني:</strong> {{ auth()->user()->email }}</p>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">الكورسات المسجل بها</h5>
                @if(auth()->user()->enrollments->count())
                    <ul class="list-group">
                        @foreach(auth()->user()->enrollments as $enrollment)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <a href="{{ route('courses.show', $enrollment->course->id) }}">
                                    {{ $enrollment->course->title }}
                                </a>
                                <span class="badge bg-success">{{ $enrollment->course->formatted_price }}</span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p>لم تقم بالتسجيل في أي كورس بعد.</p>
                @endif
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">تقييماتك</h5>
                @php
                    $reviews = auth()->user()->reviews;
                @endphp
                @if($reviews->count())
                    <ul class="list-group">
                        @foreach($reviews as $review)
                            <li class="list-group-item">
                                <strong>{{ $review->course->title }}:</strong>
                                ⭐ {{ $review->rating }}<br>
                                {{ $review->review }}
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p>لم تقم بكتابة أي تقييمات بعد.</p>
                @endif
            </div>
        </div>
    </div>
@endsection
