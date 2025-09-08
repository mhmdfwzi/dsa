<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // إضافة role إذا لم يكن موجوداً
            if (!Schema::hasColumn('users', 'role')) {
                $table->enum('role', ['admin', 'trainer', 'student'])->default('student')->after('password');
            }
            
            // إذا كان العمود موجوداً، تأكد من أنه بنفس المواصفات
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'trainer', 'student'])->default('student')->change();
        });

            // إضافة bio إذا لم يكن موجوداً
            if (!Schema::hasColumn('users', 'bio')) {
                $table->text('bio')->nullable()->after('phone');
            }
            
            
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // يمكنك إزالة الحقول إذا أردت، لكن عادة نتركها للبيئة التنموية فقط
            /*
            $table->dropColumn([
                'role',
                'bio', 
                'expertise',
                'is_approved',
                'profile_photo_path',
                'last_login_at',
                'last_login_ip'
            ]);
            */
        });
    }
};