@extends('index')

@section('content1')
    <h1>Matières pour le Semestre {{ $semestreId }}</h1>
    <table class="table">
        <thead>
            <tr>
                <th>ID Matière</th>
                <th>Référence</th>
                <th>Nom</th>
                <th>Coefficient</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($matieres as $matiere)
                <tr>
                    <td>{{ $matiere->idmatiere }}</td>
                    <td>{{ $matiere->reference }}</td>
                    <td>{{ $matiere->nom }}</td>
                    <td>{{ $matiere->coefficient }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
