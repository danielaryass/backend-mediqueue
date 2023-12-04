@extends('layouts.app')
@section('title', 'Appointment List')
@section('content')
    <!-- Basic Tables start -->
    <section class="section">
        <div class="card">
            <div class="card-header">
                <a href="{{ route('appointment.create') }}" class="btn btn-primary">Tambahkan Appointment</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table" id="table1">
                        <thead>
                            <tr>
                                <th>Appointment Code</th>
                                <th>Nama Patient</th>
                                <th>Tipe Appointment</th>
                                <th>Status</th>
                                <th>Dokter</th>
                                <th>No Antrian</th>
                                <th>Waktu Datang</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($appointments as $key => $appointment)
                                <tr>
                                    <td>{{ $appointment->appointment_code }}</td>
                                    <td>{{ $appointment->user->name }}</td>
                                    <td>{{ $appointment->type_appointment }}</td>
                                    <td>{{ $appointment->status }}</td>
                                    <td>{{ $appointment->doctor->name }}</td>
                                    <td>{{ $appointment->no_queue }}</td>
                                    <td>{{ $appointment->appointment_time }}</td>
                                    <td class="">
                                       
                                        <form action="{{ route('appointment.done', $appointment->id) }}" method="POST" class="mb-2 col-12">
                                            @csrf
                                            <input type="text" value="Done" hidden>
                                            <button type="submit" class="btn btn-success btn-sm">Done</button>
                                        </form>
                                        <form action="{{ route('appointment.missing', $appointment->id) }}" method="POST" class="">
                                            @csrf
                                            <input type="text" value="Missing" hidden>
                                            <button type="submit" class="btn btn-danger btn-sm">Missing</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                            @endforelse

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </section>
    <!-- Basic Tables end -->
@endsection
@push('js')
    <script src="{{ asset('assets/extensions/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/extensions/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/static/js/pages/datatables.js') }}"></script>
@endpush
@push('css')
    <link rel="stylesheet" href="{{ asset('/assets/compiled/css/table-datatable-jquery.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">
@endpush
