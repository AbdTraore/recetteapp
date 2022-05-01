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
    <div class="card-body">
      <div style="text-align: center; font-size:24px; text-decoration: underline; padding-bottom:3rem">{{strtoupper('Liste des collecteurs')}}</div>

        <table class="table table-sm table-bordered" style="width: 100%">          
          <thead>
            <tr> 
              <th style="width: 10px">N°</th>
              <th>Nom</th>
              <th>Prénom</th>
              <th>Numéro de téléphone</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($collecteur as $item)                               
                <tr style="font-size: 85%">
                  <th scope="row"> {{ $loop->index + 1 }} </th>
                  <td>{{$item->nomcollecteur}}</td>
                  <td>{{$item->prenomcollecteur  }}</td> 
                  <td>{{$item->telephone  }}</td> 
                </tr>
            @endforeach
            
          </tbody>
        </table>
      </div>
</body>
</html>