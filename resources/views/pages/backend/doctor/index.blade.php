@extends('layouts.app')
@section('title', 'Doctors List')
@section('content')
    <!-- Basic Tables start -->
    <section class="section">
        <div class="card">
            <div class="card-header">
                <a href="{{route('doctor.create')}}" class="btn btn-primary">Tambahkan Dokter</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table" id="table1">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Jam Kerja Awal</th>
                                <th>Jam Kerja Akhir</th>
                                <th>Photo</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($doctors as $key => $doctor)
                                <tr>
                                    <td>{{ $doctor->name }}</td>
                                    <td>{{date("H:i", strtotime($doctor->start_time))}}</td>
                                    <td>{{date("H:i", strtotime($doctor->end_time))}}</td>
                                    <td><img src="{{ request()->getSchemeAndHttpHost() . '/storage' . '/' . $doctor->image_url }}" alt="Gambar tidak ada" class="img-thumbnail" style="width: 75px"></td>
                                    <td>
                                        <a href="{{route('doctor.edit',$doctor->id)}}">Edit</a>
                                        <span class="badge bg-success">Active</span>
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
