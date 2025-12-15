function changeImage(smallImg) {
            document.getElementById("MainImg").src = smallImg.src;
        }

        // Hàm kiểm tra Size
        function validateSize() {
            var size = document.getElementById("sizeSelect").value;
            // Nếu value là rỗng (option đầu tiên) thì báo lỗi
            if (size === "") {
                alert("⚠️ Vui lòng chọn Size giày trước khi thêm vào giỏ!");
                return false; // Chặn không cho gửi form
            }
            return true; // Cho phép gửi form
        }