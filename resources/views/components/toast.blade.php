<style>
@keyframes slideIn {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

@keyframes slideOut {
    from {
        transform: translateX(0);
        opacity: 1;
    }
    to {
        transform: translateX(100%);
        opacity: 0;
    }
}

.toast-slide-in {
    animation: slideIn 0.3s cubic-bezier(0.16, 1, 0.3, 1) forwards;
}

.toast-slide-out {
    animation: slideOut 0.3s cubic-bezier(0.7, 0, 0.3, 1) forwards;
}
</style>

<div id="toast-template" class="hidden">
    <div class="toast-item pointer-events-auto relative overflow-hidden flex items-center gap-3 px-4 py-4 rounded-lg border bg-[#262626] text-white shadow-[0_8px_30px_rgb(0,0,0,0.5)] min-w-[300px] max-w-sm">
        <div class="toast-icon shrink-0"></div>
        <div class="toast-message text-sm flex-1 font-medium"></div>
        <button class="toast-close text-[#9CA3AF] hover:text-white transition-colors" onclick="closeToast(this)">
            <i class="fas fa-times"></i>
        </button>
        <!-- progress bar effect -->
        <div class="toast-progress absolute bottom-0 left-0 h-[2px] opacity-70 transition-all duration-100 ease-linear"></div>
    </div>
</div>

<script>
window.showToast = function(message, type = 'success', duration = 3000) {
    const container = document.getElementById('toast-container');
    if (!container) return;
    
    const templateNode = document.getElementById('toast-template').firstElementChild.cloneNode(true);
    
    const iconContainer = templateNode.querySelector('.toast-icon');
    const progressNode = templateNode.querySelector('.toast-progress');
    let borderColor, iconClass, bgColor;
    
    switch(type) {
        case 'success':
            iconClass = 'fas fa-check-circle text-emerald-400';
            borderColor = 'border-emerald-500/30';
            bgColor = 'bg-emerald-400';
            break;
        case 'error':
            iconClass = 'fas fa-exclamation-circle text-red-500';
            borderColor = 'border-red-500/30';
            bgColor = 'bg-red-500';
            break;
        case 'warning':
            iconClass = 'fas fa-exclamation-triangle text-yellow-500';
            borderColor = 'border-yellow-500/30';
            bgColor = 'bg-yellow-500';
            break;
        case 'info':
        default:
            iconClass = 'fas fa-info-circle text-blue-400';
            borderColor = 'border-blue-500/30';
            bgColor = 'bg-blue-400';
            break;
    }
    
    iconContainer.innerHTML = `<i class="${iconClass} text-xl"></i>`;
    templateNode.classList.add(borderColor);
    progressNode.classList.add(bgColor);
    
    templateNode.querySelector('.toast-message').textContent = message;
    templateNode.classList.add('toast-slide-in');
    
    container.appendChild(templateNode);
    
    // Progress Bar Animation
    progressNode.style.width = '100%';
    progressNode.style.transitionDuration = `${duration}ms`;
    
    requestAnimationFrame(() => {
        setTimeout(() => {
           progressNode.style.width = '0%'; 
        }, 50);
    });

    const removeTimeout = setTimeout(() => {
        closeToast(templateNode.querySelector('.toast-close'));
    }, duration);

    templateNode.dataset.timeoutId = removeTimeout;
};

window.closeToast = function(btn) {
    const toast = btn.closest('.toast-item');
    if(toast) {
        if(toast.dataset.timeoutId) clearTimeout(toast.dataset.timeoutId);
        toast.classList.replace('toast-slide-in', 'toast-slide-out');
        setTimeout(() => toast.remove(), 300);
    }
}
</script>
