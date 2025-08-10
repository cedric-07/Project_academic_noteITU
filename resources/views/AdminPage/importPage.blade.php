@extends('index')

@section('content1')
<style>
    .card-box {
        background-color: #ffffff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .card-box h2 {
        font-size: 28px;
        font-weight: 600;
        margin-bottom: 20px;
        color: #333;
        text-align: center;
    }

    .form-group label {
        font-weight: 500;
        color: #495057;
    }

    .form-group input {
        border: 1px solid #ced4da;
        border-radius: 5px;
        padding: 10px;
        width: 100%;
    }

    .btn-custom {
        width: 100%;
        padding: 10px;
        border-radius: 5px;
        font-size: 16px;
        margin-top: 10px;
    }

    .alert ul {
        margin-bottom: 0;
    }

    .alert ul ul {
        margin-top: 5px;
        margin-left: 20px;
    }

    .row {
        display: flex;
        flex-wrap: wrap;
    }

    .col-md-6 {
        flex: 1;
        padding: 10px;
    }

    .alert {
        border-radius: 5px;
    }
</style>

<h2 class="h3 mb-0 text-center">Import Data Page</h2>
<br>
<div class="pd-20 card-box mb-30">
    <div class="row">
        <div class="col-md-6">
            <form action="{{ route('import.importnote') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="Note">Import the data of notes</label>
                    <input type="file" class="form-control-file" id="Note" name="note" accept=".csv" required>
                </div>
                <button type="submit" class="btn btn-success btn-custom">Import</button>
            </form>
        </div>

        <div class="col-md-6">
            <form action="{{ route('import.importconfig') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="Note">Import the data of config</label>
                    <input type="file" class="form-control-file" id="Note" name="config" accept=".csv" required>
                </div>
                <button type="submit" class="btn btn-success btn-custom">Import</button>
            </form>
        </div>
    </div>

    @if (session('errors'))
        <div class="alert alert-danger mt-4">
            <ul>
                @foreach (session('errors') as $category => $messages)
                    <li><strong>{{ ucfirst($category) }}:</strong>
                        <ul>
                            @foreach ($messages as $message)
                                <li>{{ $message }}</li>
                            @endforeach
                        </ul>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success mt-4">
            <p>{{ session('success') }}</p>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger mt-4">
            <p>{{ session('error') }}</p>
        </div>
    @endif
</div>
@endsection
