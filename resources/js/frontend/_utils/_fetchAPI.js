export async function fetchAPI(endpoint, method = "GET", body = null, needsCSRF = false) {
    const headers = {
        'X-Requested-With': 'XMLHttpRequest', 
        'Content-Type': 'application/x-www-form-urlencoded',
        'Accept': 'application/json',
    };
    // send (typed) body
    if (method !== "GET" && method !== "HEAD") {
        headers['Content-Type'] = 'application/json';
    }
    // csrf token
    if (needsCSRF) {
        headers['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').content;
    }
    // console.log(endpoint);
    try {
        const fetchOptions = {
            method,
            headers,
        };

        if (body && method === "POST" && method !== "DELETE") {
            fetchOptions.body = JSON.stringify(body);
        }

        const response = await fetch(endpoint, fetchOptions);

        // Try to parse JSON even on 401/409/etc. 
        const data = await response.json().catch(() => null); 
        if (!response.ok) { // Return Laravel's real error message 
            throw new Error(data?.message || 'Unknown error'); 
        }
        console.log(data);
        return data;
    } catch (error) {
        console.error('Error:', error);
        throw error;
    }
   
}