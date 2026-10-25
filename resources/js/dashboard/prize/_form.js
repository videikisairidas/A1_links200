
export function initPrizeForm() {
    console.log("prize form");
    const addKeys = document.getElementById('addKeys');
    const addEnergy = document.getElementById('addEnergy');
    const addPoints = document.getElementById('addPoints'); 
    const addUsers = document.getElementById('addUsers');

    if (addKeys) {
        console.log("yes    ");
        addKeys.addEventListener('click', (e) => {
            const addButton = e.target.closest('button');
            const amount = addButton.dataset.add;

            const inputKeys = document.getElementById('keys');
            inputKeys.value = parseInt(inputKeys.value) + parseInt(amount);
        });
    }

    if (addEnergy) {
        addEnergy.addEventListener('click', (e) => {
            const addButton = e.target.closest('button');
            const amount = addButton.dataset.add;

            const inputEnergy = document.getElementById('energy');
            inputEnergy.value = parseInt(inputEnergy.value) + parseInt(amount);
        });
    }

    if (addPoints) {
        addPoints.addEventListener('click', (e) => {
            const addButton = e.target.closest('button');
            const amount = addButton.dataset.add;

            const inputPoints = document.getElementById('points');
            inputPoints.value = parseInt(inputPoints.value) + parseInt(amount);
        });
    }

    if (addUsers) {
        addUsers.addEventListener('click', (e) => {
            const addButton = e.target.closest('button');
            const amount = addButton.dataset.add;

            const inputUsers = document.getElementById('users_limit');
            inputUsers.value = parseInt(inputUsers.value) + parseInt(amount);
            console.log(inputUsers.value);
        });
    }

}