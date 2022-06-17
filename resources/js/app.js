import Dropzone from 'dropzone';

document.addEventListener('DOMContentLoaded', () => {

    if (document.querySelector('#dropzone')) {
        Dropzone.autoDiscover = false;
        const selectorImagen = document.querySelector('#imagen');

        const dropzone = new Dropzone('#dropzone', {
            dictDefaultMessage: 'Sube aquí tu imagen',
            acceptedFiles: '.png, .jpg, .jpeg, .gif',
            addRemoveLinks: true,
            dictRemoveFile: 'Borrar archivo',
            maxFiles: 1,
            uploadMultiple: false,
            init: function () {
                if (selectorImagen.value.trim()) {
                    const imagenPublicada = {};
                    imagenPublicada.size = 1234;
                    imagenPublicada.name = selectorImagen.value;

                    this.options.addedfile.call(this, imagenPublicada);
                    this.options.thumbnail.call(this, imagenPublicada, `/uploads/${imagenPublicada.name}`);

                    imagenPublicada.previewElement.classList.add('dz-success', 'dz-complete');
                }
            }
        });

        dropzone.on('success', function (file, response) {
            selectorImagen.value = response.imagen;
        });

        dropzone.on('removedfile', function () {
            selectorImagen.value = '';
        });
    }
});
