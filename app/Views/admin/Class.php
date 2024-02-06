<div class="page-content">

    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Tables</a></li>
            <li class="breadcrumb-item active" aria-current="page">Data Class</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="card-title mb-0">Data Class</h6>
                        <div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle" type="button" id="addDataDropdown"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i data-feather="plus"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="addDataDropdown">
                                <a class="dropdown-item" href="#" id="addData">Add Data Class</a>
                                <!-- <a class="dropdown-item" href="#" id="importExcel">Import Excel</a>
                                <a class="dropdown-item" href="#" id="downloadTemplate">Download Template</a>
                                <input type="file" id="excelFileInput" style="display: none;"> -->
                            </div>
                        </div>
                    </div>


                    <div class="table-responsive">
                        <table id="dataTableKaryawan" class="table table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Pemilik</th>
                                    <th>Code</th>
                                    <th>Location</th>
                                    <th>Date</th>
                                    <th>Capacity</th>
                                    <th>Price</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($class as $row): ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= $username; ?></td>
                                    <td><?= $row['code']; ?></td>
                                    <td><?= $row['location']; ?></td>
                                    <td><?= $row['date']; ?></td>
                                    <td><?= $row['capacity']; ?></td>
                                    <td><span class="badge bg-primary">Rp. <?= $row['price']; ?></span></td>
                                    <td><?= $row['status']; ?></td>
                                    <td>
                                    <?php if ($row['status'] == 'open'): ?>
                                        <button class="btn btn-sm btn-success copy-button"
                                            data-clipboard-text="<?= base_url('?id='. $row['code']); ?>">Salin
                                            Link</button>
                                        <button class="btn btn-sm btn-info"
                                            data-id="<?= $row['classId']; ?>">Edit</button>
                                        <button class="btn btn-sm btn-danger"
                                            data-id="<?= $row['classId']; ?>">Close</button>
                                        <?php endif; ?>
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

<!-- Add Class Modal -->
<div class="modal fade" id="addClassModal" tabindex="-1" aria-labelledby="addClassModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="addClassModalLabel">Add Class</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addClassForm">
                    <div class="mb-3">
                        <label for="code" class="form-label">Code</label>
                        <input type="text" class="form-control" id="code" value="<?= $code; ?>"
                            placeholder="Enter Class Code" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="location" class="form-label">Location</label>
                        <input type="text" class="form-control" id="location" placeholder="Enter Location">
                    </div>
                    <div class="mb-3">
                        <label for="date" class="form-label">Date</label>
                        <input type="date" class="form-control" id="date">
                    </div>
                    <div class="mb-3">
                        <label for="capacity" class="form-label">Capacity</label>
                        <input type="number" class="form-control" id="capacity" placeholder="Enter Capacity">
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">price</label>
                        <input type="number" class="form-control" id="price" placeholder="Enter price">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveAddClass">Save</button>
            </div>
        </div>
    </div>
</div>



<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.8/clipboard.min.js"></script>

<script>
$(document).ready(function() {
    var clipboard = new ClipboardJS('.copy-button');

    clipboard.on('success', function(e) {
        alert('Link berhasil disalin!');
        e.clearSelection();
    });

    clipboard.on('error', function(e) {
        alert('Gagal menyalin link.');
    });


    const url = '<?= base_url(); ?>';
    let classId = null;

    $('#addData').click(resetFormAndShowModal);
    $('.btn-info').click(fetchAndShowData);
    $('#saveAddClass').click(saveClassData);
    $('.btn-danger').click(changeStatusToClosed);

    function reloadPage() {
        setTimeout(() => location.reload(), 2000);
    }

    function resetFormAndShowModal() {
        $('#location, #date, #capacity, #price').val('');
        $('#code').val('<?= $code; ?>');
        classId = null;
        $('#addClassModal').modal('show');
    }

    function fetchAndShowData() {
        classId = $(this).data('id');
        $.ajax({
            url: `${url}api/class/show/${classId}`,
            method: 'GET',
            success: populateAndShowModal,
            error: () => Swal.fire('Gagal', 'Data tidak ditemukan', 'error')
        });
    }

    function populateAndShowModal(response) {
        if (response.info === 'sukses') {
            $('#code').val(response.data.code);
            $('#location').val(response.data.location);
            $('#date').val(response.data.date);
            $('#capacity').val(response.data.capacity);
            $('#price').val(response.data.price);
            $('#addClassModal').modal('show');
        }
    }

    function saveClassData() {
        const data = gatherFormData();
        const ajaxConfig = {
            url: classId ? `${url}api/class/update/${classId}` : `${url}api/class/create`,
            method: classId ? 'PUT' : 'POST',
            data: data,
            success: function(response) {
                handleSuccess(response, classId ? 'diperbarui' : 'ditambahkan');
                reloadPage();
            },
            error: function(error) {
                handleError(error, classId ? 'diperbarui' : 'ditambahkan');
            }
        };

        $.ajax(ajaxConfig);
    }

    function gatherFormData() {
        return {
            code: $('#code').val(),
            location: $('#location').val(),
            date: $('#date').val(),
            capacity: $('#capacity').val(),
            price: $('#price').val(),
            status: 'open',
            userId: '<?= $userId; ?>'
        };
    }

    function handleSuccess(response, action) {
        Swal.fire('Sukses', `Data berhasil ${action}`, 'success');
        $('#addClassModal').modal('hide');
    }

    function handleError(error, action) {
        Swal.fire('Gagal', `Data gagal ${action}`, 'error');
    }

    function changeStatusToClosed() {
        const classId = $(this).data('id');
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Status akan diubah menjadi 'closed'",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, ubah!'
        }).then((result) => {
            if (!result.isConfirmed) return;

            $.ajax({
                url: `${url}api/class/close/${classId}`,
                method: 'PUT',
                success: function(response) {
                    const message = response.info === 'sukses' ?
                        'Data berhasil diubah statusnya menjadi closed' :
                        'Data gagal diubah';
                    Swal.fire(response.info.toUpperCase(), message, response.info);
                    reloadPage();
                },
                error: () => Swal.fire('Gagal', 'Terjadi kesalahan', 'error')
            });
        });
    }
});
</script>