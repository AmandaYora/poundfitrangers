<div class="page-content">

    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Tables</a></li>
            <li class="breadcrumb-item active" aria-current="page">Data Bank</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="card-title mb-0">Data Bank</h6>
                        <div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle" type="button" id="addDataDropdown"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i data-feather="plus"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="addDataDropdown">
                                <a class="dropdown-item" href="#" id="addData">Add Data</a>
                                <input type="file" id="excelFileInput" style="display: none;">
                            </div>
                        </div>
                    </div>


                    <div class="table-responsive">
                        <table id="dataTableRekening" class="table table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Rekening</th>
                                    <th>Nama Bank</th>
                                    <th>Nomor Rekening</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($bank as $b): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $b['nama_rekening'] ?></td>
                                    <td><?= $b['nama_bank'] ?></td>
                                    <td><?= $b['nomor_rekening'] ?></td>
                                    <td>
                                        <button class="btn btn-sm btn-info edit-button"
                                            data-bank-id="<?= $b['bankId'] ?>">Edit</button>
                                        <button class="btn btn-sm btn-danger delete"
                                            data-bank-id="<?= $b['bankId'] ?>">Delete</button>
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

<!-- Edit Bank Modal -->
<div class="modal fade" id="editBankModal" tabindex="-1" aria-labelledby="editBankModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="editBankModalLabel">Data Bank</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editBankForm" id="editBankForm" data-bank-id="">
                    <div class="mb-3">
                        <label for="editNamaRekening" class="form-label">Nama Rekening</label>
                        <input type="text" class="form-control" id="editNamaRekening">
                    </div>
                    <div class="mb-3">
                        <label for="editNamaBank" class="form-label">Nama Bank</label>
                        <input type="text" class="form-control" id="editNamaBank">
                    </div>
                    <div class="mb-3">
                        <label for="editNomorRekening" class="form-label">Nomor Rekening</label>
                        <input type="text" class="form-control" id="editNomorRekening">
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


<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    var userId = <?= $userId; ?>;
    var ajaxUrl = '<?= base_url() ?>api/bank/'

    $('#addData').click(function() {
        $('#editBankForm').attr('data-bank-id', ''); // Kosongkan bankId
        $('#editBankModalLabel').text("Tambah Data");
        $('#editNamaRekening').val("");
        $('#editNamaBank').val("");
        $('#editNomorRekening').val("");
        $('#saveEdit').text("Tambah Data");
        $('#editBankModal').modal('show'); // Tampilkan modal
    });

    // Tampilkan modal untuk edit data
    $('.edit-button').click(function() {
        const bankId = $(this).attr('data-bank-id'); // Ambil bankId dari data-bank-id
        const row = $(this).closest("tr");
        const namaRekening = row.find("td:eq(1)").text();
        const namaBank = row.find("td:eq(2)").text();
        const nomorRekening = row.find("td:eq(3)").text();

        $('#editBankForm').attr('data-bank-id', bankId); // Set bankId
        $('#editBankModalLabel').text("Edit Data");
        $('#editNamaRekening').val(namaRekening);
        $('#editNamaBank').val(namaBank);
        $('#editNomorRekening').val(nomorRekening);
        $('#saveEdit').text("Simpan Perubahan");
        $('#editBankModal').modal('show'); // Tampilkan modal
    });

    // Simpan perubahan atau tambah data baru
    $('#saveEdit').click(function() {
        const bankId = $('#editBankForm').attr('data-bank-id');
        const namaRekening = $('#editNamaRekening').val();
        const namaBank = $('#editNamaBank').val();
        const nomorRekening = $('#editNomorRekening').val();

        const data = {
            nama_rekening: namaRekening,
            nama_bank: namaBank,
            userId: userId,
            nomor_rekening: nomorRekening
        };

        console.log(data)

        $.ajax({
            url: bankId ? ajaxUrl + 'update/' + bankId : ajaxUrl + 'create',
            method:  bankId ? 'PUT' : 'POST',
            data: data,
            success: function(response) {
                console.log(response)
                Swal.fire({
                    title: response.info,
                    text: response.message,
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    location.reload();
                });
            },
            error: function(error) {
                Swal.fire({
                    title: 'Error!',
                    text: 'Something went wrong',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        });
    });

    $('.delete').click(function() {
        const bankId = $(this).data('bank-id');

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: ajaxUrl + 'delete/' + bankId,
                    method: 'DELETE',
                    success: function(response) {
                        Swal.fire({
                            title: 'Deleted!',
                            text: 'Your file has been deleted.',
                            icon: 'success'
                        }).then((result) => {
                            location.reload();
                        });
                    },
                    error: function(error) {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Something went wrong',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            }
        });
    });
});
</script>