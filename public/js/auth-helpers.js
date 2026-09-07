// Wraps fetch with centralized error handling.
// Returns the parsed JSON response body on success, or null on failure
// (network error or non-2xx status).
async function fetchAPI(url, options) {
    try {
        const response = await fetch(url, options);

        if (!response.ok) {
            return await response.json().catch(() => null);
        }

        return await response.json();

    } catch (error) {
        console.error('Network error:', error);
        return null;
    }
}
