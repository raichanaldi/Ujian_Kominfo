<?php

namespace App\Http\Controllers;

use App\Models\Pokemon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class PokemonController extends Controller
{
    public function fetch()
    {
        // 1️⃣ Ambil list pokemon
        $response = Http::get('https://pokeapi.co/api/v2/pokemon?limit=20');

        if (!$response->successful()) {
            return response()->json(['message' => 'API gagal'], 400);
        }

        $data = $response->json();

        //  pakai transaction
        DB::beginTransaction();

        try {
            //  Loop hasil list
            foreach ($data['results'] as $item) {

                //  Ambil detail pokemon
                $detailResponse = Http::get($item['url']);

                if (!$detailResponse->successful()) {
                    continue;
                }

                $detail = $detailResponse->json();

                //  Filter (contoh: weight <= 100)
                if ($detail['weight'] > 100) {
                    continue;
                }

                //  Simpan gambar 
                $imagePath = null;
                $imageUrl = $detail['sprites']['front_default'] ?? null;

                if ($imageUrl) {
                    $image = Http::get($imageUrl)->body();
                    $fileName = 'pokemon_' . $detail['id'] . '.png';

                    Storage::disk('public')->put('pokemon/' . $fileName, $image);
                    $imagePath = 'storage/pokemon/' . $fileName;
                }

                //  Simpan data pokemon 
                Pokemon::updateOrCreate(
                    ['pokemon_id' => $detail['id']],
                    [
                        'name'       => $detail['name'],
                        'weight'     => $detail['weight'],
                        'experience' => $detail['base_experience'],
                        'image_path' => $imagePath
                    ]
                );
            }

            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 400);
        }

        return response()->json([
            'message' => 'Data Pokémon berhasil disimpan'
        ]);
    }

    /**
     *  DATA POKEMON
     */
    public function index(Request $request)
    {
        $query = Pokemon::query();

        // Filter weight 
        if ($request->weight === 'light') {
            $query->where('weight', '<=', 50);
        } elseif ($request->weight === 'medium') {
            $query->whereBetween('weight', [51, 100]);
        }

        // berat → ringan
        $Pokemon = $query->orderBy('weight', 'desc')->get();

        return view('Pokemon', compact('Pokemon'));
    }
}
