// Preview ảnh ngay khi chọn
        const avatarInput = document.getElementById("avatarInput");
        const preview = document.getElementById("preview");

        avatarInput.addEventListener("change", function() {
            const file = this.files[0];
            if (file) {
                preview.src = URL.createObjectURL(file);
            }
        });