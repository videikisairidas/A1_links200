export function initAlertBladeLoaded() {
    
    const alertContainer = document.getElementById('messagesContainer');
    const FADE_DURATION = 500; 

    // --- 1. Function to Remove Alert with Fade Effect ---
    const removeAlertWithFade = (element) => {
        if (!element || !element.classList.contains('alert')) return;

        element.classList.remove('show'); 
        
        setTimeout(() => {
            element.remove();
        }, FADE_DURATION);
    };

    if (alertContainer) {
        // --- 2. Click to Remove Logic ---
        alertContainer.addEventListener('click', (e) => {
            if (e.target.classList.contains('alert-close')) {
                e.preventDefault();
                
                // Find the closest parent alert element
                const alertElement = e.target.closest('.alert');
                
                if (alertElement) {
                    removeAlertWithFade(alertElement);
                }
            }
        });

        // --- 3. Auto-Remove Existing Alerts on Page Load ---
        const staticAlerts = alertContainer.querySelectorAll('.alert.fade.show');
        
        staticAlerts.forEach(alertElement => {
            const duration = 3000; 
            
            setTimeout(() => {
                if (alertElement.parentElement) {
                    removeAlertWithFade(alertElement);
                }
            }, duration);
        });
    }
}