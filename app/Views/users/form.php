<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Inputan Modern</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    body {
        background: linear-gradient(to right, #0066ff, #33ccff);
        margin: 0;
        font-family: Arial, Helvetica, sans-serif;
        padding-bottom: 50px;
    }


    .card {
        border: none;
        border-radius: 15px;
        box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
    }

    .form-control,
    select.form-control {
        border-radius: 30px;
        border: 1px solid #ccc;
        transition: box-shadow 0.3s ease-in-out;
    }

    .form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, .25);
    }

    .btn-primary {
        border-radius: 30px;
        background: linear-gradient(to right, #0066ff, #33ccff);
        border: none;
        display: block;
        margin: auto;
        width: 70%;
    }

    .money-display {
        font-size: 36px;
        font-weight: bold;
        color: #007bff;
        text-align: center;
        margin: 10px 0;
        background: #ffffff;
        border-radius: 15px;
    }

    .error {
        margin-top: 10px;
        font-size: 12px;
        /* Atur ukuran font */
        font-style: italic;
        /* Buat font miring */
    }

    .form-control.invalid {
        border-color: red;
        box-shadow: 0 0 0 0.2rem rgba(255, 0, 0, .25);
    }
    </style>
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8 col-12">
                <div class="card">
                    <div class="card-header bg-primary text-white text-center">
                        <h3>Form Pendaftaran</h3>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="mb-3">
                                <label for="namaLengkap" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" id="namaLengkap" name="namaLengkap"
                                    placeholder="Masukkan nama lengkap Anda">
                                <div class="error text-danger"></div>
                            </div>
                            <div class="mb-3">
                                <label for="number" class="form-label">Jumlah Orang</label>
                                <input type="number" class="form-control" id="jumlahOrang" name="jumlahOrang"
                                    placeholder="Masukkan jumlah yang akan daftar">
                                <div class="error text-danger"></div>
                            </div>
                            <div class="mb-3" id="additionalNames"></div>
                            <div class="mb-3">
                                <label for="umur" class="form-label">Umur</label>
                                <input type="number" class="form-control" id="umur" name="umur"
                                    placeholder="Masukkan umur Anda" min="1" max="99">
                                <div class="error text-danger"></div>
                            </div>
                            <div class="mb-3">
                                <label for="nomorHp" class="form-label">Nomor HP</label>
                                <input type="text" class="form-control" id="nomorHp" name="nomorHp"
                                    placeholder="Masukkan nomor HP Anda">
                                <div class="error text-danger"></div>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    placeholder="Masukkan email aktif anda">
                                <div class="error text-danger"></div>
                            </div>
                            <div class="mb-3">
                                <label for="bankTujuan" class="form-label">Bank Tujuan</label>
                                <select class="form-control" id="bankTujuan" name="bankTujuan">
                                    <option value="" disabled selected>Pilih Bank Tujuan</option>
                                    <?php foreach($bank as $b): ?>
                                    <option value="<?= $b['nama_bank'] ?> - <?= $b['nomor_rekening'] ?>">
                                        <?= $b['nama_bank'] ?> - <?= $b['nomor_rekening'] ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>

                                <div class="error text-danger"></div>
                            </div>
                            <div class="mb-3">
                                <label for="nominalTransfer" class="form-label">Nominal Transfer</label>
                                <input type="number" class="form-control" id="nominalTransfer" name="nominalTransfer"
                                    placeholder="Masukkan nominal transfer" value="<?= $harga + $kodeunik; ?>" readonly>
                                <div class="error text-danger"></div>
                            </div>
                            <div class="container mt-5 mb-5" id="transferInfoContainer">
                                <div class="card text-center shadow-lg" id="transferInfoCard">
                                    <!-- Tambahkan class shadow-lg untuk bayangan -->
                                    <div class="card-header">
                                        <h5>Informasi Transfer</h5>
                                    </div>
                                    <div class="card-body">
                                        <h6 class="card-title">Silahkan transfer sebesar</h6>
                                        <div class="money-display mb-3">
                                            <h1 class="display-4">Rp 0</h1>
                                        </div>
                                        <h6 class="card-title">dengan rekening tujuan:</h6>
                                        <p class="lead bank mb-1">Bank: BCA</p>
                                        <p class="lead rekening">Nomor Rekening: 280129261</p>
                                    </div>
                                    <div class="card-footer text-muted">
                                        Mohon selesaikan transfer dalam 24 jam, dan upload bukti transfer
                                    </div>
                                </div>
                            </div>


                            <div class="mb-3">
                                <label for="lampiranFile" class="form-label">Bukti transfer</label>
                                <input type="file" class="form-control" id="lampiranFile" name="lampiranFile">
                                <div class="error text-danger"></div>
                            </div>


                            <button type="submit" class="btn btn-primary btn-lg mt-5 mb-3">Daftar</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS (optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    $(document).ready(function() {
        var url = window.location.href;

        if (!url.includes('?id=')) {
            window.location.href = '/auth';
        }


        const status = '<?= $status ?>';
        const isFull = '<?= $isFull ?>';
        const affiliate = '<?= $affiliate; ?>';
        const isExpired = '<?= $is_expired; ?>';
        const hargaPerOrang = <?= $harga; ?>;
        const kodeunik = <?= $kodeunik; ?>;

        if (isExpired == true) {
            Swal.fire({
                title: 'Class Has been expired',
                text: 'mohon tanyakan pada penyedia kelas.',
                icon: 'warning',
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: false
            });
        }

        $("#jumlahOrang").on('input', function() {
            const jumlahOrang = parseInt($(this).val()) || 0;
            const totalNominal = jumlahOrang * hargaPerOrang + kodeunik;
            if (jumlahOrang === '' || jumlahOrang === '0' || jumlahOrang === 0) {
                $('#nominalTransfer').val(hargaPerOrang + kodeunik);
            } else {
                $('#nominalTransfer').val(totalNominal);
            }
        });



        if (status === 'closed' || isFull == true) {
            if (affiliate == 'admin' || !status || status == null || status == "") {
                Swal.fire({
                    title: 'Class Not Found',
                    text: 'Check your url address.',
                    icon: 'warning',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showConfirmButton: false
                });
            } else {
                Swal.fire({
                    title: 'Class Closed',
                    text: 'This class has already been closed.',
                    icon: 'warning',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showConfirmButton: false
                });
            }

        }



        if (status !== 'closed' || isFull == false) {

            const validationConfig = {
                'namaLengkap': [/^[a-zA-Z\s]*$/, 'Nama lengkap tidak boleh mengandung angka.', ''],
                'umur': [/^[0-9]{1,2}$/, 'Umur harus berupa angka dan maksimal 2 digit.', ''],
                'nomorHp': [/^08[0-9]{8,11}$/,
                    'Nomor HP harus diawali dengan 08 dan mengandung 10-13 angka.',
                    ''
                ],
                'email': [/@gmail\.com$/, 'Email harus mengandung @gmail.com.', ''],
                'nominalTransfer': [/^[1-9][0-9]*$/,
                    'Nominal transfer harus berupa angka dan lebih dari 0.',
                    'Nominal transfer tidak boleh kosong.'
                ],
                'lampiranFile': [/.+/, 'File tidak valid.', 'File belum dipilih.'],
                'bankTujuan': [/.+/, 'Bank tujuan tidak valid.', 'Bank tujuan tidak boleh kosong.'],
                'jumlahOrang': [/^[1-9]\d*$/, 'Jumlah orang harus lebih dari 0.',
                    'Jumlah orang tidak boleh kosong.'
                ],

            };

            function formatRupiah(value) {
                return new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR'
                }).format(value).replace(',00', '');
            }

            function updateError(field, message) {
                $(field).next('.error').text(message);
                $(field).toggleClass('invalid', Boolean(message));
            }

            function validateField(fieldId) {
                const [pattern, error, empty] = validationConfig[fieldId];
                const field = `#${fieldId}`;
                const value = $(field).val();
                if (!value) return updateError(field, empty);
                if (!pattern.test(value)) return updateError(field, error);
                updateError(field, '');
                return true;
            }

            // Formatters
            $("#nominalTransfer").on('input', function() {
                $('.money-display').text(formatRupiah($(this).val()));
            });

            $("#namaLengkap").on('input', function() {
                this.value = this.value.replace(/[^a-zA-Z\s]/g, '');
            });

            $("#umur").on('input', function() {
                if (this.value.length > 2) {
                    this.value = this.value.slice(0, 2);
                }
            });

            $("#nomorHp").on('input', function() {
                this.value = this.value.replace(/[^0-9]/g, '');
                if (this.value.length > 13) {
                    this.value = this.value.slice(0, 13);
                }
            });

            // Validators
            $("#namaLengkap, #nomorHp, #email, #nominalTransfer, #lampiranFile").on('blur', function() {
                validateField(this.id);
            });

            $("#jumlahOrang").on('blur', function() {
                validateField(this.id);
            });


            $("#bankTujuan").on('change', function() {
                validateField(this.id);
            });

            $('#jumlahOrang').on('input', function() {
                var jumlahOrang = $(this).val();
                $('#additionalNames').empty();

                for (var i = 1; i < jumlahOrang; i++) {
                    $('#additionalNames').append(
                        '<div class="mb-3">' +
                        '<label class="form-label">Nama Tambahan ' + i + '</label>' +
                        '<input type="text" class="form-control additionalName" placeholder="Masukkan nama tambahan">' +
                        '</div>'
                    );
                }
            });


            // Submit validator
            $("form").submit(function(event) {
                const isValid = Object.keys(validationConfig).every(validateField);

                if (!isValid) {
                    event.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Mohon periksa kembali data yang anda masukan'
                    });
                } else {
                    event.preventDefault(); // Mencegah form dari mengirim data langsung
                    Swal.fire({
                        title: 'Anda yakin?',
                        text: "Kami akan mengirim bukti pembayaran ke email anda. Pastikan email Anda benar.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, Saya Daftar!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const formData = new FormData(this);

                            // Mengumpulkan nama tambahan dan join menjadi string
                            var namaTambahanArray = [];
                            $('.additionalName').each(function() {
                                namaTambahanArray.push($(this).val());
                            });
                            var namaTambahanJoined = namaTambahanArray.join(',');
                            formData.append('namaTambahan', namaTambahanJoined);

                            // Jika Anda juga ingin menambahkan data lain ke FormData
                            $("form").serializeArray().forEach(({
                                name,
                                value
                            }) => {
                                formData.append(name, value);
                            });

                            // Jika Anda ingin melihat data yang telah dikumpulkan (hanya untuk debugging)
                            const dataInput = {};
                            for (const [key, value] of formData.entries()) {
                                if (value instanceof File) {
                                    dataInput[key] = value.name; // Menampilkan hanya nama file
                                } else {
                                    dataInput[key] = value; // Menampilkan nilai lain
                                }
                            }

                            const url = '<?= base_url(); ?>';

                            formData.append('affiliate', affiliate);

                            Swal.fire({
                                title: 'Sedang Memproses...',
                                text: 'Mohon tunggu sebentar.',
                                allowEscapeKey: false,
                                allowOutsideClick: false,
                                showConfirmButton: false,
                                didOpen: () => {
                                    Swal.showLoading();
                                }
                            });

                            // AJAX request
                            $.ajax({
                                url: url + 'upload', // Sesuaikan dengan URL di CI4 Anda
                                type: 'post',
                                data: formData,
                                processData: false, // Penting, jangan mengolah data
                                contentType: false, // Penting, jangan set tipe konten
                                success: function(response) {
                                    Swal.close();
                                    // Tangani response dari server
                                    if (response.info ===
                                        'success') { // Merubah dari status ke info
                                        Swal.fire(
                                            'Berhasil!',
                                            'Anda berhasil mendaftar, silahkan tunggu dan periksa email Anda.',
                                            'success'
                                        );
                                    } else if (response.info ===
                                        'error') {
                                        Swal.fire(
                                            'Gagal!',
                                            response.message,
                                            'error'
                                        );
                                    } else {
                                        Swal.fire(
                                            'Gagal!',
                                            'Ada masalah saat mendaftar.',
                                            'error'
                                        );
                                    }
                                    console.log(response);
                                    console.log("Data yang diinputkan:", dataInput);
                                },
                                error: function(jqXHR, textStatus, errorThrown) {
                                    Swal.close();
                                    console.log("AJAX error: ", textStatus,
                                        errorThrown);
                                },
                                complete: function(xhr, status) {
                                    console.log("Request is complete. Status: ",
                                        status);
                                }
                            });
                        }

                    });
                }
            });

            $('#transferInfoContainer').hide();

            $('#bankTujuan').change(function() {
                // Tampilkan kontainer informasi transfer ketika pengguna memilih bank tujuan
                $('#transferInfoContainer').show();

                // Dapatkan nilai dari dropdown bank tujuan
                let selectedOption = $('#bankTujuan option:selected').text();

                // Pecah string menjadi nama bank dan nomor rekening
                let [bankName, bankAccount] = selectedOption.split(" - ");

                // Ambil nominal transfer
                let amount = $('#nominalTransfer').val() || 0;

                // Perbarui tampilan kartu informasi transfer
                $('#transferInfoContainer .bank').text('Bank: ' + bankName);
                $('#transferInfoContainer .rekening').text('Nomor Rekening: ' + bankAccount);
                $('#transferInfoContainer .display-4').text(formatRupiah(amount));
            });

            $('#nominalTransfer').change(function() {
                // Perbarui tampilan nominal transfer pada kartu
                let amount = $('#nominalTransfer').val() || 0;
                $('#transferInfoContainer .display-4').text('Rp ' + amount);
            });
        }
    });
    </script>

</body>

</html>