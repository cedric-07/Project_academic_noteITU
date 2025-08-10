@extends('index')

@section('content1')
<div class="pd-20 card-box mb-30">
    <h2 class="h3 mb-0" >Create Note ITU</h2>
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
    <div class="bg-white p-4 text-dark">
        <form action="{{ route('note.confirmation')}}" method="GET">
            @csrf
            <div class="form-group row">
                <label class="col-sm-12 col-md-2 col-form-label">Promotion</label>
                <div class="col-sm-12 col-md-10">
                    <select name="promotionId" id="promotion" class="form-control">
                        @foreach ($promotions as $promotion)
                            <option value="{{ $promotion->idpromotion }}">{{ $promotion->nom }}</option>
                        @endforeach
                    </select>
                </div>
                @error('promotion')
                    <div class="alert alert-danger mt-1">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-group row">
                <label class="col-sm-12 col-md-2 col-form-label">Matiere References</label>
                <div class="col-sm-12 col-md-10">
                    <select name="matiereId" id="matiere" class="form-control">
                            @foreach ($matieres as $matiere)
                            <option value="{{ $matiere->idmatiere }}">{{ $matiere->reference }}</option>
                        @endforeach
                    </select>
                </div>
                @error('matiere')
                    <div class="alert alert-danger mt-1">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-group row">
                <label class="col-sm-12 col-md-2 col-form-label">Note</label>
                <div class="col-sm-12 col-md-10">
                    <input type="number" class="form-control" id="note" name="note" placeholder="Enter note" min="0" max="20" required>
                </div>
                @error('note')
                    <div class="alert alert-danger mt-1">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary mt-3">Submit</button>
        </form>
    </div>
</div>
@endsection
