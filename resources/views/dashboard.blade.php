<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __('You\'re logged in!') }}
                </div>
            </div>

            <div class="mt-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div class="bg-gray-100 p-4 rounded-lg shadow">
                            <h3 class="text-lg font-semibold">{{ __('Total Courses') }}</h3>
                            <p class="text-2xl">{{ $coursesCount }}</p>
                        </div>
                        <div class="bg-gray-100 p-4 rounded-lg shadow">
                            <h3 class="text-lg font-semibold">{{ __('Total Students') }}</h3>
                            <p class="text-2xl">{{ $studentsCount }}</p>
                        </div>
                        <div class="bg-gray-100 p-4 rounded-lg shadow">
                            <h3 class="text-lg font-semibold">{{ __('Total Enrollments') }}</h3>
                            <p class="text-2xl">{{ $enrollmentsCount }}</p>
                        </div>
                    </div>

                    <div class="mt-6">
                        <h3 class="text-lg font-semibold">{{ __('Top 5 Courses') }}</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mt-2">
                            @foreach ($topCourses as $course)
                                <div class="bg-gray-50 p-3 rounded-lg shadow">
                                    <p>{{ $course->title }} ({{ $course->students_count }} {{ __('Students') }})</p>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="mt-6">
                        <h3 class="text-lg font-semibold">{{ __('Enrollments in Last 30 Days') }}</h3>
                        <canvas id="enrollmentsChart" class="w-full h-64"></canvas>
                        <script>
                            const ctx = document.getElementById('enrollmentsChart').getContext('2d');
                            new Chart(ctx, {
                                type: 'line',
                                data: {
                                    labels: @json($chartLabels),
                                    datasets: [{
                                        label: '{{ __('Enrollments') }}',
                                        data: @json($chartData),
                                        borderColor: 'rgba(75, 192, 192, 1)',
                                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                        fill: true,
                                    }]
                                },
                                options: {
                                    scales: {
                                        y: { beginAtZero: true }
                                    }
                                }
                            });
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>