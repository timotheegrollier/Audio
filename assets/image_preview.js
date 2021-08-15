let uploadImg = document.querySelector(".form_imageFile_file");
let errorExt = document.getElementById("errorExt");

if (uploadImg) {
  uploadImg.onchange = (evt) => {
    const [file] = uploadImg.files;
    let fileName = [file][0].name;
    let extensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;

    if (file) {
      // On vérifie l'extension du fichier grace à la regex
      if (extensions.exec(fileName)) {
        errorExt.classList.add("d-none");
        $("#blah").css("display", "block");
        $(".vich-image a").hide();
        blah.src = URL.createObjectURL(file);
      } else {
        $("#blah").css("display", "none");
        errorExt.classList.remove("d-none");

      }
    }
  };
}
