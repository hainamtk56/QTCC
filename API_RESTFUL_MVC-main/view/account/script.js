document.addEventListener("DOMContentLoaded", function () {

    const userInput = document.getElementById('userInput');
    const passInput = document.getElementById('passInput');
    const typeInput = document.getElementById('typeInput');
    const searchInput = document.getElementById('searchInput');

    const addButton = document.getElementById('addBtn');
    const updateButton = document.getElementById('updateBtn');
    const deleteButton = document.getElementById('deleteBtn');
    const cancelButton = document.getElementById('cancelBtn');
    const searchButton = document.getElementById('searchBtn');

    const accountTableBody = document.getElementById('accountTableBody');
    const accountTable = document.getElementById('accountTable');

    let selectedAccountId = null;
    let isEditing = true;

    // Lấy dữ liệu sinh viên và hiển thị trên bảng khi trang được tải
    fetchAccounts();
    // disableInputs();

    // Ẩn nút "Cập nhật" và "Hủy bỏ"
    updateButton.style.display = 'none';
    cancelButton.style.display = 'none';

    // function disableInputs() {
    //     userInput.disabled = true;
    //     passInput.disabled = true;
    //     typeInput.disabled = true;
    // }

    // function enableInputs() {
    //     userInput.disabled = false;
    //     passInput.disabled = false;
    //     typeInput.disabled = false;
    // }

    // Hàm để lấy dữ liệu sinh viên từ API và hiển thị trên bảng
    function fetchAccounts() {
        fetch('http://localhost/KTX-API/API_RESTFUL_MVC-main/api/account/read.php')
            .then(response => response.json())
            .then(data => {
                if (data.message === 'No records found') {
                    // Hiển thị thông báo không có bản ghi nếu không có dữ liệu
                    console.log('No records found');
                } else {
                    // Hiển thị dữ liệu sinh viên trên bảng
                    displayAccounts(data.data);
                }
            })
            .catch(error => console.error('Error:', error));
    }

    // Hàm để hiển thị dữ liệu sinh viên trên bảng
    function displayAccounts(accounts) {
        // Xóa hết dữ liệu cũ trên bảng
        accountTableBody.innerHTML = '';

        // Duyệt qua mảng tài khoản và thêm từng dòng vào bảng
        accounts.forEach(account => {
            const row = `<tr data-account-id="${account.id_account}">
                            <td>${account.id_account}</td>
                            <td>${account.user_account}</td>
                            <td>${account.pass_account}</td>
                            <td>${account.type_account}</td>
                            <td>
                                <button type="button" id="updateBtn_${account.id_account}" class="btn-sua">Sửa</button>
                                <button type="button" id="deleteBtn_${account.id_account}" class="btn-xoa">Xóa</button>
                            </td>
                        </tr>`;
            accountTableBody.insertAdjacentHTML('beforeend', row);
        });
    }

    // Sự kiện click vào hàng trong bảng
    accountTable.addEventListener('click', function (event) {
        const selectedRow = event.target.closest('tr');
        const target = event.target;

        if (selectedRow) {
            // Lấy id của tài khoản được chọn
            selectedAccountId = selectedRow.getAttribute('data-account-id');

            // Nếu đang trong quá trình sửa, hiển thị thông tin tài khoản lên các input
            if (isEditing) {
                fetch(`http://localhost/KTX-API/API_RESTFUL_MVC-main/api/account/show.php?id_account=${selectedAccountId}`)
                    .then(response => response.json())
                    .then(account => {
                        userInput.value = account.user_account;
                        passInput.value = account.pass_account;
                        typeInput.value = account.type_account;
                    })
                    .catch(error => console.error('Error:', error));
            }
        }

        // Kiểm tra xem có phải là nút xóa không
        if (target.classList.contains('btn-xoa')) {
            // Lấy hàng chứa nút xóa
            const selectedRow = target.closest('tr');

            // Lấy id của tài khoản được chọn
            selectedAccountId = selectedRow.getAttribute('data-account-id');

            // Hiển thị hộp thoại xác nhận
            if (confirm('Bạn có chắc chắn muốn xóa tài khoản này không?')) {
                // Thực hiện xóa tài khoản
                deleteAccount(selectedAccountId);
            }
        }

        // Kiểm tra xem có phải là nút sửa không
        if (target.classList.contains('btn-sua')) {
            // Lấy hàng chứa nút sửa
            const selectedRow = target.closest('tr');
            isEditing = false;
            // Lấy id của tài khoản được chọn
            selectedAccountId = selectedRow.getAttribute('data-account-id');

            // Hiển thị hộp thoại xác nhận
            if (confirm('Bạn có chắc chắn muốn sửa tài khoản này không?')) {
                // Đã xác nhận sửa, tiếp tục thực hiện các thao tác cần thiết
                // Lấy thông tin của tài khoản từ API và hiển thị lên các ô input
                fetch(`http://localhost/KTX-API/API_RESTFUL_MVC-main/api/account/show.php?id_account=${selectedAccountId}`)
                    .then(response => response.json())
                    .then(account => {
                        userInput.value = account.user_account;
                        passInput.value = account.pass_account;
                        typeInput.value = account.type_account;

                        // enableInputs();

                        // Hiển thị nút "Cập nhật" và "Hủy bỏ"
                        updateButton.style.display = 'inline-block';
                        cancelButton.style.display = 'inline-block';
                        addButton.style.display = 'none';

                        // Ẩn nút "XÓA" và "SỬA"
                        const deleteBtns = document.querySelectorAll('.btn-xoa');
                        const updateBtns = document.querySelectorAll('.btn-sua');
                        deleteBtns.forEach(btn => {
                            btn.style.display = 'none';
                        });
                        updateBtns.forEach(btn => {
                            btn.style.display = 'none';
                        });
                    })
                    .catch(error => console.error('Error:', error));
            } else {
                // Không xác nhận sửa, không thực hiện thêm thao tác nào
                // Không cần phải làm gì ở đây, vì người dùng không muốn sửa
            }
        }
    });

    // Sự kiện click vào nút Thêm tài khoản
    addButton.addEventListener('click', function () {
        // Kiểm tra xem các trường dữ liệu đã được điền đầy đủ chưa
        if (userInput.value && passInput.value && typeInput.value) {
            // Hiển thị hộp thoại xác nhận
            if (confirm('Bạn có chắc chắn muốn thêm tài khoản mới không?')) {
                const newAccount = {
                    user_account: userInput.value,
                    pass_account: passInput.value,
                    type_account: typeInput.value,
                };

                // Thực hiện yêu cầu API để thêm tài khoản mới
                fetch('http://localhost/KTX-API/API_RESTFUL_MVC-main/api/account/create.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(newAccount)
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.message === 'Duplicate data') {
                            alert('Tài khoản hoặc mật khẩu đã bị trùng!');
                        } else {
                            console.log(data);
                            fetchAccounts();
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }
        } else {
            console.log('Vui lòng điền đầy đủ thông tin.');
            alert("Vui lòng điền đầy đủ thông tin.");
        }
    });

    // Sự kiện click vào nút Cập nhật sinh viên
    updateButton.addEventListener('click', function () {
        isEditing = true;
        // Kiểm tra xem các trường dữ liệu đã được điền đầy đủ chưa
        if (userInput.value && passInput && typeInput.value) {
            // Hiển thị hộp thoại xác nhận
            if (confirm('Bạn có chắc muốn cập nhật dữ liệu hay không?')) {
                const updatedAccount = {
                    id_account: selectedAccountId,
                    user_account: userInput.value,
                    pass_account: passInput.value,
                    type_account: typeInput.value,
                };

                fetch('http://localhost/KTX-API/API_RESTFUL_MVC-main/api/account/update.php', {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(updatedAccount)
                })
                    .then(response => response.json())
                    .then(data => {
                        console.log(data);
                        fetchAccounts();

                        // Xóa dữ liệu trong các ô input sau khi cập nhật thành công
                        userInput.value = '';
                        passInput.value = '';
                        typeInput.value = '';

                        // disableInputs();

                        updateButton.style.display = 'none';
                        cancelButton.style.display = 'none';
                        addButton.style.display = 'inline-block';
                    })
                    .catch(error => console.error('Error:', error));
            }
        } else {
            console.log('Vui lòng điền đầy đủ thông tin.');
        }
    });

    // Sự kiện click vào nút Hủy bỏ
    cancelButton.addEventListener('click', function () {
        isEditing = true;
        // Xóa dữ liệu trong các ô input
        userInput.value = '';
        passInput.value = '';
        typeInput.value = '';

        // Ẩn nút "Cập nhật" và "Hủy bỏ"
        updateButton.style.display = 'none';
        cancelButton.style.display = 'none';
        addButton.style.display = 'inline-block';

        // disableInputs();

        // Hiển thị nút "XÓA" và "SỬA"
        const deleteBtns = document.querySelectorAll('.btn-xoa');
        const updateBtns = document.querySelectorAll('.btn-sua');
        deleteBtns.forEach(btn => {
            btn.style.display = 'inline-block';
        });
        updateBtns.forEach(btn => {
            btn.style.display = 'inline-block';
        });
    });

    // Hàm để xóa tài khoản
    function deleteAccount(accountId) {
        fetch(`http://localhost/KTX-API/API_RESTFUL_MVC-main/api/account/delete.php?id_account=${accountId}`, {
            method: 'DELETE'
        })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                fetchAccounts(); // Sau khi xóa thành công, tải lại danh sách tài khoản
            })
            .catch(error => console.error('Error:', error));
    }

    // Sự kiện click vào nút Tìm kiếm
    searchButton.addEventListener('click', function () {
        // Lấy giá trị keyword từ input
        const searchKeyWord = searchInput.value;
        searchAccounts(searchKeyWord);
    });

    // Hàm để tìm kiếm tài khoản theo từ khóa
    function searchAccounts(keyword) {
        fetch(`http://localhost/KTX-API/API_RESTFUL_MVC-main/api/account/search.php?keyword=${keyword}`)
            .then(response => response.json())
            .then(data => {
                if (data.message) {
                    console.log(data.message); // In ra thông báo nếu không tìm thấy kết quả
                } else {
                    displayAccounts(data); // Hiển thị kết quả tìm kiếm trên bảng
                }
            })
            .catch(error => console.error('Error:', error));
    }
});