import { ENDPOINTS } from '../_adminEndPoints';

export function initEditCat() {

    document.addEventListener('click', function(e) {
        const editButton = e.target.closest('.editCatButton');
        // update button
        if (!editButton) { return; }    

        if (editButton) {
            const createForm = document.querySelector('.catForm');
            createForm.querySelector('button').innerHTML = 'Update Category';
            createForm.querySelector('input[name="name"]').value = editButton.closest('.category-card').dataset.name;
            insertPutInput(createForm);
            createForm.action = ENDPOINTS.EDIT_CATEGORY(editButton.closest('.category-card').dataset.id);
            editButton.closest('.category-card').classList.add('active');
            // const form = editButton.closest('form');
            // form.submit();
        }
        
    });

    function insertPutInput(form) {
        const putInputHidden = document.createElement('input');
        putInputHidden.setAttribute('type', 'hidden');
        putInputHidden.setAttribute('name', '_method');
        putInputHidden.setAttribute('value', 'PUT');
        // removing doublication
        let next = form.querySelector('button').nextElementSibling;
        while (next) {
            const toRemove = next;
            next = next.nextElementSibling;
            toRemove.remove();
        }
        //add
        form.appendChild(putInputHidden);
    }
}