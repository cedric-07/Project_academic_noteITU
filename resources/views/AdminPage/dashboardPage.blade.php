{{-- @extends('index')
@section('content1')

<div class="container mt-5">
    <h1 class="text-center">Dashboard for Administrators</h1>
</div>
<div class="container mt-5">
    <div class="row">
        <!-- Card for Number of Students Admitted in Licence -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0 text-light">Number of Students Admitted in Licence</h5>
                </div>
                <div class="card-body d-flex align-items-center justify-content-center">
                    <div class="text-center">
                        <h1 class="display-4 text-success">{{ $nbradmis }}</h1>
                        <p class="mb-0">Admitted</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card for Number of Students Not Admitted in Licence -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0 text-light">Number of Students Not Admitted in Licence</h5>
                </div>
                <div class="card-body d-flex align-items-center justify-content-center">
                    <div class="text-center">
                        <h1 class="display-4 text-danger">{{ $nbrajour }}</h1>
                        <p class="mb-0">Not Admitted</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card for Total Students -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0 text-light">Total Students</h5>
                </div>
                <div class="card-body d-flex align-items-center justify-content-center">
                    <div class="text-center">
                        <h1 class="display-4 text-primary">{{ $nbretudiant }}</h1>
                        <p class="mb-0">Total</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<h2 class="h3 mb-0">List of Students</h2>
<div class="pd-20 card-box mb-30">

    <div class="invoice">
        <hr>
        <table class="table">
            <thead class="table-dark">
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">FirstName</th>
                    <th scope="col">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($status as $stat)
                <tr>
                    <td>{{ $stat['etudiant']->nom }}</td>
                    <td>{{ $stat['etudiant']->prenom }}</td>
                    <td class="{{ $stat['statut'] == 'admis licence' ? 'text-success' : 'text-danger' }}">
                        {{ $stat['statut'] }}
                    </td>
                </tr>


                @endforeach
            </tbody>
        </table>
        <hr>
        <div class="row">
            <div class="col-md-6 text-right">
                <p><strong>Date:</strong> {{ \Carbon\Carbon::parse(now()->format('Y-m-d'))->locale('fr')->isoFormat('DD MMMM YYYY') }}</p>
            </div>
        </div>
    </div>
</div>

@endsection --}}




{{-- @extends('index')

@section('content1')

<div class="container mt-5">
    <h1 class="text-center mb-4">Dashboard for Administrators</h1>
    <div class="row">
        <!-- Card for Number of Students Admitted in Licence -->
        <div class="col-md-4 mb-4">
            <div class="card  shadow-sm h-100">
                <div class="card-body d-flex flex-column align-items-center justify-content-center">
                    <h1 class="display-4 text-success">{{ $nbradmis }}</h1>
                    <p class="mb-0 text-success">Admitted</p>
                </div>
            </div>
        </div>

        <!-- Card for Number of Students Not Admitted in Licence -->
        <div class="col-md-4 mb-4">
            <div class="card   shadow-sm h-100">
                <div class="card-body d-flex flex-column align-items-center justify-content-center">
                    <h1 class="display-4 text-danger">{{ $nbrajour }}</h1>
                    <p class="mb-0 text-danger">Not Admitted</p>
                </div>
            </div>
        </div>

        <!-- Card for Total Students -->
        <div class="col-md-4 mb-4">
            <div class="card  shadow-sm h-100">
                <div class="card-body d-flex flex-column align-items-center justify-content-center">
                    <h1 class="display-4 text-blue">{{ $nbretudiant }}</h1>
                    <p class="mb-0 text-blue">Total</p>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="container mt-5">
    <h2 class="h3 mb-4 text-center">List of Students</h2>

    <div class="row">
        <!-- Table for Admitted Students -->
        <div class="col-md-12 mb-5">
            <div class="card h-100 shadow-sm">
                <div class="card-header">
                    <h4 class="mb-0">Admitted Students</h4>
                </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">ETU</th>
                                <th scope="col">Name</th>
                                <th scope="col">First Name</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $index = 1; @endphp
                            @foreach($status as $stat)
                                @if($stat['statut'] == 'admis')
                                    <tr>
                                        <td>{{ $index++ }}</td>
                                        <td>{{ $stat['etudiant']->numetu }}</td>
                                        <td>{{ $stat['etudiant']->nom }}</td>
                                        <td>{{ $stat['etudiant']->prenom }}</td>
                                        <td class="font-weight-bold">{{ $stat['statut'] }}</td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Table for Not Admitted Students -->
        <div class="col-md-12 mb-5">
            <div class="card h-100 shadow-sm">
                <div class="card-header">
                    <h4 class="mb-0">Not Admitted Students</h4>
                </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">ETU</th>
                                <th scope="col">Name</th>
                                <th scope="col">First Name</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $index = 1; @endphp
                            @foreach($status as $stat)
                                @if($stat['statut'] == 'aj')
                                    <tr>
                                        <td>{{ $index++ }}</td>
                                        <td>{{ $stat['etudiant']->numetu }}</td>
                                        <td>{{ $stat['etudiant']->nom }}</td>
                                        <td>{{ $stat['etudiant']->prenom }}</td>
                                        <td class="font-weight-bold">{{ $stat['statut'] }}</td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>



@endsection --}}

@extends('index')

@section('content1')

<div class="container mt-5">
    <h1 class="text-center mb-4">Dashboard for Administrators</h1>
    <div class="row">
        <!-- Card for Number of Students Admitted in Licence -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm h-100" id="showAdmitted">
                <div class="card-body d-flex flex-column align-items-center justify-content-center">
                    <h1 class="display-4 text-success">{{ $nbradmis }}</h1>
                    <p class="mb-0 text-success">Admitted</p>
                    {{-- <button class="btn btn-success mt-3">Voir Détails</button> --}}
                </div>
            </div>
        </div>

        <!-- Card for Number of Students Not Admitted in Licence -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm h-100" id="showNotAdmitted">
                <div class="card-body d-flex flex-column align-items-center justify-content-center">
                    <h1 class="display-4 text-danger">{{ $nbrajour }}</h1>
                    <p class="mb-0 text-danger">Not Admitted</p>
                    {{-- <button class="btn btn-danger mt-3">Voir Détails</button> --}}
                </div>
            </div>
        </div>

        <!-- Card for Total Students -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm h-100" id="showAll">
                <div class="card-body d-flex flex-column align-items-center justify-content-center">
                    <h1 class="display-4 text-blue">{{ $nbretudiant }}</h1>
                    <p class="mb-0 text-blue">Total</p>
                    {{-- <button class="btn btn-primary mt-3">Voir Détails</button> --}}
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container mt-5">
    <h2 class="h3 mb-4 text-center">List of Students</h2>

    <div class="row">
        <!-- Table for Admitted Students -->
        <div class="col-md-12 mb-5" id="admittedTable" style="display: none;">
            <div class="card h-100 shadow-sm">
                <div class="card-header">
                    <h4 class="mb-0">Admitted Students</h4>
                </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">ETU</th>
                                <th scope="col">Name</th>
                                <th scope="col">First Name</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $index = 1; @endphp
                            @foreach($status as $stat)
                                @if($stat['statut'] == 'admis')
                                    <tr>
                                        <td>{{ $index++ }}</td>
                                        <td>{{ $stat['etudiant']->numetu }}</td>
                                        <td>{{ $stat['etudiant']->nom }}</td>
                                        <td>{{ $stat['etudiant']->prenom }}</td>
                                        <td class="font-weight-bold text-success">{{ $stat['statut'] }}</td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Table for Not Admitted Students -->
        <div class="col-md-12 mb-5" id="notAdmittedTable" style="display: none;">
            <div class="card h-100 shadow-sm">
                <div class="card-header">
                    <h4 class="mb-0">Not Admitted Students</h4>
                </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">ETU</th>
                                <th scope="col">Name</th>
                                <th scope="col">First Name</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $index = 1; @endphp
                            @foreach($status as $stat)
                                @if($stat['statut'] == 'aj')
                                    <tr>
                                        <td>{{ $index++ }}</td>
                                        <td>{{ $stat['etudiant']->numetu }}</td>
                                        <td>{{ $stat['etudiant']->nom }}</td>
                                        <td>{{ $stat['etudiant']->prenom }}</td>
                                        <td class="font-weight-bold text-danger">{{ $stat['statut'] }}</td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Table for Total Students -->
        <div class="col-md-12 mb-5" id="totalStudentsTable" style="display: none;">
            <div class="card h-100 shadow-sm">
                <div class="card-header">
                    <h4 class="mb-0">Total Students</h4>
                </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">ETU</th>
                                <th scope="col">Name</th>
                                <th scope="col">First Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $index = 1; @endphp
                            @foreach($etudiants as $etudiant)
                                <tr>
                                    <td>{{ $index++ }}</td>
                                    <td>{{ $etudiant->numetu }}</td>
                                    <td>{{ $etudiant->nom }}</td>
                                    <td>{{ $etudiant->prenom }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('showAdmitted').addEventListener('click', function() {
        document.getElementById('admittedTable').style.display = 'block';
        document.getElementById('notAdmittedTable').style.display = 'none';
        document.getElementById('totalStudentsTable').style.display = 'none';
    });

    document.getElementById('showNotAdmitted').addEventListener('click', function() {
        document.getElementById('admittedTable').style.display = 'none';
        document.getElementById('notAdmittedTable').style.display = 'block';
        document.getElementById('totalStudentsTable').style.display = 'none';
    });

    document.getElementById('showAll').addEventListener('click', function() {
        document.getElementById('admittedTable').style.display = 'none';
        document.getElementById('notAdmittedTable').style.display = 'none';
        document.getElementById('totalStudentsTable').style.display = 'block';
    });
</script>

@endsection

