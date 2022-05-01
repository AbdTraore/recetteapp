@extends('layouts.navigation')
@section('content')
<div class="container grid place-items-center">
    <br>
    <h4 class="border-bottom pb-2 mb-5 text-center">Modification d'une taxe </h4>

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
            @if (session('succesUpdate'))
                <div class="alert alert-success">
                    {{ session('succesUpdate') }}
                </div>
            @endif
        </div>
        <form method="POST" action="{{route('update.taxes',  ['taxes'=>$taxes->id])}}">
            @csrf
            <input type="hidden" name="_method" value="put">
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
                <input type="number" class="form-control" value="{{$taxes->montantTaxes }}" required name="montantTaxes" id="InputMontant">
            </div>
            <div class="form-group mb-3">
                <select class="form-select form-select form-control" required name="contribuables_id">
                  <option selected disabled>Cliquez pour choisir le contribuables</option>                 
                  @foreach ($contribuables as $contribuable)
                  @if ($contribuable->id == $taxes->contribuables_id)
                    <option value="{{ $contribuable->id }}" selected>{{$contribuable->nom ." ". $contribuable->prenom}}</option>
                  @else
                    <option value="{{ $contribuable->id }}">{{$contribuable->nom ." ". $contribuable->prenom}}</option>                     
                  @endif
                 @endforeach             
                </select>
            </div>
             <div class="form-group mb-3">
                <select class="form-select form-select form-control" required name="collecteurs_id">
                  <option selected disabled>Cliquez pour choisir le collecteur ayant collecté la taxe</option>
                  @foreach ($collecteurs as $collecteur)
                    @if ($collecteur->id == $taxes->collecteurs_id)
                    <option value="{{ $collecteur->id }}" selected>{{$collecteur->nom ." ". $collecteur->prenom}}</option>
                    @else
                    <option value="{{ $collecteur->id }}">{{$collecteur->nom ." ". $collecteur->prenom}}</option>                     
                    @endif                     
                  @endforeach             
                </select>
            </div> 
            <div class="form-group mb-3">
                <select class="form-select form-select form-control" required name="activites_id">
                  <option selected disabled>Cliquez pour choisir l'activité</option>
                  @foreach ($activites as $activite)
                    @if ($activite->id == $taxes->activites_id)
                    <option value="{{ $activite->id }}" selected>{{$activite->typeActivite}}</option>
                    @else
                    <option value="{{ $activite->id }}">{{$activite->typeActivite}}</option>                     
                    @endif                      
                  @endforeach             
                </select>
            </div>    
           
            <button type="submit" class="btn btn-primary">Enregistrer</button>
            <a href="{{route('contribuable')}}" class="btn btn-danger">Annuler</a>
        </form>
    </div> 
</div> 
@endsection