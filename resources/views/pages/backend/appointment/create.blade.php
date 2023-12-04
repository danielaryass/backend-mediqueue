@extends('layouts.app')
@section('title', 'Tambah Dokter')
@section('content')
    <section id="input-style">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Tambahkan Dokter</h4>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <form action="{{ route('appointment.store') }}" method="POST" class="row">
                                @csrf
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="name">Nama</label>
                                        <input type="text" id="name" class="form-control round" placeholder="name"
                                            name="name" value="{{ auth()->user()->name }}" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="phone">Nomor Telepon</label>
                                        <input type="text" id="phone" class="form-control round"
                                            placeholder="085xxxxxxx" name="phone"
                                            value="{{ isset(auth()->user()->phone) ? auth()->user()->phone : '' }}">
                                    </div>
                                </div>
                                <div class="cold-md-12">
                                    <div class="form-group">
                                        <label for="birth_date" class="mb-0">Pilih Tanggal Lahir</label>
                                        <input type="date" class="form-control mb-3 flatpickr-always-open"
                                            placeholder="Select date.." name="birth_date" id="birth_date">

                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="blood_group" class="mb-0">Golongan darah</label>
                                        <select id="blood_group" name="blood_group" class="choices form-select">
                                            <option value="">Pilih Golongan Darah</option>
                                            <option value="A">A</option>
                                            <option value="AB">AB</option>
                                            <option value="B">B</option>
                                            <option value="O">O</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="doctor_id" class="mb-0">Pilih Dokter</label>
                                        <select id="doctor_id" name="doctor_id" class="choices form-select">
                                            <option value="">Pilih Dokter</option>
                                            @foreach ($doctors as $doctor)
                                                <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="type_appointment" class="mb-0">Pilih Tipe Appointment</label>
                                        <select id="type_appointment" name="type_appointment" class="choices form-select">
                                            <option value="">Pilih Tipe Appointment</option>
                                            <option value="BPJS">BPJS</option>
                                            <option value="Mandiri">Mandiri</option>
                                            <option value="Asuransi">Asuransi</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="cold-md-12">
                                    <div class="form-group">
                                        <label for="appointment_date" class="mb-0">Pilih Tanggal Appointment</label>
                                        <input type="date" class="form-control mb-3 flatpickr-always-open"
                                            placeholder="Select date.." name="appointment_date" id="appointment_date">

                                    </div>
                                </div>
                                <div class="">
                                    <button type="submit" class="btn btn-primary">Tambahkan Appointment</button>
                                    <a href="#" class="btn btn-warning rounded-pill fw-bold">TEXT JADI APA</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
@push('js')
    <script src="{{ asset('assets/extensions/choices.js/public/assets/scripts/choices.js') }}"></script>
    <script src="{{ asset('assets/static/js/pages/form-element-select.js') }}"></script>
    <script src="{{ asset('assets/extensions/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ asset('assets/static/js/pages/date-picker.js') }}"></script>
@endpush
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/extensions/choices.js/public/assets/styles/choices.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/extensions/flatpickr/flatpickr.min.css') }}">
@endpush
