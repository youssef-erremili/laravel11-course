<!-- <head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head> -->

<div class="mb-4 flex justify-between">
    <input type="search" id="search" placeholder="Search contacts" class="w-50% px-4 py-2 border border-gray-300 rounded-md">
    <button id="add" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">Ajouter</button>
</div>
<table class="table-data w-full border-collapse border border-gray-300">
    <thead>
        <tr class="bg-gray-200 border border-gray-300">
            <th class="p-2 text-left">NOM DU CONTACT</th>
            <th class="p-2 text-left">SOCIÉTÉ</th>
            <th class="p-2 text-left">STATUT</th>
            <th class="p-2">Edit</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($contacts as $contact)
        <tr class="border border-gray-300">
            <td class="p-2">{{ $contact->nom }} {{ $contact->prenom }}</td>
            <td class="p-2">{{ $contact->organisation->nom }}</td>
            <td class="p-2 
                    @if($contact->organisation->statut == 'CLIENT') 
                        bg-primary 
                    @elseif($contact->organisation->statut == 'LEAD') 
                        bg-black 
                    @elseif($contact->organisation->statut == 'PROSPECT') 
                        bg-success 
                    @endif
                    ">
                {{ $contact->organisation->statut }}
            </td>

            <td class="p-2 flex">
                <button class="showContact" class="rounded-md" data-id="{{ $contact->id }}" data-toggle="modal" data-target="#contactDetailModal">
                    <ion-icon name="eye-outline"></ion-icon>
                </button>
                <!-- <a href="#" class="text-blue-500 hover:underline"><ion-icon name="pencil-outline"></ion-icon></a> -->
                <button class="showContact" type="button" data-id="{{ $contact->id }}" class="text-blue-500 hover:underline deleteBtn">
                    <ion-icon name="pencil-outline"></ion-icon>
                </button>
                <button data-id="{{ $contact->id }}" class="text-blue-500 hover:underline deleteBtn"><ion-icon class="text-red-600" name="trash-outline"></ion-icon></button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>