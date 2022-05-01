<!DOCTYPE html>
<html>
<head>
    <title>Hi</title>
    <style>
      .table-bordered {
          border: 1px solid black;
        }

        .table-bordered th,
        .table-bordered td {
          border: 1px solid black;
        }

        .table-bordered thead ,
        .table-bordered thead td {
          border-bottom-width: 2px;
        }

      .table{
        display: table;
      }
      .collectivite
      {
          margin-bottom: 5rem;
      }
      .table-bordered
      {
        border: 1px solid black;
        text-align: center;
        width: 100%;
      }
      .text-sm
      {
        font-size: 15px; 
      }
      thead{
        border-bottom: 1px solid black;
      }
      tr{
        border-right: 1px solid black;
      }
     

    </style>    
</head>
<body>
    {{-- <div class="collectivite" style="display: inline-block">
      <div style="display: inline">
        <div>Commune de Toumodi</div>
        <div>Service Financier</div>
        <div>Régie de Recette</div>
      </div>
      <div style="text-align: right; display: inline">
        Exercice 2020
      </div>
    </div> --}}

    {{-- {{ dump($taxes) }}
    {{ die() }} --}}

    <p style="padding-bottom: 8rem">
      <span style="float: right  "> Exercice @if (isset($exercice__)) {{ $exercice__  }} @else {{date('Y') }} @endif  </span> 
      
      <span style="float: left">
        <div>Commune de Toumodi</div>
        <div>Services Financiers</div>
        <div>Régie de Recettes</div>
      </span>      
    </p>
    <div class="card-body">
        <div style="text-align: center; font-size:26px; text-decoration: underline; padding-bottom:3rem">{{strtoupper($titre)}}</div>
        <table class="table table-sm table-bordered">          
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
            @foreach ($taxes as $item)
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
                  <td> {{number_format($item->janvier + $item->fevrier + $item->mars + $item->avril
                    + $item->mai + $item->juin + $item->juillet + $item->aout + $item->septembre + 
                    $item->octobre + $item->novembre + $item->decembre) }} </td>                      
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
      </div>
      {{-- <div style="float: right; padding-top:2rem">Total : {{number_format($sum)}} FCFA</div> --}}
</body>
</html>