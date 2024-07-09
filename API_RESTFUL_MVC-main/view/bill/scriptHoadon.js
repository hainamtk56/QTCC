document.addEventListener("DOMContentLoaded", function() {
    const capnhatButton = document.getElementById('capnhatBtn');
    const hoadonTableBody = document.getElementById('hoadonTableBody');
    const urlParams = new URLSearchParams(window.location.search);
    const MaPhong = urlParams.get('MaPhong');

     // Hàm tính tổng tiền từ các input
     function calculateTotal() {
        const TienDien = parseFloat(document.getElementById('TienDienInput').value) || 0;
        const TienNuoc = parseFloat(document.getElementById('TienNuocInput').value) || 0;
        const TienMang = parseFloat(document.getElementById('TienMangInput').value) || 0;

        return TienDien + TienNuoc + TienMang;
    }

    if (MaPhong) {
        fetchHoadonByMaPhong(MaPhong);
    } else {
        console.log('Missing MaPhong parameter');
    }

    function fetchHoadonByMaPhong(MaPhong) {
        fetch(`http://localhost/KTX-API/API_RESTFUL_MVC-main/api/bill/readbymaphong.php?MaPhong=${MaPhong}`)
            .then(response => response.json())
            .then(data => {
                if (data.message === 'No records found') {
                    console.log('No records found');
                } else {
                    displayHoadon(data.data);
                }
            })
            .catch(error => console.error('Error:', error));
    }

    function displayHoadon(hoadons) {
        hoadonTableBody.innerHTML = '';
    
        hoadons.forEach(hoadon => {
            // Tính tổng tiền
            const TongTien = parseFloat(hoadon.TienDien) + parseFloat(hoadon.TienNuoc) + parseFloat(hoadon.TienMang);
    
            const row = `<tr data-hoadon-mahd="${hoadon.MaHD}">
                            <td>${hoadon.MaHD}</td>
                            <td>${hoadon.MaPhong}</td>
                            <td>${hoadon.Thang}</td>
                            <td>${hoadon.TienDien}</td>
                            <td>${hoadon.TienNuoc}</td>
                            <td>${hoadon.TienMang}</td>
                            <td>${TongTien}</td>
                            <td><button class="statusBtn" data-hoadon-id="${hoadon.MaHD}" ${hoadon.TinhTrang === 'Chưa thu' ? '' : 'disabled'}>${hoadon.TinhTrang}</button></td>
                            <td><button class="deleteBtn" data-hoadon-id="${hoadon.MaHD}">Xóa</button></td>
                        </tr>`;
            hoadonTableBody.insertAdjacentHTML('beforeend', row);
        });
    

        const deleteButtons = document.querySelectorAll('.deleteBtn');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const hoadonId = button.getAttribute('data-hoadon-id');
                if (hoadonId) {
                    fetch(`http://localhost/KTX-API/API_RESTFUL_MVC-main/api/bill/deletehoadon.php?MaHD=${hoadonId}`, {
                        method: 'DELETE'
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log(data);
                        fetchHoadonByMaPhong(MaPhong);
                    })
                    .catch(error => console.error('Error:', error));
                     alert('Đã xóa hóa đơn');

                }
            });
        });

        const statusButtons = document.querySelectorAll('.statusBtn');
        statusButtons.forEach(button => {
            button.addEventListener('click', function() {
                const hoadonId = button.getAttribute('data-hoadon-id');
                const newStatus = button.textContent === 'Chưa thu' ? 'Đã thu' : 'Chưa thu';
                
                fetch(`http://localhost/KTX-API/API_RESTFUL_MVC-main/api/bill/updatestatus.php?MaHD=${hoadonId}&TinhTrang=${newStatus}`, {
                    method: 'PUT'
                })
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    fetchHoadonByMaPhong(MaPhong);
                })
                .catch(error => console.error('Error:', error));   
                 alert('Thanh toán hóa đơn thành công');

            });
        });
    }

    capnhatButton.addEventListener('click', function() {
        const TienDien = document.getElementById('TienDienInput').value;
        const TienNuoc = document.getElementById('TienNuocInput').value;
        const TienMang = document.getElementById('TienMangInput').value;
        const Thang = document.getElementById('ThangInput').value;
        const TinhTrang = 'Chưa thu';
    
        // Kiểm tra nếu một trong các trường không được nhập
        if (!TienDien || !TienNuoc || !TienMang || !Thang) {
            alert('Vui lòng nhập đầy đủ thông tin');
            return; // Dừng hàm nếu không đủ thông tin
        }

        const TongTien = calculateTotal();

    
        const newHoadon = {
            MaPhong,
            Thang,
            TienDien,
            TienNuoc,
            TienMang,
            TongTien,
            TinhTrang
        };
    
        fetch('http://localhost/KTX-API/API_RESTFUL_MVC-main/api/bill/createhoadon.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(newHoadon)
        })
        .then(response => response.json())
        .then(data => {
            console.log(data);
            fetchHoadonByMaPhong(MaPhong);
        })
        .catch(error => console.error('Error:', error));
         alert('Thêm hóa đơn thành công');

    });
    

    // Gán sự kiện cho nút "Quay lại"
    const quayLaiButton = document.getElementById('quayLaiBtn');
    quayLaiButton.addEventListener('click', function() {
    // Chuyển hướng trang về index.html
    window.location.href = 'index.html';
});
});
