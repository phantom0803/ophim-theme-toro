# THEME - TORO 2023 - OPHIM CMS

## Demo
### Trang Chủ
![Alt text](https://i.ibb.co/WzsL2vL/THEME-TORO-INDEX.png "Home Page")

### Trang Danh Sách Phim
![Alt text](https://i.ibb.co/W29D6Pp/THEME-TORO-CATALOG.png "Catalog Page")

### Trang Thông Tin Phim
![Alt text](https://i.ibb.co/dbSBgfC/THEME-TORO-SINGLE.png "Single Page")

### Trang Xem Phim
![Alt text](https://i.ibb.co/QfcscDD/THEME-TORO-EPISODE.png "Episode Page")

## Requirements
https://github.com/hacoidev/ophim-core

## Install
1. Tại thư mục của Project: `composer require ophimcms/theme-toro`
2. Kích hoạt giao diện trong Admin Panel

## Update
1. Tại thư mục của Project: `composer update ophimcms/theme-toro`
2. Re-Activate giao diện trong Admin Panel

## Note
- Một vài lưu ý quan trọng của các nút chức năng:
    + `Activate` và `Re-Activate` sẽ publish toàn bộ file js,css trong themes ra ngoài public của laravel.
    + `Reset` reset lại toàn bộ cấu hình của themes

## Document
### List
- Home page poster slider: `Label|relation|find_by_field|value|sort_by_field|sort_algo|limit`
####
    Phim đề cử||is_recommended|1|updated_at|desc|10
####

- Home page thumb slider: `Label|relation|find_by_field|value|sort_by_field|sort_algo|limit`
####
    Phim mới cập nhật||is_copyright|0|updated_at|desc|24
####

- Leftbar: `display_label|relation|find_by_field|value|sort_by_field|sort_algo|limit|show_more_url|show_template (section_thumb|section_poster)`
####
    Phim chiếu rạp mới||is_shown_in_theater|1|created_at|desc|6|/danh-sach/phim-chieu-rap|section_poster
    Phim bộ mới||type|series|updated_at|desc|16|/danh-sach/phim-bo|section_thumb
    Phim lẻ mới||type|single|updated_at|desc|16|/danh-sach/phim-le|section_thumb
    Phim hoạt hình mới|categories|slug|hoat-hinh|updated_at|desc|12|/the-loai/hoat-hinh|section_poster
####

- Rightbar:  `Label|relation|find_by_field|value|sort_by_field|sort_algo|limit|show_template (rightbar_text|rightbar_thumb|rightbar_thumb_2)`
####
    Sắp chiếu||status|trailer|publish_year|desc|5|rightbar_text
    Top phim lẻ||type|single|view_week|desc|5|rightbar_thumb
    Top phim bộ||type|series|view_week|desc|6|rightbar_thumb_2
####

### Custom View Blade
- File blade gốc trong Package: `/vendor/ophimcms/ophim-toro/resources/views/themetoro`
- Copy file cần custom đến: `/resources/views/vendor/themes/toro`
