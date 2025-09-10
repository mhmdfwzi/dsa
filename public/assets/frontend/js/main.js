// كود JavaScript لتفعيل التصميم
document.addEventListener('DOMContentLoaded', function() {
    // تفعيل dropdowns في الهيدر (معدل)
    const dropdownToggles = document.querySelectorAll('.dropdown-toggle');
    
    dropdownToggles.forEach(toggle => {
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            const dropdownMenu = this.nextElementSibling;
            dropdownMenu.classList.toggle('show');
            
            // إغلاق باقي القوائم المفتوحة
            document.querySelectorAll('.dropdown-menu').forEach(menu => {
                if (menu !== dropdownMenu) {
                    menu.classList.remove('show');
                }
            });
        });
    });

    // إغلاق dropdown عند النقر خارجها (معدل)
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.dropdown')) {
            document.querySelectorAll('.dropdown-menu').forEach(menu => {
                menu.classList.remove('show');
            });
        }
    });

    // تفعيل نظام التقييم بالنجوم (معدل)
    const setupStarRating = () => {
        const starsContainer = document.querySelector('.stars-container');
        if (!starsContainer) return;
        
        const stars = starsContainer.querySelectorAll('.fa-star');
        const selectedRatingInput = document.getElementById('selectedRating');
        
        stars.forEach(star => {
            star.addEventListener('click', function() {
                const value = this.getAttribute('data-value');
                if (selectedRatingInput) {
                    selectedRatingInput.value = value;
                }
                
                stars.forEach(s => {
                    const starValue = s.getAttribute('data-value');
                    if (starValue <= value) {
                        s.classList.remove('far');
                        s.classList.add('fas');
                    } else {
                        s.classList.remove('fas');
                        s.classList.add('far');
                    }
                });
            });
        });
    };
    
    setupStarRating();

    // تأثيرات التمرير للعناصر (معدل)
    const initScrollAnimations = () => {
        const animatedElements = document.querySelectorAll('.course-card, .sidebar-card');
        if (animatedElements.length === 0) return;
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    // يمكن إضافة تأخير بناء على index العنصر
                    const index = Array.from(animatedElements).indexOf(entry.target);
                    entry.target.style.transitionDelay = `${index * 0.1}s`;
                }
            });
        }, { threshold: 0.1 });
        
        animatedElements.forEach(element => {
            element.style.opacity = '0';
            element.style.transform = 'translateY(20px)';
            element.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
            observer.observe(element);
        });
    };
    
    initScrollAnimations();

    // تفعيل أكورديون محتوى الكورس (معدل)
    const initAccordions = () => {
        const accordionButtons = document.querySelectorAll('.accordion-button');
        if (accordionButtons.length === 0) return;
        
        accordionButtons.forEach(button => {
            button.addEventListener('click', function() {
                const targetId = this.getAttribute('data-bs-target');
                const collapseElement = document.querySelector(targetId);
                
                if (collapseElement) {
                    // تبديل حالة العرض
                    const isExpanded = collapseElement.classList.contains('show');
                    
                    if (isExpanded) {
                        collapseElement.style.height = `${collapseElement.scrollHeight}px`;
                        setTimeout(() => {
                            collapseElement.style.height = '0';
                            setTimeout(() => {
                                collapseElement.classList.remove('show');
                            }, 300);
                        }, 50);
                    } else {
                        collapseElement.style.height = '0';
                        collapseElement.classList.add('show');
                        collapseElement.style.height = `${collapseElement.scrollHeight}px`;
                        
                        setTimeout(() => {
                            collapseElement.style.height = 'auto';
                        }, 300);
                    }
                }
            });
        });
    };
    
    initAccordions();

    // إضافة تأثيرات للأزرار (معدل)
    const initButtonEffects = () => {
        const buttons = document.querySelectorAll('.btn:not(.disabled)');
        buttons.forEach(button => {
            button.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-2px)';
                this.style.boxShadow = '0 4px 8px rgba(0,0,0,0.1)';
            });
            
            button.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
                this.style.boxShadow = 'none';
            });
        });
    };
    
    initButtonEffects();

    // تفعيل نموذج إضافة التقييم (معدل)
    const initReviewForm = () => {
        const reviewForm = document.querySelector('.add-review-section form');
        if (!reviewForm) return;
        
        reviewForm.addEventListener('submit', function(e) {
            const rating = this.querySelector('#selectedRating')?.value;
            const comment = this.querySelector('#comment')?.value;
            
            if (!rating || !comment.trim()) {
                e.preventDefault();
                
                // عرض رسالة خطأ بشكل أنيق
                const errorDiv = document.createElement('div');
                errorDiv.className = 'alert alert-danger mt-3';
                errorDiv.innerHTML = '<i class="fas fa-exclamation-circle me-2"></i> يرجى ملء جميع الحقول المطلوبة';
                
                // إزالة أي رسائل خطأ سابقة
                const existingError = this.querySelector('.alert-danger');
                if (existingError) {
                    existingError.remove();
                }
                
                this.appendChild(errorDiv);
                
                // اهتزاز النموذج للإشارة إلى الخطأ
                this.style.animation = 'shake 0.5s';
                setTimeout(() => {
                    this.style.animation = '';
                }, 500);
            }
        });
    };
    
    initReviewForm();
});

// إضافة تأثير الاهتزاز للنماذج
const style = document.createElement('style');
style.textContent = `
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        20%, 60% { transform: translateX(-5px); }
        40%, 80% { transform: translateX(5px); }
    }
`;
document.head.appendChild(style);