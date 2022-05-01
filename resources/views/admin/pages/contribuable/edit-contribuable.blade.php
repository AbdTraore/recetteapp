@extends('layouts.navigation')
@section('content')
<div class="container grid place-items-center">
    <br>
    <h4 class="border-bottom pb-2 mb-5 text-center"> Modification d'un contribuable </h4>

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
            @if (session('ErrorPhoneNumber'))
                <div class="alert alert-danger">
                    {{ session('ErrorPhoneNumber') }}
                </div>
            @endif
          </div>
        <form method="POST" action="{{route('update.contribuable', ['contribuable'=>$contribuable->id])}}">
            @csrf
            <input type="hidden" name="_method" value="put">

            <div class="row mb-4">
                <div class="col">
                    <input type="text" class="form-control" value="{{ $contribuable->nom }}" required name="nom" placeholder="Nom" id="InputNom">
                </div>
                <div class="col">
                    <input type="text" class="form-control" value="{{ $contribuable->prenom }}" required name="prenom" placeholder="Prénom" id="InputPrenom">
                </div>
            </div>           
            <div class="row mb-4">                
                
                <div class="col">
                    <select required  class="form-select form-control" name="zones_id">
                      <option selected disabled>Cliquez pour choisir la zone</option>
                      @foreach ($zones as $zone)
                      @if ($zone->id == $contribuable->zones->id)
                      <option value="{{$zone->id}}" selected>{{$zone->nom}}</option>
                      @else
                      <option value="{{$zone->id}}">{{$zone->nom}}</option> 
                      @endif               
                      @endforeach                
                    </select>
                </div>
            </div>
            <div class="mb-3">
                <input type="text" class="form-control" value="{{ $contribuable->telephone }}" placeholder="Numéro de téléphone" minlength="10"  maxlength="10"  required name="telephone" id="InputTelephone">
            </div>  
            <button type="submit" class="btn btn-primary">Enregistrer</button>
            <a href="{{route('contribuable')}}" class="btn btn-danger">Annuler</a>
        </form>
    </div> 
</div> 
@endsection