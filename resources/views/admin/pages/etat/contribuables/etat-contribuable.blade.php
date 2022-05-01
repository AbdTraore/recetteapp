@extends('layouts.navigation')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1> Contribuables </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Contribuables</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <div>
      @if (session('succesDelete'))
          <div class="alert alert-danger">
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
                    <h3 class="card-title">Liste des contribuables</h3>
                </div>              
                <div class="sm:display-block"></div>                
              </div>                
              <div class="container-fluid m-2">
                <div class="col-sm-6">
                  @if (session('error1'))
                      <div class="alert alert-danger">
                           {{ session('error1') }}
                      </div>
                  @endif
                </div>
                <form method="POST" action="{{route('contribuable-filter-result')}}">
                  @csrf 
                  <div class="d-flex flex justify-content-between display-inline">
                    <div class="col-lg-5 col-md-5 col-12">
                      <b>Rechercher par nom</b>
                      <div class="form-group mb-3">
                        <select class="js-example-basic-single form-select form-control" required name="nom">
                          <option selected disabled>Cliquez pour choisir</option>
                          @foreach ($contribuable_items as $items)
                          <option value="{{$items->nom}}">{{$items->nom}}</option>                
                          @endforeach                
                        </select>
                      </div>
                        <div class="form-group mb-3">
                          <select class="js-example-basic-single form-select form-control" required name="prenom">
                            <option selected disabled>Cliquez pour choisir</option>
                            @foreach ($contribuable_items as $items)
                            <option value="{{$items->prenom}}">{{$items->prenom}}</option>                
                            @endforeach                
                          </select>
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-5 col-12">
                      <b>Rechercher par zone et/ou par activité</b>
                        <div class="form-group mb-3">
                              <div class="form-group mb-3 input-group-prepend">
                                <select class="js-example-basic-single form-select form-control" required name="zone">
                                  <option selected disabled>Cliquez pour choisir</option>
                                  @foreach ($zone_items as $items)
                                  <option value="{{$items->id}}">{{$items->nom}}</option>                
                                  @endforeach                
                                </select>
                              </div>
                              <div class="form-group mb-3">
                                <select class="js-example-basic-single form-select form-control" required name="activite">
                                  <option selected disabled>Cliquez pour choisir</option>
                                  @foreach ($activites_items as $items_)
                                  <option value="{{$items_->id}}">{{$items_->typeActivite}}</option>                
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
                     
              <!-- /.card-header -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>

@endsection


