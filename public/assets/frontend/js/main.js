// كود الجافاسكريبت المحسن للواجهة الأمامية
document.addEventListener('DOMContentLoaded', function() {
    // تفعيل التنقل المتنقل
    initMobileNavigation();
    
    // تفعيل العدادات الإحصائية
    initStatsCounter();
    
    // تفعيل الرسوم المتحركة عند التمرير
    initScrollAnimations();
    
    // تفعيل التحقق من النماذج
    initFormValidation();
    
    // تفعيل إشعارات التفاعل
    initNotifications();
});

// تهيئة التنقل المتنقل مع تحسينات
function initMobileNavigation() {
    const menuToggle = document.querySelector('.mobile-menu-toggle');
    const nav = document.querySelector('.main-nav');
    
    if (menuToggle && nav) {
        menuToggle.addEventListener('click', function() {
            nav.classList.toggle('active');
            menuToggle.classList.toggle('active');
            document.body.classList.toggle('menu-open');
        });
        
        // إغلاق القائمة عند النقر على رابط
        const navLinks = nav.querySelectorAll('a');
        navLinks.forEach(link => {
            link.addEventListener('click', () => {
                nav.classList.remove('active');
                menuToggle.classList.remove('active');
                document.body.classList.remove('menu-open');
            });
        });
        
        // إغلاق القائمة عند النقر خارجها
        document.addEventListener('click', function(e) {
            if (!nav.contains(e.target) && !menuToggle.contains(e.target) && nav.classList.contains('active')) {
                nav.classList.remove('active');
                menuToggle.classList.remove('active');
                document.body.classList.remove('menu-open');
            }
        });
    }
}

// تهيئة العدادات الإحصائية مع تحسينات
function initStatsCounter() {
    const statItems = document.querySelectorAll('.stat-item h3');
    
    if (statItems.length > 0) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const stat = entry.target;
                    const target = parseInt(stat.getAttribute('data-count'));
                    let current = 0;
                    const duration = 2000;
                    const increment = target / (duration / 16);
                    
                    const updateCounter = () => {
                        current += increment;
                        if (current < target) {
                            stat.textContent = Math.floor(current) + '+';
                            requestAnimationFrame(updateCounter);
                        } else {
                            stat.textContent = target + '+';
                        }
                    };
                    
                    updateCounter();
                    observer.unobserve(stat);
                }
            });
        }, { threshold: 0.5 });
        
        statItems.forEach(stat => {
            observer.observe(stat);
        });
    }
}

// تهيئة الرسوم المتحركة عند التمرير
function initScrollAnimations() {
    const animatedElements = document.querySelectorAll('.category-item, .course-card, .instructor-card, .testimonial-card');
    
    if (animatedElements.length > 0) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-fadeInUp');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1 });
        
        animatedElements.forEach(element => {
            observer.observe(element);
        });
    }
}

// تهيئة التحقق من النماذج
function initFormValidation() {
    const newsletterForm = document.querySelector('.newsletter-form');
    
    if (newsletterForm) {
        newsletterForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const emailInput = this.querySelector('input[type="email"]');
            
            if (validateEmail(emailInput.value)) {
                // محاكاة إرسال النموذج
                showNotification('تم الاشتراك بنجاح! سنبقيك على اطلاع بأحدث الكورسات.', 'success');
                emailInput.value = '';
            } else {
                showNotification('يرجى إدخال بريد إلكتروني صحيح.', 'error');
            }
        });
    }
}

// التحقق من صحة البريد الإلكتروني
function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

// تهيئة الإشعارات
function initNotifications() {
    // إظهار إشعارات محفوظة في localStorage إذا وجدت
    const savedNotification = localStorage.getItem('siteNotification');
    if (savedNotification) {
        const { message, type } = JSON.parse(savedNotification);
        showNotification(message, type);
        localStorage.removeItem('siteNotification');
    }
}

// عرض الإشعارات
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `notification ${type}`;
    notification.innerHTML = `
        <div class="notification-content">
            <i class="fas fa-${getNotificationIcon(type)}"></i>
            <span>${message}</span>
        </div>
        <button class="notification-close">
            <i class="fas fa-times"></i>
        </button>
    `;
    
    // إضافة أنماط للإشعار
    const style = document.createElement('style');
    style.textContent = `
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            background: white;
            padding: 15px 20px;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            display: flex;
            align-items: center;
            gap: 15px;
            z-index: 10000;
            transform: translateX(100%);
            transition: transform 0.3s ease;
            max-width: 400px;
            border-right: 4px solid;
        }
        
        .notification.success {
            border-right-color: var(--success-color);
        }
        
        .notification.error {
            border-right-color: var(--accent-color);
        }
        
        .notification.info {
            border-right-color: var(--primary-color);
        }
        
        .notification.warning {
            border-right-color: var(--warning-color);
        }
        
        .notification-content {
            display: flex;
            align-items: center;
            gap: 10px;
            flex: 1;
        }
        
        .notification-close {
            background: none;
            border: none;
            cursor: pointer;
            color: var(--text-light);
            font-size: 14px;
        }
        
        .notification.show {
            transform: translateX(0);
        }
    `;
    
    document.head.appendChild(style);
    document.body.appendChild(notification);
    
    // إظهار الإشعار
    setTimeout(() => {
        notification.classList.add('show');
    }, 100);
    
    // إغلاق الإشعار عند النقر على الزر
    const closeBtn = notification.querySelector('.notification-close');
    closeBtn.addEventListener('click', () => {
        notification.classList.remove('show');
        setTimeout(() => {
            notification.remove();
            style.remove();
        }, 300);
    });
    
    // إغلاق الإشعار تلقائياً بعد 5 ثوانٍ
    setTimeout(() => {
        if (notification.parentNode) {
            notification.classList.remove('show');
            setTimeout(() => {
                notification.remove();
                style.remove();
            }, 300);
        }
    }, 5000);
}

// الحصول على الأيقونة المناسبة لنوع الإشعار
function getNotificationIcon(type) {
    const icons = {
        success: 'check-circle',
        error: 'exclamation-circle',
        warning: 'exclamation-triangle',
        info: 'info-circle'
    };
    return icons[type] || 'info-circle';
}

// إدارة حالة القائمة المتنقلة في localStorage
function handleMenuState() {
    const menuState = localStorage.getItem('menuOpen');
    if (menuState === 'true') {
        document.body.classList.add('menu-open');
    }
    
    window.addEventListener('beforeunload', () => {
        localStorage.setItem('menuOpen', document.body.classList.contains('menu-open'));
    });
}

// تحميل الصور بكسل أفضل
function enhanceImages() {
    const images = document.querySelectorAll('img');
    
    images.forEach(img => {
        // إضافة تحميل كسول للصور
        if (!img.hasAttribute('loading')) {
            img.setAttribute('loading', 'lazy');
        }
        
        // إضافة نص بديل إذا لم يكن موجوداً
        if (!img.alt) {
            img.alt = 'أكاديمية المهارات الرقمية';
        }
    });
}

// إدارة سلة التسوق (إذا كانت موجودة)
function initCart() {
    const cartButtons = document.querySelectorAll('.cart-btn');
    
    if (cartButtons.length > 0) {
        cartButtons.forEach(button => {
            button.addEventListener('click', function() {
                this.classList.add('adding');
                setTimeout(() => {
                    this.classList.remove('adding');
                    showNotification('تمت إضافة الكورس إلى سلة التسوق', 'success');
                }, 1000);
            });
        });
    }
}

// تهيئة جميع المكونات عند تحميل الصفحة
window.addEventListener('load', function() {
    enhanceImages();
    handleMenuState();
    initCart();
    
    // إظهار رسالة ترحيب للمستخدمين الجدد
    if (!localStorage.getItem('firstVisit')) {
        setTimeout(() => {
            showNotification('مرحباً بك في أكاديمية المهارات الرقمية! استمتع بتجربة تعلم فريدة.', 'info');
            localStorage.setItem('firstVisit', 'true');
        }, 2000);
    }
});

// تحسين الأداء عند التمرير
let scrollTimeout;
window.addEventListener('scroll', function() {
    clearTimeout(scrollTimeout);
    document.body.classList.add('scrolling');
    
    scrollTimeout = setTimeout(() => {
        document.body.classList.remove('scrolling');
    }, 100);
});

// دعم خدمة العملاء عبر الدردشة المباشرة
function initChatSupport() {
    const chatButton = document.createElement('div');
    chatButton.className = 'chat-support';
    chatButton.innerHTML = `
        <i class="fas fa-comments"></i>
    `;
    
    const style = document.createElement('style');
    style.textContent = `
        .chat-support {
            position: fixed;
            bottom: 20px;
            left: 20px;
            width: 60px;
            height: 60px;
            background-color: var(--primary-color);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(52, 152, 219, 0.3);
            z-index: 999;
            transition: var(--transition);
        }
        
        .chat-support:hover {
            background-color: var(--secondary-color);
            transform: scale(1.1);
        }
        
        .chat-support i {
            font-size: 24px;
        }
    `;
    
    document.head.appendChild(style);
    document.body.appendChild(chatButton);
    
    chatButton.addEventListener('click', function() {
        showNotification('سيتم تفعيل خدمة الدردشة المباشرة قريباً', 'info');
    });
}

// تفعيل الدردشة المباشرة للصفحات الكبيرة فقط
if (window.innerWidth > 1024) {
    setTimeout(initChatSupport, 10000); // بعد 10 ثوانٍ من التحميل
}
// تفعيل الأكورديون لمحتوى الكورس
function initCourseAccordion() {
    const accordionHeaders = document.querySelectorAll('.accordion-header');
    
    accordionHeaders.forEach(header => {
        header.addEventListener('click', function() {
            this.parentElement.classList.toggle('active');
            
            // إغلاق الباقي تلقائياً
            accordionHeaders.forEach(otherHeader => {
                if (otherHeader !== this) {
                    otherHeader.parentElement.classList.remove('active');
                }
            });
        });
    });
}

// تفعيل عدادات الإحصائيات
function initStatsCounter() {
    const counterElements = document.querySelectorAll('.stat .number');
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const target = parseInt(entry.target.textContent);
                let current = 0;
                const duration = 2000;
                const increment = target / (duration / 16);
                
                const updateCounter = () => {
                    current += increment;
                    if (current < target) {
                        entry.target.textContent = Math.floor(current);
                        requestAnimationFrame(updateCounter);
                    } else {
                        entry.target.textContent = target;
                    }
                };
                
                updateCounter();
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.5 });
    
    counterElements.forEach(element => {
        observer.observe(element);
    });
}

// تحديث DOMContentLoaded ليشمل الدوال الجديدة
document.addEventListener('DOMContentLoaded', function() {
    initMobileNavigation();
    initTestimonialsSlider();
    initStatsCounter();
    initCourseAccordion();
});