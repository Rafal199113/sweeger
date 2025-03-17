<?php

namespace App\Http\Controllers;

use App\Http\Requests\PetStoreRequest; 
use App\Models\Pet; 
use Illuminate\Http\Request;
use Storage;
use GuzzleHttp\Client;
use Illuminate\Support\Str;
use GuzzleHttp\Exception\ClientException;

class PetController extends Controller
{

    protected $client;
    protected $headers;

    public function __construct()
    {
        $this->client = new Client();

        $this->headers = [
            'Cache-Control' => 'no-cache',
            'Client-ID'     => 'a1b2c3d4e5f6g7h8i9j0', 
            'API-Key'       => 'ZYXW-9876-VUTS-5432-RQPO', 
            'Content-Type'  => 'application/json' 
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $petId = old('filters.petFilter.id');
        $petStatus = old('filters.petFilter.status');
    
       
        if( old('filters') == null){
            $this->data['filters']['petFilter']['status'] = 'available';
        }else{
            $this->data['filters']['petFilter']['status'] = old('filters')['petFilter']['status'];
        }

        $response = $this->client->get('https://petstore3.swagger.io/api/v3/pet/findByStatus?status='.$this->data['filters']['petFilter']['status'], [
                'headers' => $this->headers 
            ]);

            
            $responseBody = $response->getBody()->getContents();

            $responseObject = json_decode($responseBody);
          
            $pet = new Pet();

           $pets = collect($responseObject)->map(function ($petData) {
        
            return new Pet([
                'id' => $petData->id ?? null, // Jeśli nie ma id, przypisujemy null
                'name' => $petData->name ?? 'Nieznane', // Jeśli nie ma name, przypisujemy domyślną wartość
                'status' => $petData->status ?? 'Nieznany', // Jeśli nie ma statusu, przypisujemy domyślną wartość
                'category' => $petData->category ?? null, // Jeśli nie ma kategorii, przypisujemy null
                'photoUrls' => $petData->photoUrls ?? [], // Jeśli nie ma zdjęć, przypisujemy pustą tablicę
                'tags' => $petData->tags ?? [], // Jeśli nie ma tagów, przypisujemy pustą tablicę
            ]);
        });
            $this->data['pets']  = $pets;
            $this->data['petStatusList']  = $pet->statusList;
         
        
        
        return view('pet.index', ['data' => $this->data]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        return view('pet.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PetStoreRequest $request)
    {
        $id = random_int(0,5000);
             
        $data = [
            "id" => $token = $id,
            "category" => [
                "id" => 0,
                "name" => $request->pet_breed
            ],
            "name" => $request->pet_name,
            "photoUrls" => count($request['photo_links'])? $request['photo_links']:['https://preview.redd.it/artist-%E3%81%93%E3%81%BE%E3%81%8D-gou-matsuoka-v0-8yve625unuoe1.jpeg?width=1080&crop=smart&auto=webp&s=b4dcd1dfbf9775e47492242919037ad8be2e3a9b'],
            "tags" => [
                [
                    "id" => 0,
                    "name" => $request->pet_tag,
                ]
            ],
            "status" => "available"
        ];

        $response = $this->client->post('https://petstore3.swagger.io/api/v3/pet', [
                'json' => $data,  
                'headers' => $this->headers 
            ]);

        $responseBody = $response->getBody()->getContents();

        $responseObject = json_decode($responseBody);
      
        Storage::put('animals.json', json_encode(['id' => $responseObject->id, 'name' => 'Burek']));
        

        if ($response->getStatusCode() == 200) {
            return redirect()->route('pets.index')->with('success', 'Zwierzę zostało dodane!');
        } else {
            return redirect()->back()->with('error', 'Coś poszło nie tak!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
     
            $response = $this->client->get('https://petstore3.swagger.io/api/v3/pet/'.$id, [
                'headers' => $this->headers
            ]);
    
            $responseBody = $response->getBody()->getContents();
            $petData = json_decode($responseBody);
    
            $this->data['pet'] = new Pet([
                'id' => $petData->id ?? null,
                'name' => $petData->name ?? 'Nieznane',
                'status' => $petData->status ?? 'Nieznany',
                'category' => $petData->category ?? null,
                'photoUrls' => $petData->photoUrls ?? [],
                'tags' => $petData->tags ?? [],
            ]);
    
            return view('pet.view', ['data' => $this->data]);
    


        
       
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $tags = json_decode($request->tags, true); 
      
        $formattedTags = array_map(function($tag) {
           
            return [
                'id' => $tag['id'],  
                'name' => $tag['name'], 
            ];
        }, $tags);

        $data = [
            "id" => $token = $id,
            "category" => [
                "id" => 0,
                "name" => $request->category
            ],
            "name" => $request->name,
            "photoUrls" =>  json_decode($request->images, true),
            "tags" => $formattedTags,
            "status" => $request->status,
        ];
 
        $response = $this->client->put('https://petstore3.swagger.io/api/v3/pet', [
            'json' => $data,  
            'headers' => $this->headers 
        ]);

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $response = $this->client->delete('https://petstore3.swagger.io/api/v3/pet/'.$id , [
            'headers' => $this->headers 
        ]);

        return redirect()->route('pets.index')->with('success', 'Zwierzę zostało dodane!');
    }
}
