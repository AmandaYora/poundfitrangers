<div class="page-content">

    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Tables</a></li>
            <li class="breadcrumb-item active" aria-current="page">Data Karyawan</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="card-title mb-0">Data Karyawan</h6>
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
                        <table id="dataTableKaryawan" class="table table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Username</th>
                                    <th>Gender</th>
                                    <th>Birthday</th>
                                    <th>Phone</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($affiliate as $row): ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= $row['name']; ?></td>
                                    <td><?= $row['email']; ?></td>
                                    <td><?= $row['username']; ?></td>
                                    <td><?= $row['gender']; ?></td>
                                    <td><?= $row['birthday']; ?></td>
                                    <td><?= $row['phone']; ?></td>
                                    <td>
                                        <button class="btn btn-sm btn-info editButton"
                                            data-username="<?= $row['username']; ?>"
                                            data-id="<?= $row['userId']; ?>">Edit</button>

                                        <button class="btn btn-sm btn-danger deleteButton"
                                            data-id="<?= $row['userId']; ?>">Delete</button>

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

<!-- Add Affiliate Modal -->
<div class="modal fade" id="addAffiliateModal" tabindex="-1" aria-labelledby="addAffiliateModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="addAffiliateModalLabel">Add Affiliate</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addAffiliateForm">
                    <!-- For each attribute, we add an input field -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" placeholder="Enter Name">
                    </div>
                    <div class="mb-3">
                        <label for="gender" class="form-label">Gender</label>
                        <select class="form-control" id="gender">
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="birthday" class="form-label">Birthday</label>
                        <input type="date" class="form-control" id="birthday">
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" class="form-control" id="phone" placeholder="Enter Phone">
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" class="form-control" id="address" placeholder="Enter Address">
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" placeholder="Enter Username">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" placeholder="Enter Email">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" placeholder="Enter Password">
                    </div>
                    <div class="mb-3">
                        <label for="role" class="form-label">Role</label>
                        <select class="form-control" id="role">
                            <option value="affiliate">Affiliate</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveAddAffiliate">Save</button>
            </div>
        </div>
    </div>
</div>




<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(() => {
    const url = '<?= base_url(); ?>';
    let userId = null;

    const resetModalFields = () => {
        $('#name, #gender, #birthday, #phone, #address, #username, #email, #password, #role').val('');
    };

    const fetchData = (type, endpoint, data = null) => {
        return $.ajax({
            url: url + endpoint,
            type,
            dataType: 'json',
            data: JSON.stringify(data),
            contentType: "application/json; charset=utf-8"
        });
    };

    const handleResponse = (response, successMessage, modalId) => {
        if (response.info === 'success') {
            Swal.fire('Success!', successMessage, 'success');
            $(`#${modalId}`).modal('hide');
            setTimeout(() => location.reload(), 3000);
        } else {
            Swal.fire('Error!', 'Operation failed.', 'error');
        }
    };

    const showModal = (modalId) => $(`#${modalId}`).modal('show');

    $("#addData").click(() => {
        resetModalFields();
        showModal('addAffiliateModal');
    });

    $(document).on('click', '.editButton', function() {
        userId = $(this).data('id');
        const username = $(this).data('username');

        fetchData('GET', `api/users/readByUsername/${username}`)
            .done(response => {
                const data = response.data;
                $('#name').val(data.name);
                $('#gender').val(data.gender);
                $('#birthday').val(data.birthday);
                $('#phone').val(data.phone);
                $('#address').val(data.address);
                $('#username').val(data.username);
                $('#email').val(data.email);
                $('#role').val(data.role);
                showModal('addAffiliateModal');
            })
            .fail(() => Swal.fire('Error!', 'Unable to fetch data.', 'error'));
    });

    $("#saveAddAffiliate").click(() => {
        const data = {
            name: $("#name").val(),
            gender: $("#gender").val(),
            birthday: $("#birthday").val(),
            phone: $("#phone").val(),
            address: $("#address").val(),
            username: $("#username").val(),
            email: $("#email").val(),
            password: $("#password").val(),
            role: $("#role").val()
        };

        const endpoint = userId ? `api/users/update/${userId}` : 'api/users/create';
        const method = userId ? 'PUT' : 'POST';
        const message = userId ? 'Data successfully updated.' : 'Data successfully added.';

        fetchData(method, endpoint, data)
            .done(response => handleResponse(response, message, 'addAffiliateModal'))
            .fail(() => Swal.fire('Error!', 'An error occurred.', 'error'));
    });

    $(document).on('click', '.deleteButton', function() {
        userId = $(this).data('id');

        Swal.fire({
            title: 'Are you sure?',
            text: 'You will not be able to recover this data!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, keep it'
        }).then((result) => {
            if (!result.isConfirmed) return;

            fetchData('DELETE', `api/users/delete/${userId}`)
                .done(() => Swal.fire('Deleted!', 'Data has been deleted.', 'success'))
                .fail(() => Swal.fire('Error!', 'An error occurred while deleting the data.',
                    'error'));
        });
    });
});
</script>