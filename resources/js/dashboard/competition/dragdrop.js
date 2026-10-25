export function initDragDrop() {
    const competitionPrizesContainer = document.getElementById('competitionPrizesContainer');
    if (competitionPrizesContainer) { 
        $('#leftDragDrop').sortable({
            connectWith: '#rightDragDrop',
            revert: true,
            cursor: 'move',
            opacity: 0.5,
            tolerance: 'pointer',
            update: function (event, ui) {
                updatePrizeIds();
            }
        });
        $('#rightDragDrop').sortable({
            connectWith: '#leftDragDrop',
            revert: true,
            cursor: 'move',
            opacity: 0.5,
            tolerance: 'pointer',
            update: function (event, ui) {
                updatePrizeIds();
            }
        });

        function updatePrizeIds() {
            let ids = [];
            document.querySelectorAll('#rightDragDrop div').forEach(el => {
                ids.push(el.getAttribute('data-id'));
            });
            document.getElementById('prizes').value = ids.join(',');
        }

    }
    
    
}