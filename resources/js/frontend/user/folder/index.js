import { alertYesNo } from "../../../_alertYesNo";
// import { showAlert } from "../../_alert";

export function initIndexFolder() {
    
    const indexFolder = document.getElementById('folderCreateContainer');

    if (!indexFolder) {return; }

    // delete folder
    let deleteFolderButtons = document.querySelectorAll('.folder-buttons-container .deleteButton');

    deleteFolderButtons.forEach(button => {
        console.log("button 111");
        button.addEventListener('click', (event) => {
            console.log("button clikc)");
            event.preventDefault();
            // const folderId = button.closest('.folder-card').getAttribute('data-folder-id');
            // const folderName = button.closest('.folder-card').querySelector('a').textContent;
            alertYesNo(`Are you sure you want to delete the folder ""?`, 'Confirm Deletion')
            .then(confirmed => {
                if (confirmed) {
                    button.closest('form').submit();
                }
            });
        });
    });
    // on change visibility
    let visibilitySelect = document.querySelectorAll('.folder-card select[name="visibility"]');
    visibilitySelect.forEach(select => {
        select.addEventListener('change', (event) => {
            event.preventDefault();
            select.closest('form').submit();
        });
    });
}