@extends('layouts.navigation')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1> Activités </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Activités</li>
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
                    <h3 class="card-title">Liste des activités</h3>
                </div>
              </div>     
                     
              <!-- /.card-header -->
              <div class="card-body">
                <table id="dtBasicExample" class="table table-bordered">
                  <thead>
                    <tr> 
                      <th style="width: 10px">#</th>
                      <th>Type d'activité</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($activites_items as $item)
                        <tr>
                          <th scope="row"> {{ $loop->index + 1 }} </th>
                          <td>{{$item->typeActivite}}</td>
                          <td>                      
                            <a href="{{route('edit.activite', ['activite'=>$item->id])}}" class="btn btn-success btn-sm"><span class="fa fa-edit"></span></a>
                             @csrf
                             <input type="hidden" name="_method" value="delete">
                           </form>
                          </td>
                        </tr>
                    @endforeach                    
                  </tbody>
                </table>
              </div>             
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>

@endsection


