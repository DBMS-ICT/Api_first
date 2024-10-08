<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\party;
use Exception;
use Illuminate\Http\Request;

class partyController extends Controller
{

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $data =  json_encode([
            app()->getLocale() => [
                'name' => $request->name
            ]
        ]);

        // return $data;
        Party::create([
            'party' => $data
            // ,
            // "ar" => [
            //     'name' => $request->name_ar
            // ],
            // "en" => [
            //     'name' => $request->name_en
            // ]
        ]);



        return response()->json(['message' => 'added', 200]);
    }
    public function update(Request $request, $id)
    {

        $request->validate([
            'name' => 'required',
        ]);
        $party = Party::findOrFail($id);
        $existingPartyData = json_decode($party->party, true);
        $existingPartyData[app()->getLocale()] = [
            'name' => $request->name,
        ];
        $party->party = json_encode($existingPartyData);
        $party->save();

        return response()->json(['message' => 'updated'], 200);
    }

    public function all()
    {
        $parties = Party::orderby('id', 'desc')->get();

        return response()->json(['data' => $parties->map(function ($party) {
            $partyData = json_decode($party->party, true);
            return isset($partyData['ckb']) ? $partyData['ckb'] : null;
        })]);
    }
    public function show_only_trash()
    {
        try {
            $parties = Party::onlyTrashed()->orderBy('id', 'desc')->get();
            $data = $parties->map(function ($party) {
                $partyData = json_decode($party->party, true);
                return isset($partyData['en']) ? $partyData['en'] : null;
            });

            return response()->json(['data' => $data], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }

    public function softDelete($id)
    {
        try {

            $party = Party::findOrFail($id);
            $party->delete();

            return response()->json(['message' => 'Party deleted successfully'], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {

            return response()->json(['message' => 'Party not found'], 404);
        } catch (Exception $e) {
            return response()->json(['message' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }

    public function restore($id)
    {
        try {
            $party = Party::withTrashed()->findOrFail($id);
            $party->restore();

            return response()->json(['message' => 'Party restored successfully'], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {

            return response()->json(['message' => 'Party not found'], 404);
        } catch (Exception $e) {
            return response()->json(['message' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }
}
