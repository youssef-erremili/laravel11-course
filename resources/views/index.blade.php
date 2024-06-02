<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home page</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .text-muted {
            display: none !important;
        }

        .global {
            padding: 0.2rem 0.8rem;
            font-size: 0.70rem;
            display: inline-block;
            margin: 0.5rem;
            font-weight: 700;
        }

        .bg-blue-light {
            background-color: #007bff46;
            color: #0b417a;
            border-radius: 2rem;
        }

        .bg-red-light {
            background-color: #ff000044;
            color: #ff0000;
            border-radius: 2rem;
        }

        .bg-green-light {
            background-color: #28a7463d;
            color: #28a745;
            border-radius: 2rem;
        }

        .mb-4:nth-child(0) {
            background-color: red
        }
    </style>
</head>

<body>
    <div class="max-w-3xl mx-auto p-4">
        <h1 class="text-2xl font-semibold mb-4">Liste des contacts</h1>
        <div class="mb-4 flex justify-between">
            <input type="search" id="search" placeholder="Search contacts"
                class="w-50% px-4 py-2 border border-gray-300 rounded-md">
            <button id="add" class="px-4 py-2 bg-blue-500 text-white rounded-md test">Ajouter</button>
        </div>
        {{-- TABLE OF CONTACT --}}
        <table class="table-data w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-200 border border-gray-300">
                    <th class="p-2 text-left">NOM DU CONTACT</th>
                    <th class="p-2 text-left">SOCIÉTÉ</th>
                    <th class="p-2 text-left">STATUT</th>
                    <th class="p-2">EDIT</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($contacts as $contact)
                    <tr class="border border-gray-300">
                        <td class="p-2">{{ $contact->nom }} {{ $contact->prenom }}</td>
                        <td class="p-2">{{ $contact->organisation->nom }}</td>
                        <td
                            class="text-center global
                            @if ($contact->organisation->statut == 'CLIENT') bg-green-light
                            @elseif($contact->organisation->statut == 'LEAD') 
                            bg-blue-light
                            @elseif($contact->organisation->statut == 'PROSPECT') 
                            bg-red-light @endif
                        ">
                            {{ $contact->organisation->statut }}
                        </td>
                        <td class="p-2 text-center">
                            <button class="showContact readOnly rounded-md" data-id="{{ $contact->id }}"
                                data-toggle="modal" data-target="#contactDetailModal">
                                <ion-icon name="eye-outline"></ion-icon>
                            </button>
                            <button class="showContact" data-id="{{ $contact->id }}">
                                <ion-icon name="pencil-outline"></ion-icon>
                            </button>
                            <button data-id="{{ $contact->id }}" class="deleteBtn">
                                <ion-icon class="text-red-600" name="trash-outline"></ion-icon>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{-- PAGINATION --}}
        <nav class="pagination flex items-center justify-between border-t border-gray-200 bg-white px-4 py-3 sm:px-6">
            <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm text-gray-700">
                        Showing
                        <span class="font-medium">{{ $contacts->firstItem() }}</span>
                        to
                        <span class="font-medium">{{ $contacts->lastItem() }}</span>
                        of
                        <span class="font-medium">{{ $contacts->total() }}</span>
                        results
                    </p>
                </div>
                <div>
                    <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
                        {{ $contacts->links() }}
                    </nav>
                </div>
            </div>
        </nav>

    </div>
    {{-- DELETE MODAL --}}
    <div id="deleteModal" style="margin-top:-18rem;" class="fixed z-10 inset-0 overflow-y-auto hidden"
        aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">​</span>
            <div
                class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                        Supprimer le contact
                    </h3>
                    <div class="mt-2">
                        <p class="text-sm text-gray-500">
                            Êtes-vous sûr de vouloir supprimer ce contact? Cette opération est irréversible.
                        </p>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit" id="deleteForm"
                        class="deleteBtn bg-red-600 ml-2 mt-3 w-30 inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 text-white">
                        Confirmer
                    </button>
                    <button type="button"
                        class="cancelBtn mt-3 w-20 inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700">
                        Annuler
                    </button>
                </div>
            </div>
        </div>
    </div>
    {{-- ADD CONTACT MODAL --}}
    <div id="addModal" class="bg-red-600 overflow-y-auto hidden">
        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);width: 35rem;"
            class="z-10 bg-white p-6 rounded-lg shadow-lg w-96">
            <h2 class="text-xl font-bold mb-4">Détail du contact</h2>
            <form method="POST" action="{{ Route('store') }}">
                @csrf
                <div class="mb-2 flex">
                    <div>
                        <label for="prenom" class="block text-sm font-medium text-gray-700">Prénom</label>
                        <input type="text" id="prenom" name="contact_prenom"
                            class="p-2 block w-36 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label for="nom" class="mx-6 block text-sm font-medium text-gray-700">Nom</label>
                        <input type="text" id="nom" name="contact_nom"
                            class="mx-6 p-2 block w-36 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>
                <div class="mb-2">
                    <label for="email" class="block text-sm font-medium text-gray-700">E-mail</label>
                    <input type="email" id="email" name="contact_e_mail"
                        class="mt-1 p-2 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div class="mb-2">
                    <label for="entreprise" class="block text-sm font-medium text-gray-700">Entreprise</label>
                    <input type="text" id="entreprise" name="organisation_nom"
                        class="mt-1 p-2 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div class="mb-2">
                    <label for="adresse" class="block text-sm font-medium text-gray-700">Adresse</label>
                    <textarea class="mt-1 p-2 block w-full border border-gray-300 rounded-md shadow-sm" name="organisation_addresse"
                        id="Adresse"></textarea>
                </div>
                <div class="mb-4 flex">
                    <div>
                        <label for="code_postal" class="block text-sm font-medium text-gray-700">Code postal</label>
                        <input type="text" id="code_postal" name="organisation_code_postal"
                            class="mt-1 p-2 block w-28 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label for="ville" class="mx-4 block text-sm font-medium text-gray-700">Ville</label>
                        <input type="text" id="ville" name="organisation_ville"
                            class="mt-1 mx-4 p-2 block w-50 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>
                <div class="mb-4">
                    <label for="statut" class="block text-sm font-medium text-gray-700">Statut</label>
                    <select id="statut" name="organisation_statut"
                        class="mt-1 p-2 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="LEAD">Lead</option>
                        <option value="CLIENT">Client</option>
                        <option value="PROSPECT">Prospect</option>
                    </select>
                </div>
                <div class="flex justify-end space-x-4">
                    <button type="button"
                        class="cancelBtn px-4 py-2 bg-gray-300 text-gray-700 rounded-md shadow-sm hover:bg-gray-400">Annuler</button>
                    <button id="valide" type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded-md shadow-sm hover:bg-blue-700">Valider</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // All necessary variable and used when needed 
        let buttonDel = document.querySelectorAll(".deleteBtn")
        let buttonAdd = document.getElementById("add")
        let cancelBtn = document.querySelectorAll(".cancelBtn")
        let deleteModal = document.getElementById("deleteModal")
        let addModal = document.getElementById("addModal")
        let showContact = document.querySelectorAll(".showContact")
        let valide = document.querySelector("#valide")
        let inputElements = document.querySelectorAll('#addModal form input');
        let textareaInput = document.querySelectorAll('#addModal form textarea');
        let readOnly = document.querySelector('.readOnly');
        let form = document.querySelector('form');



        // this function is run after user press on delete button
        buttonDel.forEach((button) => {
            button.addEventListener("click", () => {
                const contactId = button.getAttribute("data-id");
                document.getElementById('deleteForm').addEventListener('click', () => {
                    submitForm(contactId);
                });
                deleteModal.classList.remove('hidden');
            })
        })

        // this function eager when user want to cancel the operation
        cancelBtn.forEach((button, index) => {
            button.addEventListener("click", () => {
                if (index === 0) {
                    deleteModal.classList.add('hidden');
                } else if (index === 1) {
                    addModal.classList.add('hidden');
                    // and also make modal empty for enter new contact
                    inputElements.forEach(input => {
                        input.value = "";
                        textareaInput.value = "";
                    });
                }
            });
        });

        // this function is about display modal for add a new contact
        buttonAdd.addEventListener("click", () => {
            addModal.classList.remove('hidden');
            valide.classList.remove("hidden")
            valide.innerText = "Valider"
        });



        // this function is about display contact from database to user interface(UI)
        showContact.forEach((contactUser, index) => {
            let contactId = contactUser.getAttribute('data-id');
            contactUser.addEventListener("click", () => {
                if (contactUser.classList.contains("readOnly")) {
                    valide.classList.add("hidden")
                } else {
                    valide.classList.remove("hidden")
                    valide.innerText = "Upgrade"
                    let newActionValue = '/update/'+contactId;
                    form.setAttribute('action', newActionValue);
                    form.setAttribute('method', "GET");
                }
                addModal.classList.remove('hidden');
                fetch('/contact/' + contactId)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('prenom').value = data.prenom;
                        document.getElementById('nom').value = data.nom;
                        document.getElementById('email').value = data.e_mail
                        document.getElementById('entreprise').value = data.organisation.nom
                        document.getElementById('ville').value = data.organisation.ville
                        document.getElementById('code_postal').value = data.organisation.code_postal
                        document.getElementById('Adresse').value = data.organisation.adresse
                        let statutSelect = document.getElementById('statut');
                        for (let option of statutSelect.options) {
                            if (option.value.toUpperCase() == data.organisation.statut) {
                                option.selected = true;
                                break;
                            }
                        }
                    })
                    .catch(error => console.error('Error fetching contact details:', error));
            });
        });

        // this code is about delete a contact from database  using fetch method
        function submitForm(contactId) {
            fetch(`/destroy/${contactId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => {
                    console.log('Contact deleted successfully.');
                    location.reload();
                })
                .catch(error => {
                    console.error('Error deleting contact:', error);
                });
        }

        // that script is about search in table row only on each page 
        // -------------------------------------------------------
        // ---- YOU CAN REMOVE COMMENTS AND TEST THIS FUNCTION ----
        // -------------------------------------------------------
        // let search = document.getElementById('search');
        // search.addEventListener('input', function() {
        //     const value = search.value.toLowerCase();
        //     const rows = document.querySelectorAll('tbody tr');
        //     rows.forEach(function(row) {
        //         const name = row.querySelector('td:nth-child(1)').textContent.toLowerCase();
        //         row.style.display = name.includes(value) ? '' : 'none';
        //     });
        // });

        //  Search in database using jquery
        $(document).on("keyup", "#search", function(e) {
            e.preventDefault();
            let search_string = $(this).val();
            $.ajax({
                url: "{{ route('search') }}",
                method: "GET",
                data: {
                    search_string: search_string
                },
                success: function(res) {
                    $('.table-data').html(res);
                }
            });
        });
    </script>


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
</body>

</html>
