// Hàm mở Modal và điền dữ liệu
        function openEditUserModal(id, fullname, email, role) {
            document.getElementById('edit_id').value = id;
            document.getElementById('edit_fullname').value = fullname;
            document.getElementById('edit_email').value = email;
            document.getElementById('edit_role').value = role;
            
            document.getElementById('editUserModal').style.display = 'block';
        }

        // Đóng modal khi click ra ngoài
        window.onclick = function(event) {
            var modal = document.getElementById('editUserModal');
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }