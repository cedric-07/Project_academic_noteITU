@extends('index')

@section('content1')
<style>
        .result-passable {
        color: blue;
    }

    .result-assez-bien {
        color: darkblue;
    }

    .result-bien {
        color: purple;
    }

    .result-tres-bien {
        color: green;
    }

    .result-ajournee {
        color: red;
    }

    .result-compensee {
        color: violet;
    }

</style>
<h2 class="h3 mb-0"> Note Details for Students {{ Auth::check() ? Auth::user()->name : ucfirst(Session::get('name')) }}</h2>
<div class="pd-20 card-box mb-30">
    <div class="invoice">
        <hr>
        <table class="table">
            <thead class="table-dark">
                <tr>
                    <th scope="col">UE</th>
                    <th scope="col">Intitulé</th>
                    <th scope="col">Crédit</th>
                    <th scope="col">Note/20</th>
                    <th scope="col">Résultat</th>
                    <th scope="col">Session</th>
                </tr>
            </thead>
            <tbody class="table-light table-hover">
                @foreach ($notes as $note)
                <tr>
                    <td>{{ $note->matiere->reference }}</td>
                    <td>{{ $note->matiere->nom }}</td>
                    <td>{{ $note->matiere->coefficient }}</td>
                    <td>{{ $note->note }}</td>
                    <td>
                        @if ($note->note >= 10 && $note->note <= 11)
                            <span class="result-passable">Passable</span>
                        @elseif ($note->note >= 12 && $note->note <= 13.99)
                            <span class="result-assez-bien">Assez bien</span>
                        @elseif ($note->note >= 14 && $note->note <= 15.99)
                            <span class="result-bien">Bien</span>
                        @elseif ($note->note >= 16 && $note->note <= 20)
                            <span class="result-tres-bien">Très bien</span>
                        @elseif ($note->note > 6)
                            <span class="result-compensee">Compensé</span>
                        @else
                            <span class="result-ajournee">Ajournée</span>
                        @endif
                    </td>
                    <td>{{ \Carbon\Carbon::parse($note->date)->locale('fr')->isoFormat('DD MMMM YYYY') }}</td>
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
@endsection
