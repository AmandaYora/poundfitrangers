<div class="page-content">

    <!-- Loading Animation -->
    <div id="loadingAnimation" class="d-none"
        style="position:fixed; top:0; left:0; width:100%; height:100%; background-color:rgba(0,0,0,0.5); z-index:9999;">
        <div class="d-flex justify-content-center align-items-center" style="height: 100%;">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>

    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Tables</a></li>
            <li class="breadcrumb-item active" aria-current="page">Data Booking</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="card-title mb-0">Data Booking</h6>
                        <div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle" type="button" id="addDataDropdown"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i data-feather="plus"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="addDataDropdown">
                                <a class="dropdown-item" href="#" id="importExcel">Export Pdf</a>
                                <input type="file" id="excelFileInput" style="display: none;">
                            </div>
                        </div>
                    </div>


                    <div class="table-responsive">
                        <table id="dataTablePeserta" class="table table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Pemilik</th>
                                    <th>Code Class</th>
                                    <th>Name</th>
                                    <th>Age</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>Bank</th>
                                    <th>Jumlah</th>
                                    <th>Nama Tambahan</th>
                                    <th>Amount</th>
                                    <th>File Transfer</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($bookings as $booking): ?>
                                <tr data-bookingId=<?= $booking['bookingId']; ?>>
                                    <td><?= $no++; ?></td>
                                    <td><?= $username; ?></td>
                                    <td><?= $booking['code']; ?></td>
                                    <td><?= $booking['name']; ?></td>
                                    <td><?= $booking['age']; ?></td>
                                    <td><?= $booking['phone']; ?></td>
                                    <td><?= $booking['email']; ?></td>
                                    <td><?= $booking['bank']; ?></td>
                                    <td><?= $booking['jumlah_orang']; ?> Orang</td>
                                    <td>
                                        <?php if ($booking['nama_tambahan'] != null) :?>
                                        <textarea rows="3"
                                            readonly><?= htmlspecialchars($booking['nama_tambahan']); ?></textarea>
                                        <?php else : ?>
                                        -
                                        <?php endif;?>
                                    </td>

                                    <td><span class="badge bg-primary">Rp.
                                            <?= number_format($booking['amount'], 0, ',', '.'); ?></span></td>
                                    <td>
                                        <button class="btn btn-xs btn-info viewImage"
                                            data-image="<?= $booking['file_transfer']; ?>" title="View Image">
                                            View
                                        </button>

                                    </td>
                                    <td><?= $booking['status_booking']; ?></td>
                                    <td>
                                        <?php if ($booking['status_booking'] == 'pending') : ?>
                                        <button class="btn btn-sm btn-success approveBooking"
                                            data-id-booking="<?= $booking['bookingId']; ?>"
                                            data-id-customer="<?= $booking['customerId']; ?>" data-status="accept"
                                            title="Approved">
                                            <i class="bi bi-check-circle"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger rejectBooking"
                                            data-id-booking="<?= $booking['bookingId']; ?>"
                                            data-id-customer="<?= $booking['customerId']; ?>" data-status="reject"
                                            title="Reject">
                                            <i class="bi bi-x-circle"></i>
                                        </button>
                                        <?php endif; ?>

                                        <?php if ($booking['status_booking'] != 'pending') : ?>
                                        <a href="<?= site_url('booking/delete/' . $booking['bookingId']); ?>"
                                            class="btn btn-sm btn-danger"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus booking ini?');">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                        <?php endif; ?>

                                        <button class="btn btn-sm btn-info detailBooking"
                                            data-id-booking="<?= $booking['bookingId']; ?>"
                                            data-id-customer="<?= $booking['customerId']; ?>" title="Detail"
                                            id="detailBooking">
                                            <i class="bi bi-info-circle"></i>
                                        </button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>


                </div>
            </div>
        </div>
    </div>

</div>

<!-- Modal for Viewing Image -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <!-- Tambahkan class modal-lg untuk membuat modal lebih besar -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Bukti Transfer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <img id="imageView" src="" alt="Image Preview" class="img-fluid">
            </div>
        </div>
    </div>
</div>

<!-- Modal for selecting code -->
<div class="modal fade" id="exportPdfModal" tabindex="-1" role="dialog" aria-labelledby="exportPdfModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exportPdfModalLabel">Export PDF</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <label>Select Code Class:</label>
                <select id="selectCode" class="form-control">
                    <?php foreach ($uniqueCodes as $book): ?>
                    <option value="<?= $book['code']; ?>"><?= $book['code']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" id="downloadPdf" class="btn btn-primary">Download PDF</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="editKaryawanModal" tabindex="-1" aria-labelledby="editKaryawanModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editKaryawanModalLabel">Edit Karyawan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editKaryawanForm">
                    <div class="form-group">
                        <label for="editName">Nama</label>
                        <input type="text" class="form-control" id="editName">
                    </div>
                    <div class="form-group">
                        <label for="editEmail">Email</label>
                        <input type="email" class="form-control" id="editEmail">
                    </div>
                    <div class="form-group">
                        <label for="editDivision">Divisi</label>
                        <select class="form-control" id="editDivision">
                            <option value="" disabled selected>Pilih Divisi</option>
                            <option value="Commercial">Commercial</option>
                            <option value="Finance">Finance</option>
                            <option value="HR">HR</option>
                            <option value="IT">IT</option>
                            <option value="ME">ME</option>
                        </select>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveEdit">Save changes</button>
            </div>
        </div>
    </div>
</div>

<!-- Detail Booking Modal -->
<div class="modal fade" id="detailBookingModal" tabindex="-1" aria-labelledby="detailBookingModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(to right, #6a11cb, #2575fc);">
                <h5 class="modal-title text-white" id="detailBookingModalLabel">Detail Booking</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body" style="background: #f4f4f4;">
                <table class="table table-striped table-hover"
                    style="border-radius: 20px; overflow: hidden; box-shadow: 0px 4px 6px rgba(0,0,0,0.1);">
                    <tr>
                        <th>Code</th>
                        <td id="detailCode"></td>
                    </tr>
                    <tr>
                        <th>Name</th>
                        <td id="detailName"></td>
                    </tr>
                    <tr>
                        <th>Age</th>
                        <td id="detailAge"></td>
                    </tr>
                    <tr>
                        <th>Phone</th>
                        <td id="detailPhone"></td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td id="detailEmail"></td>
                    </tr>
                    <tr>
                        <th>Bank</th>
                        <td id="detailBank"></td>
                    </tr>
                    <tr>
                        <th>Amount</th>
                        <td id="detailAmount"></td>
                    </tr>
                    <tr>
                        <th>Tanggal Order</th>
                        <td id="detailCreatedAt"></td>
                    </tr>
                    <tr>
                        <th>Location</th>
                        <td id="detailLocation"></td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td id="detailStatus"></td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>




<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    var bookingsData = <?= json_encode($bookings); ?>;

    $('#detailBooking').click(function() {

        const bookingId = $(this).closest('tr').data('bookingid').toString();
        const bookingDetail = bookingsData.find(function(booking) {
            return booking.bookingId === bookingId;
        });
        console.log(bookingDetail)
        if (bookingDetail) {
            $('#detailCode').text(bookingDetail.code);
            $('#detailName').text(bookingDetail.name);
            $('#detailAge').text(bookingDetail.age);
            $('#detailPhone').text(bookingDetail.phone);
            $('#detailEmail').text(bookingDetail.email);
            $('#detailBank').text(bookingDetail.bank);
            $('#detailAmount').text(bookingDetail.amount);
            $('#detailCreatedAt').text(bookingDetail.created_at);
            $('#detailLocation').text(bookingDetail.location);
            $('#detailStatus').text(bookingDetail.status_booking);

            // Tampilkan modal
            $('#detailBookingModal').modal('show');
        }
    });

    var baseUrl = '<?= base_url(); ?>';
    var formData = new FormData();

    $('.viewImage').click(function() {
        var imagePath = baseUrl + 'uploads/' + $(this).data(
            'image'); // Gabungkan base URL dengan path gambar
        $('#imageView').attr('src', imagePath);
        $('#imageModal').modal('show');
    });

    $('#importExcel').click(function() {
        $('#exportPdfModal').modal('show');
    });

    function base64ToBlob(base64, mimetype) {
        let bytes = atob(base64);
        let len = bytes.length;
        let buffer = new Uint8Array(len);

        for (let i = 0; i < len; i++) {
            buffer[i] = bytes.charCodeAt(i);
        }

        return new Blob([buffer], {
            type: mimetype
        });
    }

    $('#downloadPdf').click(function() {
        // Mengambil nilai dari select box dengan id #selectCode
        const selectedCode = $('#selectCode').val();

        if (selectedCode) {
            // Menggunakan AJAX untuk memanggil fungsi downloadPdf di controller
            $.ajax({
                url: baseUrl + 'downloadPdf', // Sesuaikan dengan path Anda
                method: 'POST',
                data: {
                    code: selectedCode
                },
                dataType: 'json', // Menambahkan ini karena Anda mengembalikan JSON
                success: function(response) {
                    let blob = base64ToBlob(response.pdf, 'application/pdf');
                    let link = document.createElement('a');
                    link.href = window.URL.createObjectURL(blob);
                    link.download = "Daftar_Peserta_Code_" + selectedCode +
                        ".pdf";
                    link.click();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error("AJAX error: ", textStatus, errorThrown);
                }
            });

        } else {
            Swal.fire({
                title: "Gagal",
                text: "Code tidak Boleh kosong",
                icon: "error",
            })
        }


    });

    function executeAjax(bookingId, customerId, status) {
        $("#loadingAnimation").removeClass("d-none");

        var formData = new FormData();
        formData.append('bookingId', bookingId);
        formData.append('customerId', customerId);
        formData.append('status', status);

        formData.forEach((value, key) => {
            console.log(`${key}: ${value}`);
        });

        $.ajax({
            url: `${baseUrl}action_booking`,
            type: 'post',
            data: formData,
            processData: false,
            contentType: false,
            success(response) {
                $("#loadingAnimation").addClass("d-none");
                Swal.fire({
                    title: response.info,
                    text: response.message,
                    icon: response.info,
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        location.reload();
                    }
                });
            },
            error() {
                $("#loadingAnimation").addClass("d-none");
            }
        });
    }

    $('.approveBooking, .rejectBooking').click(function() {
        const bookingId = $(this).data('id-booking');
        const customerId = $(this).data('id-customer');
        const status = $(this).data('status');

        executeAjax(bookingId, customerId, status);
    });
});
</script>

<script>
$(document).ready(function() {
    // Periksa flashdata untuk 'success'
    var success = <?= json_encode(session()->getFlashdata('success')) ?>;
    if (success) {
        Swal.fire({
            title: 'Berhasil!',
            text: success,
            icon: 'success',
            timer: 3000,
            showConfirmButton: false
        });
    }

    // Periksa flashdata untuk 'error'
    var error = <?= json_encode(session()->getFlashdata('error')) ?>;
    if (error) {
        Swal.fire({
            title: 'Error!',
            text: error,
            icon: 'error',
            timer: 3000,
            showConfirmButton: false
        });
    }
});
</script>