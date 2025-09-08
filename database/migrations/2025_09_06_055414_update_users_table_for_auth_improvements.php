<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUsersTableForAuthImprovements extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // تغيير طول حقل remember_token إلى 100 (إذا كان موجودًا بالفعل)
            if (Schema::hasColumn('users', 'remember_token')) {
                $table->string('remember_token', 100)->nullable()->change();
            } else {
                $table->string('remember_token', 100)->nullable();
            }

            // إضافة الحقول الجديدة إذا لم تكن موجودة
            if (!Schema::hasColumn('users', 'last_login_at')) {
                $table->timestamp('last_login_at')->nullable();
            }
            if (!Schema::hasColumn('users', 'last_login_ip')) {
                $table->string('last_login_ip')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // في حالة التراجع، نعيد الحقول إلى ما كانت عليه (إذا أردنا إزالة الحقول الجديدة)
            // لكن note: لا يمكننا بسهولة استعادة الطول الأصلي لـ remember_token لأننا لا نعرفه، لذا قد نتركه كما هو.
            // إذا أردنا إزالة الحقول الجديدة في التراجع:
            $table->dropColumn(['last_login_at', 'last_login_ip']);
            // لا نتراجع عن تغيير طول remember_token لأنه غير ضروري وقد يكون هناك بيانات مخزنة
        });
    }
}