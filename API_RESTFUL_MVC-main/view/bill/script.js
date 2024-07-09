document.addEventListener("DOMContentLoaded", function() {
    const maPhongInput = document.getElementById('maPhongInput');
    const maKhuInput = document.getElementById('maKhuInput');
    const soNguoiHienTaiInput = document.getElementById('soNguoiHienTaiInput');
    const soNguoiToiDaInput = document.getElementById('soNguoiToiDaInput');
    const giaInput = document.getElementById('giaInput');
    const phongTableBody = document.getElementById('phongTableBody');
    const phongTable = document.getElementById('phongTable');
    const searchInput = document.getElementById('searchInput');
    const searchButton = document.getElementById('searchBtn');

    let selectedPhongId = null;

    // Lấy dữ liệu phòng và hiển thị trên bảng khi trang được tải
    fetchPhong();

    // Hàm để lấy dữ liệu phòng từ API và hiển thị trên bảng
    function fetchPhong() {
        fetch('http://localhost/KTX-API/API_RESTFUL_MVC-main/api/bill/read.php')
            .then(response => response.json())
            .then(data => {
                if (data.message === 'No records found') {
                    console.log('No records found');
                } else {
                    displayPhong(data.data);
                }
            })
            .catch(error => console.error('Error:', error));
    }

    // Hàm để hiển thị dữ liệu phòng trên bảng
    function displayPhong(phongs) {
        phongTableBody.innerHTML = '';

        phongs.forEach(phong => {
            const row = `<tr data-phong-id="${phong.MaPhong}">
                            <td>${phong.MaPhong}</td>
                            <td>${phong.MaKhu}</td>
                            <td>${phong.SoNguoiHienTai}</td>
                            <td>${phong.SoNguoiToiDa}</td>
                            <td>${phong.Gia}</td>
                            <td><button class="add-button" data-ma-phong="${phong.MaPhong}">Thêm</button></td>
                        </tr>`;
            phongTableBody.insertAdjacentHTML('beforeend', row);
        });

        // Lắng nghe sự kiện click cho tất cả các nút "Thêm"
        const addButtons = document.querySelectorAll('.add-button');
        addButtons.forEach(button => {
            button.addEventListener('click', function() {
                const maPhong = button.getAttribute('data-ma-phong');
                redirectToHoaDonForm(maPhong);
            });
        });
    }
    
    // Gán sự kiện cho nút Tìm kiếm
    searchButton.addEventListener('click', function() {
        // Lấy giá trị mã phòng từ input
        const searchMaPhong = searchInput.value; // Loại bỏ khoảng trắng đầu cuối (nếu có)

        // Gọi hàm searchPhongByMaPhong để tìm kiếm phòng theo mã phòng
        searchPhong(searchMaPhong);
    });

    // Hàm để tìm kiếm phòng theo mã phòng và hiển thị kết quả trên bảng
    function searchPhong(MaPhong) {
        // Gọi API để lấy thông tin phòng theo mã phòng
        fetch(`http://localhost/KTX-API/API_RESTFUL_MVC-main/api/bill/search.php?MaPhong=${MaPhong}`)
            .then(response => response.json())
            .then(data => {
                // Hiển thị kết quả trên bảng
                displayPhong(data);
            })
            .catch(error => console.error('Error:', error));
    }

    // Hàm xử lý khi nút "Thêm" được nhấp
    function redirectToHoaDonForm(maPhong) {
        // Chuyển hướng người dùng đến form hóa đơn với mã phòng tương ứng
        window.location.href = `indexHoadon.html?MaPhong=${maPhong}`;
    }
});
