
uploadImg = document.getElementById('form_imageFile_file')

if (uploadImg) {
    form_imageFile_file.onchange = evt => {
        const [file] = form_imageFile_file.files
        if (file) {
            $('#blah').css('display', 'block')
            blah.src = URL.createObjectURL(file)
        }
    }
}