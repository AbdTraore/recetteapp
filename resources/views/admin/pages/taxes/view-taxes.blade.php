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
                {{-- <form method="POST" action="{{route('taxes-filter-result')}}">
                  @csrf 
                  <div class="d-flex flex justify-content-between display-inline">
                    <div class="col-lg-5 col-md-5 col-12">
                      <b>Rechercher par type de taxe / par contribuable</b>
                        <div class="form-group mb-3">
                          <select class="form-select form-select form-control" required name="typeTaxes">
                            <option selected disabled>Cliquez pour choisir le type de taxe</option>
                            <option value="Baux à loyer">Baux à loyer</option>                
                            <option value="Taxes forfaitaires des pétits commerçant et artisans">Taxes forfaitaires des pétits commerçant et artisans</option>                
                            <option value="Taxes sur la publicité">Taxes sur la publicité</option>                
                            <option value="Occupation du domaine public">Occupation du domaine public</option>                
                            <option value="Taxe sur les taxis ville">Taxe sur les taxis ville</option>                
                            <option value="Taxe sur les taxis brousses">Taxe sur les taxis brousses</option>                
                            <option value="Taxe sur les tricycle">Taxe sur les tricycle</option>                
                            <option value="Taxe sur les charettes">Taxe sur les charettes</option>                
                            <option value="Taxe sur le stationnement">Taxe sur le stationnement</option>                
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
                      <b>Rechercher par mois/ collecteur / activité</b>
                        <div class="form-group mb-3">
                              <div class="form-group mb-3 input-group-prepend">
                                <select class="form-select form-control" required name="mois">
                                  <option selected disabled>Cliquez pour choisir le mois</option>
                                    <option value="01">Janvier</option>
                                    <option value="02">Février</option>
                                    <option value="03">Mars</option>
                                    <option value="04">Avril</option>
                                    <option value="05">Mai</option>
                                    <option value="06">Juin</option>
                                    <option value="07">Juillet</option>
                                    <option value="08">Août</option>
                                    <option value="09">Septembre</option>
                                    <option value="10">Octobre</option>
                                    <option value="11">Novembre</option>
                                    <option value="12">Décembre</option>
                                </select>
                              </div>
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
                                  @foreach ($collecteur_items as $items_collecteur)
                                  <option value="{{$items_collecteur->id}}">{{$items_collecteur->nom." ".$items_collecteur->prenom}}</option>                
                                  @endforeach                
                                </select>
                              </div>
                      </div>    
                    </div>
                  </div>                                   
                  
                  <input type="submit" value="Export to pdf" name="pdf" class="btn btn-success">
                  <button type="submit" class="btn btn-primary">Search</button>
                  <a href="" type="reset" class="btn btn-danger">Restaurer le filtre</a>
              </form> --}}
              </div>
            
              {{-- Fin du filtre --}}
               
              <!-- /.card-header -->
              <div class="card-body">
                <table id="dtBasicExample"  class="table table-responsive table-bordered table-sm">
                  <thead>
                    <tr class="text-sm"> 
                      <th style="width: 10px">#</th>
                      <th>Contribuable</th>
                      <th>Activité</th>
                      <th>Zone</th>
                      <th>Type de taxe</th>
                      <th>Taxe mensuelle</th>
                      <th>Taxe annuelle</th>
                      <th>Jan</th>
                      <th>Fev</th>
                      <th>Mar</th>
                      <th>Avr</th>
                      <th>Mai</th>
                      <th>Juin</th>
                      <th>Juil</th>
                      <th>Aou</th>
                      <th>Sept</th>
                      <th>Oct</th>
                      <th>Nov</th>
                      <th>Dec</th>                      
                      <th>Total</th>                      
                    </tr>
                  </thead>
                  <tbody>  
                    @foreach ($taxes_items as $item)
                        <tr style="font-size:80%">
                          <th scope="row"> {{ $loop->index + 1 }} </th>
                          <td>{{$item->nom." ".$item->prenom}}</td>
                          <td>{{$item->activites->typeActivite}}</td>
                          <td>{{$item->zones->nom}}</td>
                          <td>{{$item->taxes->typeTaxes}}</td>
                          <td>{{ number_format($item->taxemensuelle) }} F</td>
                          <td>{{ number_format($item->taxeannuelle) }} F</td>
                          <td>{{$item->janvier}} </td>
                          <td>{{$item->fevrier}}</td>
                          <td>{{$item->mars}} </td>
                          <td>{{$item->avril}} </td>
                          <td>{{$item->mai}} </td>
                          <td>{{$item->juin}} </td>
                          <td>{{$item->juillet}}</td>
                          <td>{{$item->aout}} </td>
                          <td>{{$item->septembre}} </td>
                          <td>{{$item->octobre}} </td>
                          <td>{{$item->novembre}} </td>
                          <td>{{$item->decembre}} </td> 
                          <td> {{ number_format($item->janvier + $item->fevrier + $item->mars + $item->avril
                            + $item->mai + $item->juin + $item->juillet + $item->aout + $item->septembre + 
                            $item->octobre + $item->novembre + $item->decembre) }} F</td>                      
                          {{-- <td  style="width:12%">  
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
                          </td> --}}
                          {{-- <td  style="width:12%">{{ \Carbon\Carbon::parse(strtotime($item->DateTaxes))->translatedFormat('F')}} </td> --}}
                          {{-- <td>{{$item->contribuables->nom." ".$item->contribuables->prenom}}</td>
                          <td>{{$item->collecteurs->nom." ".$item->collecteurs->prenom}}</td>
                          <td>{{$item->activites->typeActivite}}</td> --}}
                          {{-- <td>                      
                            <a href="" class="btn btn-primary btn-sm"><span class="fa fa-eye"></span></a>
                            <a href="{{route('edit.taxes', ['taxes'=>$item->id])}}" class="btn btn-success btn-sm"><span class="fa fa-edit"></span></a>
                            <a href="#" class="btn btn-danger btn-sm" onclick="if(confirm('Voulez-vous vraiment supprimer cette activitée ? Cette action est irreversible'))
                             document.getElementById('form-{{$item->id}}').submit() }"><span class="fa fa-trash-alt"></span></a> 
                           <form id="form-{{$item->id}}" action="{{route('delete.activite', ['activite'=>$item->id])}}" 
                              method="POST">
                             @csrf
                             <input type="hidden" name="_method" value="delete">
                           </form>
                          </td> --}}

                        </tr>
                    @endforeach                    
                  </tbody>
                  <tfoot>
                    <tr>                      
                      <td align="center" colspan="5"> </b></td>
                      <td align="center" colspan="2"> <b> Total attendu</b></td>
                      <td align="center" colspan="13"> <b> Montants récouvrés</b></td>
                    </tr>
                    <tr style="font-size: 75%">
                      <td align="center" colspan="5"> </b></td>                      
                      <td> <span> <b> {{number_format($total_taxe_mensuelle) }} F</b></span></td>
                      <td> <span> <b>{{number_format($total_taxe_annuelle)}} F</b> </span></td>
                      <td> <span> <b>{{number_format($jan)}} F</b> </span></td>
                      <td> <span> <b>{{number_format($fev)}} F</b> </span></td>
                      <td> <span> <b>{{number_format($mar)}} F</b> </span></td>
                      <td> <span> <b>{{number_format($avr)}} F</b> </span></td>
                      <td> <span> <b>{{number_format($mai)}} F</b> </span></td>
                      <td> <span> <b>{{number_format($juin)}} F</b> </span></td>
                      <td> <span> <b>{{number_format($juil)}} F</b> </span></td>
                      <td> <span> <b>{{number_format($aou)}} F</b> </span></td>
                      <td> <span> <b>{{number_format($sep)}} F</b> </span></td>
                      <td> <span> <b>{{number_format($oct)}} F</b> </span></td>
                      <td> <span> <b>{{number_format($nov)}} F</b> </span></td>
                      <td> <span> <b>{{number_format($dec)}} F</b> </span></td>
                    </tr>                    
                  </tfoot>
                </table>
                <a href="{{route('alltaxeexport')}}" type="button" class="btn btn-primary">Exporter toutes les taxes en pdf <span class="fa fa-download"></span> </a>

              </div>             
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>

@endsection


