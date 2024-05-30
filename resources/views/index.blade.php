<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home page</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="max-w-3xl mx-auto p-4">
        <h1 class="text-2xl font-semibold mb-4">Liste des contacts</h1>
        @include('table')
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                {{ $contacts->links() }}
            </ul>
        </nav>
        <!-- <div class="mt-4 flex justify-between items-center">
            <div class="text-gray-600">Showing 1 to 10 of 242 results</div>
            <div class="flex space-x-2">

            <button class="text-blue-500 hover:underline">Previous</button>
                <button class="text-blue-500 hover:underline">1</button>
                <button class="text-blue-500 hover:underline">2</button>
                <button class="text-blue-500 hover:underline">Next</button>
            </div>
        </div> -->
    </div>
    <div id="deleteModal" class="fixed z-10 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true" data-contact-id="">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">​</span>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
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
                    <button type="submit" id="deleteForm" class="deleteBtn">Delete</button>
                    <button type="button" class="mt-3 w-20 inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none ">
                        Annuler
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div id="addModal" class="bg-red-600 overflow-y-auto hidden">
        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);width: 35rem;" class="z-10 bg-white p-6 rounded-lg shadow-lg w-96">
            <h2 class="text-xl font-bold mb-4">Détail du contact</h2>
            <form method="POST" action="{{Route('store')}}">
                @csrf
                <div class="mb-2 flex">
                    <div>
                        <label for="prenom" class="block text-sm font-medium text-gray-700">Prénom</label>
                        <input type="text" id="prenom" name="contact_prenom" class="p-2 block w-36 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label for="nom" class="mx-6 block text-sm font-medium text-gray-700">Nom</label>
                        <input type="text" id="nom" name="contact_nom" class="mx-6 p-2 block w-36 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>
                <div class="mb-2">
                    <label for="email" class="block text-sm font-medium text-gray-700">E-mail</label>
                    <input type="email" id="email" name="contact_e_mail" class="mt-1 p-2 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div class="mb-2">
                    <label for="telephone_fixe" class="block text-sm font-medium text-gray-700">telephone fixe</label>
                    <input type="text" id="telephone_fixe" name="contact_telephone_fixe" class="mt-1 p-2 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div class="mb-2">
                    <label for="service" class="block text-sm font-medium text-gray-700">service</label>
                    <input type="text" id="service" name="contact_service" class="mt-1 p-2 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div class="mb-2">
                    <label for="entreprise" class="block text-sm font-medium text-gray-700">Entreprise</label>
                    <!-- <select name="organisation_id" id="entrepriseSelect" class="mt-1 p-2 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </select> -->
                    <input type="text" id="entreprise" name="organisation_nom" class="mt-1 p-2 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div class="mb-2">
                    <label for="adresse" class="block text-sm font-medium text-gray-700">Adresse</label>
                    <textarea class="mt-1 p-2 block w-full border border-gray-300 rounded-md shadow-sm" name="organisation_addresse" id="Adresse"></textarea>
                </div>
                <div class="mb-4 flex">
                    <div>
                        <label for="code_postal" class="block text-sm font-medium text-gray-700">Code postal</label>
                        <input type="text" id="code_postal" name="organisation_code_postal" class="mt-1 p-2 block w-28 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label for="ville" class="mx-4 block text-sm font-medium text-gray-700">Ville</label>
                        <input type="text" id="ville" name="organisation_ville" class="mt-1 mx-4 p-2 block w-50 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>
                <div class="mb-4">
                    <label for="statut" class="block text-sm font-medium text-gray-700">Statut</label>
                    <select id="statut" name="organisation_statut" class="mt-1 p-2 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="Lead">Lead</option>
                        <option value="Client">Client</option>
                        <option value="Prospect">Prospect</option>
                    </select>
                </div>
                <div class="flex justify-end space-x-4">
                    <button id="cancelBtn" type="button" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md shadow-sm hover:bg-gray-400">Annuler</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md shadow-sm hover:bg-blue-700">Valider</button>
                </div>
            </form>
        </div>
    </div>


    <!-- 
    <div class="modal fade" id="contactDetailModal" tabindex="-1" aria-labelledby="contactDetailModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="contactDetailModalLabel">Contact Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Contact details will be loaded here
                    <p id="contact-name"></p>
                    <p id="contact-email"></p>
                    <p id="contact-phone"></p>
                    <p id="contact-service"></p>
                    <p id="contact-function"></p>
                    <p id="contact-key"></p>
                    <p id="organisation-name"></p>
                    <p id="organisation-status"></p>
                </div>
            </div>
        </div>
    </div> -->


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        let buttonDel = document.querySelectorAll(".deleteBtn")
        let buttonAdd = document.getElementById("add")
        let cancel = document.getElementById("cancel")
        let cancelBtn = document.getElementById("cancelBtn")
        let deleteModal = document.getElementById("deleteModal")
        let addModal = document.getElementById("addModal")
        let showContact = document.querySelectorAll(".showContact")


        
        buttonDel.forEach((button) => {
            button.addEventListener("click", () => {
                const contactId = button.getAttribute("data-id");
                document.getElementById('deleteForm').addEventListener('click', () => {
                    submitForm(contactId);
                });
                deleteModal.classList.remove('hidden');
                console.log(contactId);
            })
        })
        // cancel.addEventListener("click", () => {
        //     deleteModal.classList.add('hidden');
        // });

        buttonAdd.addEventListener("click", () => {
            addModal.classList.remove('hidden');
            // fetch('/create')
            //     .then(response => response.json())
            //     .then(data => {
            //         let entrepriseSelect = document.getElementById('entrepriseSelect');
            //         entrepriseSelect.innerHTML = "";
            //         data.forEach(item => {
            //             let option = document.createElement('option');
            //             option.value = item.id;
            //             option.textContent = item.nom; 
            //             entrepriseSelect.appendChild(option);
            //         });
            //     })
        });

        cancelBtn.addEventListener("click", () => {
            addModal.classList.add('hidden');
        });

        showContact.forEach(contactUser => {
            contactUser.addEventListener("click", () => {
                let contactId = contactUser.getAttribute('data-id');
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

        function submitForm(contactId) {
            console.log("contactId :", contactId)
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
</body>

</html>