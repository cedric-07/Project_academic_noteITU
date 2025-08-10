@extends('index')

@section('content1')

<div class="container mt-5">
    <h2 class="h3 mb-4 text-center text-primary">Update Configuration Note</h2>

    <!-- Display success and error messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
            <strong>There were some problems with your input:</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <form action="{{ route('config.update') }}" method="POST" class="bg-white p-5 rounded shadow-lg border border-light">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="configOption">Select Option</label>
            <select class="form-control" id="configOption" name="code">
                <option value="" selected disabled>Select config ...</option>
                @foreach ($configs as $config)
                    <option value="{{ $config->code }}" {{ $config->code }}>
                        {{ $config->code }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label for="valeur" class="form-label fw-semibold">Value</label>
            <input type="number" class="form-control" id="valeur" name="valeur" value="{{ old('valeur', $config->value) }}" required>
        </div>

        <button type="submit" class="btn btn-primary btn-lg w-100">Update</button>
    </form>
</div>

@endsection
