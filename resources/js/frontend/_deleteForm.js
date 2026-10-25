import { alertYesNo } from "../_alertYesNo";

export function initDeleteForms() {
    document.addEventListener('click', function(e) {
        const deleteButton = e.target.closest('.deleteImageForm');

        if (deleteButton) { 
            const form = deleteButton.closest('form');
            alertYesNo('Are you sure you want to delete this image?', 'Confirm Deletion')
            .then(confirmed => {
                if (confirmed) {
                    form.submit();
                }
            });
        }
                
        
    });
}