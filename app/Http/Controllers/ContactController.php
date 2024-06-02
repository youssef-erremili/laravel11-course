<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Organisation;
use Illuminate\Http\Request;

use function Termwind\render;

class ContactController extends Controller
{


    // display contact from database
    public function create()
    {
        $organisation = Organisation::all();
        return response()->json($organisation);
    }

    public function index()
    {
        $contacts = Contact::with('organisation')->paginate(10);
        return view('index', compact('contacts'));
    }




    // store functon is about add a new contact  
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
            'organisation_statut' => 'required|string|in:LEAD,CLIENT,PROSPECT',
        ]);

        $organisation = new Organisation();
        $organisation->nom = $validatedData['organisation_nom'];
        $organisation->code_postal = $validatedData['organisation_code_postal'];
        $organisation->ville = $validatedData['organisation_ville'];
        $organisation->statut = $validatedData['organisation_statut'];
        $organisation->adresse = $validatedData['organisation_addresse'];
        $organisation->cle = $this->RandomString();
        $organisation->save();

        $contact = new Contact();
        $contact->prenom = $validatedData['contact_prenom'];
        $contact->nom = $validatedData['contact_nom'];
        $contact->e_mail = $validatedData['contact_e_mail'];
        $contact->organisation_id = $organisation->id;
        $contact->cle = $this->RandomString();
        $contact->telephone_fixe = $this->RondomPhoneNumber();
        $contact->service = "";
        $contact->fonction = "";
        $contact->save();
        return back();
    }

    // this function its role is about generate a RONDOM cle 
    private function RandomString($length = 32)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;;
    }

    // this function its role is about generate a RONDOM phone number
    private function RondomPhoneNumber()
    {
        $useInternational = random_int(0, 1) === 1;
        if ($useInternational) {
            $prefix = '+33';
            $number = '7';
            for ($i = 0; $i < 8; $i++) {
                $number .= random_int(0, 9);
            }
            return $prefix . $number;
        } else {
            $prefix = '0';
            $number = random_int(1, 5);
            for ($i = 0; $i < 8; $i++) {
                $number .= random_int(0, 9);
            }
            return $prefix . $number;
        }
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
        // Validate the request data
        $validatedData = $request->validate([
            'contact_prenom' => 'required|string',
            'contact_nom' => 'required|string',
            'contact_e_mail' => 'required|email',
            'organisation_nom' => 'required|string',
            'organisation_code_postal' => 'required|string',
            'organisation_ville' => 'required|string',
            'organisation_addresse' => 'required|string',
            'organisation_statut' => 'required|string|in:LEAD,CLIENT,PROSPECT',
        ]);

        // Find the existing contact
        $contact = Contact::findOrFail($id);

        // Find the associated organisation
        $organisation = Organisation::findOrFail($contact->organisation_id);

        // Update organisation details
        $organisation->nom = $validatedData['organisation_nom'];
        $organisation->code_postal = $validatedData['organisation_code_postal'];
        $organisation->ville = $validatedData['organisation_ville'];
        $organisation->statut = $validatedData['organisation_statut'];
        $organisation->adresse = $validatedData['organisation_addresse'];
        $organisation->save();

        // Update contact details
        $contact->prenom = $validatedData['contact_prenom'];
        $contact->nom = $validatedData['contact_nom'];
        $contact->e_mail = $validatedData['contact_e_mail'];
        $contact->organisation_id = $organisation->id;
        $contact->save();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Contact updated successfully.');
    }


    // public function update(Request $request, string $id)
    // {
    //     $validatedData = $request->validate([
    //         'contact_prenom' => 'required|string',
    //         'contact_nom' => 'required|string',
    //         'contact_e_mail' => 'required|email',
    //         'organisation_nom' => 'required|string',
    //         'organisation_code_postal' => 'required|string',
    //         'organisation_ville' => 'required|string',
    //         'organisation_addresse' => 'required|string',
    //         'organisation_statut' => 'required|string|in:Lead,Client,Prospect',
    //     ]);
    //     $organisation = new Organisation();
    //     $organisation->nom = $validatedData['organisation_nom'];
    //     $organisation->code_postal = $validatedData['organisation_code_postal'];
    //     $organisation->ville = $validatedData['organisation_ville'];
    //     $organisation->statut = $validatedData['organisation_statut'];
    //     $organisation->adresse = $validatedData['organisation_statut'];
    //     $organisation->cle = "";
    //     $organisation->save();

    //     $contact = new Contact();
    //     $contact->prenom = $validatedData['contact_prenom'];
    //     $contact->nom = $validatedData['contact_nom'];
    //     $contact->e_mail = $validatedData['contact_e_mail'];
    //     $contact->organisation_id = $organisation->id;
    //     $contact->cle = "";
    //     $contact->telephone_fixe = "060000090";
    //     $contact->service = "";
    //     $contact->fonction = "";
    //     $contact->save();
    // }



    // this one is about delete a contact from databse
    public function destroy(string $id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();
        return redirect()->back()->with('success', 'Contact deleted successfully.');
    }


    // this function is about to search in database and display results 
    public function search(Request $request)
    {
        $contacts = Contact::where('nom', 'like', '%' . $request->search_string . '%')
            ->orwhere('prenom', 'like', '%' . $request->search_string . '%')
            ->paginate(10);
        if ($contacts->count() >= 1) {
            return view('index', compact('contacts'))->render();
        } else {
            return response()->json([
                'status' => 'No contact found in our records'
            ]);
        };
    }
}
