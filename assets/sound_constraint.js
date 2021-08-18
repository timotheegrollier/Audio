let uploadSound = document.querySelector(".form_soundFile_file");
let errorExtSound = document.getElementById("errorExtSound");

if (uploadSound) {
    uploadSound.onchange = (evt) => {
        const [file] = uploadSound.files;
        let fileName = [file][0].name;
        let extensions = /(\.mp3|\.ogg|\.aac|\.mpeg|\.oga)$/i;

        if (file) {
            // On vérifie l'extension du fichier grace à la regex
            if (extensions.exec(fileName)) {
                errorExtSound.classList.add("d-none");

            } else {
                errorExtSound.classList.remove("d-none");
                $(".loader").css("display", "none");
            }
        }
    };
}


