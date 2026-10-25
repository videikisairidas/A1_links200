import { alertYesNo } from '../_alertYesNo.js';

export function initDeleteButtonSubmit() {
    
    document.addEventListener('click', function(e) {
        const deleteButton = e.target.closest('.deleteButtonSubmit');
        
        if (deleteButton) {
            const form = deleteButton.closest('form'); 
            console.log(deleteButton);
            alertYesNo('Are you sure you want to delete this item?', 'Confirm Deletion')
            .then(confirmed => {
                if (confirmed) {
                    form.submit();
                }
            });
        }
    });
}