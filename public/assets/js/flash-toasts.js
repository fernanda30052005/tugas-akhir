/**
 * Flash Toasts
 * Handle flash messages and display as Bootstrap toasts
 */

document.addEventListener('DOMContentLoaded', function() {
    // Check for flash messages and show toast
    const flashMessages = {
        success: document.getElementById('flash-success')?.textContent,
        error: document.getElementById('flash-error')?.textContent,
        warning: document.getElementById('flash-warning')?.textContent,
        info: document.getElementById('flash-info')?.textContent
    };

    Object.entries(flashMessages).forEach(([type, message]) => {
        if (message) {
            showToast(type, message);
        }
    });

    function showToast(type, message) {
        const toastEl = document.querySelector('.toast-placement-ex');
        const toastHeader = toastEl.querySelector('.toast-header');
        const toastBody = toastEl.querySelector('.toast-body');
        
        // Set icon and title based on type
        let iconClass = 'bx bx-check';
        let title = 'Success';
        
        switch(type) {
            case 'error':
                iconClass = 'bx bx-error';
                title = 'Error';
                break;
            case 'warning':
                iconClass = 'bx bx-error-circle';
                title = 'Warning';
                break;
            case 'info':
                iconClass = 'bx bx-info-circle';
                title = 'Info';
                break;
        }
        
        // Update toast content
        toastHeader.querySelector('i').className = iconClass + ' me-2';
        toastHeader.querySelector('.fw-semibold').textContent = title;
        toastBody.textContent = message;
        
        // Show toast
        const toast = new bootstrap.Toast(toastEl);
        toast.show();
    }
});
