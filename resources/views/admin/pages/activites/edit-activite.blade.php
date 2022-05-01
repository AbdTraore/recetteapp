@extends('layouts.navigation')
@section('content')
<div class="container grid place-items-center">
    <br>
    <h4 class="border-bottom pb-2 mb-5 text-center"> Modification d'une activitée </h4>

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
        <form method="POST" action="{{route('update.activite', ['activite'=>$activite->id])}}">
            @csrf
            <input type="hidden" name="_method" value="put">

            <div class="form-group mb-3">
                <label for="InputtypeActivite">Libelle de l'activité</label>
                <input type="text" class="form-control" autofocus required name="typeActivite" value="{{ $activite->typeActivite }}" id="InputtypeActivite">
            </div>            
            
            <button type="submit" class="btn btn-primary">Enregistrer</button>
            <a href="{{route('view-activites')}}" class="btn btn-danger">Annuler</a>
        </form>
    </div> 
</div> 
@endsection