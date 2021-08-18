let uploadImg = document.querySelector(".form_imageFile_file");
let errorExt = document.getElementById("errorExt");

if (uploadImg) {
  uploadImg.onchange = (evt) => {
    const file = uploadImg.files;
    let extensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;

    if (file) {

      // On vérifie l'extension du fichier grace à la regex
      if (extensions.exec(file[0].name)) {
        errorExt.classList.add("d-none");
        $("#blah").css("display", "block");
        $(".vich-image a").hide();
        blah.src = URL.createObjectURL(file[0]);
      } else {
        $("#blah").css("display", "none");
        errorExt.classList.remove("d-none");

      }
    }
  };
}
