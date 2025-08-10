@extends('index')

@section('content1')
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
    </style>

<h2 class="h3 mb-0">Relever Notes</strong></h2>
<div class="pd-20 card-box mb-30">
    <div style="background-color: #f8f9fa; padding: 20px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
        <p style="margin: 10px 0; font-size: 16px; color: #333;"><strong>Name: </strong>{{ $etudiant->nom }}</p>
        <p style="margin: 10px 0; font-size: 16px; color: #333;"><strong>First Name: </strong>{{ $etudiant->prenom }}</p>
        <p style="margin: 10px 0; font-size: 16px; color: #333;"><strong>ETU: </strong>{{ $etudiant->numetu }}</p>
        {{-- <p style="margin: 10px 0; font-size: 16px; color: #333;"><strong>Year: </strong>{{ \Carbon\Carbon::parse( $etudiantsemestre->date )->locale('fr')->isoFormat('DD MMMM YYYY') }}</p> --}}
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
        <div class="container mt-5">
            <div class="container mt-5">
                <div class="header-export mb-4">
                    <h2 class="mb-3">Export PDF File</h2>
                    <a class="btn btn-danger btn-sm d-inline-flex align-items-center" href="{{ route('export.exportCategoriePDF', ['nomCategorie'=> $categorie->nom, 'etudiantsId' => $etudiant->idetudiant]) }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" class="bi bi-file-earmark-pdf me-1" viewBox="0 0 16 16">
                            <path d="M5.5 6.5A.5.5 0 0 1 6 7h1v2H6a.5.5 0 0 1-.5-.5v-2z"/>
                            <path d="M4.5 10a.5.5 0 0 0 0 1h3.707l-2.224 2.224a.5.5 0 0 0 .707.707l3-3a.5.5 0 0 0 0-.707l-3-3a.5.5 0 1 0-.707.707L8.207 10H4.5zm9.5 1V4a1 1 0 0 0-1-1h-4.5a1 1 0 0 1-1-1H3a2 2 0 0 0-2 2v9.5a1 1 0 0 0 1 1H9a1 1 0 0 0 1-1v-3a1 1 0 0 0 1-1v-1a1 1 0 0 0 1-1zm-1-5v4H10v3H3V3a1 1 0 0 1 1-1h3v2.5A1.5 1.5 0 0 0 8.5 6h2a1.5 1.5 0 0 0 1.5-1.5V2.268A1 1 0 0 1 13 3v3z"/>
                        </svg>
                        PDF
                    </a>
                </div>

                <div class="header-export mb-4">
                    <h2 class="mb-3">Export Excel File</h2>
                    <a class="btn btn-success btn-sm d-inline-flex align-items-center" href="{{ route('export.exportCSV', ['nomCategorie'=> $categorie->nom, 'etudiantsId' => $etudiant->idetudiant]) }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" class="bi bi-file-earmark-excel me-1" viewBox="0 0 16 16">
                            <path d="M5.5 6.5A.5.5 0 0 1 6 7h1v2H6a.5.5 0 0 1-.5-.5v-2z"/>
                            <path d="M4.5 10a.5.5 0 0 0 0 1h3.707l-2.224 2.224a.5.5 0 0 0 .707.707l3-3a.5.5 0 0 0 0-.707l-3-3a.5.5 0 1 0-.707.707L8.207 10H4.5zm9.5 1V4a1 1 0 0 0-1-1h-4.5a1 1 0 0 1-1-1H3a2 2 0 0 0-2 2v9.5a1 1 0 0 0 1 1H9a1 1 0 0 0 1-1v-3a1 1 0 0 0 1-1v-1a1 1 0 0 0 1-1zm-1-5v4H10v3H3V3a1 1 0 0 1 1-1h3v2.5A1.5 1.5 0 0 0 8.5 6h2a1.5 1.5 0 0 0 1.5-1.5V2.268A1 1 0 0 1 13 3v3z"/>
                        </svg>
                        Excel
                    </a>
                </div>
            </div>

        @foreach ($semestres as $semestre)
        <hr>


        <h2 class="h3 mb-0">Liste Note for S{{ $semestre->idsemestre }}</h2>
        <br>
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
                            <span>AB</span>
                        @elseif ($note->note >= 14 && $note->note <= 15.99)
                            {{-- <span class="result-bien">B</span> --}}
                            <span>B</span>
                        @elseif ($note->note >= 16 && $note->note <= 20)
                            {{-- <span class="result-tres-bien">TB</span> --}}
                            <span>TB</span>
                        @elseif ($note->note >= 6 && $note->note < 10 && $notes['moyennesParSemestre'][$semestre->idsemestre] >= 10)
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
                        <td class="text-bold text-primary">{{ number_format($notes['moyennesParSemestre'][$semestre->idsemestre], 2) }}</td>
                        @if ($notes['mentions'][$semestre->idsemestre])
                            <td @class(['p-4', 'font-bold' , 'text-danger' => true])>Aj.</td>
                        @else
                         <td @class(['p-4', 'font-bold' , 'text-success' => true])>Admis</td>
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
                        <th>Moyenne Génerale</th>
                        <th>Mention</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-bold text-primary">{{ number_format($notes['moyenneGenerale'], 2) }}</td>
                        @if (number_format($notes['moyenneGenerale'], 2) < 10)
                            <td @class(['p-4', 'font-bold' , 'text-danger' => true])>Aj.</td>
                        @else
                         <td @class(['p-4', 'font-bold' , 'text-success' => true])>Admis</td>
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
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
@endsection
