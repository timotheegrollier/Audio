let uploadImg = document.getElementById("form_imageFile_file");
let errorExt = document.getElementById("errorExt");

if (uploadImg) {
  form_imageFile_file.onchange = (evt) => {
    const [file] = form_imageFile_file.files;
    let fileName = [file][0].name;
    let extensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;

    if (file) {
        // On vérifie l'extension du fichier grace à la regex
      if (extensions.exec(fileName)) {
        errorExt.classList.add("d-none");
        $("#blah").css("display", "block");
        blah.src = URL.createObjectURL(file);
      } else {
        errorExt.classList.remove("d-none");
        $("#blah").css("display", "none");
      }
    }
  };
}
