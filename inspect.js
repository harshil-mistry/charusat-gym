document.addEventListener('contextmenu', function (e) {
    e.preventDefault();
});
document.addEventListener('keydown', function (e) {
    // Block F12
    if (e.key === "F12") {
        e.preventDefault();
    }
    // Block Ctrl+Shift+I or Command+Option+I (for Mac)
    if (e.ctrlKey && e.shiftKey && e.key === 'I') {
        e.preventDefault();
    }
    // Block Ctrl+Shift+J or Command+Option+J (for Mac)
    if (e.ctrlKey && e.shiftKey && e.key === 'J') {
        e.preventDefault();
    }
    // Block Ctrl+U (View Page Source)
    if (e.ctrlKey && e.key === 'u') {
        e.preventDefault();
    }
});