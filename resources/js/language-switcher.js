window.switchLanguage = function(locale) {
    fetch(`/localization/${locale}`, { method: 'GET', credentials: 'same-origin' })
        .then(response => {
            if (response.ok) {
                // Navigate to the current path, which will now be localized
                window.location.href = window.location.pathname;
            } else {
                console.error('Failed to switch language');
            }
        })
        .catch(error => {
            console.error('Error during language switch:', error);
        });
};
