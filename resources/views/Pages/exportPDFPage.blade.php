<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notes des étudiants</title>
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
    </style>
</head>
<body>



    <h2 class="h3 mb-0">Relever Notes</h2>
    <div class="pd-20 card-box mb-30">
        <div style="background-color: #f8f9fa; padding: 20px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
            <p style="margin: 10px 0; font-size: 16px; color: #333;"><strong>Nom: </strong>{{ $etudiant->nom }}</p>
            <p style="margin: 10px 0; font-size: 16px; color: #333;"><strong>Prénom: </strong>{{ $etudiant->prenom }}</p>
            <p style="margin: 10px 0; font-size: 16px; color: #333;"><strong>Semestre: </strong>{{ $semestre->nom }}</p>
        </div>

        @if (Session::has('success'))
            <div class="alert alert-success mt-1">
                {{ Session::get('success') }}
            </div>
        @endif

        @if (Session::has('error'))
            <div class="alert alert-danger mt-1">
                {{ Session::get('error') }}
            </div>
        @endif

        <div class="invoice">
            <hr>
            <table class="table table-custom">
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
                <tbody class="table-hover">
                    @foreach ($notes as $note)
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
                                <span>AB</span>
                            @elseif ($note->note >= 14 && $note->note <= 15.99)
                                {{-- <span class="result-bien">B</span> --}}
                                <span>B</span>
                            @elseif ($note->note >= 16 && $note->note <= 20)
                                {{-- <span class="result-tres-bien">TB</span> --}}
                                <span>TB</span>
                            @elseif ($note->note >= 6 && $note->note < 10 && $moyenne >= 10)
                                {{-- <span class="result-compensee">Comp</span> --}}
                                <span>Comp</span>
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
                <h1>Résultat</h1>
                <table class="table table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>Crédit</th>
                            <th>Moyenne Générale</th>
                            <th>Mention</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $totalCredits }}</td>
                            <td class="text-bold text-primary">{{ $moyenne}}</td>
                            <td class="{{ $ajournee ? 'text-danger' : 'text-success' }}">
                                {{ $ajournee ? 'Aj.' : 'Admis' }}
                            </td>
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


</body>
</html>
