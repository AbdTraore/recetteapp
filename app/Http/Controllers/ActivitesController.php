<?php

namespace App\Http\Controllers;

use App\Models\activite;
use App\Models\contribuable;
use App\Models\taxerecouvre;
use App\Models\taxes;
use App\Models\User;
use Illuminate\Http\Request;

class ActivitesController extends Controller
{
    public function dashboard()
    {
        
        if ( date('d/m') == '01/01' ) 
        {
            $anneprecedente = date('Y') - 1;
            
            $a = taxerecouvre::where([
                ["exercice", "=", $anneprecedente]
            ])->get();

            $year = date('Y');
            $day = date('d-m-Y H:i:s');
            foreach ($a as $key => $value) 
            {
                taxerecouvre::create([
                        "taxemensuelle" =>  $value->taxemensuelle,
                        "taxeannuelle" => $value->taxeannuelle,
                        "janvier" => null,
                        "fevrier" => null,
                        "mars" => null,
                        "avril" => null,
                        "mai" => null,
                        "juin" => null,
                        "juillet" => null,
                        "aout" => null,
                        "septembre" => null,
                        "octobre" => null,
                        "novembre" => null,
                        "decembre" => null,
                        "exercice" => $year,
                        "contribuables_id" => $value->contribuables_id,
                        "taxes_id" =>  $value->taxes_id,
                        "created_at" => $day,
                        "updated_at" => null,
                ]);
            }
        }
        

        $count_contribuable = contribuable::count();
        $count_taxes = taxerecouvre::count();
        $month =   \Carbon\Carbon::parse(strtotime(date('M')))->translatedFormat('F');
        $month =   date('m');
        $year = date('Y');
        $user = User::all();

        
        if ($month == "01") 
        {
            $month = "janvier";
            $taxes_month = taxerecouvre::where([ ["exercice", "=", $year] ])->sum($month);
            $taxes_month_2 = taxerecouvre::where([ ["exercice", "=", $year] ])->count($month);
            
        }
        elseif ($month == "02") 
        {            
            $month = "fevrier";
            $taxes_month = taxerecouvre::where([ ["exercice", "=", $year] ])->sum($month);
            $taxes_month_2 = taxerecouvre::where([ ["exercice", "=", $year] ])->count($month);
            
        }
        elseif ($month == "03") 
        {            
            $month = "mars";
            $taxes_month = taxerecouvre::where([ ["exercice", "=", $year] ])->sum($month);
            $taxes_month_2 = taxerecouvre::where([ ["exercice", "=", $year] ])->count($month);
            
        }
        elseif ($month == "04") 
        {            
            $month = "avril";
            $taxes_month = taxerecouvre::where([ ["exercice", "=", $year] ])->sum($month);
            $taxes_month_2 = taxerecouvre::where([ ["exercice", "=", $year] ])->count($month);
            
        }
        elseif ($month == "05") 
        {            
            $month = "mai";
            $taxes_month = taxerecouvre::where([ ["exercice", "=", $year] ])->sum($month);
            $taxes_month_2 = taxerecouvre::where([ ["exercice", "=", $year] ])->count($month);
            
        }
        elseif ($month == "06") 
        {            
            $month = "juin";
            $taxes_month = taxerecouvre::where([ ["exercice", "=", $year] ])->sum($month);
            $taxes_month_2 = taxerecouvre::where([ ["exercice", "=", $year] ])->count($month);
            
        }
        elseif ($month == "07") 
        {            
            $month = "juillet";
            $taxes_month = taxerecouvre::where([ ["exercice", "=", $year] ])->sum($month);
            $taxes_month_2 = taxerecouvre::where([ ["exercice", "=", $year] ])->count($month);
            
        }
        elseif ($month == "08") 
        {            
            $month = "aout";
            $taxes_month = taxerecouvre::where([ ["exercice", "=", $year] ])->sum($month);
            $taxes_month_2 = taxerecouvre::where([ ["exercice", "=", $year] ])->count($month);
            
        }
        elseif ($month == "09") 
        {            
            $month = "septembre";
            $taxes_month = taxerecouvre::where([ ["exercice", "=", $year] ])->sum($month);
            $taxes_month_2 = taxerecouvre::where([ ["exercice", "=", $year] ])->count($month);
            
        }
        elseif ($month == "10") 
        {            
            $month = "octobre";
            $taxes_month = taxerecouvre::where([ ["exercice", "=", $year] ])->sum($month);
            $taxes_month_2 = taxerecouvre::where([ ["exercice", "=", $year] ])->count($month);
            
        }
        elseif ($month == "11") 
        {            
            $month = "novembre";
            $taxes_month = taxerecouvre::where([ ["exercice", "=", $year] ])->sum($month);
            $taxes_month_2 = taxerecouvre::where([ ["exercice", "=", $year] ])->count($month);
            
        }
        elseif ($month == "12") 
        {            
            $month = "decembre";
            $taxes_month = taxerecouvre::where([ ["exercice", "=", $year] ])->sum($month);
            $taxes_month_2 = taxerecouvre::where([ ["exercice", "=", $year] ])->count($month);
            
        }
       
        
        $janvier = taxerecouvre::where([ ["exercice", "=", $year] ])->sum('janvier');
        $fevrier = taxerecouvre::where([ ["exercice", "=", $year] ])->sum('fevrier');
        $mars = taxerecouvre::where([ ["exercice", "=", $year] ])->sum('mars');
        $avril = taxerecouvre::where([ ["exercice", "=", $year] ])->sum('avril');
        $mai = taxerecouvre::where([ ["exercice", "=", $year] ])->sum('mai');
        $juin = taxerecouvre::where([ ["exercice", "=", $year] ])->sum('juin');
        $juillet = taxerecouvre::where([ ["exercice", "=", $year] ])->sum('juillet');
        $aout = taxerecouvre::where([ ["exercice", "=", $year] ])->sum('aout');
        $septembre = taxerecouvre::where([ ["exercice", "=", $year] ])->sum('septembre');
        $octobre = taxerecouvre::where([ ["exercice", "=", $year] ])->sum('octobre');
        $novembre = taxerecouvre::where([ ["exercice", "=", $year] ])->sum('novembre');
        $decembre = taxerecouvre::where([ ["exercice", "=", $year] ])->sum('decembre');

        $taxes_year = $janvier + $fevrier + $mars + $avril + $mai +
         $juin + $juillet + $aout + $septembre + $octobre + $novembre + $decembre;

        return view('admin.index', compact('count_contribuable','taxes_month_2', 'count_taxes', 'taxes_month', 'taxes_year'));

    }

    public function index()
    {
        return view('admin.pages.activites.add-activite');
    }
    public function viewactivite()
    {
        $activites_items = activite::orderBy("typeActivite", "asc")->Paginate(20);
        return view('admin.pages.activites.view-activites', compact('activites_items'));
    }
    public function saveactivites(Request $request)
    {
        $validated = $request->validate([
                    "typeActivite" => "required"           
                ]);

        if (activite::where([ ['typeActivite', '=', $request->typeActivite] ])->exists()) 
        {
            return back()->with('ErrorActivite', "L'activité <<".$request->typeActivite.">> existe déjà");            
        }
        else
        {
            activite::create($request->all());
            return back()->with('succes', 'Enregistrement effectué avec succès');
        }        
        
    }
    public function edit(activite $activite)
    {
        return view('admin.pages.activites.edit-activite', compact('activite'));
    }
    public function update(Request $request, activite $activite)
    {   
        $validated = $request->validate([
            "typeActivite" => "required"    
        ]);

        $activite->update([
            "typeActivite" => $request->typeActivite
        ]);        
        return back()->with('succesUpdate', 'Modification effectué avec succès');
    }

    public function delete(activite $activite)
    {   
        $activite->delete();    
        return back()->with('succesDelete', 'Suppression effectué avec succès');

    }
}
