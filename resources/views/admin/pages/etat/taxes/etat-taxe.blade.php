@extends('layouts.navigation')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1> Taxes </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Taxes</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <div>
      @if (session('succesDelete'))
          <div class="alert alert-success">
               {{ session('succesDelete') }}
          </div>
      @endif
    </div>
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header mb-5 d-flex flex justify-content-between display-inline">
                <div>
                    <h3 class="card-title">Liste des taxes</h3>
                </div>   
               
              </div>     
              {{-- Filtre de données --}}

              {{-- {{ dump($collecteur_items) }}
              {{die()}}
               --}}
              <div class="container-fluid m-2">
                <div class="col-sm-6">
                  @if (session('error1'))
                      <div class="alert alert-danger">
                           {{ session('error1') }}
                      </div>
                  @endif
                </div>
                <form method="POST" action="{{route('taxes-filter-result')}}">
                  @csrf 
                  <div class="d-flex flex justify-content-between display-inline">
                    <div class="col-lg-5 col-md-5 col-12">
                      <b>Rechercher par type de taxe / par contribuable</b>
                        <div class="form-group mb-3">
                            <select class="form-select form-control" required name="typeTaxes">
                            <option selected disabled>Cliquez pour choisir le type de taxe</option>
                                @foreach ($taxe_items as $items)
                                <option value="{{$items->id}}">{{$items->typeTaxes}}</option>                
                                @endforeach                
                            </select>
                        </div>
                        <div class="form-group mb-3">
                          <select class="js-example-basic-single form-select form-control" required name="nom">
                            <option selected disabled>Cliquez pour choisir le nom</option>
                            @foreach ($contribuable_items as $items)
                            <option value="{{$items->id}}">{{$items->nom." ".$items->prenom}}</option>                
                            @endforeach                
                          </select>
                        </div>
                        <div class="form-group mb-3">
                          <input type="text" name="annee" class="form-control" placeholder="Année de la taxe">
                        </div>          
                        
                    </div>
                    <div class="col-lg-5 col-md-5 col-12">
                      <b>Rechercher par collecteur / activité / zone</b>
                        <div class="form-group mb-3">                              
                              <div class="form-group mb-3">
                                <select class="js-example-basic-single form-select form-control" required name="activite">
                                  <option selected disabled>Cliquez pour choisir l'activite</option>
                                  @foreach ($activites_items as $items_)
                                  <option value="{{$items_->id}}">{{$items_->typeActivite}}</option>                
                                  @endforeach                
                                </select>
                              </div>
                              <div class="form-group mb-3">
                                <select class="js-example-basic-single form-select form-control" required name="collecteur">
                                  <option selected disabled>Cliquez pour choisir le collecteur</option>
                                  @foreach ($collecteurs_items as $items_collecteur)
                                  <option value="{{$items_collecteur->id}}">{{$items_collecteur->nomcollecteur." ".$items_collecteur->prenomcollecteur}}</option>                
                                  @endforeach                
                                </select>
                              </div>
                              <div class="form-group mb-3">
                                <select class="js-example-basic-single form-select form-control" required name="zone">
                                  <option selected disabled>Cliquez pour choisir le zone</option>
                                  @foreach ($zones as $items_zone)
                                  <option value="{{$items_zone->id}}">{{$items_zone->nom}}</option>                
                                  @endforeach                
                                </select>
                              </div>
                      </div>    
                    </div>
                  </div>                                   
                  
                  <input type="submit" value="Export to pdf" name="pdf" class="btn btn-success">
                  <button type="submit" class="btn btn-primary">Search</button>
                  <a href="" type="reset" class="btn btn-danger">Restaurer le filtre</a>
              </form>
              </div>
              {{-- <div class="container">
                <b>Exercice :</b> <input type="text" value="{{date('Y')}}" class="form-control col-sm-3">
              </div> --}}

              {{-- Fin du filtre --}}
               
              <!-- /.card-header -->
                         
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>

@endsection


