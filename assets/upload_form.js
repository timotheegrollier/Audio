const uploadForm = document.getElementById('uploadForm');

if (uploadForm) {
    uploadForm.addEventListener('submit', (e) => {
        $('#uploadBtn').attr('disabled', 'disabled')
        console.log(e);
    })

}