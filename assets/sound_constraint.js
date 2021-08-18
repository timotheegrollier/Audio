const uploadSound = document.querySelector(".form_soundFile_file");
const errorExtSound = document.getElementById("errorExtSound");
const errorSizeSound = document.getElementById("errorSizeSound");


if (uploadSound) {
    uploadSound.onchange = (e) => {
        const file = uploadSound.files;
        let extensions = /(\.mp3|\.ogg|\.aac|\.mpeg|\.oga)$/i;

        if (file[0]) {
            // On vérifie l'extension du fichier grace à la regex
            if (extensions.exec(file[0].name)) {
                errorExtSound.classList.add("d-none");
            } else {
                errorExtSound.classList.remove("d-none");
            }

            // On vérifie que le fichier ne dépasse pas 100Mo
            if (file[0].size < 100000000) {
                errorSizeSound.classList.add("d-none");
            } else {
                errorSizeSound.classList.remove("d-none");
            }

            //   On réactive le button uniquement si les deux conditions sont remplie si i l n'y aucun message d'erreur
            if ($('#errorExtSound').hasClass('d-none') && $('#errorSizeSound').hasClass('d-none') && $('#errorExtImg').hasClass('d-none') && $('#errorSizeImg').hasClass('d-none')) {
                $('#uploadBtn').removeAttr('disabled')
            } else {
                $('#uploadBtn').attr('disabled', 'disabled')

            }
        }
        // Si aucun fichier upload Aucun message d'erreur et bouton ON
        else {
            $('#uploadBtn').removeAttr('disabled')
            errorExtSound.classList.add('d-none')
            errorSizeSound.classList.add('d-none')
        }

    };
}

