@extends('index')

@section('content1')
<h2 class="h3 mb-0">List of Students</h2>
<div class="pd-20 card-box mb-30">
    <div class="header-search mt-5">
        <form action="{{ route('etudiant.filter') }}" method="GET">
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="searchTerm">Name of the student</label>
                        <input type="text" class="form-control" id="nom" name="nom" placeholder="Enter student name">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="searchTerm">Promotion name</label>
                        <select name="promotion" id="" class="form-control">
                            <option value="" hidden>select promotion</option>
                            @foreach ($promotions as $promotion)
                                <option value="{{ $promotion->idpromotion }}">{{ $promotion->nom }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
            </div>
        </form>
    </div>
    <div class="invoice">
        <hr>
        <table class="table">
            <thead class="table-dark">
                <tr>
                    <th scope="col">index</th>
                    <th scope="col">Name</th>
                    <th scope="col">FirstName</th>
                    <th scope="col">ETU</th>
                    <th scope="col">Birth</th>
                    <th scope="col">Promotion</th>
                    <th scope="col">Note Per Semester</th>
                    <th scope="col">Note Per Categorie</th>

                </tr>
            </thead>
            <tbody class="table-light table-hover">
                @foreach ($etudiant as $etudiant)

                <tr>
                    <td>{{ $row = $loop->iteration }}</td>
                    <td>{{ $etudiant->nom }}</td>
                    <td>{{ $etudiant->prenom }}</td>
                    <td>{{ $etudiant->numetu }}</td>
                    <td>{{ \Carbon\Carbon::parse($etudiant->dtn)->locale('fr')->isoFormat('DD MMMM YYYY') }}</td>
                    <td>{{ $etudiant->promotion->nom }}</td>
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
                            <a class="dropdown-item"  href="{{ route('semestre.getsemestre' , ['etudiantsId' => $etudiant->idetudiant])}}"><i class="dw dw-edit2"></i> View note per Semestre</a>
                            </div>
                        </div>
                    </td>
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
                            <a class="dropdown-item"  href="{{ route('categorie.getcategoriewithsemestre' , ['categorieId' => $categories->idcategorie , 'etudiantsId' => $etudiant->idetudiant])}}"><i class="dw dw-edit2"></i> View note per Categorie</a>
                            </div>
                        </div>
                    </td>
                    @endforeach
                </tr>
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
