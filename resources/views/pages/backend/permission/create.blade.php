@extends('layouts.app')
@section('title', 'Tambah Permission')
@section('content')
    <section id="input-style">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Tambahkan Permission</h4>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <form action="{{ route('permissions.store') }}" method="POST">
                                @csrf
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" id="name" class="form-control round" placeholder="name"
                                            name="name" value="{{ old('name') }}">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Tambahkan Permission</button>
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
@endpush
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/extensions/choices.js/public/assets/styles/choices.css') }}">
@endpush
