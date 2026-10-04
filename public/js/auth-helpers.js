/**
 * Wraps fetch with centralized error handling.
 * Returns the parsed JSON response body on success, or null on failure (network error or non-2xx status).
 *
 * @param {string} url - The destination for the request.
 * @param {RequestInit} [options] - Optional. Method, headers, body, etc.
 * @returns {Promise<object|null>} The JSON data, or null if it fails.
 */
async function fetchAPI(url, options) {
  // alert("My phone is trying to reach: " + url);
  try {
    const response = await fetch(url, options);

    if (!response.ok) {
      return await response.json().catch(() => null);
    }

    return await response.json();
  } catch (error) {
    console.error("Network error:", error);
    return null;
  }
}
