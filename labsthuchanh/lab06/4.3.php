<?php
$content = file_get_contents("http://thethao.vnexpress.net/");
//echo $content;
$pattern='/<div class="title_news">.*<\/div>/imsU';
preg_match_all($pattern, $content, $arr);
print_r($arr);
?>
<?php
    $url = "http://thethao.vnexpress.net/";
    // Nếu allow_url_fopen bật thì thử dùng file_get_contents
    $content = file_get_contents($url);
    if ($content !== false) {
        echo "Đọc được trang web. <br/>";
        // Biểu thức chính quy tìm tất cả các thẻ h3 chứa class="title-news"
        $pattern = '/<h3\s+class=["\']title-news["\'][^>]*>(.*?)<\/h3>/is';
        preg_match_all($pattern, $content, $arr);

        // Kiểm tra và in ra kết quả
        if (!empty($arr[0])) {
            // Duyệt qua từng phần tử trong mảng kết quả
            foreach ($arr[0] as $divContent) {
                // In ra nội dung của từng thẻ div có ptu con chứa class="title-news"
                echo "Nội dung: <br>" . htmlspecialchars($divContent) . "<br><br>";
            }
        } else {
            echo "Không tìm thấy các thẻ <h3 class=\'title-news\'>";
        }
    }
?>