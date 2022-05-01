@extends('layouts.navigation')
@section('content')
<div class="container grid place-items-center">
    <br>
    <h4 class="border-bottom pb-2 mb-5 text-center"> Ajouter une nouvelle zone </h4>

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
                    {{ session('succes') }} <a href="{{route('view-zone')}}">cliquer pour voir</a>
                </div>
            @endif
            @if (session('Errorzone'))
                <div class="alert alert-danger">
                    {{ session('Errorzone') }} <a href="{{route('view-zone')}}">cliquer pour voir</a>
                </div>
            @endif 
            @if (session('Errorzone1'))
                <div class="alert alert-danger">
                    {{ session('Errorzone1') }} <a href="{{route('view-zone')}}">cliquer pour voir</a>
                </div>
            @endif           
        </div>
        <form method="POST" action="{{route('save.zone')}}">
            @csrf
            <div class="form-group mb-3">
                <label for="InputNom">Nom</label>
                <input type="text" class="form-control" required name="nom" id="InputNom">
            </div>            
            <div class="form-group mb-3">
                <select class="js-example-basic-single form-select form-select form-control" required name="collecteurs_id">
                  <option selected disabled>Cliquez pour choisir le collecteur</option>
                  @foreach ($collecteurs as $collecteur)
                    <option value="{{ $collecteur->id }}">{{$collecteur->nomcollecteur." ".$collecteur->prenomcollecteur}}</option>                     
                 @endforeach             
                </select>
            </div>            
            <button type="submit" class="btn btn-primary">Enregistrer</button>
            <a href="{{route('view-zone')}}" class="btn btn-danger">Annuler</a>
        </form>
    </div> 
</div> 
@endsection