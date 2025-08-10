{{-- @extends('index')

@section('content1')
<div class="container">
    <h1>Étudiants par Semestre</h1>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Numéro Étudiant</th>
                <th>Moyenne</th>
                <th>Rang</th>
            </tr>
        </thead>
        <tbody>
            @foreach($moyennes as $moyenne)
                @php
                    // Trouver l'étudiant correspondant
                    $etudiant = $etudiants->firstWhere('idetudiant', $moyenne->idetudiant);
                @endphp
                @if($etudiant)
                    <tr>
                        <td>{{ $etudiant->nom }}</td>
                        <td>{{ $etudiant->prenom }}</td>
                        <td>{{ $etudiant->numetu }}</td>
                        <td>{{ $moyenne->moyenne }}</td>
                        <td>{{ $moyenne->rang }}</td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
</div>
@endsection --}}

@extends('index')
<style>
    /* Dans votre fichier CSS */
.highlight-rank {
    background-color: #f8d7da; /* Couleur de fond pour les rangs exæquo */
    color: #721c24; /* Couleur du texte pour les rangs exæquo */
}

.first-rank {
    background-color: #d4edda; /* Couleur de fond pour le premier rang */
    color: #155724; /* Couleur du texte pour le premier rang */
}

.last-rank {
    background-color: #cce5ff; /* Couleur de fond pour le dernier rang */
    color: #004085; /* Couleur du texte pour le dernier rang */
}
</style>

@section('content1')
<div class="container">
    <h1>Students by Semester</h1>

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Name</th>
                <th>First Name</th>
                <th>Student Number</th>
                <th>Average</th>
                <th>Rank</th>
            </tr>
        </thead>
        <tbody>
            @php
                // Trouver la liste des moyennes pour détecter les rangs exæquo
                $moyennesGrouped = $moyennes->groupBy('moyenne');

                // Trouver le premier et le dernier rang
                $firstRank = $moyennes->min('rang');
                $lastRank = $moyennes->max('rang');
            @endphp

            @foreach($moyennes as $moyenne)
                @php
                    // Trouver l'étudiant correspondant
                    $etudiant = $etudiants->firstWhere('idetudiant', $moyenne->idetudiant);

                    // Déterminer si ce rang est exæquo
                    $isExeco = $moyennesGrouped[$moyenne->moyenne]->count() > 1;

                    // Déterminer si c'est le premier ou le dernier rang
                    $isFirstRank = $moyenne->rang == $firstRank;
                    $isLastRank = $moyenne->rang == $lastRank;
                @endphp
                @if($etudiant)
                    <tr class="{{
                        $isFirstRank ? 'first-rank' :
                        ($isLastRank ? 'last-rank' :
                        ($isExeco ? 'highlight-rank' : ''))
                    }}">
                        <td>{{ $etudiant->nom }}</td>
                        <td>{{ $etudiant->prenom }}</td>
                        <td>{{ $etudiant->numetu }}</td>
                        <td>
                            @if ($moyenne->moyenne < 10)
                                <span class="text-primary">{{ $moyenne->moyenne }}</span>
                            @else
                                {{ $moyenne->moyenne }}
                            @endif
                        </td>
                        <td>{{ $moyenne->rang }}</td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
</div>
@endsection




