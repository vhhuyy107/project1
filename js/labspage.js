function toggleLab(id) {
        // Lấy danh sách cần xổ ra
        var list = document.getElementById(id);
        
        // Kiểm tra xem nó đang hiện hay ẩn để toggle class
        if (list.classList.contains('show-files')) {
            list.classList.remove('show-files');
        } else {
            // (Tùy chọn) Đóng tất cả các tab khác trước khi mở tab này
            var allLists = document.querySelectorAll('.file-list');
            allLists.forEach(function(item) {
                item.classList.remove('show-files');
            });
            
            // Mở tab hiện tại
            list.classList.add('show-files');
        }
    }