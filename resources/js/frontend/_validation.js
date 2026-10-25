export function validateId(id) {
    const regex = /^[0-9]+$/;
    if (!regex.test(id)) return false;

    const numberId = parseInt(id);
    return numberId;
}