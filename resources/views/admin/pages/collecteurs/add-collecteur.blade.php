@extends('layouts.navigation')
@section('content')
<div class="container grid place-items-center">
    <br>
    <h4 class="border-bottom pb-2 mb-5 text-center"> Ajout d'un nouveau collecteur </h4>

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
                    {{ session('succes') }} <a href="{{route('view-collecteur')}}">cliquer pour voir</a>
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
        <form method="POST" action="{{route('save.collecteur')}}">
            @csrf
            <div class="form-group mb-3">
                <label for="InputNom">Nom</label>
                <input type="text" class="form-control" required name="nomcollecteur" id="InputNom">
            </div>            
            <div class="form-group mb-3">
                <label for="InputPrenom">Prénom</label>
                <input type="text" class="form-control" required name="prenomcollecteur" id="InputPrenom">
            </div>
            <div class="form-group mb-3">
                <label for="InputTelephone">Téléphone</label>
                <input type="text" class="form-control" minlength="10"  maxlength="10" required name="telephone" id="InputTelephone">
            </div>            
            <button type="submit" class="btn btn-primary">Enregistrer</button>
            <a href="{{route('view-collecteur')}}" class="btn btn-danger">Annuler</a>
        </form>
    </div> 
</div> 
@endsection