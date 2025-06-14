<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

## Giới thiệu

Dự án là một trang web thương mại điện tử chuyên cung cấp các sản phẩm cà phê chất lượng cao. Trang web được xây dựng trên nền tảng Laravel, một framework PHP mạnh mẽ và linh hoạt, giúp việc phát triển trở nên dễ dàng và thú vị hơn.

## Chức năng chính

- *Quản lý sản phẩm*: Cho phép quản trị viên thêm, chỉnh sửa và xóa sản phẩm.
- *Quản lý đơn hàng*: Người dùng có thể đặt hàng, xem lịch sử đơn hàng và theo dõi trạng thái đơn hàng.
- *Đánh giá sản phẩm*: Người dùng có thể đánh giá và nhận xét về các sản phẩm đã mua.
- *Quản lý người dùng*: Hỗ trợ đăng ký, đăng nhập, chỉnh sửa hồ sơ và đổi mật khẩu.
- *Quản lý giao dịch*: Quản trị viên có thể theo dõi và quản lý các giao dịch tài chính.

## Hướng dẫn cài đặt

1. *Clone repository*:
    
    git clone https://github.com/nguyenvanchienn/WEBNC.git
    

2. *Cài đặt các gói phụ thuộc*:
    
    composer install
    npm install
    

3. *Cấu hình môi trường*:
    - Tạo file [.env](http://_vscodecontentref_/0) từ file mẫu [.env.example](http://_vscodecontentref_/1):
        
        cp .env.example .env
        
    - Cập nhật các thông tin cấu hình trong file [.env](http://_vscodecontentref_/2) (database, mail, etc.).

4. *Tạo khóa ứng dụng*:
    
    php artisan key:generate
    

5. *Chạy các migration và seed dữ liệu*:
    
    php artisan migrate --seed
    

6. *Khởi động server*:
    
    php artisan serve
    

## Hướng dẫn sử dụng

### Người dùng

- *Đăng ký và đăng nhập*: Người dùng có thể đăng ký tài khoản mới hoặc đăng nhập vào tài khoản hiện có.
- *Mua hàng*: Duyệt qua các sản phẩm, thêm vào giỏ hàng và tiến hành thanh toán.
- *Đánh giá sản phẩm*: Sau khi mua hàng, người dùng có thể để lại đánh giá và nhận xét về sản phẩm.

### Quản trị viên

- *Quản lý sản phẩm*: Thêm mới, chỉnh sửa và xóa sản phẩm.
- *Quản lý đơn hàng*: Xem và cập nhật trạng thái đơn hàng.
- *Quản lý người dùng*: Xem danh sách người dùng và chỉnh sửa thông tin nếu cần.
- *Quản lý giao dịch*: Theo dõi các giao dịch tài chính và tạo báo cáo.

## Tài liệu và Hỗ trợ

- [Tài liệu Laravel](https://laravel.com/docs)
- [Laravel Bootcamp](https://bootcamp.laravel.com)
- [Laracasts](https://laracasts.com)

## Đóng góp

Chúng tôi hoan nghênh mọi đóng góp từ cộng đồng. Nếu bạn muốn đóng góp, vui lòng fork repository này và gửi pull request.

## Liên hệ

Nếu bạn có bất kỳ câu hỏi hoặc phản hồi nào, vui lòng liên hệ với chúng tôi.

---

Cảm ơn bạn đã sử dụng dịch vụ của chúng tôi!
