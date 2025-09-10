<?php

use Illuminate\Support\Facades\Route;

// ✅ رواتس المصادقة
require __DIR__.'/auth.php';

// ✅ رواتس الواجهة الأمامية
require __DIR__.'/front.php';

// ✅ رواتس لوحة التحكم (الإدارة)
require __DIR__.'/admin.php';

