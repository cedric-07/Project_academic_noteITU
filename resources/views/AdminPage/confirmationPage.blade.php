@extends('index')

@section('content1')
<h2 class="h3 mb-0">Confirmation Details</h2>
<div class="pd-20 card-box mb-30">
    <div class="invoice">
        <hr>
        <table class="table">
            <thead class="table-dark">
                <tr>
                    <th scope="col">Nom promotion</th>
                    <th scope="col">Matiere reference</th>
                    <th scope="col">Note</th>
                </tr>
            </thead>
            <tbody class="table-light table-hover">
                <tr>
                    <td>{{ $promotionNom}}</td>
                    <td>{{ $matiereNom }}</td>
                    <td>{{ $note }}</td>
                </tr>
            </tbody>
        </table>
        <hr>
        <div class="row">
            <div class="col-md-6">
                <a href="{{ route('note.notepage') }}" class="btn btn-primary">Back</a>
            </div>
            <div class="col-md-6">
                {{-- <a href="{{ route('note.addnote', ['semestreId', 'etudiantId', 'matiereId', 'note' => $note]) }}" class="btn btn-primary">Add</a> --}}
                <form action="{{route('note.addnote')}}" method="post">
                    @csrf
                    <input type="hidden" name="promotionId" value="{{ $promotionId }}">
                    <input type="hidden" name="matiereId" value="{{ $matiereId }}">
                    <input type="hidden" name="note" value="{{ $note }}">
                    <input type="submit" class="btn btn-success" value="Save">
                </form>
            </div>

            <div class="col-md-6 text-right">
                <p><strong>Date:</strong> {{ \Carbon\Carbon::parse(now()->format('Y-m-d'))->locale('fr')->isoFormat('DD MMMM YYYY') }}</p>
            </div>
    </div>
</div>
@endsection
