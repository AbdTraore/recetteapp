@extends('layouts.navigation')
@section('content')
<div class="container grid place-items-center">
    <br>
    <h4 class="border-bottom pb-2 mb-5 text-center"> Modification d'une zone </h4>

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
        <form method="POST" action="{{route('update.zone', ['zone'=>$zone->id])}}">
            @csrf
            <input type="hidden" name="_method" value="put">
            <div class="form-group mb-3">
                <label for="InputNom">Nom</label>
                <input type="text" class="form-control" autofocus required name="nom" value="{{ $zone->nom }}" id="InputNom">
            </div>            
            <div class="form-group mb-3">
                <select class="form-select form-select form-control" required name="collecteurs_id">
                  <option selected disabled>Cliquez pour choisir le collecteur</option>
                  @foreach ($collecteurs as $collecteur)
                    @if ($collecteur->id == $zone->collecteurs_id)
                    <option value="{{ $collecteur->id }}" selected>{{$collecteur->nom." ".$collecteur->prenom}}</option>
                    @else
                    <option value="{{ $collecteur->id }}">{{$collecteur->nom." ".$collecteur->prenom}}</option>                     
                    @endif                      
                  @endforeach             
                </select>
            </div>             
            <button type="submit" class="btn btn-primary">Enregistrer</button>
            <a href="{{route('view-zone')}}" class="btn btn-danger">Annuler</a>
        </form>
    </div> 
</div> 
@endsection