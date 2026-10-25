export function showAlert(message, type = 'success') {
    const alertContainer = document.getElementById('messagesContainer');

    if (!alertContainer) return;
    
    const alertClasses = {
        'success': 'alert-success',
        'error': 'alert-danger',
        'warning': 'alert-warning',
        'info': 'alert-info',
        'danger': 'alert-danger',
    }
    const alertClass = alertClasses[type] || 'alert-info';

    const duration = 3000; // 3 seconds
    const fadeDuration = 500; // 0.5 seconds (Must match CSS transition duration)

    // Create alert element
    const alertElement = document.createElement('div');
    alertElement.className = `alert ${alertClass} alert-dismissible fade show dynamic-alert`; 
    alertElement.role = 'alert';
    alertElement.innerHTML = `${message}
        <div class="alert-close btn-close" data-bs-dismiss="alert" aria-label="Close">x</div>
    `;
    alertContainer.appendChild(alertElement);

    
    // Function to handle the removal with fade-out effect
    const removeAlertWithFade = () => {
        alertElement.classList.remove('show'); 
        setTimeout(() => {
            alertElement.remove();
        }, fadeDuration);
    };
    // Auto-remove after duration
    setTimeout(() => {
        if (alertElement.parentElement) {
            removeAlertWithFade();
        }
    }, duration);

}
