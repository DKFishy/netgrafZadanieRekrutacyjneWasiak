<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ApiController extends Controller
{
    public function fetchData()
    {
        //Pobranie wszystkich zwierząt z API. Nie ma domyślnej metody na pobranie wszystkich, więc wykorzystujemy wyszukiwanie poprzez stan.
        $response = Http::get('https://petstore.swagger.io/v2/pet/findByStatus?status=available,pending,sold');
        $data = $response->json();

        //Sortowanie rosnąco poprzez wartość ID. Tylko do celów testowych
        /*usort($data, function ($a, $b) {
            return $a['id'] - $b['id'];
        });*/

        return view ('api.index', ['data' => $data]);
    }

    public function createForm()
    {
        // Wyświetl formularz dodawania nowego zwierzaka
        return view('api.create');
    }

    public function store(Request $request)
    {
        // Przygotowanie danych do wysłania

        $data = [
            'id' => (int)0,
            'name' => $request->input('name'),
            'status' => $request->input('status'),
            'category' => [
                'id' => 0, // dane zastępcze, zamienić na $request->input('category_id') jeśli użytkownik chce dodać numer kategorii
                'name' => $request->input('category'), 
            ],
        ];

        $response = Http::post("https://petstore.swagger.io/v2/pet", $data);
        $createdPet = $response->json();

        // Przekierowania zależnie od wyników
        if ($response->successful()){
            return redirect()->route('pets')->with('success', 'Pet updated successfully!');
        } else {
            return redirect()->route('pets.editForm', ['petId' => $petId])->with('error', 'Failed to create pet. Please try again.');
        }
    }

    public function editForm($petId)
    {
        // Pobranie danych zwierzaka do edycji
        $response = Http::get("https://petstore.swagger.io/v2/pet/{$petId}");
        $pet = $response->json();

        // Show the form for editing the pet
        return view('api.edit', ['pet' => $pet]);
    }

    public function update(Request $request, $petId)
    {
        $data = [
            'id' => (int)$petId,
            'name' => $request->input('name'),
            'status' => $request->input('status'),
            'category' => [
                'id' => 0, // dane zastępcze, zamienić na $request->input('category_id') jeśli użytkownik chce dodać numer kategorii
                'name' => $request->input('category'), 
            ],
        ];
    

        // wysłanie zmienionych danych
        $response = Http::put("https://petstore.swagger.io/v2/pet", $data);
        $updatedPet = $response->json();


        // Przekierowania zależnie od wyników
        if ($response->successful()){
            return redirect()->route('pets')->with('success', 'Pet updated successfully!');
        } else {
            return redirect()->route('pets.editForm', ['petId' => $petId])->with('error', 'Failed to update pet. Please try again.');
        }
    }

    public function destroy($petId)
    {
        // Perform the DELETE request to remove the pet
        $response = Http::delete("https://petstore.swagger.io/v2/pet/{$petId}");

        // Redirect or respond as needed
        return redirect()->route('pets')->with('success', 'Pet deleted successfully!');
    }
}
