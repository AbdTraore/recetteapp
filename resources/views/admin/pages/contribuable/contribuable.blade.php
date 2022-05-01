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
              <!-- /.card-header -->
              <div class="card-body">
                <table id="dtBasicExample" class="table table-bordered table-sm">
                  <thead>
                    <tr> 
                      <th style="width: 10px">#</th>
                      <th>Code Contribuable</th>
                      <th>Nom et Prénom</th>
                      <th>Numéro de téléphone</th>
                      <th>Zone</th>
                      <th>activite</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>                    
                    @foreach ($contribuable_items as $item)     
                        <tr style="font-size: 85%">
                          <th scope="row"> {{ $loop->index + 1 }} </th>
                          <td>{{$item->codecontribuable}}</td>
                          <td>{{$item->nom ." ". $item->prenom}}</td>
                          <td>{{$item->telephone  }}</td> 
                          <td>{{$item->zones->nom}}</td>
                          <td>{{$item->activites->typeActivite}}</td>
                          <td>                      
                            <a href="{{route('taxe-list', ['contribuable'=>$item->id])}}" class="btn btn-primary btn-sm"><span class="fa fa-eye"></span></a>
                            <a href="{{route('edit.contribuable', ['contribuable'=>$item->id]) }}" class="btn btn-success btn-sm"><span class="fa fa-edit"></span></a>
                            {{--   --}}
                          </td>
                        </tr>
                    @endforeach                    
                  </tbody>
                </table>
                <a href="{{route('allcontribuableexport')}}" type="button" class="btn btn-primary">Exporter tous les contribuable en pdf</a>

              </div>              
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>

@endsection


