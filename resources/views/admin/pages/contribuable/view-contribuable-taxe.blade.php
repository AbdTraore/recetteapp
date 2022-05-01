@extends('layouts.navigation')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1> Taxe du contribuable  </h1>
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
{{-- 
    {{ dump($contribuable_taxes) }}
    {{die()}}

    <!-- Main content --> --}}
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header mb-5 d-flex flex justify-content-between display-inline">
                <div>
                    <h3 class="card-title">Liste des taxes à payer pour le contribuable</h3>
                </div>              
                <div class="sm:display-block"></div>                
              </div>                
              <div class="col-lg-6">
                @if (session('TaxeDoestExist'))
                  <div class="alert alert-danger">
                      {{ session('TaxeDoestExist') }}
                  </div>
                @endif
                @if (session('AddTaxeSucces'))
                  <div class="alert alert-success">
                      {{ session('AddTaxeSucces') }} <a href="{{route('contribuable')}}">cliquer pour voir</a>
                  </div>
                @endif
              </div>

                     {{-- @foreach ($contribuable_taxes as $x)                         
                     @endforeach
                     @if (isset($x))
                         @if ($x->MoisTaxes >= $month)
                            <h3 class="container text-red">** Ce contribuable est à jours **</h3>                             
                         @else
                            <h3 class="container text-red">** Ce contribuable n'est pas à jours **</h3>
                         @endif
                     @else   
                     <h3 class="container text-red">** Aucune taxe enregistré pour ce contribuable **</h3>
                     @endif --}}
                     
              <!-- /.card-header -->
              <div class="card-body">
                <table id="dtBasicExample" class="table table-bordered table-sm">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Mois de la taxes</th>
                      <th>Exercice de la taxes</th>
                      <th>Type de taxe</th>
                      <th>Action</th>                     
                    </tr>
                  </thead>
                  <tbody>                    
                    @foreach ($taxes as $item)   
                        <tr style="font-size: 85%">
                          <th scope="row"> {{ $loop->index + 1 }} </th>   
                          <form method="POST" action="{{route('point-taxe', ['contribuable'=>$contribuableId, 'taxe'=>$item->id] )}}"> 
                            @csrf     
                            <td>
                              <select name="mois" id="mois" class="form form-control">
                                <option value="Janvier">Janvier</option>
                                <option value="Fevrier">Fevrier</option>
                                <option value="Mars">Mars</option>
                                <option value="Avril">Avril</option>
                                <option value="Mai">Mai</option>
                                <option value="Juin">Juin</option>
                                <option value="Juillet">Juillet</option>
                                <option value="Aout">Aout</option>
                                <option value="Septrembre">Septrembre</option>
                                <option value="Octobre">Octobre</option>
                                <option value="Novembre">Novembre</option>
                                <option value="Decembre">Decembre</option>
                              </select>
                            </td>
                          <td> <input type="text" name="exercice" minlength="4" maxlength="4" required  class="form-control" value="{{ date('Y') }}"> </td>
                          <td>{{$item->typeTaxes}}</td>
                          <td>
                            <button type="submit"  class="btn btn-primary btn-sm"><span class="fa fa-check"></span></button>
                          </td>
                        </form>
                          {{-- <td>
                            @if ($item->MoisTaxes == "01")                                 
                            {{ "Janvier" }}                                  
                            @elseif ($item->MoisTaxes == "02") 
                            {{"Février" }}  
                            @elseif ($item->MoisTaxes == "03") 
                            {{ "Mars" }} 
                            @elseif ($item->MoisTaxes == "04") 
                            {{ "Avril" }}  
                            @elseif ($item->MoisTaxes == "05") 
                            {{ "Mai" }}   
                            @elseif ($item->MoisTaxes == "06") 
                            {{ "Juin" }}  
                            @elseif ($item->MoisTaxes == "07") 
                            {{ "Juillet" }}  
                            @elseif ($item->MoisTaxes == "08") 
                            {{ "Août" }}  
                            @elseif ($item->MoisTaxes == "09") 
                            {{ "Septembre" }}  
                            @elseif ($item->MoisTaxes == "10") 
                            {{ "Octobre" }}  
                            @elseif ($item->MoisTaxes == "11") 
                            {{ "Novembre" }}  
                            @elseif ($item->MoisTaxes == "12") 
                            {{ "Décembre" }}  
                            @endif
                              {{$item->AnneeTaxes}}
                           </td> --}}
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


