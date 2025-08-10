<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relevé de Notes</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .result-passable {
            color: blue;
            font-weight: bold;
        }

        .result-assez-bien {
            color: darkblue;
            font-weight: bold;
        }

        .result-bien {
            color: purple;
            font-weight: bold;
        }

        .result-tres-bien {
            color: green;
            font-weight: bold;
        }

        .result-ajournee {
            color: red;
            font-weight: bold;
        }

        .result-compensee {
            color: violet;
            font-weight: bold;
        }

        .table-custom th, .table-custom td {
            text-align: center;
        }

        .table-custom thead {
            background-color: #343a40;
            color: white;
        }

        .table-custom tbody tr:hover {
            background-color: #f1f1f1;
        }

        .result-summary {
            margin-top: 20px;
        }

        .result-summary h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        .btn-export {
            display: inline-flex;
            align-items: center;
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .btn-export:hover {
            background-color: #0056b3;
            color: #fff;
        }

        .btn-export svg {
            margin-right: 8px;
            fill: currentColor;
        }

        .header-export {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .header-export h2 {
            margin: 0;
            font-size: 24px;
        }

        .card-box {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .alert-success, .alert-danger {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="card card-box mb-30">
            <div class="card-body">
                <div class="personal-info mb-4">
                    <p><strong>Nom: </strong>{{ $etudiant->nom }}</p>
                    <p><strong>Prénom: </strong>{{ $etudiant->prenom }}</p>
                    <p><strong>ETU: </strong>{{ $etudiant->numetu }}</p>
                    <p class="text-bold"><strong>School name : </strong>ITUniversity</p>
                </div>

                @if (Session::has('success'))
                    <div class="alert alert-success">
                        {{ Session::get('success') }}
                    </div>
                @endif

                @if (Session::has('error'))
                    <div class="alert alert-danger">
                        {{ Session::get('error') }}
                    </div>
                @endif

                @foreach ($semestres as $semestre)
                    <h2 class="h3 mb-4">List Note S{{ $semestre->idsemestre }}</h2>
                    <table class="table table-custom table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">UE</th>
                                <th scope="col">Intitulé</th>
                                <th scope="col">Crédit</th>
                                <th scope="col">Note/20</th>
                                <th scope="col">Résultat</th>
                                <th scope="col">Session</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($notes[$semestre->idsemestre] as $note)
                                <tr>
                                    <td>{{ $note->reference }}</td>
                                    <td>{{ $note->matiere }}</td>
                                    <td>{{ $note->coefficient }}</td>
                                    <td>{{ $note->note }}</td>
                                    <td>
                                        @if ($note->note >= 10 && $note->note <= 11.99)
                                            {{-- <span class="result-passable">P</span> --}}
                                            <span>P</span>
                                        @elseif ($note->note >= 12 && $note->note <= 13.99)
                                            {{-- <span class="result-assez-bien">AB</span> --}}
                                            <span >AB</span>
                                        @elseif ($note->note >= 14 && $note->note <= 15.99)
                                            {{-- <span class="result-bien">B</span> --}}
                                            <span >B</span>
                                        @elseif ($note->note >= 16 && $note->note <= 20)
                                            {{-- <span class="result-tres-bien">TB</span> --}}
                                            <span >TB</span>
                                        @elseif ($note->note >= 6 && $note->note < 10 && $notes['moyennesParSemestre'][$semestre->idsemestre] >= 10)
                                            {{-- <span class="result-compensee">Comp</span> --}}
                                            <span >Comp</span>
                                        @else
                                            {{-- <span class="result-ajournee">Aj</span> --}}
                                            <span>Aj</span>
                                        @endif
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($note->date)->locale('fr')->isoFormat('DD MMMM YYYY') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="result-summary">
                        <h1>Result for S{{ $semestre->idsemestre }}</h1>
                        <table class="table table-bordered">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Crédit</th>
                                    <th>Moyenne</th>
                                    <th>Mention</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $totalCredits }}</td>
                                    <td class="font-weight-bold text-primary">{{ number_format($notes['moyennesParSemestre'][$semestre->idsemestre], 2) }}</td>
                                    @if ($notes['mentions'][$semestre->idsemestre])
                                        {{-- <td class="font-weight-bold text-danger">Aj.</td> --}}
                                        <td>Aj.</td>
                                    @else
                                        {{-- <td class="font-weight-bold text-success">Admis</td> --}}
                                        <td>Admis</td>
                                    @endif
                                </tr>
                            </tbody>
                        </table>
                    </div>
                @endforeach

                <div class="result-summary">
                    <table class="table table-bordered">
                        <thead class="thead-dark">
                            <tr>
                                <th>Moyenne Générale</th>
                                <th>Mention</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="font-weight-bold text-primary">{{ number_format($notes['moyenneGenerale'], 2) }}</td>
                                @if (number_format($notes['moyenneGenerale'], 2) < 10)
                                    <td class="font-weight-bold text-danger">Aj.</td>
                                @else
                                    <td class="font-weight-bold text-success">Admis</td>
                                @endif
                            </tr>
                        </tbody>
                    </table>
                </div>

                <hr>

                <div class="row">
                    <div class="col-md-6 text-right">
                        <p><strong>Date:</strong> {{ \Carbon\Carbon::parse(now()->format('Y-m-d'))->locale('fr')->isoFormat('DD MMMM YYYY') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
