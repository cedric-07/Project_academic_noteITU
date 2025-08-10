@extends('index')

@section('content1')
<div class="container mt-5">
    <h2 class="h3 mb-4 text-center">Pending Courses</h2>

    @if (empty($matieresAjournees) || count($matieresAjournees) === 0)
        <div class="alert alert-info text-center" role="alert">
            No pending courses for this student.
        </div>
    @else
        <div class="card shadow-lg mb-4">
            <div class="card-body text-center">
                <h4 class="font-weight-bold mb-2">Total Amount for Resits:</h4>
                @if ($montantTotal <= 50000)
                    <h1 class="display-4 font-weight-bold text-danger">{{ $montantTotal }} Ar</h1>
                @else
                    <h1 class="display-4 font-weight-bold text-success">{{ $montantTotal }} Ar</h1>
                @endif
            </div>
        </div>

        <div class="card shadow-lg">
            <div class="card-body">
                <table class="table table-hover table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">UE</th>
                            <th scope="col">Title</th>
                            <th scope="col">Credit</th>
                            <th scope="col">Grade / 20</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($matieresAjournees as $matiere)
                        <tr>
                            <td>{{ $matiere->reference }}</td>
                            <td>{{ $matiere->matiere }}</td>
                            <td>{{ $matiere->coefficient }}</td>
                            <td>{{ number_format($matiere->note, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-6 text-right">
                <p><strong>Date:</strong> {{ \Carbon\Carbon::parse(now()->format('Y-m-d'))->locale('en')->isoFormat('DD MMMM YYYY') }}</p>
            </div>
        </div>
    @endif
</div>
@endsection
