@extends('layouts.navigation')
@section('content')
<div class="container grid place-items-center">
    <br>
    <h4 class="border-bottom pb-2 mb-5 text-center"> Formulaire d'ajout d'une nouvelle taxe </h4>

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
                    {{ session('succes') }} <a href="{{route('view-taxes')}}">cliquer pour voir</a>
                </div>
            @endif 
            @if (session('AnneeError'))
                <div class="alert alert-danger">
                    {{ session('AnneeError') }}
                </div>
            @endif 
        </div>
        <form method="POST" action="{{route('save.taxes')}}">
            @csrf
            <div class="form-group mb-3">
                <select class="form-select form-select form-control" required name="typeTaxes">
                  <option selected disabled>Cliquez pour choisir le type de taxe</option>
                  {{-- @foreach ($classes as $classe) --}}
                  <option value="Baux à loyer">Baux à loyer</option>                
                  <option value="Taxes forfaitaires des pétits commerçant et artisans">Taxes forfaitaires des pétits commerçant et artisans</option>                
                  <option value="Taxes sur la publicité">Taxes sur la publicité</option>                
                  <option value="Occupation du domaine public">Occupation du domaine public</option>                
                  <option value="Taxe sur les taxis ville">Taxe sur les taxis ville</option>                
                  <option value="Taxe sur les taxis brousses">Taxe sur les taxis brousses</option>                
                  <option value="Taxe sur les tricycle">Taxe sur les tricycle</option>                
                  <option value="Taxe sur les charettes">Taxe sur les charettes</option>                
                  <option value="Taxe sur le stationnement">Taxe sur le stationnement</option>                
                  {{-- @endforeach                 --}}
                </select>
            </div>
            <div class="form-group mb-3">
                <label for="InputMontant">Montant</label>
                <input type="number" class="form-control" required name="montantTaxes" id="InputMontant">
            </div>
            <div class="form-group mb-3">
                <label for="InputDateTaxe">Taxe du mois de :</label>
                <input type="date" class="form-control" required name="DateTaxes" id="InputDateTaxe">
            </div>
            <div class="form-group mb-3">
                <select  class="js-example-basic-single form-select form-control" required name="contribuables_id">
                  <option selected disabled>Cliquez pour choisir le contribuables</option>
                  @foreach ($contribuables as $contribuable)
                    <option value="{{ $contribuable->id }}">{{$contribuable->nom ." ". $contribuable->prenom}}</option>                     
                 @endforeach             
                </select>
            </div>
             <div class="form-group mb-3">
                <select class="js-example-basic-single form-select form-select form-control" required name="collecteurs_id">
                  <option selected disabled>Cliquez pour choisir le collecteur ayant collecté la taxe</option>
                  @foreach ($collecteurs as $collecteur)
                    <option value="{{ $collecteur->id }}">{{$collecteur->nom ." ". $collecteur->prenom}}</option>                     
                 @endforeach             
                </select>
            </div> 
            <div class="form-group mb-3">
                <select class="js-example-basic-single form-select form-select form-control" required name="activites_id">
                  <option selected disabled>Cliquez pour choisir l'activité</option>
                  @foreach ($activites as $activite)
                    <option value="{{ $activite->id }}">{{$activite->typeActivite}}</option>                     
                 @endforeach             
                </select>
            </div>    
           
            <button type="submit" class="btn btn-primary">Enregistrer</button>
            <a href="{{route('view-taxes')}}" class="btn btn-danger">Annuler</a>
        </form>
    </div> 
</div> 
@endsection