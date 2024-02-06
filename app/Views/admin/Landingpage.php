<div class="page-content">
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Tables</a></li>
            <li class="breadcrumb-item active" aria-current="page">Data Identity</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="card-title mb-0">Data Identity</h6>
                        <button class="btn btn-primary" type="button" id="addData">Add Data Identity</button>
                    </div>

                    <div class="table-responsive">
                        <table id="dataTableIdentity" class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Identity ID</th>
                                    <th>Attribute</th>
                                    <th>Code</th>
                                    <th>Value</th>
                                    <th>Is Active</th>
                                    <th>Description</th>
                                    <th>Date Updated</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($identity as $item): ?>
                                <tr>
                                    <td><?= esc($item['identity_id']); ?></td>
                                    <td><?= esc($item['attribute']); ?></td>
                                    <td><?= esc($item['code']); ?></td>
                                    <td>
                                        <textarea class="form-control" rows="5"
                                            readonly><?= esc($item['value'] ?? 'null'); ?></textarea>
                                    </td>
                                    <td><?= esc($item['is_active'] ? 'Yes' : 'No'); ?></td>
                                    <td>
                                        <textarea class="form-control" rows="5"
                                            readonly><?= esc($item['description']); ?></textarea>
                                    </td>
                                    <td><?= esc($item['updated_at']); ?></td>
                                    <td>
                                        <button class="btn btn-primary edit-btn" data-id="<?= $item['identity_id']; ?>"
                                            data-attribute="<?= esc($item['attribute']); ?>"
                                            data-code="<?= esc($item['code']); ?>"
                                            data-value="<?= esc($item['value'] ?? 'null'); ?>"
                                            data-is_active="<?= esc($item['is_active']); ?>"
                                            data-description="<?= esc($item['description']); ?>">
                                            Update
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

<!-- Add/Edit Identity Modal -->
<div class="modal fade" id="addIdentityModal" tabindex="-1" aria-labelledby="addIdentityModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="addIdentityModalLabel">Add Identity</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addIdentityForm" action="" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <!-- Form fields for Identity -->
                    <div class="mb-3">
                        <label for="attribute" class="form-label">Attribute</label>
                        <input type="text" class="form-control" id="attribute" name="attribute"
                            placeholder="Enter Attribute">
                    </div>
                    <div class="mb-3">
                        <label for="code" class="form-label">Code</label>
                        <input type="text" class="form-control" id="code" name="code" placeholder="Enter Code">
                    </div>
                    <div class="mb-3" id="valueInputContainer">
                        <label for="value" class="form-label">Value</label>
                        <!-- Textarea untuk input biasa -->
                        <textarea class="form-control d-none" id="valueTextarea" name="value" rows="3"></textarea>
                        <!-- Input file untuk code khusus -->
                        <input type="file" class="form-control d-none" id="valueFile" name="valueFile">
                    </div>

                    <div class="mb-3">
                        <label for="is_active" class="form-label">Is Active</label>
                        <select class="form-control" id="is_active" name="is_active">
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- JavaScript Dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    $('#addData').click(function() {
        $('#addIdentityModalLabel').text('Tambah Identity');
        $('#addIdentityForm').attr('action', '<?= base_url('/setting/create') ?>');

        // Reset form fields and modal title
        $('#addIdentityForm')[0].reset();
        $('#addIdentityModalLabel').text('Add Identity');
        $('#addIdentityModal').modal('show');
    });

    $('.edit-btn').click(function() {
        var id = $(this).data('id');
        var attribute = $(this).data('attribute');
        var code = $(this).data('code');
        var value = $(this).data('value');
        var isActive = $(this).data('is_active');
        var description = $(this).data('description');

        if (code === 'img_page' || code === 'image1'|| code === 'image2' || code === 'image3') {
            $('#valueTextarea').addClass('d-none');
            $('#valueFile').removeClass('d-none');
        } else {
            $('#valueFile').addClass('d-none');
            $('#valueTextarea').removeClass('d-none');
        }

        // Mengisi form modal dengan data
        $('#attribute').val(attribute);
        $('#code').val(code);
        $('#value').val(value);
        $('#is_active').val(isActive ? '1' : '0');
        $('#description').val(description);

        // Mengubah judul modal dan tindakan form
        $('#addIdentityModalLabel').text('Edit Identity');
        $('#addIdentityForm').attr('action', '<?= base_url('/setting/update/') ?>' + id);

        // Menampilkan modal
        $('#addIdentityModal').modal('show');
    });
});
</script>