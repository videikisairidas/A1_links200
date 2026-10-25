


export function initGalleryFilter() {
    const filterForm = document.getElementById('galleryFilterForm');
    if (!filterForm) { return; }

    filterForm.addEventListener('submit', function (event) {
        if (event.target === filterForm) {
            event.preventDefault();

            // Build cats array fresh from DOM
            const checked = [...filterForm.querySelectorAll('input[type=checkbox]:checked')]
                .map(cb => cb.value);

            filterForm.querySelector('input[name="cats"]').value = checked.join(',');
            console.log(checked);
            filterForm.submit();
        }
    });
    // set categories check after load
    const params = new URLSearchParams(window.location.search);
    const catsParam = params.get('cats');

    if (!catsParam) { return; }

    const selectedCats = catsParam.split(',')

    selectedCats.forEach(cat => {
        const catCheckbox = filterForm.querySelector(`input[value="${cat}"]`);
        if (catCheckbox) {
            catCheckbox.checked = true;
        }
    });

}