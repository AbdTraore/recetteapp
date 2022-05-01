@extends('layouts.navigation')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1> Collecteurs </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Collecteurs</li>
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
                    <h3 class="card-title">Liste des collecteurs</h3>
                </div>            
              </div>                          
              <!-- /.card-header -->
              <div class="card-body">
                <table id="dtBasicExample" class="table table-bordered">
                  <thead>
                    <tr> 
                      <th style="width: 10px">#</th>
                      <th>Nom et Prénom</th>
                      <th>Numéro de téléphone</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>                    
                    @foreach ($collecteur_items as $item)                 
                        <tr style="font-size: 85%">
                          <th scope="row"> {{ $loop->index + 1 }} </th>
                          <td>{{$item->nomcollecteur ." ". $item->prenomcollecteur}}</td>
                          <td>{{$item->telephone }}</td>                           
                          <td>                      
                            <a href="{{route('edit.collecteur', ['collecteur'=>$item->id]) }}" class="btn btn-success btn-sm"><span class="fa fa-edit"></span></a>
                            {{-- <a href="#" class="btn btn-danger btn-sm" onclick="if(confirm('Voulez-vous vraiment supprimer ce collecteur ? Cette action est irreversible'))
                            { document.getElementById('form-{{$item->id}}').submit() }"><span class="fa fa-trash-alt"></span></a>
                            <form id="form-{{$item->id}}" action="{{route('delete.collecteur', ['collecteur'=>$item->id])}}"
                              method="POST">
                             @csrf
                             <input type="hidden" name="_method" value="delete">
                           </form> --}}
                          </td>
                        </tr>
                    @endforeach                    
                  </tbody>
                </table>
                <a href="{{route('allcollecteurexport')}}" type="button" class="btn btn-primary">Exporter tout les collecteurs en pdf</a>
              </div>             
            </div>
            <!-- /.card -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>

@endsection


