@extends('layouts.navigation')
@section('content')
<div class="container grid place-items-center">
    <br>
    <h4 class="border-bottom pb-2 mb-5 text-center"> Création d'une nouvelle activitée </h4>
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
                    {{ session('succes') }} 
                </div>
            @endif
            @if (session('ErrorActivite'))
                <div class="alert alert-danger">
                    {{ session('ErrorActivite') }} 
                </div>
            @endif
        </div>
        <form method="POST" action="{{route('save.activites')}}">
            @csrf
            <div class="form-group mb-3">
                <label for="InputActivite">Libellé de l'activité</label>
                <input type="text" class="form-control" required name="typeActivite" id="InputActivite">
            </div> 
            <button type="submit" class="btn btn-primary">Enregistrer</button>
            <a href="{{route('view-activites')}}" class="btn btn-danger">Annuler</a>
        </form>
    </div> 
</div> 
@endsection