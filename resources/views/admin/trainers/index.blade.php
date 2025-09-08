@extends('admin.layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center py-3">
        <h2 class="fw-bold mb-0">إدارة المدربين</h2>
        <a href="{{ route('admin.trainers.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i> إضافة مدرب جديد
        </a>
    </div>

    <div class="card shadow">
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>الصورة</th>
                            <th>الاسم</th>
                            <th>التخصص</th>
                            <th>الحالة</th>
                            <th>تاريخ الإضافة</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($trainers as $trainer)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <img src="{{ $trainer->profile_photo_url }}" alt="{{ $trainer->name }}" 
                                     class="rounded-circle" width="50" height="50">
                            </td>
                            <td>{{ $trainer->name }}</td>
                            <td>{{ $trainer->expertise }}</td>
                            <td>
                                <span class="badge bg-{{ $trainer->is_approved ? 'success' : 'warning' }}">
                                    {{ $trainer->is_approved ? 'مفعل' : 'غير مفعل' }}
                                </span>
                            </td>
                            <td>{{ $trainer->created_at->format('Y-m-d') }}</td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('admin.trainers.show', $trainer) }}" 
                                       class="btn btn-sm btn-info" title="عرض">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.trainers.edit', $trainer) }}" 
                                       class="btn btn-sm btn-primary" title="تعديل">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.trainers.destroy', $trainer) }}" 
                                          method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" 
                                                onclick="return confirm('هل أنت متأكد من الحذف؟')" title="حذف">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">لا يوجد مدربين حتى الآن</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($trainers->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $trainers->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection