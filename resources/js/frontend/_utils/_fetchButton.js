import { showAlert } from '../../_alert';
import { fetchAPI } from './_fetchAPI';
export async function fetchButton(endpoint, method = "GET", body = null) {
    try {
        const needCSRF = true;
        const response = await fetchAPI(endpoint, method, body, needCSRF);
        if (response.status === 'success') {
            showAlert(response.message, 'success');
        } else {
            showAlert(response.message, 'error');
        }
        return response;
    } catch (error) {
        console.error('There was a problem with the fetch operation:', error);
    }
}
export async function fetchButton_WithDeleteParent(endpoint, method = "DELETE", targetElement) {
    try {
        const needCSRF = true;
        const response = await fetchAPI(endpoint, method, null, needCSRF);
        if (response.status === 'success') {
            showAlert(response.message, 'success');
            targetElement.remove();
        } else {
            showAlert(response.message, 'error');
        }
        return response;
    } catch (error) {
        console.error('There was a problem with the fetch operation:', error);
    }
}