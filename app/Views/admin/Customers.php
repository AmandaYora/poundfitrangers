<div class="page-content">

    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Tables</a></li>
            <li class="breadcrumb-item active" aria-current="page">Data Customers</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="card-title mb-0">Data Customers</h6>
                        <div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle" type="button" id="addDataDropdown"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i data-feather="plus"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="addDataDropdown">
                                <a class="dropdown-item" href="#" id="downloadTemplate">Download Excel</a>
                                <input type="file" id="excelFileInput" style="display: none;">
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="dataTablePeserta" class="table table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Age</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <!-- <th>Action</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($customers as $customer): ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= $customer['name']; ?></td>
                                    <td><?= $customer['age']; ?></td>
                                    <td><?= $customer['phone']; ?></td>
                                    <td><?= $customer['email']; ?></td>
                                    <!-- <td>
                                        <button class="btn btn-sm btn-info" data-id="<?= $customer['customerId']; ?>"
                                            title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger deleteCustomer"
                                            data-id="<?= $customer['customerId']; ?>" title="Delete">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td> -->
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



<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>