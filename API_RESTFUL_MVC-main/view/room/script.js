document.addEventListener("DOMContentLoaded", function () {
    // Lấy các phần tử DOM
    const addButton = document.getElementById('addBtn');
    const updateButton = document.getElementById('updateBtn');
    const deleteButton = document.getElementById('deleteBtn');
    const searchButton = document.getElementById('searchBtn');
    const cancelButton = document.getElementById('cancelBtn');
    const MaPhongInput = document.getElementById('MaPhongInput');
    const MaKhuInput = document.getElementById('MaKhuInput');
    const SoNguoiToiDaInput = document.getElementById('SoNguoiToiDaInput');
    const SoNguoiHienTaiInput = document.getElementById('SoNguoiHienTaiInput');
    const GiaInput = document.getElementById('GiaInput');
    const phongTableBody = document.getElementById('phongTableBody');
    const phongTable = document.getElementById('phongTable');
    const searchInput = document.getElementById('searchInput');

    let selectedPhongId = null;

    // Lấy dữ liệu sinh viên và hiển thị trên bảng khi trang được tải
    fetchPhongs();

    // Hàm để lấy dữ liệu sinh viên từ API và hiển thị trên bảng
    function fetchPhongs() {
        fetch('http://localhost/KTX-API/API_RESTFUL_MVC-main/api/room/read.php')
            .then(response => response.json())
            .then(data => {
                if (data.message === 'No records found') {
                    // Hiển thị thông báo không có bản ghi nếu không có dữ liệu
                    console.log('No records found');
                } else {
                    //cap nhat so luong sinh vien hien tai trong moi phong khi tair laij trang
                    fetchCurrentStudentsCount()
                    // Hiển thị dữ liệu sinh viên trên bảng
                    displayPhongs(data.data);
                }
            })
            .catch(error => console.error('Error:', error));
        addButton.disabled = false;
        deleteButton.disabled = true;
        updateButton.disabled = true;
        addButton.style.opacity = '1';
        deleteButton.style.opacity = '0.5';
        updateButton.style.opacity = '0.5';
    }

    // Hàm để hiển thị dữ liệu sinh viên trên bảng
    function displayPhongs(phongs) {
        // Xóa hết dữ liệu cũ trên bảng
        phongTableBody.innerHTML = '';

        // Duyệt qua mảng sinh viên và thêm từng dòng vào bảng
        phongs.forEach(phong => {
            const row = `<tr data-phong-id="${phong.MaPhong}">
            <td>${phong.MaPhong}</td>
            <td>${phong.MaKhu}</td>
            <td>${phong.SoNguoiToiDa}</td>
            <td>${phong.SoNguoiHienTai}</td>
            <td>${phong.Gia}</td>
            </tr>`;
            phongTableBody.insertAdjacentHTML('beforeend', row);
        });
    }

    // Hàm để cập nhật số người hiện tại trong mỗi phòng từ cơ sở dữ liệu
function fetchCurrentStudentsCount() {
    fetch('http://localhost/KTX-API/API_RESTFUL_MVC-main/api/room/songuoihientai.php')
        .then(response => response.json())
        .then(data => {
            data.forEach(item => {
                const MaPhong = item.MaPhong;
                const SoSinhVien = item.SoSinhVien;

                // Tìm phòng tương ứng trong bảng và cập nhật số người hiện tại
                const phongRow = document.querySelector(`tr[data-phong-id="${MaPhong}"]`);
                if (phongRow) {
                    const SoNguoiHienTaiCell = phongRow.querySelector('td:nth-child(4)');
                    if (SoNguoiHienTaiCell) {
                        SoNguoiHienTaiCell.textContent = SoSinhVien;
                    }
                }

                // Cập nhật số người hiện tại trong cơ sở dữ liệu
                updateCurrentStudentsCountInDatabase(MaPhong, SoSinhVien);
            });
        })
        .catch(error => console.error('Error:', error));
}

// Hàm để cập nhật số người hiện tại trong cơ sở dữ liệu
function updateCurrentStudentsCountInDatabase() {
    // Gửi yêu cầu để lấy danh sách tất cả các mã phòng từ cơ sở dữ liệu
    fetch('http://localhost/KTX-API/API_RESTFUL_MVC-main/api/room/all_rooms.php')
        .then(response => response.json())
        .then(data => {
            // Duyệt qua danh sách các mã phòng
            data.forEach(room => {
                const MaPhong = room.MaPhong;
                const SoSinhVien = room.SoSinhVien;

                // Gửi yêu cầu cập nhật số người hiện tại cho từng mã phòng
                fetch(`http://localhost/KTX-API/API_RESTFUL_MVC-main/api/room/update_songuoihientai.php?MaPhong=${MaPhong}&SoNguoiHienTai=${SoSinhVien}`, {
                    method: 'PUT'
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log(data);
                })
                .catch(error => console.error('Error:', error));
            });
        })
        .catch(error => console.error('Error:', error));
}



    // Sự kiện click vào hàng trong bảng
    phongTable.addEventListener('click', function (event) {
        const selectedRow = event.target.closest('tr');
        if (selectedRow) {
            const selectedRows = phongTableBody.querySelectorAll('.selected-row');
            selectedRows.forEach(row => {
                row.classList.remove('selected-row');
            });
            // Thêm kiểu cho hàng được chọn
            selectedRow.classList.add('selected-row');

            // Lấy id của sinh viên được chọn
            selectedPhongId = selectedRow.getAttribute('data-phong-id');

            // Lấy thông tin của sinh viên từ API và hiển thị lên các ô input
            fetch(`http://localhost/KTX-API/API_RESTFUL_MVC-main/api/room/show.php?MaPhong=${selectedPhongId}`)
                .then(response => response.json())
                .then(phong => {
                    MaPhongInput.value = phong.MaPhong;
                    MaKhuInput.value = phong.MaKhu;
                    SoNguoiToiDaInput.value = phong.SoNguoiToiDa;
                    SoNguoiHienTaiInput.value = phong.SoNguoiHienTai;
                    GiaInput.value = phong.Gia;

                    // Disable chỉnh sửa ô MaPhong
                    MaPhongInput.disabled = true;
                })
                .catch(error => console.error('Error:', error));

            addButton.disabled = true;
            deleteButton.disabled = false;
            updateButton.disabled = false;
            addButton.style.opacity = '0.5';
            deleteButton.style.opacity = '1';
            updateButton.style.opacity = '1';
        }
    });


    // Sự kiện click vào nút Thêm
    addButton.addEventListener('click', function () {
        // Kiểm tra xem các ô text (ngoại trừ ô text Số người hiện tại) đã được nhập đầy đủ thông tin chưa
        if (MaPhongInput.value && MaKhuInput.value && SoNguoiToiDaInput.value && GiaInput.value) {
            const newPhong = {
                MaPhong: MaPhongInput.value,
                MaKhu: MaKhuInput.value,
                SoNguoiToiDa: SoNguoiToiDaInput.value,
                SoNguoiHienTai: 0, // Gán giá trị mặc định cho Số người hiện tại là 0
                Gia: GiaInput.value
            };
    
            // Kiểm tra xem Mã phòng đã tồn tại chưa bằng cách gửi yêu cầu GET đến API
            fetch(`http://localhost/KTX-API/API_RESTFUL_MVC-main/api/room/show.php?MaPhong=${newPhong.MaPhong}`)
                .then(response => response.json())
                .then(existingPhong => {
                    if (existingPhong && existingPhong.MaPhong === newPhong.MaPhong) {
                        // Nếu Mã phòng đã tồn tại, hiển thị thông báo lỗi
                        alert("Mã phòng đã tồn tại. Vui lòng nhập Mã phòng khác!");
                    } else {
                        // Nếu Mã phòng chưa tồn tại, thêm mới
                        fetch('http://localhost/KTX-API/API_RESTFUL_MVC-main/api/room/create.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify(newPhong)
                        })
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error('Network response was not ok');
                                }
                                return response.json();
                            })
                            .then(data => {
                                console.log(data);
                                fetchPhongs();
                                alert("Thêm thành công!");
                            })
                            .catch(error => console.error('Error:', error));
                    }
                })
                .catch(error => console.error('Error:', error));
    
            addButton.disabled = false;
            deleteButton.disabled = true;
            updateButton.disabled = true;
            addButton.style.opacity = '1';
            deleteButton.style.opacity = '0.5';
            updateButton.style.opacity = '0.5';
        } else {
            // Nếu không nhập đầy đủ thông tin, hiển thị thông báo
            alert("Bạn phải nhập đầy đủ thông tin (ngoại trừ Số người hiện tại)!");
        }
    });
    


    // Sự kiện click vào nút Sửa
    updateButton.addEventListener('click', function () {
        const updatedPhong = {
            MaPhong: selectedPhongId,
            MaKhu: MaKhuInput.value,
            SoNguoiToiDa: SoNguoiToiDaInput.value,
            SoNguoiHienTai: SoNguoiHienTaiInput.value,
            Gia: GiaInput.value
        };

        fetch('http://localhost/KTX-API/API_RESTFUL_MVC-main/api/room/update.php', {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(updatedPhong)
        })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                fetchPhongs();
                alert("Sửa thành công!");
            })
            .catch(error => console.error('Error:', error));

        addButton.disabled = false;
        deleteButton.disabled = true;
        updateButton.disabled = true;
        addButton.style.opacity = '1';
        deleteButton.style.opacity = '0.5';
        updateButton.style.opacity = '0.5';
    });

    // Sự kiện click vào nút Xoá
    // deleteButton.addEventListener('click', function() {
    //     if (selectedPhongId) {

    //         fetch(`http://localhost/KTX-API/API_RESTFUL_MVC-main/api/room/delete.php?MaPhong=${selectedPhongId}`, {
    //             method: 'DELETE'
    //         })
    //         .then(response => response.json())
    //         .then(data => {
    //             console.log(data);
    //             fetchPhongs();
    //         })
    //         .catch(error => console.error('Error:', error));
    //     }
    // });

    deleteButton.addEventListener('click', function () {
        if (selectedPhongId) {
            // Hiển thị hộp thoại xác nhận
            var confirmation = confirm("Bạn có chắc chắn muốn xóa không?");

            if (confirmation) {
                // Nếu người dùng chọn "Có"
                fetch(`http://localhost/KTX-API/API_RESTFUL_MVC-main/api/room/delete.php?MaPhong=${selectedPhongId}`, {
                    method: 'DELETE'
                })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log(data);
                        fetchPhongs();
                        alert("Xóa thành công!");
                    })
                    .catch(error => console.error('Error:', error));
            } else {
                // Nếu người dùng chọn "Hủy"
                console.log("Hủy xóa phòng");
                // Hoặc có thể thực hiện các hành động khác tùy theo yêu cầu
            }
        } else {
            console.log("Không có phòng được chọn để xóa");
            // Hoặc có thể thực hiện các hành động khác tùy theo yêu cầu
        }
        addButton.disabled = false;
        deleteButton.disabled = true;
        updateButton.disabled = true;
        addButton.style.opacity = '1';
        deleteButton.style.opacity = '0.5';
        updateButton.style.opacity = '0.5';
    });


    // Sự kiện click vào nút Hủy
    cancelButton.addEventListener('click', function () {
        // Xóa lớp CSS 'selected-row' khỏi tất cả các hàng trong bảng
        const selectedRows = phongTableBody.querySelectorAll('.selected-row');
        selectedRows.forEach(row => {
            row.classList.remove('selected-row');
        });

        // Đặt giá trị của selectedPhongId thành null
        selectedPhongId = null;

        // Mở khóa ô nhập liệu "Mã Phòng" để có thể chỉnh sửa
        MaPhongInput.disabled = false;

        // Đặt giá trị của các ô input về rỗng
        MaPhongInput.value = '';
        MaKhuInput.value = '';
        SoNguoiToiDaInput.value = '';
        SoNguoiHienTaiInput.value = '';
        GiaInput.value = '';

        addButton.disabled = false;
        deleteButton.disabled = true;
        updateButton.disabled = true;
        addButton.style.opacity = '1';
        deleteButton.style.opacity = '0.5';
        updateButton.style.opacity = '0.5';
    });

    // Gán sự kiện cho nút Tìm kiếm
    searchButton.addEventListener('click', function () {
        // Lấy giá trị ID từ input
        const searchId = searchInput.value;

        // Gọi hàm searchStudent để tìm kiếm sinh viên theo ID
        searchPhong(searchId);
    });

    // Hàm để tìm kiếm sinh viên theo ID và hiển thị kết quả trên bảng
    function searchPhong(MaPhong) {
        // Gọi API để lấy thông tin sinh viên theo ID
        fetch(`http://localhost/KTX-API/API_RESTFUL_MVC-main/api/room/search.php?MaPhong=${MaPhong}`)
            .then(response => response.json())
            .then(data => {
                // Hiển thị kết quả trên bảng
                displayPhongs(data);
            })
            .catch(error => console.error('Error:', error));
    }
});
