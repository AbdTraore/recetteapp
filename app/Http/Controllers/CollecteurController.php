<?php

namespace App\Http\Controllers;

use App\Models\collecteur;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\PseudoTypes\HtmlEscapedString;

class CollecteurController extends Controller
{
    public function index()
    {
        $collecteur_items = collecteur::orderBy("nomcollecteur", "asc")->get();
        return view('admin.pages.collecteurs.view-collecteur', compact('collecteur_items'));
    }
    public function add()
    {
        $collecteurs = collecteur::all();
        return view('admin.pages.collecteurs.add-collecteur', compact('collecteurs'));
    }
    public function edit(Collecteur $collecteur)
    {
        return view('admin.pages.collecteurs.edit-collecteur', compact('collecteur'));
    }
    public function update(Request $request, collecteur $collecteur)
    {   
        $validated = $request->validate([
            "nomcollecteur" => "required",
            "prenomcollecteur" => "required",
            "telephone" => "required|bail|min:10|max:10",
        ]);

       
            $a = substr($request->telephone,0,2);
            if ($a == "01" || $a == "05" || $a == "07") 
            {                
                if (is_numeric($request->telephone)) {
                    $collecteur->update([
                        "nomcollecteur" => htmlspecialchars(ucfirst($request->nomcollecteur)),
                        "prenomcollecteur" => htmlspecialchars(ucfirst($request->prenomcollecteur)),
                        "telephone" => $request->telephone
                    ]);
                    return back()->with('succes', 'Modification effectué avec succès ');    
                }
                else{
                    return back()->with('ErrorPhoneNumber', "Ceci n'est pas un numéro de téléphone");
                }    
            }
            else
            {
                return back()->with('ErrorPhoneNumber', 'Le numéro de téléphone doit commencer par 01/05/07');
            }
        


    }
    public function savecollecteur(Request $request)
    {
        $validated = $request->validate([
            "nomcollecteur" => "required",
            "prenomcollecteur" => "required",
            "telephone" => "required|bail|min:10|max:10",
        ]);

        if ( collecteur::where([['nomcollecteur', '=', $request->nom], ['prenomcollecteur', '=', $request->prenom], ['telephone', '=', $request->telephone] ])->exists() )
        {
            return back()->with('ErrorCollecteur', 'Il existe déjà un collecteur avec ce numéro de téléphone');            
        }
        else
        {
            $a = substr($request->telephone,0,2);
            if ($a == "01" || $a == "05" || $a == "07") 
            {
                if (is_numeric($request->telephone)) {
                    collecteur::create([
                        "nomcollecteur" => htmlspecialchars(ucfirst($request->nomcollecteur)),
                        "prenomcollecteur" => htmlspecialchars(ucfirst($request->prenomcollecteur)),
                        "telephone" => $request->telephone
                    ]);
                    return back()->with('succes', 'Enregistrement effectué avec succès ');    
                }
                else{
                    return back()->with('ErrorPhoneNumber', "Ceci n'est pas un numéro de téléphone");
                }               
            }
            else
            {
                return back()->with('ErrorPhoneNumber', 'Le numéro de téléphone doit commencer par 01/05/07');
            }
        }
        
    }
    
    public function delete(collecteur $collecteur)
    {   
        $full_name = $collecteur->nom." ".$collecteur->prenom;
        $collecteur->delete();    
        return redirect('view-collecteur')->with('succesDelete', "Le collecteurs '$full_name' a été supprimé avec succès ! ");
    
    }
}
