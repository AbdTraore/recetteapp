@extends('layouts.navigation')
@section('content')
<div class="container grid place-items-center">
    <br>
    <h4 class="border-bottom pb-2 mb-5 text-center"> Ajout une nouvelle taxe au contribuable </h4>

    <div class="my-3 p-3 bg-body rounded shadow-sm" style="width:65%; margin-left:20%;">
        <div>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
        <div>
            @if (session('succes'))
                <div class="alert alert-success">
                    {{ session('succes') }} <a href="{{route('contribuable')}}">cliquer pour voir</a>
                </div>
            @endif
            @if (session('taxeExist'))
                <div class="alert alert-danger">
                    {{ session('taxeExist') }}
                </div>
            @endif
            @if (session('codeError'))
            <div class="alert alert-success">
                {{ session('codeError') }}
            </div>
             @endif
             @if (session('ErrorCollecteur'))
                <div class="alert alert-danger">
                    {{ session('ErrorCollecteur') }} <a href="{{route('view-collecteur')}}">cliquer pour voir</a>
                </div>
            @endif
            @if (session('ErrorPhoneNumber'))
                <div class="alert alert-danger">
                    {{ session('ErrorPhoneNumber') }}
                </div>
            @endif
        </div>
        <form method="POST" action="{{route('save.taxe.contribuable')}}">
            @csrf            
            <div class="form-group mb-3">
                <select class="js-example-basic-single form-select form-control" required name="contribuables_id">
                  <option selected disabled>Cliquez pour choisir le contribuable</option>
                  @foreach ($contribuables as $contribuable)
                  <option value="{{$contribuable->id}}">{{$contribuable->codecontribuable." - ".$contribuable->nom."  ".$contribuable->prenom}}</option>                
                  @endforeach                
                </select>
            </div>
            <div class="form-group mb-3">
                <select class="form-select form-control" required name="taxes_id">
                  <option selected disabled>Cliquez pour choisir le type de taxe</option>
                  @foreach ($taxes as $taxe)
                  <option value="{{$taxe->id}}">{{$taxe->typeTaxes}}</option>                
                  @endforeach                
                </select>
            </div>
            <div class="form-group mb-3">
                <input type="text" class="form-control" placeholder="Montant de la taxe" required name="montantTaxes" id="InputMontant">
            </div>
            <button type="submit" class="btn btn-primary">Enregistrer</button>
            <a href="{{route('contribuable')}}" class="btn btn-danger">Annuler</a>
        </form>
    </div> 
</div> 
@endsection