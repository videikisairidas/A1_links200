export function alertYesNo(message, title = 'Please Confirm') {
    return new Promise((resolve) => {
        const modal = document.getElementById('alertYesNoContainer');
        const messageElement = document.getElementById('alertYesNoMessage');
        const tittleElement = document.getElementById('alertYesNoTitle');
        const yesButton = document.getElementById('alertYesNoYesButton');
        const noButton = document.getElementById('alertYesNoNoButton');

        messageElement.textContent = message;
        tittleElement.textContent = title;

        const cleanUpAndResolve = (result) => {
            yesButton.removeEventListener('click', onYes);
            noButton.removeEventListener('click', onNo);

            modal.classList.remove('active');
            // setTimeout(() => {
                
            // }, timeout);
            resolve(result);
        };

        const handleYes = () => {cleanUpAndResolve(true);};
        const handleNo = () => {cleanUpAndResolve(false);};
        // add evelent listeners
        const onYes = yesButton.addEventListener('click', handleYes);
        const onNo = noButton.addEventListener('click', handleNo);
        // show modal
        modal.classList.add('active');
    });
}
