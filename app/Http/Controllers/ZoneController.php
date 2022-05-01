<?php

namespace App\Http\Controllers;

use App\Models\collecteur;
use App\Models\zone;
use Illuminate\Http\Request;

class ZoneController extends Controller
{
    public function index()
    {
        $zone_items = zone::orderBy("nom", "asc")->get();
        return view('admin.pages.zones.view-zone', compact('zone_items'));
    }
    public function add()
    {
        $zones = zone::all();
        $collecteurs = collecteur::all();
        return view('admin.pages.zones.add-zone', compact('zones', 'collecteurs'));
    }
    public function edit(zone $zone)
    {
        $collecteurs = collecteur::all();
        return view('admin.pages.zones.edit-zone', compact('zone', 'collecteurs'));
    }
    public function update(Request $request, zone $zone)
    {   

        $validated = $request->validate([
            "nom" => "required",
            "collecteurs_id" => "required",
        ]);


        $zone->update([
            "nom" => $request->nom,
            "collecteurs_id" => $request->collecteurs_id,
        ]);        
        return back()->with('succesUpdate', 'Modification effectué avec succès');
    }
    
    public function savezone(Request $request)
    {
        $validated = $request->validate([
            "nom" => "required",
            "collecteurs_id" => "required",
        ]);
        if ( zone::where([ ['nom', '=', $request->nom] ])->exists() ) 
        {
            return back()->with('Errorzone', 'Cette zone existe déjà');
        }
        else
        {
            if ( zone::where([ ['nom', '=', $request->nom], ['collecteurs_id', '=', $request->collecteurs_id] ])->exists() ) 
            {
                return back()->with('Errorzone1', 'Cette zone existe déjà et est déjà attribué à ce collecteur');                                
            }
            else
            {
                zone::create($request->all());
                return back()->with('succes', 'Enregistrement effectué avec succès');
            }            
        }      
       
    }
    
    public function delete(zone $zone)
    {   
        $full_name = $zone->nom." ".$zone->prenom;
        $zone->delete();    
        return redirect('view-zone')->with('succesDelete', "Le zones '$full_name' a été supprimé avec succès ! ");
    
    }
}
