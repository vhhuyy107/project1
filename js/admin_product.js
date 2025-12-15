// --- JAVASCRIPT XỬ LÝ 3 MODAL ---
        
        // 1. Mở Modal Thêm
        document.getElementById("openAddModalBtn").onclick = function() {
            document.getElementById("addProductModal").style.display = "block";
        }

        // 2. Mở Modal Sửa (Nhận data từ nút bấm và điền vào form)
        function openEditModal(id, name, brand, price, quantity, desc, imgSrc) {
            document.getElementById("edit_id").value = id;
            document.getElementById("edit_name").value = name;
            document.getElementById("edit_brand").value = brand;
            document.getElementById("edit_price").value = price;
            document.getElementById("edit_quantity").value = quantity;
            document.getElementById("edit_description").value = desc;
            document.getElementById("current_img_preview").src = imgSrc;
            
            document.getElementById("editProductModal").style.display = "block";
        }

        // 3. Mở Modal Xóa
        function openDeleteModal(id) {
            document.getElementById("delete_id").value = id;
            document.getElementById("deleteProductModal").style.display = "block";
        }

        // Hàm đóng Modal chung
        function closeModal(modalId) {
            document.getElementById(modalId).style.display = "none";
        }

        // Bấm ra ngoài vùng trắng thì đóng
        window.onclick = function(event) {
            if (event.target.classList.contains('modal')) {
                event.target.style.display = "none";
            }
        }