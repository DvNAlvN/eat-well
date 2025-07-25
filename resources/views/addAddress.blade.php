@extends('master')

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/addAddress.css') }}">
@endsection

@section('content')
    <div class="address-container text-center">
        <div class="text-start mb-3">
            <i class="bi bi-arrow-left fs-4"></i>
        </div>

        <div class="divider"></div>
        <h4 class="section-title">Address Management</h4>
        <img src="https://img.icons8.com/ios-filled/100/000000/home--v1.png" alt="icon" width="60" class="my-3">

        <p class="text-muted small mb-4">Places where healthy foods will be delivered to. Have multiple places you wish
            food could be delivered? This page will help you to manage your multiple of your addresses.
        </p>

        <form action="{{ route('store-address') }}" method="POST" id="addressForm" novalidate>
            @csrf
            <div class="row justify-content-center mb-4">
                <div class="col-sm-3">
                    <select id="provinsi" class="form-select form-select-sm" aria-label="Small select example"
                        name="provinsi_id" required>
                        <option value="">Pilih Provinsi</option>
                    </select>
                    <input type="hidden" name="provinsi_name" id="provinsi_name">
                    <div class="invalid-feedback" data-message-required="Provinsi tidak boleh kosong."></div>
                </div>
                <div class="col-sm-3">
                    <select id="kota" class="form-select form-select-sm" aria-label="Small select example"
                        name="kota_id" required disabled>
                        <option value="">Pilih Kota</option>
                    </select>
                    <input type="hidden" name="kota_name" id="kota_name">
                    <div class="invalid-feedback" data-message-required="Kota tidak boleh kosong."></div>
                </div>
                <div class="col-sm-3">
                    <select id="kecamatan" class="form-select form-select-sm" aria-label="Small select example"
                        name="kecamatan_id" required disabled>
                        <option value="">Pilih Kecamatan</option>
                    </select>
                    <input type="hidden" name="kecamatan_name" id="kecamatan_name">
                    <div class="invalid-feedback" data-message-required="Kecamatan tidak boleh kosong."></div>
                </div>
                <div class="col-sm-3">
                    <select id="kelurahan" class="form-select form-select-sm" aria-label="Small select example"
                        name="kelurahan_id" required disabled>
                        <option value="">Pilih Kelurahan</option>
                    </select>
                    <input type="hidden" name="kelurahan_name" id="kelurahan_name">
                    <div class="invalid-feedback" data-message-required="Kelurahan tidak boleh kosong."></div>
                </div>
            </div>

            <div class="row justify-content-center mb-4">
                <div class="col-sm-9">
                    <div class="mb-3">
                        <input class="form-control form-control-sm" type="text" placeholder="Alamat"
                            aria-label=".form-control-sm example" name="jalan" required maxlength="255">
                        <div class="invalid-feedback">
                            Alamat tidak boleh kosong.
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <input class="form-control form-control-sm" type="text" placeholder="Kode pos"
                        aria-label=".form-control-sm example" name="kode_pos" required pattern="[0-9]{5}" minlength="5" maxlength="5">
                    <div class="invalid-feedback"
                        data-message-required="Kode pos tidak boleh kosong."
                        data-message-pattern="Kode pos harus 5 digit angka.">
                    </div>
                </div>
            </div>

            <div class="row justify-content-center mb-4">
                <div class="col-sm-12">
                    <div class="mb-3">
                        <input class="form-control form-control-sm" type="text" placeholder="Catatan (Opsional)"
                            aria-label=".form-control-sm example" name="notes" maxlength="255">
                        <div class="invalid-feedback">
                            Catatan maksimal 255 karakter.
                        </div>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center mb-4">
                <div class="col-sm-3">
                    <div class="mb-3">
                        <input class="form-control form-control-sm" type="text" placeholder="Nama Penerima"
                            aria-label=".form-control-sm example" name="recipient_name" required maxlength="100">
                        <div class="invalid-feedback">
                            Nama penerima tidak boleh kosong.
                        </div>
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="mb-3">
                        <input class="form-control form-control-sm" type="text" placeholder="Nomor Telepon"
                            aria-label=".form-control-sm example" name="recipient_phone" required pattern="[0-9]+" minlength="10" maxlength="15">
                        <div class="invalid-feedback"
                            data-message-required="Nomor telepon tidak boleh kosong."
                            data-message-pattern="Nomor telepon harus angka."
                            data-message-minlength="Nomor telepon minimal 10 digit."
                            data-message-maxlength="Nomor telepon maksimal 15 digit.">
                        </div>
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="mb-3">
                        <button type="submit" class="btn btn-success btn-sm" style="width: 140px">Save</button>
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="mb-3">
                        <button type="button" class="btn btn-danger btn-sm" style="width: 140px"
                            onclick="window.location.href='{{ route('manage-address') }}'">Cancel</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous">
    </script>

    <script>
        const API_KEY = '543d80b3b490190006f5a670ce47292b0ebe9a3da6a097a0efc32b87096de8e4';

        async function fetchData(url) {
            const res = await fetch(url);
            const data = await res.json();
            return data.value;
        }

        // --- Fungsi untuk menangani validasi kustom dan pesan error ---
        function setCustomValidationMessage(inputElement, feedbackElement) {
            if (inputElement.validity.valueMissing) {
                feedbackElement.textContent = feedbackElement.dataset.messageRequired || 'Bidang ini tidak boleh kosong.';
            } else if (inputElement.validity.patternMismatch) {
                feedbackElement.textContent = feedbackElement.dataset.messagePattern || 'Format tidak sesuai.';
            } else if (inputElement.validity.tooShort) {
                feedbackElement.textContent = feedbackElement.dataset.messageMinlength || `Minimal ${inputElement.minLength} karakter.`;
            } else if (inputElement.validity.tooLong) {
                feedbackElement.textContent = feedbackElement.dataset.messageMaxlength || `Maksimal ${inputElement.maxLength} karakter.`;
            } else {
                feedbackElement.textContent = ''; // Hapus pesan jika valid
            }
        }

        // --- Inisialisasi Validasi Bootstrap ---
        (function() {
            'use strict';
            const form = document.getElementById('addressForm');

            // Event listener untuk setiap input yang memiliki validasi kustom
            document.querySelectorAll('input, select').forEach(input => {
                input.addEventListener('input', function() {
                    const feedbackElement = this.nextElementSibling;
                    if (feedbackElement && feedbackElement.classList.contains('invalid-feedback')) {
                        if (!this.validity.valid && this.type !== 'hidden') {
                            this.classList.add('is-invalid');
                            setCustomValidationMessage(this, feedbackElement);
                        } else {
                            this.classList.remove('is-invalid');
                            feedbackElement.textContent = '';
                        }
                    }
                });

                if (input.tagName === 'SELECT') {
                    input.addEventListener('change', function() {
                        const feedbackElement = this.nextElementSibling;
                        if (feedbackElement && feedbackElement.classList.contains('invalid-feedback')) {
                            if (!this.validity.valid) {
                                this.classList.add('is-invalid');
                                setCustomValidationMessage(this, feedbackElement);
                            } else {
                                this.classList.remove('is-invalid');
                                feedbackElement.textContent = '';
                            }
                        }
                    });
                }
            });

            form.addEventListener('submit', function(event) {
                // Ensure all relevant inputs are marked with 'is-invalid' if invalid
                let formValid = true;

                // Loop melalui semua elemen form yang 'required' atau punya validasi kustom
                document.querySelectorAll('#addressForm [required], #addressForm [pattern], #addressForm [minlength], #addressForm [maxlength]').forEach(inputElement => {
                    if (!inputElement.checkValidity()) { // checkValidity() akan mengevaluasi semua aturan HTML5
                        inputElement.classList.add('is-invalid');
                        const feedbackElement = inputElement.nextElementSibling;
                        if (feedbackElement && feedbackElement.classList.contains('invalid-feedback')) {
                            setCustomValidationMessage(inputElement, feedbackElement);
                        }
                        formValid = false;
                    } else {
                        inputElement.classList.remove('is-invalid');
                        const feedbackElement = inputElement.nextElementSibling;
                        if (feedbackElement && feedbackElement.classList.contains('invalid-feedback')) {
                            feedbackElement.textContent = '';
                        }
                    }
                });

                if (!formValid) {
                    event.preventDefault();
                    event.stopPropagation();
                }

                form.classList.add('was-validated');
            }, false);
        })();

        // --- Logika Pengisian Dropdown dan Input Hidden ---

        // Fungsi untuk mereset dropdown di bawahnya, mengosongkan input hidden, dan disable
        function resetAndDisableLowerDropdowns(currentDropdownId) {
            const dropdownOrder = ['provinsi', 'kota', 'kecamatan', 'kelurahan'];
            const currentIndex = dropdownOrder.indexOf(currentDropdownId);

            for (let i = currentIndex + 1; i < dropdownOrder.length; i++) {
                const selectElement = document.getElementById(dropdownOrder[i]);
                selectElement.innerHTML = `<option value="">Pilih ${dropdownOrder[i].charAt(0).toUpperCase() + dropdownOrder[i].slice(1)}</option>`;
                selectElement.disabled = true; // Disable dropdown
                selectElement.classList.remove('is-invalid'); // Remove validation feedback

                const hiddenInput = document.getElementById(dropdownOrder[i] + '_name');
                if (hiddenInput) {
                    hiddenInput.value = '';
                }
            }
        }

        // Load Provinsi saat halaman dimuat
        document.addEventListener('DOMContentLoaded', async () => {
            const provinsiSelect = document.getElementById('provinsi');
            const data = await fetchData(`https://api.binderbyte.com/wilayah/provinsi?api_key=${API_KEY}`);
            data.forEach(prov => {
                provinsiSelect.innerHTML += `<option value="${prov.id}">${prov.name}</option>`;
            });
            // Pastikan kota, kecamatan, kelurahan disabled di awal
            resetAndDisableLowerDropdowns('provinsi'); // Call to disable from 'provinsi' downwards
        });

        // Event listener untuk Provinsi
        document.getElementById('provinsi').addEventListener('change', async function() {
            const provinsiNameInput = document.getElementById('provinsi_name');
            provinsiNameInput.value = this.options[this.selectedIndex].text;

            resetAndDisableLowerDropdowns(this.id); // Reset dan disable dropdown di bawahnya
            const kotaSelect = document.getElementById('kota');
            const provID = this.value;

            if (provID) { // Jika provinsi dipilih (bukan option kosong)
                kotaSelect.disabled = false; // Enable kota dropdown
                const data = await fetchData(
                    `https://api.binderbyte.com/wilayah/kabupaten?api_key=${API_KEY}&id_provinsi=${provID}`);
                data.forEach(kota => {
                    kotaSelect.innerHTML += `<option value="${kota.id}">${kota.name}</option>`;
                });
            } else {
                // If "Pilih Provinsi" is selected, keep kota disabled
                kotaSelect.disabled = true;
                // Force validation feedback if it was previously invalid
                this.classList.add('is-invalid');
                this.nextElementSibling.textContent = this.nextElementSibling.dataset.messageRequired;
            }
            // Trigger validation check after change for UI feedback
            this.dispatchEvent(new Event('input'));
        });

        // Event listener untuk Kota
        document.getElementById('kota').addEventListener('change', async function() {
            const kotaNameInput = document.getElementById('kota_name');
            kotaNameInput.value = this.options[this.selectedIndex].text;

            resetAndDisableLowerDropdowns(this.id); // Reset dan disable dropdown di bawahnya
            const kecamatanSelect = document.getElementById('kecamatan');
            const kotaID = this.value;

            if (kotaID) {
                kecamatanSelect.disabled = false; // Enable kecamatan dropdown
                const data = await fetchData(
                    `https://api.binderbyte.com/wilayah/kecamatan?api_key=${API_KEY}&id_kabupaten=${kotaID}`);
                data.forEach(kec => {
                    kecamatanSelect.innerHTML += `<option value="${kec.id}">${kec.name}</option>`;
                });
            } else {
                kecamatanSelect.disabled = true;
                this.classList.add('is-invalid');
                this.nextElementSibling.textContent = this.nextElementSibling.dataset.messageRequired;
            }
            this.dispatchEvent(new Event('input'));
        });

        // Event listener untuk Kecamatan
        document.getElementById('kecamatan').addEventListener('change', async function() {
            const kecNameInput = document.getElementById('kecamatan_name');
            kecNameInput.value = this.options[this.selectedIndex].text;

            resetAndDisableLowerDropdowns(this.id); // Reset dan disable dropdown di bawahnya
            const kelurahanSelect = document.getElementById('kelurahan');
            const kecID = this.value;

            if (kecID) {
                kelurahanSelect.disabled = false; // Enable kelurahan dropdown
                const data = await fetchData(
                    `https://api.binderbyte.com/wilayah/kelurahan?api_key=${API_KEY}&id_kecamatan=${kecID}`);
                data.forEach(kel => {
                    kelurahanSelect.innerHTML += `<option value="${kel.id}">${kel.name}</option>`;
                });
            } else {
                kelurahanSelect.disabled = true;
                this.classList.add('is-invalid');
                this.nextElementSibling.textContent = this.nextElementSibling.dataset.messageRequired;
            }
            this.dispatchEvent(new Event('input'));
        });

        // Event listener untuk Kelurahan
        document.getElementById('kelurahan').addEventListener('change', async function() {
            const kelNameInput = document.getElementById('kelurahan_name');
            kelNameInput.value = this.options[this.selectedIndex].text;
            // Tidak perlu reset di bawahnya karena ini yang paling bawah
            this.dispatchEvent(new Event('input'));
        });
    </script>
@endsection
