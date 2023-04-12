# webAssignment
1/ Client:

Cách 1:
+ Tải nodejs nếu máy tính chưa có
+ cd client -> npm install express (Để tải thư viện cần thiết)
+ node index.js (Sau đó truy cập localhost:3000/login.html)

Cách 2:
+ Sử dụng Extension Live server của Visual Studio Code

2/ Server:
+ Vào XAMPP Control Panel -> config (Ở module apache) -> Apache (httpd.conf)
-> Đổi đường dẫn C:/xampp/htdocs thành C:/.../webAssignment/server (... là đường dẫn đến thư mục webAssignment)
Ví dụ:
DocumentRoot "C:/.../webAssignment/server" 
<Directory "C:/.../webAssignment/server">
