<?php

namespace App\Http\Controllers;

use App\Models\activite;
use App\Models\contribuable;
use App\Models\contribuables_activites;
use App\Models\ContribuableTaxe;
use App\Models\taxerecouvre;
use App\Models\taxes;
use App\Models\zone;
use Illuminate\Http\Request;

class contribuableController extends Controller
{
    public function index()
    {       
       
        $contribuable_items = contribuable::orderBy("nom", "asc")->get();
        $activites_items = activite::all();

        $month = date('m');
        $year = date('Y');

        // $taxes_a_jours = taxes::where([
        //     ['MoisTaxes', '=', $month],
        //     ['AnneeTaxes', '=', $year]
        // ])->get(); 

        return view('admin.pages.contribuable.contribuable', compact('contribuable_items', 'activites_items'));
    }
    public function add() 
    {
        $activites = activite::all();
        $zones = zone::all();
        $taxes = taxes::all();
        return view('admin.pages.contribuable.add-contribuable', compact('activites', 'zones', 'taxes'));
    }
    public function addTaxeToContribuable() 
    {
        $taxes = taxes::all();
        $contribuables = contribuable::all();
       
        return view('admin.pages.contribuable.add-taxe-contribuable', compact('taxes', 'contribuables'));
    }
    public function edit(Contribuable $contribuable)
    {
        $activites = activite::all();
        $zones = zone::all();
        return view('admin.pages.contribuable.edit-contribuable', compact('contribuable','activites','zones'));
    }
    public function savecontribuable(Request $request)
    {      
        $exercice = date('Y');
        $validated = $request->validate([
            "nom" => "required",
            "prenom" => "required",
            "telephone" => "required|bail|min:10|max:10",
            "zones_id" => "required",
            "activites_id" => "required",
            "montantTaxes" => "required",            
        ]);

        $s_nom = substr($request->nom, 0,3);
        $s_prenom = substr($request->prenom, 0,3);
        $nb = rand(10000,99999);
        $codecontribuable = strtoupper($s_nom.$nb.$s_prenom);       

        if (contribuable::where([ ['codecontribuable', '=', $codecontribuable] ] )->exists()) 
        {   
            return back()->with('codeError', 'Veuillez réessayer');            
        }
        else
        {
                $a = substr($request->telephone,0,2);

                if ($a == "01" || $a == "05" || $a == "07" && is_numeric($request->telephone)) 
                {         
                        $contribuable = contribuable::create([
                            "codecontribuable" => $codecontribuable,
                            "nom" => ucfirst($request->nom),
                            "prenom" => ucfirst($request->prenom),
                            "telephone" => $request->telephone,
                            "activites_id" => $request->activites_id,
                            "zones_id" => $request->zones_id,
                        ]);  

                        $taxeMensuelle = $request->montantTaxes;
                        $taxeAnnuelle = $taxeMensuelle * 12;

                        
                        $contribuable->Taxes()->attach($request->taxes_id); 
                        taxerecouvre::create([
                            "taxemensuelle" => $taxeMensuelle,
                            "taxeannuelle" => $taxeAnnuelle,
                            "contribuables_id" => $contribuable->id,
                            "taxes_id" => $request->taxes_id,
                            "exercice" => $exercice
                        ]);

                    

                    //    $a =  contribuable::where('codecontribuable', '=', $codecontribuable)->get();
                    //    foreach ($a as $key => $value_a) { }            

                    //     contribuables_activites::create([
                    //         "activites_id" => $request->activites_id,
                    //         "contribuables_id" => $value_a->id,
                    //     ]);

                    // contribuable::create($request->all());
                    return back()->with('succes', 'Enregistrement effectué avec succès ');
                }
                else
                {
                    return back()->with('ErrorPhoneNumber', 'Le numéro de téléphone doit commencer par 01/05/07 et doit être numérique');
                }   
             
        }        
       
    }
    public function savetaxetocontribubale(Request $request)
    {
                $validated = $request->validate([
                    "contribuables_id" => "required",
                    "taxes_id" => "required",
                    "montantTaxes" => "required|numeric",
                ]);        

                if (ContribuableTaxe::where([ ["contribuable_id", "=", $request->contribuables_id], ["taxes_id", "=", $request->taxes_id,] ])->exists() ) 
                {
                    return back()->with('taxeExist', 'Cette taxe est déjà assigné au contribuable'); 
                }
                else
                {
                    ContribuableTaxe::create([
                    "contribuable_id" => $request->contribuables_id,
                    "taxes_id" => $request->taxes_id,
                    ]);

                    $taxeMensuelle = $request->montantTaxes;
                    $taxeAnnuelle = $taxeMensuelle * 12;
                    $year = date('Y');
                    
                    taxerecouvre::create([
                        "taxemensuelle" => $taxeMensuelle,
                        "taxeannuelle" => $taxeAnnuelle,
                        "exercice" => $year,
                        "contribuables_id" => $request->contribuables_id,
                        "taxes_id" => $request->taxes_id
                    ]);

                    return back()->with('succes', 'Enregistrement effectué avec succès ');

                }

    }
    public function update(Request $request, contribuable $contribuable)
    {   
        
        $validated = $request->validate([
            "nom" => "required",
            "prenom" => "required",
            "telephone" => "required|bail|min:10|max:10",
            "zones_id" => "required",
        ]);

        $a = substr($request->telephone,0,2);

        if ($a == "01" || $a == "05" || $a == "07" && is_numeric($request->telephone)) 
            {
                $contribuable->update([
                    "nom" => $request->nom,
                    "prenom" => $request->prenom,
                    "telephone" => $request->telephone,
                    "zones_id" => $request->zones_id
                ]);        
                 return back()->with('succesUpdate', 'Modification effectué avec succès');
            }
        else
            {
                return back()->with('ErrorPhoneNumber', 'Le numéro de téléphone doit commencer par 01/05/07 et doit être numérique');
            }   
       
    }
    public function delete(contribuable $contribuable)
    {   
        $full_name = $contribuable->nom." ".$contribuable->prenom;
        $contribuable->delete();    
        return back()->with('succesDelete', "Le contribuable '$full_name' a été supprimé avec succès ! ");
    
    }
    public function statuscheck(contribuable $contribuable)
    {
        $year = date('Y');
        $month = date('m');

       $contribuable_taxes = taxes::where([
            ['contribuables_id', '=', $_GET['contribuable'] ],
            ['AnneeTaxes', '=', $year ]
        ]) ->join('contribuables', 'contribuables.id', '=', 'taxes.contribuables_id') ->get();
        
        return view('admin.pages.contribuable.view-contribuable-status', compact('contribuable_taxes', 'month'));

    }
    public function taxelist($contribuableId)
    {
        $year = date('Y');
        $month = date('m');
        $contribuable = contribuable::findOrFail($contribuableId);
        $taxes = $contribuable->taxes;
    //    $contribuable_taxes = taxes::where([
    //         ['contribuables_id', '=', $_GET['id'] ],
    //         ['AnneeTaxes', '=', $year ]
    //     ]) ->join('contribuables', 'contribuables.id', '=', 'taxes.contribuables_id') ->get();
        
        return view('admin.pages.contribuable.view-contribuable-taxe', compact('taxes', 'month', 'contribuableId'));

    }
    

}
