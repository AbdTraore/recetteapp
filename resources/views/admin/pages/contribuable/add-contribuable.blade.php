@extends('layouts.navigation')
@section('content')
<div class="container grid place-items-center">
    <br>
    <h4 class="border-bottom pb-2 mb-5 text-center"> Création d'un nouveau contribuable </h4>

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
        <form method="POST" action="{{route('save.contribuable')}}">
            @csrf
            <div class="row mb-4">
                <div class="col">
                    <input type="text" class="form-control" required name="nom" placeholder="Nom" id="InputNom">
                </div>
                <div class="col">
                    <input type="text" class="form-control" required name="prenom" placeholder="Prénom" id="InputPrenom">
                </div>
            </div>
            <div class="row mb-4">
                <div class="col">
                    <select class="form-select form-control" required name="taxes_id">
                      <option selected disabled>Cliquez pour choisir le type de taxe</option>
                      @foreach ($taxes as $taxe)
                      <option value="{{$taxe->id}}">{{$taxe->typeTaxes}}</option>                
                      @endforeach                
                    </select>
                </div> 
                <div class="col">
                    <input type="number" class="form-control" placeholder="Montant de la taxe" required name="montantTaxes" id="InputMontant">
                </div>
            </div>
            <div class="row mb-4">
                <div class="col">
                    <select required  class="form-select form-control" name="activites_id">
                      <option selected disabled>Cliquez pour choisir l'activité</option>
                      @foreach ($activites as $activite)
                      <option value="{{$activite->id}}">{{$activite->typeActivite}}</option>                
                      @endforeach                
                    </select>
                </div>
                <div class="col">
                    <select class="form-select form-control" required name="zones_id">
                      <option selected disabled>Cliquez pour choisir la zone</option>
                      @foreach ($zones as $zone)
                      <option value="{{$zone->id}}">{{$zone->nom}}</option>                
                      @endforeach                
                    </select>
                </div>
            </div>
            <div class="mb-3">
                <input type="text" class="form-control" placeholder="Numéro de téléphone" minlength="10"  maxlength="10"  required name="telephone" id="InputTelephone">
            </div>  
            
            <button type="submit" class="btn btn-primary">Enregistrer</button>
            <a href="{{route('contribuable')}}" class="btn btn-danger">Annuler</a>
        </form>
    </div> 
</div> 
@endsection