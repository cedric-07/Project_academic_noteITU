@extends('index')

@section('content1')
<h2 class="h3 mb-0">List of Students</h2>
<div class="pd-20 card-box mb-30">
    @if (session('success'))
        <div class="alert alert-success mt-3">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger mt-3">
            {{ session('error') }}
        </div>
    @endif
    <div class="invoice">
        <hr>
        @if ($etudiants->isEmpty())
            <div class="alert alert-warning mt-3">
                No students found for the given search criteria.
            </div>
        @else
            <table class="table">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">FirstName</th>
                        <th scope="col">ETU</th>
                        <th scope="col">Birth</th>
                        <th scope="col">Promotion</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody class="table-light table-hover">
                    @foreach ($etudiants as $etudiant)
                        <tr>
                            <td>{{ $etudiant->nom }}</td>
                            <td>{{ $etudiant->prenom }}</td>
                            <td>{{ $etudiant->numetu }}</td>
                            <td>{{ \Carbon\Carbon::parse($etudiant->dtn)->locale('fr')->isoFormat('DD MMMM YYYY') }}</td>
                            <td>{{ $etudiant->promotion->nom }}</td>
                            <td>
                                <div class="dropdown">
                                    <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                        <i class="dw dw-more"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                        <a class="dropdown-item" href="{{ route('semestre.getsemestre', ['etudiantsId' => $etudiant->idetudiant]) }}"><i class="dw dw-edit2"></i> View Semester</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
        <hr>
        <div class="row">
            <div class="col-md-6 text-right">
                <p><strong>Date:</strong> {{ \Carbon\Carbon::parse(now()->format('Y-m-d'))->locale('fr')->isoFormat('DD MMMM YYYY') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
