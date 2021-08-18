let uploadSound = document.querySelector(".form_soundFile_file");
let errorExtSound = document.getElementById("errorExtSound");
let errorSizeSound = document.getElementById("errorSizeSound");

if (uploadSound) {
  uploadSound.onchange = (e) => {
    const file = uploadSound.files;
    let extensions = /(\.mp3|\.ogg|\.aac|\.mpeg)$/i;

    if (file[0]) {
      // On vérifie l'extension du fichier grace à la regex
      if (extensions.exec(file[0].name)) {
        errorExtSound.classList.add("d-none");

      } else {
          $('#uploadBtn').attr('disabled','disabled')
        errorExtSound.classList.remove("d-none");
      }

    // On vérifie que le fichier ne dépasse pas 100Mo
      if (file[0].size > 100000000) {
          $('#uploadBtn').attr('disabled','disabled')
        errorSizeSound.classList.remove("d-none");

      } else {
        errorSizeSound.classList.add("d-none");
      }

    //   On réactive le button uniquement si les deux conditions sont remplie
      if(extensions.exec(file[0].name) && file[0].size < 100000000){
        $('#uploadBtn').removeAttr('disabled')
      }
    }
  };
}
