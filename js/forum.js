document.querySelector('form').addEventListener('submit', function(e) {
    const title = document.getElementById('title');
    if (!title.value) {
        e.preventDefault();
        alert('Titel is verplicht!');
    }
});
