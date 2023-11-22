document.addEventListener('DOMContentLoaded', () => {
    // Po načtení stránky zkontrolovat, jestli jsou uložené hodnoty
    if (localStorage.getItem('mistnost') && document.getElementById('tryMistnost').value === '') {
        document.getElementById('mistnost').value = localStorage.getItem('mistnost');
    }
    if (localStorage.getItem('den') && document.getElementById('tryDen').value === '') {
        document.getElementById('den').value = localStorage.getItem('den');
    }
    if (localStorage.getItem('start') && document.getElementById('tryStart').value === '') {
        document.getElementById('start').value = localStorage.getItem('start');
    }
});

// Funkce pro uložení hodnot do localStorage
function saveFormValues() {
    localStorage.setItem('mistnost', document.getElementById('mistnost').value);
    localStorage.setItem('den', document.getElementById('den').value);
    localStorage.setItem('start', document.getElementById('start').value);
}