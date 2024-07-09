document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("registration-form").addEventListener("submit", function(event) {
        event.preventDefault();

        var username = document.getElementById("username").value;
        var password = document.getElementById("password").value;
        var confirmPassword = document.getElementById("confirm-password").value;

        // Tạo một đối tượng FormData chứa dữ liệu form
        var formData = new FormData();
        formData.append("username", username);
        formData.append("password", password);
        formData.append("confirm-password", confirmPassword);

        // Gửi dữ liệu đăng ký lên server sử dụng fetch
        fetch("http://localhost/KTX-API/API_RESTFUL_MVC-main/api/register/register.php", {
            method: "POST",
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                window.location.href = '../login/index.html';
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error("Error:", error);
        });
    });
});
