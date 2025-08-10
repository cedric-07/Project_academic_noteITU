@extends('index')

@section('content1')
<h2 class="h3 mb-0">list of Categorie</h2>
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
<div class="pd-20 card-box mb-30">
    <div class="invoice">
        <hr>
        <table class="table">
            <thead class="table-dark">
                <tr>
                    <th scope="col">Categorie</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody class="table-light table-hover">
              @foreach ($categorie as $c)
              <tr>
                <td>{{ $c[0]->nom }}</td>
                <td>
                    <div class="dropdown">
                        <a
                            class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle"
                            href="#"
                            role="button"
                            data-toggle="dropdown"
                        >
                            <i class="dw dw-more"></i>
                        </a>
                        <div
                            class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list"
                        >
                        <a class="dropdown-item" href="{{ route('note.categorie', ['nomCategorie' => $c[0]->nom , 'etudiantsId' => $etudiant->idetudiant]) }}"><i class="dw dw-edit2"></i> View note {{ $c[0]->nom }}</a>
                        </div>
                    </div>
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
@endsection





