const uploadForm = document.querySelector('.uploadForm');
const submit = document.getElementById("uploadBtn")

if (uploadForm) {
    uploadForm.addEventListener('submit', (e) => {
        submit.innerHTML = "<div class='loader'><span class='spinner-border spinner-border-sm' role='status' aria-hidden='true'></span> Chargement...</div >";
        submit.disabled = true;
    })

}

