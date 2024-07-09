document.addEventListener("DOMContentLoaded", function () {
    // Lấy các phần tử DOM
    const addButton = document.getElementById('addBtn');
    const editButton = document.getElementById('editBtn');
    const updateButton = document.getElementById('updateBtn');
    const deleteButton = document.getElementById('deleteBtn');
    const searchButton = document.getElementById('searchBtn');
    const cancelButton = document.getElementById('cancelBtn');

    const MaSVInput = document.getElementById('MaSVInput');
    const HoTenInput = document.getElementById('HoTenInput');
    const NgaySinhInput = document.getElementById('NgaySinhInput');
    const GioiTinhInput = document.getElementById('GioiTinhInput');
    const DiaChiInput = document.getElementById('DiaChiInput');
    const SDTInput = document.getElementById('SDTInput');
    const MailInput = document.getElementById('MailInput');
    const MaPhongInput = document.getElementById('MaPhongInput');
    const TenKhuInput = document.getElementById('TenKhuInput');
    const user_accountInput = document.getElementById('user_accountInput');
    const searchInput = document.getElementById('searchInput');

    const studentTableBody = document.getElementById('studentTableBody');
    const studentTable = document.getElementById('studentTable');

    let selectedStudentMaSV = null;

    // khi web vừa chạy lên thì khoá 2 nút
    updateButton.disabled = true;
    updateButton.style.opacity = '0.5';
    deleteButton.disabled = true;
    deleteButton.style.opacity = '0.5';

    // Lấy dữ liệu sinh viên và hiển thị trên bảng khi trang được tải
    fetchStudents();
    // Hàm để lấy dữ liệu sinh viên từ API và hiển thị trên bảng
    function fetchStudents() {
        fetch('http://localhost/KTX-API/API_RESTFUL_MVC-main/api/student/read.php')
            .then(response => response.json())
            .then(data => {
                if (data.message === 'No records found') {
                    // Hiển thị thông báo không có bản ghi nếu không có dữ liệu
                    console.log('No records found');
                } else {
                    // Hiển thị dữ liệu sinh viên trên bảng
                    displayStudents(data.data);
                }
            })
            .catch(error => console.error('Error:', error));
    }

    // Hàm để hiển thị dữ liệu sinh viên trên bảng
    function displayStudents(students) {
        // Xóa hết dữ liệu cũ trên bảng
        studentTableBody.innerHTML = '';
        // Duyệt qua mảng sinh viên và thêm từng dòng vào bảng
        students.forEach(student => {
            const row = `<tr data-student-MaSV="${student.MaSV}">
                            <td>${student.MaSV}</td>
                            <td>${student.HoTen}</td>
                            <td>${student.NgaySinh}</td>
                            <td>${student.GioiTinh}</td>
                            <td>${student.DiaChi}</td>
                            <td>${student.SDT}</td>
                            <td>${student.Mail}</td>
                            <td>${student.MaPhong}</td>
                            <td>${student.TenKhu}</td>
                            <td>${student.user_account}</td>
                        </tr>`;
            studentTableBody.insertAdjacentHTML('beforeend', row);
        });
    }

    // Sự kiện click vào hàng trong bảng
    studentTable.addEventListener('click', function (event) {
        const selectedRow = event.target.closest('tr');
        if (selectedRow) {
            addButton.disabled = true;
            addButton.style.opacity = '0.5';
            cancelButton.disabled = false;
            cancelButton.style.opacity = '1';
            deleteButton.disabled = false;
            deleteButton.style.opacity = '1';
            // Lấy MaSV của sinh viên được chọn và gán vào selectedStudentMaSV
            selectedStudentMaSV = selectedRow.getAttribute('data-student-MaSV');

            // Lấy thông tin của sinh viên từ API và hiển thị lên các ô input
            fetch(`http://localhost/KTX-API/API_RESTFUL_MVC-main/api/student/show.php?MaSV=${selectedStudentMaSV}`)
                .then(response => response.json())
                .then(student => {
                    MaSVInput.value = student.MaSV;
                    HoTenInput.value = student.HoTen;
                    NgaySinhInput.value = student.NgaySinh;
                    GioiTinhInput.value = student.GioiTinh;
                    DiaChiInput.value = student.DiaChi;
                    SDTInput.value = student.SDT;
                    MailInput.value = student.Mail;
                    MaPhongInput.value = student.MaPhong;
                    TenKhuInput.value = student.TenKhu;
                    user_accountInput.value = student.user_account;

                    console.log(selectedStudentMaSV);

                })
                .catch(error => console.error('Error:', error));
        }
    });
    // Sự kiện click vào nút Thêm sinh viên
    addButton.addEventListener('click', function () {
        // Thêm sinh viên mới nếu không có mã sinh viên trùng
        const newStudent = {
            MaSV: MaSVInput.value,
            HoTen: HoTenInput.value,
            NgaySinh: NgaySinhInput.value,
            GioiTinh: GioiTinhInput.value,
            DiaChi: DiaChiInput.value,
            SDT: SDTInput.value,
            Mail: MailInput.value,
            MaPhong: MaPhongInput.value,
            TenKhu: TenKhuInput.value,
            user_account: user_accountInput.value,
        };

        // Kiểm tra xem tất cả các ô text có giá trị không
        if (MaSVInput.value && HoTenInput.value && NgaySinhInput.value && GioiTinhInput.value && DiaChiInput.value
            && SDTInput.value && MailInput.value && MaPhongInput.value && TenKhuInput.value && user_accountInput.value) {

            // Gọi hàm KiemTra để kiểm tra dữ liệu
            if (!KiemTra()) {
                // Nếu dữ liệu không hợp lệ, dừng hàm và không thực hiện thêm sinh viên
                return;
            }

            // Kiểm tra xem mã sinh viên có trùng không
            fetch(`http://localhost/KTX-API/API_RESTFUL_MVC-main/api/student/show.php?MaSV=${newStudent.MaSV}`)
                .then(response => response.json())
                .then(exitstingStudent => {
                    if (exitstingStudent && exitstingStudent.MaSV === newStudent.MaSV) {
                        alert('Mã sinh viên đã tồn tại. Vui lòng chọn mã sinh viên khác.');
                    } else {
                        fetch('http://localhost/KTX-API/API_RESTFUL_MVC-main/api/student/create.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify(newStudent)
                        })
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error('Network response was not ok');
                                }
                                return response.json();
                            })
                            .then(data => {
                                console.log(data);
                                fetchStudents();
                                resetForm();
                            })
                            .catch(error => console.error('Error:', error));
                    }
                })
                .catch(error => console.error('Error:', error));
        } else {
            alert('Vui lòng điền đầy đủ thông tin sinh viên.');
        }
    });



    // Sự kiện click vào nút Edit
    editButton.addEventListener('click', function () {
        // Kiểm tra xem có hàng nào được chọn không
        if (selectedStudentMaSV) {
            const selectedRow = document.querySelector(`tr[data-student-MaSV="${selectedStudentMaSV}"]`);
            const cells = selectedRow.querySelectorAll('td');
            MaSVInput.value = cells[0].innerText; // Chỉ mục 0 cho Mã SV
            HoTenInput.value = cells[1].innerText; // Chỉ mục 1 cho Họ tên
            NgaySinhInput.value = cells[2].innerText; // Chỉ mục 2 cho Ngày sinh
            GioiTinhInput.value = cells[3].innerText; // Chỉ mục 3 cho Giới tính
            DiaChiInput.value = cells[4].innerText; // Chỉ mục 4 cho Địa chỉ
            SDTInput.value = cells[5].innerText; // Chỉ mục 5 cho SDT
            MailInput.value = cells[6].innerText; // Chỉ mục 6 cho Mail
            MaPhongInput.value = cells[7].innerText; // Chỉ mục 7 cho Mã phòng
            TenKhuInput.value = cells[8].innerText; // Chỉ mục 8 cho Tên Khu
            user_accountInput.value = cells[9].innerText; // Chỉ mục 9 cho Tên đăng nhập

            MaSVInput.disabled = true;

            updateButton.disabled = false;
            cancelButton.disabled = false;
            updateButton.style.opacity = '1';
            cancelButton.style.opacity = '1';

            addButton.disabled = true;
            deleteButton.disabled = true;
            addButton.style.opacity = '0.5';
            deleteButton.style.opacity = '0.5';
        }
    });



    // Sự kiện click vào nút Update
    updateButton.addEventListener('click', function () {
        // Kiểm tra xem tất cả các ô text có giá trị không
        if (MaSVInput.value && HoTenInput.value && NgaySinhInput.value && GioiTinhInput.value && DiaChiInput.value
            && SDTInput.value && MailInput.value && MaPhongInput.value && TenKhuInput.value && user_accountInput.value) {
            // Lấy thông tin sinh viên từ các ô input
            const updatedStudent = {
                MaSV: selectedStudentMaSV,
                MaSV: MaSVInput.value,
                HoTen: HoTenInput.value,
                NgaySinh: NgaySinhInput.value,
                GioiTinh: GioiTinhInput.value,
                DiaChi: DiaChiInput.value,
                SDT: SDTInput.value,
                Mail: MailInput.value,
                MaPhong: MaPhongInput.value,
                TenKhu: TenKhuInput.value,
                user_account: user_accountInput.value,
            };

            // Gọi hàm cập nhật thông tin sinh viên
            updateStudent(updatedStudent);
        } else {
            alert('Vui lòng điền đầy đủ thông tin sinh viên.');
        }
    });

    function updateStudent(student) {
        // Gọi hàm KiemTra để kiểm tra dữ liệu
        if (!KiemTra()) {
            // Nếu dữ liệu không hợp lệ, dừng hàm và không thực hiện cập nhật sinh viên
            return;
        }

        console.log('Data sent to server:', student);

        // Gửi yêu cầu cập nhật sinh viên đến API
        fetch('http://localhost/KTX-API/API_RESTFUL_MVC-main/api/student/update.php', {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(student)
        })
            .then(response => response.json())
            .then(data => {
                console.log('Response from server:', data);
                if (data.success) {
                    // Nếu cập nhật thành công, làm mới dữ liệu sinh viên và hiển thị lại trên bảng
                    fetchStudents();
                    selectedStudentMaSV = student.MaSV;
                } else {
                    alert('Cập nhật không thành công. Vui lòng thử lại sau.');
                }
                resetForm();
                editButton.disabled = false;
                editButton.style.opacity = '1';

                addButton.disabled = false;
                deleteButton.disabled = false;
                addButton.style.opacity = '1';
                deleteButton.style.opacity = '1';
            })
            .catch(error => console.error('Error:', error));
    }


    // Sự kiện click vào nút Xoá sinh viên
    deleteButton.addEventListener('click', function () {
        if (selectedStudentMaSV) {
            var confirmation = confirm("Bạn có chắc chắn muốn xóa không?");
            if (confirmation) {
                fetch(`http://localhost/KTX-API/API_RESTFUL_MVC-main/api/student/delete.php?MaSV=${selectedStudentMaSV}`, {
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
                        fetchStudents();
                        alert("Xóa thành công!");
                        resetForm();
                    })
                    .catch(error => console.error('Error:', error));
            } else {
                // Nếu người dùng chọn "Hủy"
                console.log("Hủy xóa sinh viên");     // Hoặc có thể thực hiện các hành động khác tùy theo yêu cầu
            }
        }
        else {
            console.log("Không có phòng được chọn để xóa");

        }
        MaSVInput.disabled = true;
        addButton.disabled = false;
        addButton.style.opacity = '1';
    });

    // Sự kiện click vào nút Hủy
    cancelButton.addEventListener('click', function () {
        resetForm();
        MaSVInput.disabled = false;
        editButton.disabled = false;
        editButton.style.opacity = '1';
        addButton.disabled = false;
        addButton.style.opacity = '1';
        deleteButton.disabled = true;
        deleteButton.style.opacity = '0.5';

    });

    // Gán sự kiện cho nút Tìm kiếm
    searchButton.addEventListener('click', function () {
        // Lấy giá trị MaSV từ input
        const searchKeyWord = searchInput.value;
        searchStudent(searchKeyWord);
    });

    // Hàm để tìm kiếm sinh viên theo MaSV và hiển thị kết quả trên bảng
    function searchStudent(keyword) {
        // Gọi API để lấy thông tin sinh viên theo MaSV
        fetch(`http://localhost/KTX-API/API_RESTFUL_MVC-main/api/student/search.php?keyword=${keyword}`)
            .then(response => response.json())
            .then(data => {
                // Hiển thị kết quả trên bảng
                displayStudents(data);
            })
            .catch(error => console.error('Error:', error));
    }

    function resetForm() {
        selectedStudentMaSV = null;
        MaSVInput.value = '';
        HoTenInput.value = '';
        NgaySinhInput.value = '';
        GioiTinhInput.value = '';
        DiaChiInput.value = '';
        SDTInput.value = '';
        MailInput.value = '';
        MaPhongInput.value = '';
        TenKhuInput.value = '';
        user_accountInput.value = '';
    }

    function KiemTra() {
        // Kiểm tra số điện thoại không chứa chữ cái
        const phoneRegex = /^[0-9]+$/;
        const phoneValue = SDTInput.value.trim(); // Cắt bỏ khoảng trắng thừa
        if (!phoneRegex.test(phoneValue)) {
            alert('Số điện thoại không được chứa chữ cái. Vui lòng nhập lại.');
            return false; // Trả về false nếu dữ liệu không hợp lệ
        }
        // Kiểm tra địa chỉ email hợp lệ
        const emailRegex = /^[^\s@]+@gmail\.com$/; // dạng phổ biến: /^[^\s@]+@[^\s@]+\.[^\s@]+$/
        const emailValue = MailInput.value.trim(); // Cắt bỏ khoảng trắng thừa
        if (!emailRegex.test(emailValue)) {
            alert('Địa chỉ email không hợp lệ. Vui lòng nhập lại.');
            return false; // Trả về false nếu dữ liệu không hợp lệ
        }
        // Trả về true nếu dữ liệu hợp lệ
        return true;
    }

});
