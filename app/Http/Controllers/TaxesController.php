<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\taxes;
use App\Models\activite;
use App\Models\collecteur;
use App\Models\contribuable;
use App\Models\ContribuableTaxe;
use App\Models\taxerecouvre;
use Illuminate\Database\Eloquent\Collection; 

class TaxesController extends Controller
{    
    public function pointtaxe(Request $request, $contribuableId, $taxeId)
    {      
        $taxerecouvreitem = taxerecouvre::where([
            ['contribuables_id', '=', $contribuableId],
            ['taxes_id', '=', $taxeId ]
        ])->get();
        
        $exercice = $request->exercice;

        if ( taxerecouvre::where([
            ['contribuables_id', '=', $contribuableId],
            ['taxes_id', '=', $taxeId ],
            ['exercice', '=', $exercice ],
        ])->exists()) 
        {
            $mois = $request->mois;
            foreach ($taxerecouvreitem as $key => $item) {   }        
                
            $addtaxe = taxerecouvre::where([
                ['contribuables_id', '=', $contribuableId],
                ['taxes_id', '=', $taxeId ],
                ['exercice', '=', $exercice ]
            ])->update(["$mois" => $item->taxemensuelle]);

            return back()->with("AddTaxeSucces", "La taxe du mois de $mois enregistré avec succès.");
        }
        else
        {
            return back()->with("TaxeDoestExist", "Cette taxe n'existe pas dans l'exercice choisi");
            
        }
        
    }    
    
    public function index()
    {
        $contribuables = contribuable::all();
        $collecteurs = collecteur::all();
        $activites = activite::all();
        return view('admin.pages.taxes.create-taxe', compact('contribuables', 'collecteurs', 'activites'));
    }
    public function viewtaxes()
    {
        $annee = date('Y');
        $total_taxe_mensuelle = taxerecouvre::where([ ["exercice", "=", $annee] ])->sum('taxemensuelle');
        $total_taxe_annuelle = taxerecouvre::where([ ["exercice", "=", $annee] ])->sum('taxeannuelle');
        $jan = taxerecouvre::where([ ["exercice", "=", $annee] ])->sum('janvier');
        $fev = taxerecouvre::where([ ["exercice", "=", $annee] ])->sum('fevrier');
        $mar = taxerecouvre::where([ ["exercice", "=", $annee] ])->sum('mars');
        $avr = taxerecouvre::where([ ["exercice", "=", $annee] ])->sum('avril');
        $mai = taxerecouvre::where([ ["exercice", "=", $annee] ])->sum('mai');
        $juin = taxerecouvre::where([ ["exercice", "=", $annee] ])->sum('juin');
        $juil = taxerecouvre::where([ ["exercice", "=", $annee] ])->sum('juillet');
        $aou = taxerecouvre::where([ ["exercice", "=", $annee] ])->sum('aout');
        $sep = taxerecouvre::where([ ["exercice", "=", $annee] ])->sum('septembre');
        $oct = taxerecouvre::where([ ["exercice", "=", $annee] ])->sum('octobre');
        $nov = taxerecouvre::where([ ["exercice", "=", $annee] ])->sum('novembre');
        $dec = taxerecouvre::where([ ["exercice", "=", $annee] ])->sum('decembre');
        $taxes_items = taxerecouvre::where([ ["exercice", "=", $annee] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')->get();

        
        $contribuable_items = contribuable::orderBy("nom", "asc")->get();
        $activites_items = activite::orderBy("typeActivite", "asc")->get();
        $collecteur_items = collecteur::orderBy("nomcollecteur", "asc")->get();
        // $taxes_sum = taxes::where('AnneeTaxes', '=', $annee)->sum('montantTaxes');   
        return view('admin.pages.taxes.view-taxes', compact('jan','fev','mar','avr','mai','juin','juil','aou','sep'
        ,'oct','nov','dec','activites_items','taxes_items','total_taxe_mensuelle','total_taxe_annuelle', 'contribuable_items', 'collecteur_items'));
    }

    public function savecontaxes(Request $request)
    {
        $validated = $request->validate([
            "typeTaxes" => "required",
            "montantTaxes" => "required",            
        ]);

        $MoisTaxes = date('m', strtotime($request->DateTaxes));
        $AnneeTaxes = date('Y', strtotime($request->DateTaxes));
        $year = date('Y');

        // if ($AnneeTaxes != $year) 
        // {            
        //     return back()->with('AnneeError', "Veuillez vérifier l'année de la taxe ");            
        // }
        // else
        // {
            // taxes::create([
            //     "typeTaxes" => $request->typeTaxes,
            //     "montantTaxes" => $request->montantTaxes,
            //     "MoisTaxes" => $MoisTaxes,
            //     "AnneeTaxes" => $AnneeTaxes,
            //     "contribuables_id" => $request->contribuables_id,
            //     "collecteurs_id" => $request->collecteurs_id,
            //     "activites_id" => $request->activites_id
            //     ]);
                taxes::create($request->all());
                return back()->with('succes', 'Enregistrement effectué avec succès');
        // }     
        
    }

    public function edit(taxes $taxes)
    {
        $contribuables = contribuable::all();
        $collecteurs = collecteur::all();
        $activites = activite::all();
        return view('admin.pages.taxes.edit-taxes', compact('taxes','contribuables', 'collecteurs', 'activites'));
    }

    public function update(Request $request, taxes $taxes)
    {                   
        $validated = $request->validate([
            "typeTaxes" => "required",
            "montantTaxes" => "required",
            "contribuables_id" => "required",
            "collecteurs_id" => "required",
            "activites_id" => "required"
        ]);
        
        $taxes->update([
            "typeTaxes" => $request->typeTaxes,
            "montantTaxes" => $request->montantTaxes,
            "contribuables_id" => $request->contribuables_id,
            "collecteurs_id" => $request->collecteurs_id,
            "activites_id" => $request->activites_id
        ]);        
        return back()->with('succesUpdate', 'Modification effectué avec succès');
    }
}
