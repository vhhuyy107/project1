const fileInput = document.getElementById('file-input');
        const preview = document.getElementById('preview');
        fileInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                preview.src = URL.createObjectURL(file);
            }
        });