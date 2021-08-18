const uploadImg = document.querySelector(".form_imageFile_file");
const errorExt = document.getElementById("errorExtImg");
const errorSize = document.getElementById("errorSizeImg");

if (uploadImg) {
  uploadImg.onchange = (e) => {
    const file = uploadImg.files;
    let extensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;

    if (file[0]) {

      // On vérifie l'extension du fichier grace à la regex
      if (extensions.exec(file[0].name)) {
        errorExt.classList.add("d-none");
        $("#imgPreview").css("display", "block");
        $(".vich-image a").hide();
        imgPreview.src = URL.createObjectURL(file[0]);
      } else {
        $("#imgPreview").css("display", "none");
        errorExt.classList.remove("d-none");
      }

      // On vérifie son poid
      if (file[0].size < 5000000) {
        errorSize.classList.add("d-none");
      } else {
        errorSize.classList.remove("d-none");
      }


      //   On réactive le button uniquement si il n'y aucun message d'erreur
      if ($('#errorExtSound').hasClass('d-none') && $('#errorSizeSound').hasClass('d-none') && $('#errorExtImg').hasClass('d-none') && $('#errorSizeImg').hasClass('d-none')) {
        $('#uploadBtn').removeAttr('disabled')
      } else {
        $('#uploadBtn').attr('disabled', 'disabled')

      }
    } else {
      errorExt.classList.add("d-none");
      errorSize.classList.add("d-none");
      $('#uploadBtn').removeAttr('disabled')

    }

  };
}
