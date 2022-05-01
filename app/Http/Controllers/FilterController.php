<?php

namespace App\Http\Controllers;

use App\Models\activite;
use App\Models\collecteur;
use App\Models\contribuable;
use App\Models\taxerecouvre;
use App\Models\taxes;
use App\Models\zone;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\PDF;
use Illuminate\Support\Facades\App;

class FilterController extends Controller
{
    
    public function allcontribuable()
    {        
        $contri = contribuable::orderBy("nom", 'asc')->get();
        $pdf = PDF::loadView('admin.pages.etat.contribuables.myPDF', compact('contri'));    
        return $pdf->stream();
    }
    public function allcollecteur()
    {
        $collecteur = collecteur::orderBy("nomcollecteur", 'asc')->get();
        $pdf = PDF::loadView('admin.pages.collecteurs.myPDF', compact('collecteur'));    
        return $pdf->stream();
    }
    public function alltaxes()
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
        $taxes = taxerecouvre::orderBy("nom", "asc")->where([ ["exercice", "=", $annee] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')->get();

        foreach ($taxes as $key => $value) { }
                   
        $titre = "LISTE DES TAXES";
        $annee = date('Y');        

        $pdf = PDF::loadView('admin.pages.etat.taxes.myPDF', compact('jan','fev','mar','avr','mai','juin','juil','aou','sep'
        ,'oct','nov','dec','taxes','total_taxe_mensuelle','total_taxe_annuelle','titre'))->setPaper('a4','landscape');    
        return $pdf->stream();
        
        // $contribuable_items = contribuable::orderBy("nom", "asc")->get();
        // $activites_items = activite::orderBy("typeActivite", "asc")->get();
        // $collecteur_items = collecteur::orderBy("nom", "asc")->get();
        // $taxes_sum = taxes::where('AnneeTaxes', '=', $annee)->sum('montantTaxes');   
        // return view('admin.pages.taxes.view-taxes', compact('jan','fev','mar','avr','mai','juin','juil','aou','sep'
        // ,'oct','nov','dec','activites_items','taxes_items','total_taxe_mensuelle','total_taxe_annuelle', 'contribuable_items', 'collecteur_items'));


      
    }

    public function etattaxe()
    {
        $contribuable_items = contribuable::orderBy("nom", "asc")->get();
        $activites_items = activite::all();
        $collecteurs_items = collecteur::all();
        $taxe_items = taxes::all();
        $zones = zone::all();
        return view('admin.pages.etat.taxes.etat-taxe', compact('contribuable_items','zones','taxe_items', 'activites_items', 'collecteurs_items'));
    }
    public function etatcontribuable()
    {
        $contribuable_items = contribuable::orderBy("nom", "asc")->get();
        $activites_items = activite::all();
        $zone_items = zone::all();
        $month = date('m');
        $year = date('Y');
        return view('admin.pages.etat.contribuables.etat-contribuable', compact('contribuable_items', 'activites_items', 'zone_items'));
    }
   
    // Contribuable filter
    public function contribuable(Request $request)
    {
       
        if (isset($request->nom) && !isset($request->prenom) && !isset($request->zone) && !isset($request->activite)) 
        {
            if (isset($request->pdf)) 
            {
                $contri = contribuable::where([
                    ['nom', '=', $request->nom],
                ])->get();    

                $pdf = PDF::loadView('admin.pages.etat.contribuables.myPDF', compact('contri'));    
                return $pdf->stream();
            }
            else
            {
                $contri = contribuable::where([
                ['nom', '=', $request->nom],
                    ])->get();         
                    
                return view('admin.pages.etat.contribuables.view-filter-result', compact('contri'));         
            }  
        }
        elseif(isset($request->prenom) && !isset($request->nom) && !isset($request->zone) && !isset($request->activite))
        {
            if (isset($request->pdf)) 
            {
                $contri = contribuable::where([ 
                    ['prenom', '=', $request->prenom]
                    ])->get();
                $pdf = PDF::loadView('admin.pages.etat.contribuables.myPDF', compact('contri'));    
                return $pdf->stream();
            }
            else
            {
                $contri = contribuable::where([ 
                ['prenom', '=', $request->prenom]
                ])->get();
                return view('admin.pages.etat.contribuables.view-filter-result', compact('contri'));
            }            
        }
        elseif(isset($request->nom) && isset($request->prenom) && !isset($request->zone) && !isset($request->activite))
        {            
            if (isset($request->pdf)) 
            {
                $contri = contribuable::where([
                    ['nom', '=', $request->nom],
                    ['prenom', '=', $request->prenom]
                ])->get();

                $pdf = PDF::loadView('admin.pages.etat.contribuables.myPDF', compact('contri'));    
                return $pdf->stream();
            }
            else
            {
                $contri = contribuable::where([
                ['nom', '=', $request->nom],
                ['prenom', '=', $request->prenom]
                ])->get();
                return view('admin.pages.etat.contribuables.view-filter-result', compact('contri'));
            }  
        }
        elseif (isset($request->zone) && !isset($request->activite) && !isset($request->prenom) && !isset($request->nom)) 
        {
            if (isset($request->pdf)) 
            {
                $contri = contribuable::where([
                    ['zones_id', '=', $request->zone]
                ])->get();

                $pdf = PDF::loadView('admin.pages.etat.contribuables.myPDF', compact('contri'));    
                return $pdf->stream();
            }
            else
            {
                $contri = contribuable::where([
                    ['zones_id', '=', $request->zone]
                ])->get();
                return view('admin.pages.etat.contribuables.view-filter-result', compact('contri'));
            }
            
        }
        elseif(isset($request->activite) && !isset($request->zone) && !isset($request->prenom) && !isset($request->nom))
        {
            if (isset($request->pdf)) 
            {
                $contri = contribuable::where([
                    ['activites_id', '=', $request->activite]
                ])->get();

                $pdf = PDF::loadView('admin.pages.etat.contribuables.myPDF', compact('contri'));    
                return $pdf->stream();
            }
            else
            {
                $contri = contribuable::where([
                    ['activites_id', '=', $request->activite]
                ])->get();
                return view('admin.pages.etat.contribuables.view-filter-result', compact('contri'));
            }
            
        }
        elseif(isset($request->zone) && isset($request->activite) && !isset($request->prenom) && !isset($request->nom))
        {    
            if (isset($request->pdf)) 
            {
                $contri = contribuable::where([
                    ['zones_id', '=', $request->zone],
                    ['activites_id', '=', $request->activite]                
                ])->get();

                $pdf = PDF::loadView('admin.pages.etat.contribuables.myPDF', compact('contri'));    
                return $pdf->stream();
            }
            else
            {
                $contri = contribuable::where([
                    ['zones_id', '=', $request->zone],
                    ['activites_id', '=', $request->activite]                
                ])->get();
                return view('admin.pages.etat.contribuables.view-filter-result', compact('contri'));
            } 
        }
        elseif( isset($request->nom) && isset($request->prenom)  && isset($request->zone))
        {    
            if (isset($request->pdf)) 
            {
                $contri = contribuable::where([
                    ['nom', '=', $request->nom],
                    ['prenom', '=', $request->prenom],
                    ['zones_id', '=', $request->zone],
                ])->get();

                $pdf = PDF::loadView('admin.pages.etat.contribuables.myPDF', compact('contri'));    
                return $pdf->stream();
            }
            else
            {
                $contri = contribuable::where([
                    ['nom', '=', $request->nom],
                    ['prenom', '=', $request->prenom],
                    ['zones_id', '=', $request->zone],               
                ])->get();
                return view('admin.pages.etat.contribuables.view-filter-result', compact('contri'));
            } 
        }
        elseif( isset($request->nom) && isset($request->prenom)  && isset($request->activite))
        {    
            if (isset($request->pdf)) 
            {
                $contri = contribuable::where([
                    ['nom', '=', $request->nom],
                    ['prenom', '=', $request->prenom],
                    ['activites_id', '=', $request->activite] 
                ])->get();

                $pdf = PDF::loadView('admin.pages.etat.contribuables.myPDF', compact('contri'));    
                return $pdf->stream();
            }
            else
            {
                $contri = contribuable::where([
                    ['nom', '=', $request->nom],
                    ['prenom', '=', $request->prenom],
                    ['activites_id', '=', $request->activite]                
                ])->get();
                return view('admin.pages.etat.contribuables.view-filter-result', compact('contri'));
            } 
        }
        elseif( isset($request->nom) && isset($request->prenom)  && isset($request->activite) && isset($request->zone))
        {    
            if (isset($request->pdf)) 
            {
                $contri = contribuable::where([
                    ['nom', '=', $request->nom],
                    ['prenom', '=', $request->prenom],
                    ['zones_id', '=', $request->zone],
                    ['activites_id', '=', $request->activite] 
                ])->get();

                $pdf = PDF::loadView('admin.pages.etat.contribuables.myPDF', compact('contri'));    
                return $pdf->stream();
            }
            else
            {
                $contri = contribuable::where([
                    ['nom', '=', $request->nom],
                    ['prenom', '=', $request->prenom],
                    ['zones_id', '=', $request->zone],
                    ['activites_id', '=', $request->activite]                
                ])->get();
                return view('admin.pages.etat.contribuables.view-filter-result', compact('contri'));
            } 
        }
        else
        {
            return back()->with('error1', 'Requête Invalide');
        }
        
    }

    // Taxes filter ******************************************************************************************

    public function taxes(Request $request)
    { 
        $exercice = date('Y');
       
        if (isset($request->typeTaxes) && !isset($request->zone) && !isset($request->annee)  && !isset($request->nom)  && !isset($request->activite) && !isset($request->collecteur)) 
        {           
            if (isset($request->pdf)) 
            {
                $total_taxe_mensuelle = taxerecouvre::where([ ["exercice", "=", $exercice], ['taxes_id', '=', $request->typeTaxes] ])->sum('taxemensuelle');
                $total_taxe_annuelle = taxerecouvre::where([ ["exercice", "=", $exercice], ['taxes_id', '=', $request->typeTaxes] ])->sum('taxeannuelle');
                $jan = taxerecouvre::where([ ["exercice", "=", $exercice], ['taxes_id', '=', $request->typeTaxes] ])->sum('janvier');
                $fev = taxerecouvre::where([ ["exercice", "=", $exercice], ['taxes_id', '=', $request->typeTaxes] ])->sum('fevrier');
                $mar = taxerecouvre::where([ ["exercice", "=", $exercice], ['taxes_id', '=', $request->typeTaxes] ])->sum('mars');
                $avr = taxerecouvre::where([ ["exercice", "=", $exercice], ['taxes_id', '=', $request->typeTaxes] ])->sum('avril');
                $mai = taxerecouvre::where([ ["exercice", "=", $exercice], ['taxes_id', '=', $request->typeTaxes] ])->sum('mai');
                $juin = taxerecouvre::where([ ["exercice", "=", $exercice], ['taxes_id', '=', $request->typeTaxes] ])->sum('juin');
                $juil = taxerecouvre::where([ ["exercice", "=", $exercice], ['taxes_id', '=', $request->typeTaxes] ])->sum('juillet');
                $aou = taxerecouvre::where([ ["exercice", "=", $exercice], ['taxes_id', '=', $request->typeTaxes] ])->sum('aout');
                $sep = taxerecouvre::where([ ["exercice", "=", $exercice], ['taxes_id', '=', $request->typeTaxes] ])->sum('septembre');
                $oct = taxerecouvre::where([ ["exercice", "=", $exercice], ['taxes_id', '=', $request->typeTaxes] ])->sum('octobre');
                $nov = taxerecouvre::where([ ["exercice", "=", $exercice], ['taxes_id', '=', $request->typeTaxes] ])->sum('novembre');
                $dec = taxerecouvre::where([ ["exercice", "=", $exercice], ['taxes_id', '=', $request->typeTaxes] ])->sum('decembre');
               
                $taxes = taxerecouvre::where([
                    ['taxes_id', '=', $request->typeTaxes],
                    ['exercice', '=', $exercice]
                ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')
                ->get();              

                $typeTaxes = taxes::find($request->typeTaxes);
                $titre = $typeTaxes->typeTaxes;

                $pdf = PDF::loadView('admin.pages.etat.taxes.myPDF', compact('jan','fev','mar','avr','mai','juin','juil','aou','sep'
                ,'oct','nov','dec','total_taxe_mensuelle','total_taxe_annuelle', 'taxes', 'titre'))->setPaper('a4','landscape');    
                return $pdf->stream();
            }
            else
            {
                $total_taxe_mensuelle = taxerecouvre::where([ ["exercice", "=", $exercice], ['taxes_id', '=', $request->typeTaxes] ])->sum('taxemensuelle');
                $total_taxe_annuelle = taxerecouvre::where([ ["exercice", "=", $exercice], ['taxes_id', '=', $request->typeTaxes] ])->sum('taxeannuelle');
                $jan = taxerecouvre::where([ ["exercice", "=", $exercice], ['taxes_id', '=', $request->typeTaxes] ])->sum('janvier');
                $fev = taxerecouvre::where([ ["exercice", "=", $exercice], ['taxes_id', '=', $request->typeTaxes] ])->sum('fevrier');
                $mar = taxerecouvre::where([ ["exercice", "=", $exercice], ['taxes_id', '=', $request->typeTaxes] ])->sum('mars');
                $avr = taxerecouvre::where([ ["exercice", "=", $exercice], ['taxes_id', '=', $request->typeTaxes] ])->sum('avril');
                $mai = taxerecouvre::where([ ["exercice", "=", $exercice], ['taxes_id', '=', $request->typeTaxes] ])->sum('mai');
                $juin = taxerecouvre::where([ ["exercice", "=", $exercice], ['taxes_id', '=', $request->typeTaxes] ])->sum('juin');
                $juil = taxerecouvre::where([ ["exercice", "=", $exercice], ['taxes_id', '=', $request->typeTaxes] ])->sum('juillet');
                $aou = taxerecouvre::where([ ["exercice", "=", $exercice], ['taxes_id', '=', $request->typeTaxes] ])->sum('aout');
                $sep = taxerecouvre::where([ ["exercice", "=", $exercice], ['taxes_id', '=', $request->typeTaxes] ])->sum('septembre');
                $oct = taxerecouvre::where([ ["exercice", "=", $exercice], ['taxes_id', '=', $request->typeTaxes] ])->sum('octobre');
                $nov = taxerecouvre::where([ ["exercice", "=", $exercice], ['taxes_id', '=', $request->typeTaxes] ])->sum('novembre');
                $dec = taxerecouvre::where([ ["exercice", "=", $exercice], ['taxes_id', '=', $request->typeTaxes] ])->sum('decembre');
               
                $taxes = taxerecouvre::where([
                    ['taxes_id', '=', $request->typeTaxes],
                    ['exercice', '=', $exercice]
                ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')
                ->get();
              

                $typeTaxes = taxes::find($request->typeTaxes);
                $titre = $typeTaxes->typeTaxes;        
                    
                return view('admin.pages.etat.taxes.view-filter-result', compact('jan','fev','mar','avr','mai','juin','juil','aou','sep'
                ,'oct','nov','dec','total_taxe_mensuelle','total_taxe_annuelle', 'taxes', 'titre'));         
            }  
        }
        elseif(!isset($request->typeTaxes) && !isset($request->zone) &&  !isset($request->annee)  && isset($request->nom)  && !isset($request->activite) && !isset($request->collecteur))
        {
            if (isset($request->pdf)) 
            {
                $total_taxe_mensuelle = taxerecouvre::where([ ["exercice", "=", $exercice], ['contribuables_id', '=', $request->nom] ])->sum('taxemensuelle');
                $total_taxe_annuelle = taxerecouvre::where([ ["exercice", "=", $exercice], ['contribuables_id', '=', $request->nom] ])->sum('taxeannuelle');
                $jan = taxerecouvre::where([ ["exercice", "=", $exercice], ['contribuables_id', '=', $request->nom] ])->sum('janvier');
                $fev = taxerecouvre::where([ ["exercice", "=", $exercice], ['contribuables_id', '=', $request->nom] ])->sum('fevrier');
                $mar = taxerecouvre::where([ ["exercice", "=", $exercice], ['contribuables_id', '=', $request->nom] ])->sum('mars');
                $avr = taxerecouvre::where([ ["exercice", "=", $exercice], ['contribuables_id', '=', $request->nom] ])->sum('avril');
                $mai = taxerecouvre::where([ ["exercice", "=", $exercice], ['contribuables_id', '=', $request->nom] ])->sum('mai');
                $juin = taxerecouvre::where([ ["exercice", "=", $exercice], ['contribuables_id', '=', $request->nom] ])->sum('juin');
                $juil = taxerecouvre::where([ ["exercice", "=", $exercice], ['contribuables_id', '=', $request->nom] ])->sum('juillet');
                $aou = taxerecouvre::where([ ["exercice", "=", $exercice], ['contribuables_id', '=', $request->nom] ])->sum('aout');
                $sep = taxerecouvre::where([ ["exercice", "=", $exercice], ['contribuables_id', '=', $request->nom] ])->sum('septembre');
                $oct = taxerecouvre::where([ ["exercice", "=", $exercice], ['contribuables_id', '=', $request->nom] ])->sum('octobre');
                $nov = taxerecouvre::where([ ["exercice", "=", $exercice], ['contribuables_id', '=', $request->nom] ])->sum('novembre');
                $dec = taxerecouvre::where([ ["exercice", "=", $exercice], ['contribuables_id', '=', $request->nom] ])->sum('decembre');
                
                $taxes = taxerecouvre::where([
                    ['contribuables_id', '=', $request->nom],
                    ['exercice', '=', $exercice]
                ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')
                ->get();              

                $nom = $taxes[0]->nom." ".$taxes[0]->prenom;
                $titre = "Taxe de : $nom";

                $pdf = PDF::loadView('admin.pages.etat.taxes.myPDF', compact('jan','fev','mar','avr','mai','juin','juil','aou','sep'
                ,'oct','nov','dec','total_taxe_mensuelle','total_taxe_annuelle', 'taxes', 'titre'))->setPaper('a4','landscape');    
                return $pdf->stream();
            }
            else
            {
                $total_taxe_mensuelle = taxerecouvre::where([ ["exercice", "=", $exercice], ['contribuables_id', '=', $request->nom] ])->sum('taxemensuelle');
                $total_taxe_annuelle = taxerecouvre::where([ ["exercice", "=", $exercice], ['contribuables_id', '=', $request->nom] ])->sum('taxeannuelle');
                $jan = taxerecouvre::where([ ["exercice", "=", $exercice], ['contribuables_id', '=', $request->nom] ])->sum('janvier');
                $fev = taxerecouvre::where([ ["exercice", "=", $exercice], ['contribuables_id', '=', $request->nom] ])->sum('fevrier');
                $mar = taxerecouvre::where([ ["exercice", "=", $exercice], ['contribuables_id', '=', $request->nom] ])->sum('mars');
                $avr = taxerecouvre::where([ ["exercice", "=", $exercice], ['contribuables_id', '=', $request->nom] ])->sum('avril');
                $mai = taxerecouvre::where([ ["exercice", "=", $exercice], ['contribuables_id', '=', $request->nom] ])->sum('mai');
                $juin = taxerecouvre::where([ ["exercice", "=", $exercice], ['contribuables_id', '=', $request->nom] ])->sum('juin');
                $juil = taxerecouvre::where([ ["exercice", "=", $exercice], ['contribuables_id', '=', $request->nom] ])->sum('juillet');
                $aou = taxerecouvre::where([ ["exercice", "=", $exercice], ['contribuables_id', '=', $request->nom] ])->sum('aout');
                $sep = taxerecouvre::where([ ["exercice", "=", $exercice], ['contribuables_id', '=', $request->nom] ])->sum('septembre');
                $oct = taxerecouvre::where([ ["exercice", "=", $exercice], ['contribuables_id', '=', $request->nom] ])->sum('octobre');
                $nov = taxerecouvre::where([ ["exercice", "=", $exercice], ['contribuables_id', '=', $request->nom] ])->sum('novembre');
                $dec = taxerecouvre::where([ ["exercice", "=", $exercice], ['contribuables_id', '=', $request->nom] ])->sum('decembre');
                
                $taxes = taxerecouvre::where([
                    ['contribuables_id', '=', $request->nom],
                    ['exercice', '=', $exercice]
                ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')
                ->get();              

                $nom = $taxes[0]->nom." ".$taxes[0]->prenom;
                $titre = "Taxe de : $nom";

                    
                return view('admin.pages.etat.taxes.view-filter-result', compact('jan','fev','mar','avr','mai','juin','juil','aou','sep'
                ,'oct','nov','dec','total_taxe_mensuelle','total_taxe_annuelle', 'taxes', 'titre'));
            }            
        }        
        elseif (!isset($request->typeTaxes) && !isset($request->zone) &&  !isset($request->annee)  && !isset($request->nom)  && isset($request->activite) && !isset($request->collecteur)) 
        {
            if (isset($request->pdf)) 
            {
                            
                
                $total_taxe_mensuelle = taxerecouvre::where([ ["exercice", "=", $exercice], ['activites_id', '=', $request->activite] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')->sum('taxemensuelle');
                $total_taxe_annuelle = taxerecouvre::where([ ["exercice", "=", $exercice], ['activites_id', '=', $request->activite] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')->sum('taxeannuelle');
                $jan = taxerecouvre::where([ ["exercice", "=", $exercice], ['activites_id', '=', $request->activite] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')->sum('janvier');
                $fev = taxerecouvre::where([ ["exercice", "=", $exercice], ['activites_id', '=', $request->activite] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')->sum('fevrier');
                $mar = taxerecouvre::where([ ["exercice", "=", $exercice], ['activites_id', '=', $request->activite] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')->sum('mars');
                $avr = taxerecouvre::where([ ["exercice", "=", $exercice], ['activites_id', '=', $request->activite] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')->sum('avril');
                $mai = taxerecouvre::where([ ["exercice", "=", $exercice], ['activites_id', '=', $request->activite] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')->sum('mai');
                $juin = taxerecouvre::where([ ["exercice", "=", $exercice], ['activites_id', '=', $request->activite] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')->sum('juin');
                $juil = taxerecouvre::where([ ["exercice", "=", $exercice], ['activites_id', '=', $request->activite] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')->sum('juillet');
                $aou = taxerecouvre::where([ ["exercice", "=", $exercice], ['activites_id', '=', $request->activite] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')->sum('aout');
                $sep = taxerecouvre::where([ ["exercice", "=", $exercice], ['activites_id', '=', $request->activite] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')->sum('septembre');
                $oct = taxerecouvre::where([ ["exercice", "=", $exercice], ['activites_id', '=', $request->activite] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')->sum('octobre');
                $nov = taxerecouvre::where([ ["exercice", "=", $exercice], ['activites_id', '=', $request->activite] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')->sum('novembre');
                $dec = taxerecouvre::where([ ["exercice", "=", $exercice], ['activites_id', '=', $request->activite] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')->sum('decembre');
                
                $taxes = taxerecouvre::where([
                    ['activites_id', '=', $request->activite],
                    ['exercice', '=', $exercice]
                ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')
                ->get();
                

                $titre = "Taxe par activité";

                                    
                $pdf = PDF::loadView('admin.pages.etat.taxes.myPDF',  compact('jan','fev','mar','avr','mai','juin','juil','aou','sep'
                ,'oct','nov','dec','total_taxe_mensuelle','total_taxe_annuelle', 'taxes', 'titre'))->setPaper('a4','landscape');    
                return $pdf->stream();
            }
            else
            {
                $total_taxe_mensuelle = taxerecouvre::where([ ["exercice", "=", $exercice], ['activites_id', '=', $request->activite] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')->sum('taxemensuelle');
                $total_taxe_annuelle = taxerecouvre::where([ ["exercice", "=", $exercice], ['activites_id', '=', $request->activite] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')->sum('taxeannuelle');
                $jan = taxerecouvre::where([ ["exercice", "=", $exercice], ['activites_id', '=', $request->activite] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')->sum('janvier');
                $fev = taxerecouvre::where([ ["exercice", "=", $exercice], ['activites_id', '=', $request->activite] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')->sum('fevrier');
                $mar = taxerecouvre::where([ ["exercice", "=", $exercice], ['activites_id', '=', $request->activite] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')->sum('mars');
                $avr = taxerecouvre::where([ ["exercice", "=", $exercice], ['activites_id', '=', $request->activite] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')->sum('avril');
                $mai = taxerecouvre::where([ ["exercice", "=", $exercice], ['activites_id', '=', $request->activite] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')->sum('mai');
                $juin = taxerecouvre::where([ ["exercice", "=", $exercice], ['activites_id', '=', $request->activite] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')->sum('juin');
                $juil = taxerecouvre::where([ ["exercice", "=", $exercice], ['activites_id', '=', $request->activite] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')->sum('juillet');
                $aou = taxerecouvre::where([ ["exercice", "=", $exercice], ['activites_id', '=', $request->activite] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')->sum('aout');
                $sep = taxerecouvre::where([ ["exercice", "=", $exercice], ['activites_id', '=', $request->activite] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')->sum('septembre');
                $oct = taxerecouvre::where([ ["exercice", "=", $exercice], ['activites_id', '=', $request->activite] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')->sum('octobre');
                $nov = taxerecouvre::where([ ["exercice", "=", $exercice], ['activites_id', '=', $request->activite] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')->sum('novembre');
                $dec = taxerecouvre::where([ ["exercice", "=", $exercice], ['activites_id', '=', $request->activite] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')->sum('decembre');
                
                $taxes = taxerecouvre::where([
                    ['activites_id', '=', $request->activite],
                    ['exercice', '=', $exercice]
                ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')
                ->get();

                $titre = "Taxe par activité";

                return view('admin.pages.etat.taxes.view-filter-result', compact('jan','fev','mar','avr','mai','juin','juil','aou','sep'
                ,'oct','nov','dec','total_taxe_mensuelle','total_taxe_annuelle', 'taxes', 'titre'));

            }              
        }
        elseif(!isset($request->typeTaxes) && !isset($request->zone) &&  !isset($request->annee)  && !isset($request->nom)  && !isset($request->activite) && isset($request->collecteur))
        {
            if (isset($request->pdf)) 
            {
                
                $total_taxe_mensuelle = taxerecouvre::where([ ["exercice", "=", $exercice], ['zones_id', '=', $request->collecteur] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')
                ->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')->sum('taxemensuelle');
                $total_taxe_annuelle = taxerecouvre::where([ ["exercice", "=", $exercice], ['zones_id', '=', $request->collecteur] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')
                ->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')->sum('taxeannuelle');
                $jan = taxerecouvre::where([ ["exercice", "=", $exercice], ['zones_id', '=', $request->collecteur] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')
                ->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')->sum('janvier');
                $fev = taxerecouvre::where([ ["exercice", "=", $exercice], ['zones_id', '=', $request->collecteur] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')
                ->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')->sum('fevrier');
                $mar = taxerecouvre::where([ ["exercice", "=", $exercice], ['zones_id', '=', $request->collecteur] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')
                ->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')->sum('mars');
                $avr = taxerecouvre::where([ ["exercice", "=", $exercice], ['zones_id', '=', $request->collecteur] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')
                ->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')->sum('avril');
                $mai = taxerecouvre::where([ ["exercice", "=", $exercice], ['zones_id', '=', $request->collecteur] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')
                ->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')->sum('mai');
                $juin = taxerecouvre::where([ ["exercice", "=", $exercice], ['zones_id', '=', $request->collecteur] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')
                ->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')->sum('juin');
                $juil = taxerecouvre::where([ ["exercice", "=", $exercice], ['zones_id', '=', $request->collecteur] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')
                ->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')->sum('juillet');
                $aou = taxerecouvre::where([ ["exercice", "=", $exercice], ['zones_id', '=', $request->collecteur] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')
                ->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')->sum('aout');
                $sep = taxerecouvre::where([ ["exercice", "=", $exercice], ['zones_id', '=', $request->collecteur] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')
                ->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')->sum('septembre');
                $oct = taxerecouvre::where([ ["exercice", "=", $exercice], ['zones_id', '=', $request->collecteur] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')
                ->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')->sum('octobre');
                $nov = taxerecouvre::where([ ["exercice", "=", $exercice], ['zones_id', '=', $request->collecteur] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')
                ->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')->sum('novembre');
                $dec = taxerecouvre::where([ ["exercice", "=", $exercice], ['zones_id', '=', $request->collecteur] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')
                ->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')->sum('decembre');
                
                $taxes = taxerecouvre::where([
                    ['zones_id', '=', $request->collecteur],
                    ['exercice', '=', $exercice]
                ])->join('contribuables', 'taxerecouvres.contribuables_id', '=',
                 'contribuables.id')->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')
                ->get();


                $titre = $taxes[0]->nomcollecteur." ".$taxes[0]->prenomcollecteur;

                $pdf = PDF::loadView('admin.pages.etat.taxes.myPDF',  compact('jan','fev','mar','avr','mai','juin','juil','aou','sep'
                ,'oct','nov','dec','total_taxe_mensuelle','total_taxe_annuelle', 'taxes', 'titre'))->setPaper('a4','landscape');    
                return $pdf->stream();
            }
            else
            {
                $total_taxe_mensuelle = taxerecouvre::where([ ["exercice", "=", $exercice], ['zones_id', '=', $request->collecteur] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')
                ->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')->sum('taxemensuelle');
                $total_taxe_annuelle = taxerecouvre::where([ ["exercice", "=", $exercice], ['zones_id', '=', $request->collecteur] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')
                ->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')->sum('taxeannuelle');
                $jan = taxerecouvre::where([ ["exercice", "=", $exercice], ['zones_id', '=', $request->collecteur] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')
                ->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')->sum('janvier');
                $fev = taxerecouvre::where([ ["exercice", "=", $exercice], ['zones_id', '=', $request->collecteur] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')
                ->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')->sum('fevrier');
                $mar = taxerecouvre::where([ ["exercice", "=", $exercice], ['zones_id', '=', $request->collecteur] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')
                ->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')->sum('mars');
                $avr = taxerecouvre::where([ ["exercice", "=", $exercice], ['zones_id', '=', $request->collecteur] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')
                ->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')->sum('avril');
                $mai = taxerecouvre::where([ ["exercice", "=", $exercice], ['zones_id', '=', $request->collecteur] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')
                ->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')->sum('mai');
                $juin = taxerecouvre::where([ ["exercice", "=", $exercice], ['zones_id', '=', $request->collecteur] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')
                ->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')->sum('juin');
                $juil = taxerecouvre::where([ ["exercice", "=", $exercice], ['zones_id', '=', $request->collecteur] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')
                ->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')->sum('juillet');
                $aou = taxerecouvre::where([ ["exercice", "=", $exercice], ['zones_id', '=', $request->collecteur] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')
                ->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')->sum('aout');
                $sep = taxerecouvre::where([ ["exercice", "=", $exercice], ['zones_id', '=', $request->collecteur] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')
                ->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')->sum('septembre');
                $oct = taxerecouvre::where([ ["exercice", "=", $exercice], ['zones_id', '=', $request->collecteur] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')
                ->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')->sum('octobre');
                $nov = taxerecouvre::where([ ["exercice", "=", $exercice], ['zones_id', '=', $request->collecteur] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')
                ->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')->sum('novembre');
                $dec = taxerecouvre::where([ ["exercice", "=", $exercice], ['zones_id', '=', $request->collecteur] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')
                ->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')->sum('decembre');
                
                $taxes = taxerecouvre::where([
                    ['zones_id', '=', $request->collecteur],
                    ['exercice', '=', $exercice]
                ])->join('contribuables', 'taxerecouvres.contribuables_id', '=',
                 'contribuables.id')->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')
                ->get();


                $titre = $taxes[0]->nomcollecteur." ".$taxes[0]->prenomcollecteur;

                return view('admin.pages.etat.taxes.view-filter-result', compact('jan','fev','mar','avr','mai','juin','juil','aou','sep'
                ,'oct','nov','dec','total_taxe_mensuelle','total_taxe_annuelle', 'taxes', 'titre'));
            }      
            
        }
        elseif(!isset($request->typeTaxes) && !isset($request->zone) &&  isset($request->annee)  && !isset($request->nom) && !isset($request->activite) && !isset($request->collecteur))
        {
            if (isset($request->pdf)) 
            {
                $total_taxe_mensuelle = taxerecouvre::where([ ["exercice", "=", $request->annee]])->sum('taxemensuelle');
                $total_taxe_annuelle = taxerecouvre::where([ ["exercice", "=", $request->annee]])->sum('taxeannuelle');
                $jan = taxerecouvre::where([ ["exercice", "=", $request->annee]])->sum('janvier');
                $fev = taxerecouvre::where([ ["exercice", "=", $request->annee]])->sum('fevrier');
                $mar = taxerecouvre::where([ ["exercice", "=", $request->annee]])->sum('mars');
                $avr = taxerecouvre::where([ ["exercice", "=", $request->annee]])->sum('avril');
                $mai = taxerecouvre::where([ ["exercice", "=", $request->annee]])->sum('mai');
                $juin = taxerecouvre::where([ ["exercice", "=", $request->annee]])->sum('juin');
                $juil = taxerecouvre::where([ ["exercice", "=", $request->annee]])->sum('juillet');
                $aou = taxerecouvre::where([ ["exercice", "=", $request->annee]])->sum('aout');
                $sep = taxerecouvre::where([ ["exercice", "=", $request->annee]])->sum('septembre');
                $oct = taxerecouvre::where([ ["exercice", "=", $request->annee]])->sum('octobre');
                $nov = taxerecouvre::where([ ["exercice", "=", $request->annee]])->sum('novembre');
                $dec = taxerecouvre::where([ ["exercice", "=", $request->annee]])->sum('decembre');
               
                $exercice__ = $request->annee;
                $taxes = taxerecouvre::where([
                    ['exercice', '=', $request->annee]
                ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')
                ->get(); 
                
                $titre = "Liste des taxes";

                $pdf = PDF::loadView('admin.pages.etat.taxes.myPDF', compact('jan','fev','mar','avr','mai','juin','juil','aou','sep'
                ,'oct','nov','exercice__', 'dec','total_taxe_mensuelle','total_taxe_annuelle', 'taxes', 'titre'))->setPaper('a4','landscape');    
                return $pdf->stream();
            }
            else
            {
                $total_taxe_mensuelle = taxerecouvre::where([ ["exercice", "=", $request->annee]])->sum('taxemensuelle');
                $total_taxe_annuelle = taxerecouvre::where([ ["exercice", "=", $request->annee]])->sum('taxeannuelle');
                $jan = taxerecouvre::where([ ["exercice", "=", $request->annee]])->sum('janvier');
                $fev = taxerecouvre::where([ ["exercice", "=", $request->annee]])->sum('fevrier');
                $mar = taxerecouvre::where([ ["exercice", "=", $request->annee]])->sum('mars');
                $avr = taxerecouvre::where([ ["exercice", "=", $request->annee]])->sum('avril');
                $mai = taxerecouvre::where([ ["exercice", "=", $request->annee]])->sum('mai');
                $juin = taxerecouvre::where([ ["exercice", "=", $request->annee]])->sum('juin');
                $juil = taxerecouvre::where([ ["exercice", "=", $request->annee]])->sum('juillet');
                $aou = taxerecouvre::where([ ["exercice", "=", $request->annee]])->sum('aout');
                $sep = taxerecouvre::where([ ["exercice", "=", $request->annee]])->sum('septembre');
                $oct = taxerecouvre::where([ ["exercice", "=", $request->annee]])->sum('octobre');
                $nov = taxerecouvre::where([ ["exercice", "=", $request->annee]])->sum('novembre');
                $dec = taxerecouvre::where([ ["exercice", "=", $request->annee]])->sum('decembre');
               
                $exercice__ = $request->annee;
                $taxes = taxerecouvre::where([
                    ['exercice', '=', $request->annee]
                ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')
                ->get(); 
                
                $titre = "Liste des taxes";

                return view('admin.pages.etat.taxes.view-filter-result', compact('jan','fev','mar','avr','mai','juin','juil','aou','sep'
                ,'oct','nov','dec','total_taxe_mensuelle','total_taxe_annuelle', 'taxes', 'titre'));
            }      
            
        }
        elseif(isset($request->typeTaxes) && !isset($request->zone) &&  !isset($request->annee)  && isset($request->nom)  && !isset($request->activite) && !isset($request->collecteur))
        {
            if (isset($request->pdf)) 
            {
                $total_taxe_mensuelle = taxerecouvre::where([['taxes_id', '=', $request->typeTaxes], ['contribuables_id', '=', $request->nom] ])->sum('taxemensuelle');
                $total_taxe_annuelle = taxerecouvre::where([['taxes_id', '=', $request->typeTaxes], ['contribuables_id', '=', $request->nom] ])->sum('taxeannuelle');
                $jan = taxerecouvre::where([['taxes_id', '=', $request->typeTaxes], ['contribuables_id', '=', $request->nom] ])->sum('janvier');
                $fev = taxerecouvre::where([['taxes_id', '=', $request->typeTaxes], ['contribuables_id', '=', $request->nom] ])->sum('fevrier');
                $mar = taxerecouvre::where([['taxes_id', '=', $request->typeTaxes], ['contribuables_id', '=', $request->nom] ])->sum('mars');
                $avr = taxerecouvre::where([['taxes_id', '=', $request->typeTaxes], ['contribuables_id', '=', $request->nom] ])->sum('avril');
                $mai = taxerecouvre::where([['taxes_id', '=', $request->typeTaxes], ['contribuables_id', '=', $request->nom] ])->sum('mai');
                $juin = taxerecouvre::where([['taxes_id', '=', $request->typeTaxes], ['contribuables_id', '=', $request->nom] ])->sum('juin');
                $juil = taxerecouvre::where([['taxes_id', '=', $request->typeTaxes], ['contribuables_id', '=', $request->nom] ])->sum('juillet');
                $aou = taxerecouvre::where([['taxes_id', '=', $request->typeTaxes], ['contribuables_id', '=', $request->nom] ])->sum('aout');
                $sep = taxerecouvre::where([['taxes_id', '=', $request->typeTaxes], ['contribuables_id', '=', $request->nom] ])->sum('septembre');
                $oct = taxerecouvre::where([['taxes_id', '=', $request->typeTaxes], ['contribuables_id', '=', $request->nom] ])->sum('octobre');
                $nov = taxerecouvre::where([['taxes_id', '=', $request->typeTaxes], ['contribuables_id', '=', $request->nom] ])->sum('novembre');
                $dec = taxerecouvre::where([['taxes_id', '=', $request->typeTaxes], ['contribuables_id', '=', $request->nom] ])->sum('decembre');
               
                $taxes = taxerecouvre::where([
                    ['taxes_id', '=', $request->typeTaxes],
                    ['contribuables_id', '=', $request->nom]
                ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')
                ->get();    
                

                $typeTaxes = taxes::find($request->typeTaxes);
                $titre = $typeTaxes->typeTaxes;

                $pdf = PDF::loadView('admin.pages.etat.taxes.myPDF', compact('jan','fev','mar','avr','mai','juin','juil','aou','sep'
                ,'oct','nov','dec','total_taxe_mensuelle','total_taxe_annuelle', 'taxes', 'titre'))->setPaper('a4','landscape');    
                return $pdf->stream();
            }
            else
            {
                $total_taxe_mensuelle = taxerecouvre::where([['taxes_id', '=', $request->typeTaxes], ['contribuables_id', '=', $request->nom] ])->sum('taxemensuelle');
                $total_taxe_annuelle = taxerecouvre::where([['taxes_id', '=', $request->typeTaxes], ['contribuables_id', '=', $request->nom] ])->sum('taxeannuelle');
                $jan = taxerecouvre::where([['taxes_id', '=', $request->typeTaxes], ['contribuables_id', '=', $request->nom] ])->sum('janvier');
                $fev = taxerecouvre::where([['taxes_id', '=', $request->typeTaxes], ['contribuables_id', '=', $request->nom] ])->sum('fevrier');
                $mar = taxerecouvre::where([['taxes_id', '=', $request->typeTaxes], ['contribuables_id', '=', $request->nom] ])->sum('mars');
                $avr = taxerecouvre::where([['taxes_id', '=', $request->typeTaxes], ['contribuables_id', '=', $request->nom] ])->sum('avril');
                $mai = taxerecouvre::where([['taxes_id', '=', $request->typeTaxes], ['contribuables_id', '=', $request->nom] ])->sum('mai');
                $juin = taxerecouvre::where([['taxes_id', '=', $request->typeTaxes], ['contribuables_id', '=', $request->nom] ])->sum('juin');
                $juil = taxerecouvre::where([['taxes_id', '=', $request->typeTaxes], ['contribuables_id', '=', $request->nom] ])->sum('juillet');
                $aou = taxerecouvre::where([['taxes_id', '=', $request->typeTaxes], ['contribuables_id', '=', $request->nom] ])->sum('aout');
                $sep = taxerecouvre::where([['taxes_id', '=', $request->typeTaxes], ['contribuables_id', '=', $request->nom] ])->sum('septembre');
                $oct = taxerecouvre::where([['taxes_id', '=', $request->typeTaxes], ['contribuables_id', '=', $request->nom] ])->sum('octobre');
                $nov = taxerecouvre::where([['taxes_id', '=', $request->typeTaxes], ['contribuables_id', '=', $request->nom] ])->sum('novembre');
                $dec = taxerecouvre::where([['taxes_id', '=', $request->typeTaxes], ['contribuables_id', '=', $request->nom] ])->sum('decembre');
               
                $taxes = taxerecouvre::where([
                    ['taxes_id', '=', $request->typeTaxes],
                    ['contribuables_id', '=', $request->nom]
                ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')
                ->get();    
                $typeTaxes = taxes::find($request->typeTaxes);

                $titre = $typeTaxes->typeTaxes;

                return view('admin.pages.etat.taxes.view-filter-result', compact('jan','fev','mar','avr','mai','juin','juil','aou','sep'
                ,'oct','nov','dec','total_taxe_mensuelle','total_taxe_annuelle', 'taxes', 'titre'));
            }      
            
        }
        elseif(!isset($request->typeTaxes) && !isset($request->zone) &&  isset($request->annee)  && isset($request->nom)  && !isset($request->activite) && !isset($request->collecteur))
        {
            if (isset($request->pdf)) 
            {
                $total_taxe_mensuelle = taxerecouvre::where([ ["exercice", "=", $request->annee],  ['contribuables_id', '=', $request->nom]])->sum('taxemensuelle');
                $total_taxe_annuelle = taxerecouvre::where([ ["exercice", "=", $request->annee], ['contribuables_id', '=', $request->nom]])->sum('taxeannuelle');
                $jan = taxerecouvre::where([ ["exercice", "=", $request->annee], ['contribuables_id', '=', $request->nom]])->sum('janvier');
                $fev = taxerecouvre::where([ ["exercice", "=", $request->annee], ['contribuables_id', '=', $request->nom]])->sum('fevrier');
                $mar = taxerecouvre::where([ ["exercice", "=", $request->annee], ['contribuables_id', '=', $request->nom]])->sum('mars');
                $avr = taxerecouvre::where([ ["exercice", "=", $request->annee], ['contribuables_id', '=', $request->nom]])->sum('avril');
                $mai = taxerecouvre::where([ ["exercice", "=", $request->annee], ['contribuables_id', '=', $request->nom]])->sum('mai');
                $juin = taxerecouvre::where([ ["exercice", "=", $request->annee], ['contribuables_id', '=', $request->nom]])->sum('juin');
                $juil = taxerecouvre::where([ ["exercice", "=", $request->annee], ['contribuables_id', '=', $request->nom]])->sum('juillet');
                $aou = taxerecouvre::where([ ["exercice", "=", $request->annee], ['contribuables_id', '=', $request->nom]])->sum('aout');
                $sep = taxerecouvre::where([ ["exercice", "=", $request->annee], ['contribuables_id', '=', $request->nom]])->sum('septembre');
                $oct = taxerecouvre::where([ ["exercice", "=", $request->annee], ['contribuables_id', '=', $request->nom]])->sum('octobre');
                $nov = taxerecouvre::where([ ["exercice", "=", $request->annee], ['contribuables_id', '=', $request->nom]])->sum('novembre');
                $dec = taxerecouvre::where([ ["exercice", "=", $request->annee], ['contribuables_id', '=', $request->nom]])->sum('decembre');
               
                $exercice__ = $request->annee;
                $taxes = taxerecouvre::where([
                    ['exercice', '=', $request->annee],
                    ['contribuables_id', '=', $request->nom]
                ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')
                ->get(); 
                
                $titre = "Liste des taxes";

                $pdf = PDF::loadView('admin.pages.etat.taxes.myPDF', compact('jan','fev','mar','avr','mai','juin','juil','aou','sep'
                ,'oct','exercice__','nov','dec','total_taxe_mensuelle','total_taxe_annuelle', 'taxes', 'titre'))->setPaper('a4','landscape');    
                return $pdf->stream();
            }
            else
            {
                
                $total_taxe_mensuelle = taxerecouvre::where([ ["exercice", "=", $request->annee],  ['contribuables_id', '=', $request->nom]])->sum('taxemensuelle');
                $total_taxe_annuelle = taxerecouvre::where([ ["exercice", "=", $request->annee], ['contribuables_id', '=', $request->nom]])->sum('taxeannuelle');
                $jan = taxerecouvre::where([ ["exercice", "=", $request->annee], ['contribuables_id', '=', $request->nom]])->sum('janvier');
                $fev = taxerecouvre::where([ ["exercice", "=", $request->annee], ['contribuables_id', '=', $request->nom]])->sum('fevrier');
                $mar = taxerecouvre::where([ ["exercice", "=", $request->annee], ['contribuables_id', '=', $request->nom]])->sum('mars');
                $avr = taxerecouvre::where([ ["exercice", "=", $request->annee], ['contribuables_id', '=', $request->nom]])->sum('avril');
                $mai = taxerecouvre::where([ ["exercice", "=", $request->annee], ['contribuables_id', '=', $request->nom]])->sum('mai');
                $juin = taxerecouvre::where([ ["exercice", "=", $request->annee], ['contribuables_id', '=', $request->nom]])->sum('juin');
                $juil = taxerecouvre::where([ ["exercice", "=", $request->annee], ['contribuables_id', '=', $request->nom]])->sum('juillet');
                $aou = taxerecouvre::where([ ["exercice", "=", $request->annee], ['contribuables_id', '=', $request->nom]])->sum('aout');
                $sep = taxerecouvre::where([ ["exercice", "=", $request->annee], ['contribuables_id', '=', $request->nom]])->sum('septembre');
                $oct = taxerecouvre::where([ ["exercice", "=", $request->annee], ['contribuables_id', '=', $request->nom]])->sum('octobre');
                $nov = taxerecouvre::where([ ["exercice", "=", $request->annee], ['contribuables_id', '=', $request->nom]])->sum('novembre');
                $dec = taxerecouvre::where([ ["exercice", "=", $request->annee], ['contribuables_id', '=', $request->nom]])->sum('decembre');
               
                $exercice__ = $request->annee;
                $taxes = taxerecouvre::where([
                    ['exercice', '=', $request->annee],
                    ['contribuables_id', '=', $request->nom]
                ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')
                ->get(); 
                
                $titre = "Liste des taxes";
                return view('admin.pages.etat.taxes.view-filter-result', compact('jan','fev','mar','avr','mai','juin','juil','aou','sep'
                ,'oct','nov','dec','total_taxe_mensuelle','total_taxe_annuelle', 'taxes', 'titre'));
            }      
            
        }
        elseif(!isset($request->typeTaxes) && !isset($request->zone) &&  isset($request->annee)  && !isset($request->nom) && isset($request->activite) && !isset($request->collecteur))
        {
            if (isset($request->pdf)) 
            {
                
                $total_taxe_mensuelle = taxerecouvre::where([ ["exercice", "=", $request->annee], ['activites_id', '=', $request->activite] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')->sum('taxemensuelle');
                $total_taxe_annuelle = taxerecouvre::where([ ["exercice", "=", $request->annee], ['activites_id', '=', $request->activite] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')->sum('taxeannuelle');
                $jan = taxerecouvre::where([ ["exercice", "=", $request->annee], ['activites_id', '=', $request->activite] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')->sum('janvier');
                $fev = taxerecouvre::where([ ["exercice", "=", $request->annee], ['activites_id', '=', $request->activite] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')->sum('fevrier');
                $mar = taxerecouvre::where([ ["exercice", "=", $request->annee], ['activites_id', '=', $request->activite] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')->sum('mars');
                $avr = taxerecouvre::where([ ["exercice", "=", $request->annee], ['activites_id', '=', $request->activite] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')->sum('avril');
                $mai = taxerecouvre::where([ ["exercice", "=", $request->annee], ['activites_id', '=', $request->activite] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')->sum('mai');
                $juin = taxerecouvre::where([ ["exercice", "=", $request->annee], ['activites_id', '=', $request->activite] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')->sum('juin');
                $juil = taxerecouvre::where([ ["exercice", "=", $request->annee], ['activites_id', '=', $request->activite] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')->sum('juillet');
                $aou = taxerecouvre::where([ ["exercice", "=", $request->annee], ['activites_id', '=', $request->activite] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')->sum('aout');
                $sep = taxerecouvre::where([ ["exercice", "=", $request->annee], ['activites_id', '=', $request->activite] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')->sum('septembre');
                $oct = taxerecouvre::where([ ["exercice", "=", $request->annee], ['activites_id', '=', $request->activite] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')->sum('octobre');
                $nov = taxerecouvre::where([ ["exercice", "=", $request->annee], ['activites_id', '=', $request->activite] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')->sum('novembre');
                $dec = taxerecouvre::where([ ["exercice", "=", $request->annee], ['activites_id', '=', $request->activite] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')->sum('decembre');
                
                $taxes = taxerecouvre::where([
                    ['activites_id', '=', $request->activite],
                    ['exercice', '=', $request->annee]
                ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')
                ->get();                

                $titre = "Taxe par activité";
                                    
                $pdf = PDF::loadView('admin.pages.etat.taxes.myPDF',  compact('jan','fev','mar','avr','mai','juin','juil','aou','sep'
                ,'oct','nov','dec','total_taxe_mensuelle','total_taxe_annuelle', 'taxes', 'titre'))->setPaper('a4','landscape');    
                return $pdf->stream();
            }
            else
            {
                $total_taxe_mensuelle = taxerecouvre::where([ ["exercice", "=", $request->annee], ['activites_id', '=', $request->activite] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')->sum('taxemensuelle');
                $total_taxe_annuelle = taxerecouvre::where([ ["exercice", "=", $request->annee], ['activites_id', '=', $request->activite] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')->sum('taxeannuelle');
                $jan = taxerecouvre::where([ ["exercice", "=", $request->annee], ['activites_id', '=', $request->activite] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')->sum('janvier');
                $fev = taxerecouvre::where([ ["exercice", "=", $request->annee], ['activites_id', '=', $request->activite] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')->sum('fevrier');
                $mar = taxerecouvre::where([ ["exercice", "=", $request->annee], ['activites_id', '=', $request->activite] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')->sum('mars');
                $avr = taxerecouvre::where([ ["exercice", "=", $request->annee], ['activites_id', '=', $request->activite] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')->sum('avril');
                $mai = taxerecouvre::where([ ["exercice", "=", $request->annee], ['activites_id', '=', $request->activite] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')->sum('mai');
                $juin = taxerecouvre::where([ ["exercice", "=", $request->annee], ['activites_id', '=', $request->activite] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')->sum('juin');
                $juil = taxerecouvre::where([ ["exercice", "=", $request->annee], ['activites_id', '=', $request->activite] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')->sum('juillet');
                $aou = taxerecouvre::where([ ["exercice", "=", $request->annee], ['activites_id', '=', $request->activite] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')->sum('aout');
                $sep = taxerecouvre::where([ ["exercice", "=", $request->annee], ['activites_id', '=', $request->activite] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')->sum('septembre');
                $oct = taxerecouvre::where([ ["exercice", "=", $request->annee], ['activites_id', '=', $request->activite] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')->sum('octobre');
                $nov = taxerecouvre::where([ ["exercice", "=", $request->annee], ['activites_id', '=', $request->activite] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')->sum('novembre');
                $dec = taxerecouvre::where([ ["exercice", "=", $request->annee], ['activites_id', '=', $request->activite] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')->sum('decembre');
                
                $taxes = taxerecouvre::where([
                    ['activites_id', '=', $request->activite],
                    ['exercice', '=', $request->annee]
                ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')
                ->get();                

                $titre = "Taxe par activité";
                return view('admin.pages.etat.taxes.view-filter-result', compact('jan','fev','mar','avr','mai','juin','juil','aou','sep'
                ,'oct','nov','dec','total_taxe_mensuelle','total_taxe_annuelle', 'taxes', 'titre'));
            }      
            
        }
        elseif(!isset($request->typeTaxes) && !isset($request->zone) &&  isset($request->annee)  && !isset($request->nom) && !isset($request->activite) && isset($request->collecteur))
        {
            if (isset($request->pdf)) 
            {
                $total_taxe_mensuelle = taxerecouvre::where([ ["exercice", "=", $request->annee], ['zones_id', '=', $request->collecteur] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')
                ->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')->sum('taxemensuelle');
                $total_taxe_annuelle = taxerecouvre::where([ ["exercice", "=", $request->annee], ['zones_id', '=', $request->collecteur] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')
                ->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')->sum('taxeannuelle');
                $jan = taxerecouvre::where([ ["exercice", "=", $request->annee], ['zones_id', '=', $request->collecteur] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')
                ->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')->sum('janvier');
                $fev = taxerecouvre::where([ ["exercice", "=", $request->annee], ['zones_id', '=', $request->collecteur] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')
                ->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')->sum('fevrier');
                $mar = taxerecouvre::where([ ["exercice", "=", $request->annee], ['zones_id', '=', $request->collecteur] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')
                ->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')->sum('mars');
                $avr = taxerecouvre::where([ ["exercice", "=", $request->annee], ['zones_id', '=', $request->collecteur] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')
                ->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')->sum('avril');
                $mai = taxerecouvre::where([ ["exercice", "=", $request->annee], ['zones_id', '=', $request->collecteur] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')
                ->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')->sum('mai');
                $juin = taxerecouvre::where([ ["exercice", "=", $request->annee], ['zones_id', '=', $request->collecteur] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')
                ->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')->sum('juin');
                $juil = taxerecouvre::where([ ["exercice", "=", $request->annee], ['zones_id', '=', $request->collecteur] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')
                ->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')->sum('juillet');
                $aou = taxerecouvre::where([ ["exercice", "=", $request->annee], ['zones_id', '=', $request->collecteur] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')
                ->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')->sum('aout');
                $sep = taxerecouvre::where([ ["exercice", "=", $request->annee], ['zones_id', '=', $request->collecteur] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')
                ->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')->sum('septembre');
                $oct = taxerecouvre::where([ ["exercice", "=", $request->annee], ['zones_id', '=', $request->collecteur] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')
                ->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')->sum('octobre');
                $nov = taxerecouvre::where([ ["exercice", "=", $request->annee], ['zones_id', '=', $request->collecteur] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')
                ->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')->sum('novembre');
                $dec = taxerecouvre::where([ ["exercice", "=", $request->annee], ['zones_id', '=', $request->collecteur] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')
                ->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')->sum('decembre');
                
                $taxes = taxerecouvre::where([
                    ['zones_id', '=', $request->collecteur],
                    ['exercice', '=', $request->annee]
                ])->join('contribuables', 'taxerecouvres.contribuables_id', '=',
                 'contribuables.id')->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')
                ->get();
        
                $exercice__ = $request->annee;
                $titre = $taxes[0]->nomcollecteur." ".$taxes[0]->prenomcollecteur;

                $pdf = PDF::loadView('admin.pages.etat.taxes.myPDF',  compact('jan','fev','mar','avr','mai','juin','juil','aou','sep'
                ,'oct','nov','exercice__','dec','total_taxe_mensuelle','total_taxe_annuelle', 'taxes', 'titre'))->setPaper('a4','landscape');    
                return $pdf->stream();
            }
            else
            {
                $total_taxe_mensuelle = taxerecouvre::where([ ["exercice", "=", $request->annee], ['zones_id', '=', $request->collecteur] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')
                ->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')->sum('taxemensuelle');
                $total_taxe_annuelle = taxerecouvre::where([ ["exercice", "=", $request->annee], ['zones_id', '=', $request->collecteur] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')
                ->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')->sum('taxeannuelle');
                $jan = taxerecouvre::where([ ["exercice", "=", $request->annee], ['zones_id', '=', $request->collecteur] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')
                ->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')->sum('janvier');
                $fev = taxerecouvre::where([ ["exercice", "=", $request->annee], ['zones_id', '=', $request->collecteur] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')
                ->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')->sum('fevrier');
                $mar = taxerecouvre::where([ ["exercice", "=", $request->annee], ['zones_id', '=', $request->collecteur] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')
                ->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')->sum('mars');
                $avr = taxerecouvre::where([ ["exercice", "=", $request->annee], ['zones_id', '=', $request->collecteur] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')
                ->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')->sum('avril');
                $mai = taxerecouvre::where([ ["exercice", "=", $request->annee], ['zones_id', '=', $request->collecteur] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')
                ->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')->sum('mai');
                $juin = taxerecouvre::where([ ["exercice", "=", $request->annee], ['zones_id', '=', $request->collecteur] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')
                ->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')->sum('juin');
                $juil = taxerecouvre::where([ ["exercice", "=", $request->annee], ['zones_id', '=', $request->collecteur] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')
                ->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')->sum('juillet');
                $aou = taxerecouvre::where([ ["exercice", "=", $request->annee], ['zones_id', '=', $request->collecteur] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')
                ->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')->sum('aout');
                $sep = taxerecouvre::where([ ["exercice", "=", $request->annee], ['zones_id', '=', $request->collecteur] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')
                ->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')->sum('septembre');
                $oct = taxerecouvre::where([ ["exercice", "=", $request->annee], ['zones_id', '=', $request->collecteur] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')
                ->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')->sum('octobre');
                $nov = taxerecouvre::where([ ["exercice", "=", $request->annee], ['zones_id', '=', $request->collecteur] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')
                ->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')->sum('novembre');
                $dec = taxerecouvre::where([ ["exercice", "=", $request->annee], ['zones_id', '=', $request->collecteur] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=', 'contribuables.id')
                ->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')->sum('decembre');
                
                $taxes = taxerecouvre::where([
                    ['zones_id', '=', $request->collecteur],
                    ['exercice', '=', $request->annee]
                ])->join('contribuables', 'taxerecouvres.contribuables_id', '=',
                 'contribuables.id')->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')
                ->get();
        
                $exercice__ = $request->annee;
                $titre = $taxes[0]->nomcollecteur." ".$taxes[0]->prenomcollecteur;
                return view('admin.pages.etat.taxes.view-filter-result', compact('jan','fev','mar','avr','mai','juin','juil','aou','sep'
                ,'oct','nov','exercice__','dec','total_taxe_mensuelle','total_taxe_annuelle', 'taxes', 'titre'));
            }                  
        }
        //**********************************************************************************/

        elseif(isset($request->zone) && !isset($request->typeTaxes) && !isset($request->annee)  && !isset($request->nom) && !isset($request->activite) && !isset($request->collecteur))
        {
            if (isset($request->pdf)) 
            {           

                $total_taxe_mensuelle = taxerecouvre::where([ ['zones_id', '=', $request->zone] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=',
                 'contribuables.id')->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')
                ->sum('taxemensuelle');
                $total_taxe_annuelle = taxerecouvre::where([ ['zones_id', '=', $request->zone] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=',
                 'contribuables.id')->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')
                ->sum('taxeannuelle');
                $jan = taxerecouvre::where([ ['zones_id', '=', $request->zone] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=',
                 'contribuables.id')->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')
                ->sum('janvier');
                $fev = taxerecouvre::where([ ['zones_id', '=', $request->zone] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=',
                 'contribuables.id')->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')
                ->sum('fevrier');
                $mar = taxerecouvre::where([ ['zones_id', '=', $request->zone] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=',
                 'contribuables.id')->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')
                ->sum('mars');
                $avr = taxerecouvre::where([ ['zones_id', '=', $request->zone] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=',
                 'contribuables.id')->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')
                ->sum('avril');
                $mai = taxerecouvre::where([ ['zones_id', '=', $request->zone] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=',
                 'contribuables.id')->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')
                ->sum('mai');
                $juin = taxerecouvre::where([ ['zones_id', '=', $request->zone] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=',
                 'contribuables.id')->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')
                ->sum('juin');
                $juil = taxerecouvre::where([ ['zones_id', '=', $request->zone] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=',
                 'contribuables.id')->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')
                ->sum('juillet');
                $aou = taxerecouvre::where([ ['zones_id', '=', $request->zone] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=',
                 'contribuables.id')->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')
                ->sum('aout');
                $sep = taxerecouvre::where([ ['zones_id', '=', $request->zone] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=',
                 'contribuables.id')->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')
                ->sum('septembre');
                $oct = taxerecouvre::where([ ['zones_id', '=', $request->zone] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=',
                 'contribuables.id')->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')
                ->sum('octobre');
                $nov = taxerecouvre::where([ ['zones_id', '=', $request->zone] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=',
                 'contribuables.id')->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')
                ->sum('novembre');
                $dec = taxerecouvre::where([ ['zones_id', '=', $request->zone] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=',
                 'contribuables.id')->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')
                ->sum('decembre');
                
                $taxes = taxerecouvre::orderBy('nom', 'asc')->where([
                    ['zones_id', '=', $request->zone],
                ])->join('contribuables', 'taxerecouvres.contribuables_id', '=',
                 'contribuables.id')->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')
                ->get();

                
                $exercice__ = $request->annee;
                $titre = zone::findOrfail($taxes[0]->zones_id);
                $titre = $titre->nom;

                $pdf = PDF::loadView('admin.pages.etat.taxes.myPDF',  compact('jan','fev','mar','avr','mai','juin','juil','aou','sep'
                ,'oct','nov','exercice__','dec','total_taxe_mensuelle','total_taxe_annuelle', 'taxes', 'titre'))->setPaper('a4','landscape');    
                return $pdf->stream();
            }
            else
            {
                $total_taxe_mensuelle = taxerecouvre::where([ ['zones_id', '=', $request->zone] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=',
                 'contribuables.id')->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')
                ->sum('taxemensuelle');
                $total_taxe_annuelle = taxerecouvre::where([ ['zones_id', '=', $request->zone] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=',
                 'contribuables.id')->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')
                ->sum('taxeannuelle');
                $jan = taxerecouvre::where([ ['zones_id', '=', $request->zone] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=',
                 'contribuables.id')->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')
                ->sum('janvier');
                $fev = taxerecouvre::where([ ['zones_id', '=', $request->zone] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=',
                 'contribuables.id')->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')
                ->sum('fevrier');
                $mar = taxerecouvre::where([ ['zones_id', '=', $request->zone] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=',
                 'contribuables.id')->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')
                ->sum('mars');
                $avr = taxerecouvre::where([ ['zones_id', '=', $request->zone] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=',
                 'contribuables.id')->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')
                ->sum('avril');
                $mai = taxerecouvre::where([ ['zones_id', '=', $request->zone] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=',
                 'contribuables.id')->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')
                ->sum('mai');
                $juin = taxerecouvre::where([ ['zones_id', '=', $request->zone] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=',
                 'contribuables.id')->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')
                ->sum('juin');
                $juil = taxerecouvre::where([ ['zones_id', '=', $request->zone] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=',
                 'contribuables.id')->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')
                ->sum('juillet');
                $aou = taxerecouvre::where([ ['zones_id', '=', $request->zone] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=',
                 'contribuables.id')->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')
                ->sum('aout');
                $sep = taxerecouvre::where([ ['zones_id', '=', $request->zone] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=',
                 'contribuables.id')->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')
                ->sum('septembre');
                $oct = taxerecouvre::where([ ['zones_id', '=', $request->zone] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=',
                 'contribuables.id')->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')
                ->sum('octobre');
                $nov = taxerecouvre::where([ ['zones_id', '=', $request->zone] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=',
                 'contribuables.id')->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')
                ->sum('novembre');
                $dec = taxerecouvre::where([ ['zones_id', '=', $request->zone] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=',
                 'contribuables.id')->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')
                ->sum('decembre');
                
                $taxes = taxerecouvre::orderBy('nom', 'asc')->where([
                    ['zones_id', '=', $request->zone],
                ])->join('contribuables', 'taxerecouvres.contribuables_id', '=',
                 'contribuables.id')->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')
                ->get();

                
                $exercice__ = $request->annee;
                $titre = zone::findOrfail($taxes[0]->zones_id);
                $titre = $titre->nom;

                return view('admin.pages.etat.taxes.view-filter-result', compact('jan','fev','mar','avr','mai','juin','juil','aou','sep'
                ,'oct','nov','exercice__','dec','total_taxe_mensuelle','total_taxe_annuelle', 'taxes', 'titre'));
            }                  
        }
        //**********************************************************************************/
        elseif(isset($request->zone) && isset($request->typeTaxes) && !isset($request->annee)  && !isset($request->nom) && !isset($request->activite) && !isset($request->collecteur))
        {
            if (isset($request->pdf)) 
            {           
                $total_taxe_mensuelle = taxerecouvre::where([ ['zones_id', '=', $request->zone], ['taxes_id', '=', $request->typeTaxes] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=',
                 'contribuables.id')->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')
                ->sum('taxemensuelle');
                $total_taxe_annuelle = taxerecouvre::where([ ['zones_id', '=', $request->zone], ['taxes_id', '=', $request->typeTaxes] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=',
                 'contribuables.id')->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')
                ->sum('taxeannuelle');
                $jan = taxerecouvre::where([ ['zones_id', '=', $request->zone], ['taxes_id', '=', $request->typeTaxes]])->join('contribuables', 'taxerecouvres.contribuables_id', '=',
                 'contribuables.id')->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')
                ->sum('janvier');
                $fev = taxerecouvre::where([ ['zones_id', '=', $request->zone], ['taxes_id', '=', $request->typeTaxes]])->join('contribuables', 'taxerecouvres.contribuables_id', '=',
                 'contribuables.id')->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')
                ->sum('fevrier');
                $mar = taxerecouvre::where([ ['zones_id', '=', $request->zone], ['taxes_id', '=', $request->typeTaxes]])->join('contribuables', 'taxerecouvres.contribuables_id', '=',
                 'contribuables.id')->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')
                ->sum('mars');
                $avr = taxerecouvre::where([ ['zones_id', '=', $request->zone], ['taxes_id', '=', $request->typeTaxes]])->join('contribuables', 'taxerecouvres.contribuables_id', '=',
                 'contribuables.id')->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')
                ->sum('avril');
                $mai = taxerecouvre::where([ ['zones_id', '=', $request->zone], ['taxes_id', '=', $request->typeTaxes]])->join('contribuables', 'taxerecouvres.contribuables_id', '=',
                 'contribuables.id')->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')
                ->sum('mai');
                $juin = taxerecouvre::where([ ['zones_id', '=', $request->zone], ['taxes_id', '=', $request->typeTaxes]])->join('contribuables', 'taxerecouvres.contribuables_id', '=',
                 'contribuables.id')->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')
                ->sum('juin');
                $juil = taxerecouvre::where([ ['zones_id', '=', $request->zone], ['taxes_id', '=', $request->typeTaxes]])->join('contribuables', 'taxerecouvres.contribuables_id', '=',
                 'contribuables.id')->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')
                ->sum('juillet');
                $aou = taxerecouvre::where([ ['zones_id', '=', $request->zone], ['taxes_id', '=', $request->typeTaxes]])->join('contribuables', 'taxerecouvres.contribuables_id', '=',
                 'contribuables.id')->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')
                ->sum('aout');
                $sep = taxerecouvre::where([ ['zones_id', '=', $request->zone], ['taxes_id', '=', $request->typeTaxes]])->join('contribuables', 'taxerecouvres.contribuables_id', '=',
                 'contribuables.id')->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')
                ->sum('septembre');
                $oct = taxerecouvre::where([ ['zones_id', '=', $request->zone], ['taxes_id', '=', $request->typeTaxes]])->join('contribuables', 'taxerecouvres.contribuables_id', '=',
                 'contribuables.id')->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')
                ->sum('octobre');
                $nov = taxerecouvre::where([ ['zones_id', '=', $request->zone], ['taxes_id', '=', $request->typeTaxes]])->join('contribuables', 'taxerecouvres.contribuables_id', '=',
                 'contribuables.id')->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')
                ->sum('novembre');
                $dec = taxerecouvre::where([ ['zones_id', '=', $request->zone], ['taxes_id', '=', $request->typeTaxes]])->join('contribuables', 'taxerecouvres.contribuables_id', '=',
                 'contribuables.id')->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')
                ->sum('decembre');
                
                $taxes = taxerecouvre::orderBy('nom', 'asc')->where([
                    ['zones_id', '=', $request->zone],
                    ['taxes_id', '=', $request->typeTaxes]
                ])->join('contribuables', 'taxerecouvres.contribuables_id', '=',
                 'contribuables.id')->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')
                ->get();
                
                $exercice__ = $request->annee;
                $titre = zone::findOrfail($taxes[0]->zones_id);
                $titre = $titre->nom;

                $pdf = PDF::loadView('admin.pages.etat.taxes.myPDF',  compact('jan','fev','mar','avr','mai','juin','juil','aou','sep'
                ,'oct','nov','exercice__','dec','total_taxe_mensuelle','total_taxe_annuelle', 'taxes', 'titre'))->setPaper('a4','landscape');    
                return $pdf->stream();
            }
            else
            {
                $total_taxe_mensuelle = taxerecouvre::where([ ['zones_id', '=', $request->zone] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=',
                'contribuables.id')->join('collecteurs', 'contribuables.zones_id', '=',
                'collecteurs.id')
               ->sum('taxemensuelle');
               $total_taxe_annuelle = taxerecouvre::where([ ['zones_id', '=', $request->zone], ['taxes_id', '=', $request->typeTaxes] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=',
                'contribuables.id')->join('collecteurs', 'contribuables.zones_id', '=',
                'collecteurs.id')
               ->sum('taxeannuelle');
               $jan = taxerecouvre::where([ ['zones_id', '=', $request->zone], ['taxes_id', '=', $request->typeTaxes]])->join('contribuables', 'taxerecouvres.contribuables_id', '=',
                'contribuables.id')->join('collecteurs', 'contribuables.zones_id', '=',
                'collecteurs.id')
               ->sum('janvier');
               $fev = taxerecouvre::where([ ['zones_id', '=', $request->zone], ['taxes_id', '=', $request->typeTaxes]])->join('contribuables', 'taxerecouvres.contribuables_id', '=',
                'contribuables.id')->join('collecteurs', 'contribuables.zones_id', '=',
                'collecteurs.id')
               ->sum('fevrier');
               $mar = taxerecouvre::where([ ['zones_id', '=', $request->zone], ['taxes_id', '=', $request->typeTaxes]])->join('contribuables', 'taxerecouvres.contribuables_id', '=',
                'contribuables.id')->join('collecteurs', 'contribuables.zones_id', '=',
                'collecteurs.id')
               ->sum('mars');
               $avr = taxerecouvre::where([ ['zones_id', '=', $request->zone], ['taxes_id', '=', $request->typeTaxes]])->join('contribuables', 'taxerecouvres.contribuables_id', '=',
                'contribuables.id')->join('collecteurs', 'contribuables.zones_id', '=',
                'collecteurs.id')
               ->sum('avril');
               $mai = taxerecouvre::where([ ['zones_id', '=', $request->zone], ['taxes_id', '=', $request->typeTaxes]])->join('contribuables', 'taxerecouvres.contribuables_id', '=',
                'contribuables.id')->join('collecteurs', 'contribuables.zones_id', '=',
                'collecteurs.id')
               ->sum('mai');
               $juin = taxerecouvre::where([ ['zones_id', '=', $request->zone], ['taxes_id', '=', $request->typeTaxes]])->join('contribuables', 'taxerecouvres.contribuables_id', '=',
                'contribuables.id')->join('collecteurs', 'contribuables.zones_id', '=',
                'collecteurs.id')
               ->sum('juin');
               $juil = taxerecouvre::where([ ['zones_id', '=', $request->zone], ['taxes_id', '=', $request->typeTaxes]])->join('contribuables', 'taxerecouvres.contribuables_id', '=',
                'contribuables.id')->join('collecteurs', 'contribuables.zones_id', '=',
                'collecteurs.id')
               ->sum('juillet');
               $aou = taxerecouvre::where([ ['zones_id', '=', $request->zone], ['taxes_id', '=', $request->typeTaxes]])->join('contribuables', 'taxerecouvres.contribuables_id', '=',
                'contribuables.id')->join('collecteurs', 'contribuables.zones_id', '=',
                'collecteurs.id')
               ->sum('aout');
               $sep = taxerecouvre::where([ ['zones_id', '=', $request->zone], ['taxes_id', '=', $request->typeTaxes]])->join('contribuables', 'taxerecouvres.contribuables_id', '=',
                'contribuables.id')->join('collecteurs', 'contribuables.zones_id', '=',
                'collecteurs.id')
               ->sum('septembre');
               $oct = taxerecouvre::where([ ['zones_id', '=', $request->zone], ['taxes_id', '=', $request->typeTaxes]])->join('contribuables', 'taxerecouvres.contribuables_id', '=',
                'contribuables.id')->join('collecteurs', 'contribuables.zones_id', '=',
                'collecteurs.id')
               ->sum('octobre');
               $nov = taxerecouvre::where([ ['zones_id', '=', $request->zone], ['taxes_id', '=', $request->typeTaxes]])->join('contribuables', 'taxerecouvres.contribuables_id', '=',
                'contribuables.id')->join('collecteurs', 'contribuables.zones_id', '=',
                'collecteurs.id')
               ->sum('novembre');
               $dec = taxerecouvre::where([ ['zones_id', '=', $request->zone], ['taxes_id', '=', $request->typeTaxes]])->join('contribuables', 'taxerecouvres.contribuables_id', '=',
                'contribuables.id')->join('collecteurs', 'contribuables.zones_id', '=',
                'collecteurs.id')
               ->sum('decembre');
               
               $taxes = taxerecouvre::orderBy('nom', 'asc')->where([
                   ['zones_id', '=', $request->zone],
                   ['taxes_id', '=', $request->typeTaxes]
               ])->join('contribuables', 'taxerecouvres.contribuables_id', '=',
                'contribuables.id')->join('collecteurs', 'contribuables.zones_id', '=',
                'collecteurs.id')
               ->get();

                
                $exercice__ = $request->annee;
                $titre = zone::findOrfail($taxes[0]->zones_id);
                $titre = $titre->nom;

                return view('admin.pages.etat.taxes.view-filter-result', compact('jan','fev','mar','avr','mai','juin','juil','aou','sep'
                ,'oct','nov','exercice__','dec','total_taxe_mensuelle','total_taxe_annuelle', 'taxes', 'titre'));
            }                  
        }       
        //**********************************************************************************/
        elseif(isset($request->zone) && !isset($request->typeTaxes) && isset($request->annee)  && !isset($request->nom) && !isset($request->activite) && !isset($request->collecteur))
        {
            if (isset($request->pdf)) 
            {           
                $total_taxe_mensuelle = taxerecouvre::where([ ['zones_id', '=', $request->zone], ['exercice', '=', $request->annee] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=',
                 'contribuables.id')->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')
                ->sum('taxemensuelle');
                $total_taxe_annuelle = taxerecouvre::where([ ['zones_id', '=', $request->zone], ['exercice', '=', $request->annee] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=',
                 'contribuables.id')->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')
                ->sum('taxeannuelle');
                $jan = taxerecouvre::where([ ['zones_id', '=', $request->zone], ['exercice', '=', $request->annee]])->join('contribuables', 'taxerecouvres.contribuables_id', '=',
                 'contribuables.id')->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')
                ->sum('janvier');
                $fev = taxerecouvre::where([ ['zones_id', '=', $request->zone], ['exercice', '=', $request->annee]])->join('contribuables', 'taxerecouvres.contribuables_id', '=',
                 'contribuables.id')->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')
                ->sum('fevrier');
                $mar = taxerecouvre::where([ ['zones_id', '=', $request->zone], ['exercice', '=', $request->annee]])->join('contribuables', 'taxerecouvres.contribuables_id', '=',
                 'contribuables.id')->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')
                ->sum('mars');
                $avr = taxerecouvre::where([ ['zones_id', '=', $request->zone], ['exercice', '=', $request->annee]])->join('contribuables', 'taxerecouvres.contribuables_id', '=',
                 'contribuables.id')->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')
                ->sum('avril');
                $mai = taxerecouvre::where([ ['zones_id', '=', $request->zone], ['exercice', '=', $request->annee]])->join('contribuables', 'taxerecouvres.contribuables_id', '=',
                 'contribuables.id')->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')
                ->sum('mai');
                $juin = taxerecouvre::where([ ['zones_id', '=', $request->zone], ['exercice', '=', $request->annee]])->join('contribuables', 'taxerecouvres.contribuables_id', '=',
                 'contribuables.id')->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')
                ->sum('juin');
                $juil = taxerecouvre::where([ ['zones_id', '=', $request->zone], ['exercice', '=', $request->annee]])->join('contribuables', 'taxerecouvres.contribuables_id', '=',
                 'contribuables.id')->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')
                ->sum('juillet');
                $aou = taxerecouvre::where([ ['zones_id', '=', $request->zone], ['exercice', '=', $request->annee]])->join('contribuables', 'taxerecouvres.contribuables_id', '=',
                 'contribuables.id')->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')
                ->sum('aout');
                $sep = taxerecouvre::where([ ['zones_id', '=', $request->zone], ['exercice', '=', $request->annee]])->join('contribuables', 'taxerecouvres.contribuables_id', '=',
                 'contribuables.id')->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')
                ->sum('septembre');
                $oct = taxerecouvre::where([ ['zones_id', '=', $request->zone], ['exercice', '=', $request->annee]])->join('contribuables', 'taxerecouvres.contribuables_id', '=',
                 'contribuables.id')->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')
                ->sum('octobre');
                $nov = taxerecouvre::where([ ['zones_id', '=', $request->zone], ['exercice', '=', $request->annee]])->join('contribuables', 'taxerecouvres.contribuables_id', '=',
                 'contribuables.id')->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')
                ->sum('novembre');
                $dec = taxerecouvre::where([ ['zones_id', '=', $request->zone], ['exercice', '=', $request->annee]])->join('contribuables', 'taxerecouvres.contribuables_id', '=',
                 'contribuables.id')->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')
                ->sum('decembre');
                
                $taxes = taxerecouvre::orderBy('nom', 'asc')->where([
                    ['zones_id', '=', $request->zone],
                    ['exercice', '=', $request->annee]
                ])->join('contribuables', 'taxerecouvres.contribuables_id', '=',
                 'contribuables.id')->join('collecteurs', 'contribuables.zones_id', '=',
                 'collecteurs.id')
                ->get();
                
                $exercice__ = $request->annee;
                $titre = zone::findOrfail($taxes[0]->zones_id);
                $titre = $titre->nom;

                $pdf = PDF::loadView('admin.pages.etat.taxes.myPDF',  compact('jan','fev','mar','avr','mai','juin','juil','aou','sep'
                ,'oct','nov','exercice__','dec','total_taxe_mensuelle','total_taxe_annuelle', 'taxes', 'titre'))->setPaper('a4','landscape');    
                return $pdf->stream();
            }
            else
            {
                $total_taxe_mensuelle = taxerecouvre::where([ ['zones_id', '=', $request->zone], ['exercice', '=', $request->annee] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=',
                'contribuables.id')->join('collecteurs', 'contribuables.zones_id', '=',
                'collecteurs.id')
               ->sum('taxemensuelle');
               $total_taxe_annuelle = taxerecouvre::where([ ['zones_id', '=', $request->zone], ['exercice', '=', $request->annee] ])->join('contribuables', 'taxerecouvres.contribuables_id', '=',
                'contribuables.id')->join('collecteurs', 'contribuables.zones_id', '=',
                'collecteurs.id')
               ->sum('taxeannuelle');
               $jan = taxerecouvre::where([ ['zones_id', '=', $request->zone], ['exercice', '=', $request->annee]])->join('contribuables', 'taxerecouvres.contribuables_id', '=',
                'contribuables.id')->join('collecteurs', 'contribuables.zones_id', '=',
                'collecteurs.id')
               ->sum('janvier');
               $fev = taxerecouvre::where([ ['zones_id', '=', $request->zone], ['exercice', '=', $request->annee]])->join('contribuables', 'taxerecouvres.contribuables_id', '=',
                'contribuables.id')->join('collecteurs', 'contribuables.zones_id', '=',
                'collecteurs.id')
               ->sum('fevrier');
               $mar = taxerecouvre::where([ ['zones_id', '=', $request->zone], ['exercice', '=', $request->annee]])->join('contribuables', 'taxerecouvres.contribuables_id', '=',
                'contribuables.id')->join('collecteurs', 'contribuables.zones_id', '=',
                'collecteurs.id')
               ->sum('mars');
               $avr = taxerecouvre::where([ ['zones_id', '=', $request->zone], ['exercice', '=', $request->annee]])->join('contribuables', 'taxerecouvres.contribuables_id', '=',
                'contribuables.id')->join('collecteurs', 'contribuables.zones_id', '=',
                'collecteurs.id')
               ->sum('avril');
               $mai = taxerecouvre::where([ ['zones_id', '=', $request->zone], ['exercice', '=', $request->annee]])->join('contribuables', 'taxerecouvres.contribuables_id', '=',
                'contribuables.id')->join('collecteurs', 'contribuables.zones_id', '=',
                'collecteurs.id')
               ->sum('mai');
               $juin = taxerecouvre::where([ ['zones_id', '=', $request->zone], ['exercice', '=', $request->annee]])->join('contribuables', 'taxerecouvres.contribuables_id', '=',
                'contribuables.id')->join('collecteurs', 'contribuables.zones_id', '=',
                'collecteurs.id')
               ->sum('juin');
               $juil = taxerecouvre::where([ ['zones_id', '=', $request->zone], ['exercice', '=', $request->annee]])->join('contribuables', 'taxerecouvres.contribuables_id', '=',
                'contribuables.id')->join('collecteurs', 'contribuables.zones_id', '=',
                'collecteurs.id')
               ->sum('juillet');
               $aou = taxerecouvre::where([ ['zones_id', '=', $request->zone], ['exercice', '=', $request->annee]])->join('contribuables', 'taxerecouvres.contribuables_id', '=',
                'contribuables.id')->join('collecteurs', 'contribuables.zones_id', '=',
                'collecteurs.id')
               ->sum('aout');
               $sep = taxerecouvre::where([ ['zones_id', '=', $request->zone], ['exercice', '=', $request->annee]])->join('contribuables', 'taxerecouvres.contribuables_id', '=',
                'contribuables.id')->join('collecteurs', 'contribuables.zones_id', '=',
                'collecteurs.id')
               ->sum('septembre');
               $oct = taxerecouvre::where([ ['zones_id', '=', $request->zone], ['exercice', '=', $request->annee]])->join('contribuables', 'taxerecouvres.contribuables_id', '=',
                'contribuables.id')->join('collecteurs', 'contribuables.zones_id', '=',
                'collecteurs.id')
               ->sum('octobre');
               $nov = taxerecouvre::where([ ['zones_id', '=', $request->zone], ['exercice', '=', $request->annee]])->join('contribuables', 'taxerecouvres.contribuables_id', '=',
                'contribuables.id')->join('collecteurs', 'contribuables.zones_id', '=',
                'collecteurs.id')
               ->sum('novembre');
               $dec = taxerecouvre::where([ ['zones_id', '=', $request->zone], ['exercice', '=', $request->annee]])->join('contribuables', 'taxerecouvres.contribuables_id', '=',
                'contribuables.id')->join('collecteurs', 'contribuables.zones_id', '=',
                'collecteurs.id')
               ->sum('decembre');
               
               $taxes = taxerecouvre::orderBy('nom', 'asc')->where([
                   ['zones_id', '=', $request->zone],
                   ['exercice', '=', $request->annee]
               ])->join('contribuables', 'taxerecouvres.contribuables_id', '=',
                'contribuables.id')->join('collecteurs', 'contribuables.zones_id', '=',
                'collecteurs.id')
               ->get();

                
                $exercice__ = $request->annee;
                $titre = zone::findOrfail($taxes[0]->zones_id);
                $titre = $titre->nom;

                return view('admin.pages.etat.taxes.view-filter-result', compact('jan','fev','mar','avr','mai','juin','juil','aou','sep'
                ,'oct','nov','exercice__','dec','total_taxe_mensuelle','total_taxe_annuelle', 'taxes', 'titre'));
            }                  
        }  
        else
        {
            return back()->with('error1', 'Requête Invalide');
        }
        
    }     
    
    }

