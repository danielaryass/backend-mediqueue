@extends('layouts.app')
@section('title', 'Users Edit')
@section('content')
    <section id="input-style">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Edit {{ $user->name }}</h4>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <form action="{{ route('user.update', [$user->id]) }}" method="POST">
                                @method('PUT')
                                @csrf
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="roundText">Name</label>
                                        <input type="text" id="name" class="form-control round" placeholder="name"
                                            name="name" value="{{ old('name', isset($user) ? $user->name : '') }}">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="roundText">Email</label>
                                        <input type="text" id="email" class="form-control round" placeholder="Email"
                                            name="email" value="{{ old('email', isset($user) ? $user->email : '') }}">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="multiple">Select Role</label>
                                        <select class="choices form-select multiple-remove" multiple="multiple"
                                            name="roles[]">
                                            {{-- @foreach ($roles as $key => $role)
                                                <option value="{{ $role->name }}">{{ $role->name }}</option>
                                            @endforeach --}}
                                            @foreach ($roles as $key => $role)
                                                <option value="{{ $role->name }}"
                                                    {{ in_array($role->name, $userRoleNames) ? 'selected' : '' }}>
                                                    {{ $role->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <button class="btn btn-warning"> Edit Data</button>
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
