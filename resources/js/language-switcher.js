// Attach the function to the window object to make it globally accessible
window.switchLanguage = function(locale) {
    // Send an AJAX request to the language switch endpoint
    fetch(`/localization/${locale}`, { method: 'GET', credentials: 'same-origin' })
        .then(response => {
            if (response.ok) {
                // Reload the page to reflect the new language
                window.location.reload();
            } else {
                console.error('Failed to switch language');
            }
        })
        .catch(error => {
            console.error('Error during language switch:', error);
        });
};
