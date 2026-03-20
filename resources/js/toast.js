// Toast Notification System
const toastContainer = document.createElement('div');
toastContainer.id = 'toast-container';
document.body.appendChild(toastContainer);

export const showAlgoNotification = (title, message, type = 'success', duration = 5000) => {
    const toast = document.createElement('div');
    toast.className = `algo-toast ${type}`;
    
    // Get icon based on type
    let icon = 'bell';
    if (type === 'success') icon = 'check-circle';
    if (type === 'danger') icon = 'alert-triangle';
    if (type === 'warning') icon = 'alert-circle';
    if (type === 'info') icon = 'info';

    toast.innerHTML = `
        <div class="algo-toast-icon">
            <i data-lucide="${icon}"></i>
        </div>
        <div class="algo-toast-content">
            <div class="algo-toast-title">${title}</div>
            <div class="algo-toast-message">${message}</div>
        </div>
        <button class="algo-toast-close">&times;</button>
    `;

    toastContainer.appendChild(toast);
    
    // Initialize Lucide icons
    if (window.lucide) {
        window.lucide.createIcons({
            attrs: {
                class: ['w-5', 'h-5']
            }
        });
    }

    // GSAP Entrance
    gsap.fromTo(toast, 
        { 
            x: 100, 
            opacity: 0, 
            scale: 0.9 
        }, 
        { 
            x: 0, 
            opacity: 1, 
            scale: 1, 
            duration: 0.5, 
            ease: "back.out(1.7)" 
        }
    );

    // Auto-remove
    const timer = setTimeout(() => {
        removeToast(toast);
    }, duration);

    // Manual close
    toast.querySelector('.algo-toast-close').onclick = (e) => {
        e.stopPropagation();
        clearTimeout(timer);
        removeToast(toast);
    };

    // Click to navigate (optional)
    toast.onclick = () => {
        window.location.href = '/signals';
    };
};

const removeToast = (toast) => {
    gsap.to(toast, {
        x: 100,
        opacity: 0,
        scale: 0.9,
        duration: 0.3,
        ease: "power2.in",
        onComplete: () => {
            toast.remove();
        }
    });
};

// Global Exposure
window.showAlgoNotification = showAlgoNotification;
