<style>
.card {
    transition: all 0.3s ease;
    cursor: pointer;
}

.card:hover {
    transform: scale(1.05);
    box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.3);
}
</style>


<div class="page-content">
    <div class="row">
        <div class="col-12 col-xl-12 stretch-card">
            <div class="row flex-grow-1">
                <!-- Data Karyawan -->
                <div class="col-md-4 grid-margin stretch-card">
                    <div class="card shadow" id="karyawan-card">
                        <!-- Tambahkan class 'shadow' di sini -->
                        <div class="card-body">
                            <div class="row">
                                <!-- Sisi kiri: teks -->
                                <div class="col-6 col-md-12 col-xl-6">
                                    <h6 class="card-title mb-3">Jumlah Pengunjung</h6>
                                    <h3 class="mt-4 mb-4"><?= $people; ?></h3>
                                </div>

                                <!-- Sisi kanan: ikon besar -->
                                <div class="col-6 col-md-12 col-xl-6 d-flex align-items-center justify-content-center">
                                    <i class="link-icon" data-feather="user"
                                        style="width: 60px; height: 60px; margin-top: 20px;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Data Karyawan -->
                <div class="col-md-4 grid-margin stretch-card">
                    <div class="card shadow" id="karyawan-card">
                        <!-- Tambahkan class 'shadow' di sini -->
                        <div class="card-body">
                            <div class="row">
                                <!-- Sisi kiri: teks -->
                                <div class="col-6 col-md-12 col-xl-6">
                                    <h6 class="card-title mb-3">Jumlah Class</h6>
                                    <h3 class="mt-4 mb-4"><?= $jumlahClass; ?></h3>
                                </div>

                                <!-- Sisi kanan: ikon besar -->
                                <div class="col-6 col-md-12 col-xl-6 d-flex align-items-center justify-content-center">
                                    <i class="link-icon" data-feather="book"
                                        style="width: 60px; height: 60px; margin-top: 20px;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Data Karyawan -->
                <div class="col-md-4 grid-margin stretch-card">
                    <div class="card shadow" id="karyawan-card">
                        <!-- Tambahkan class 'shadow' di sini -->
                        <div class="card-body">
                            <div class="row">
                                <!-- Sisi kiri: teks -->
                                <div class="col-6 col-md-12 col-xl-6">
                                    <h6 class="card-title mb-3">Omzet bulan ini</h6>
                                    <h3 class="mt-4 mb-4"><?= $nominal; ?></h3>
                                </div>

                                <!-- Sisi kanan: ikon besar -->
                                <div class="col-6 col-md-12 col-xl-6 d-flex align-items-center justify-content-center">
                                    <i class="link-icon" data-feather="dollar-sign"
                                        style="width: 60px; height: 60px; margin-top: 20px;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- row -->
</div>