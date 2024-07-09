document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.getElementById('login-form');
    loginForm.addEventListener('submit', function(event) {
        event.preventDefault();
        const formData = new FormData(loginForm);

        fetch('http://localhost/KTX-API/API_RESTFUL_MVC-main/api/login/login.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Đăng nhập thành công, redirect hoặc thực hiện hành động tiếp theo
                alert(data.message);
                window.location.href = '../menu/index.html'; // Redirect đến trang dashboard
            } else {
                // Đăng nhập thất bại, hiển thị thông báo lỗi
                document.getElementById('message').textContent = data.message;
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
});
