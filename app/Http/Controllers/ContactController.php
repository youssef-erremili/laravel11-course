<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Organisation;
use Illuminate\Http\Request;

use function Termwind\render;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contacts = Contact::with('organisation')->paginate(10);

        // dd($contacts);
        return view('index', ['contacts' => $contacts]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $organisation = Organisation::all();
        return response()->json($organisation);
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'contact_prenom' => 'required|string',
            'contact_nom' => 'required|string',
            'contact_e_mail' => 'required|email',
            'organisation_nom' => 'required|string',
            'organisation_code_postal' => 'required|string',
            'organisation_ville' => 'required|string',
            'organisation_addresse' => 'required|string',
            'organisation_statut' => 'required|string|in:Lead,Client,Prospect',
        ]);
        $organisation = new Organisation();
        $organisation->nom = $validatedData['organisation_nom'];
        $organisation->code_postal = $validatedData['organisation_code_postal'];
        $organisation->ville = $validatedData['organisation_ville'];
        $organisation->statut = $validatedData['organisation_statut'];
        $organisation->adresse = $validatedData['organisation_statut'];
        $organisation->cle = "";
        $organisation->save();

        $contact = new Contact();
        $contact->prenom = $validatedData['contact_prenom'];
        $contact->nom = $validatedData['contact_nom'];
        $contact->e_mail = $validatedData['contact_e_mail'];
        $contact->organisation_id = $organisation->id;
        $contact->cle = "";
        $contact->telephone_fixe = "060000090";
        $contact->service = "";
        $contact->fonction = "";
        $contact->save();
    }

    public function show(string $id)
    {
        $contact = Contact::with('organisation')->findOrFail($id);
        return response()->json($contact);
    }

    public function edit(string $id)
    {
        $contact = Contact::with('organisation')->findOrFail($id);
        return response()->json($contact);
    }

    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'contact_prenom' => 'required|string',
            'contact_nom' => 'required|string',
            'contact_e_mail' => 'required|email',
            'organisation_nom' => 'required|string',
            'organisation_code_postal' => 'required|string',
            'organisation_ville' => 'required|string',
            'organisation_addresse' => 'required|string',
            'organisation_statut' => 'required|string|in:Lead,Client,Prospect',
        ]);
        $organisation = new Organisation();
        $organisation->nom = $validatedData['organisation_nom'];
        $organisation->code_postal = $validatedData['organisation_code_postal'];
        $organisation->ville = $validatedData['organisation_ville'];
        $organisation->statut = $validatedData['organisation_statut'];
        $organisation->adresse = $validatedData['organisation_statut'];
        $organisation->cle = "";
        $organisation->save();

        $contact = new Contact();
        $contact->prenom = $validatedData['contact_prenom'];
        $contact->nom = $validatedData['contact_nom'];
        $contact->e_mail = $validatedData['contact_e_mail'];
        $contact->organisation_id = $organisation->id;
        $contact->cle = "";
        $contact->telephone_fixe = "060000090";
        $contact->service = "";
        $contact->fonction = "";
        $contact->save();
    }

    public function destroy(string $id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();
        return redirect()->back()->with('success', 'Contact deleted successfully.');
    }

    public function search(Request $request)
    {
        $contacts = Contact::where('nom', 'like', '%' . $request->search_string . '%')
            ->orwhere('prenom', 'like', '%' . $request->search_string . '%')
            ->paginate(4);
        if ($contacts->count() >= 1) {
            return view('index', compact('contacts'))->render();
        } else {
            return response()->json([
                'status' => 'No contact found in our records'
            ]);
        };
    }
}
