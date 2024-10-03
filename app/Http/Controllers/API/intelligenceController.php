<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\family;
use App\Models\intelligence;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Exception;
use Illuminate\Support\Facades\Log;

class intelligenceController extends Controller
{
    public function store_family(Request $request)
    {
        $validatedData = $request->validate([
            'employee_id' => 'required',
            'name' => 'required|string',
            'option' => 'required|string',
            'occupation' => 'required|string',
            'party' => 'required|string',
        ]);

        $family = new family();
        $family->employee_id = $request->employee_id;
        $family->name = $request->name;
        $family->option = $request->option;
        $family->occupation = $request->occupation;
        $family->party = $request->party;

        $family->save();
        return response()->json([
            'status' => Response::HTTP_OK,
            'message' => 'Family members added successfully!'
        ], Response::HTTP_OK);
    }


    public function store_intelligence(Request $request)
    {
        try {

            $validatedData = $request->validate([
                'employee_id' => 'required',
                'supported_by' => 'required|string',
                'Former_member' => 'required',
                'party' => 'required|string',
                'Date_connection' => 'required|date',
                'Travel' => 'required|boolean',
                'Reason_travelling' => 'string',
                'another_passport' => 'required|boolean',
                'country_passport' => 'string',
                'attach' => 'required|file',
            ]);

            $intelligence = new intelligence();
            $intelligence->employee_id = $request->employee_id;
            $intelligence->supported_by = $request->supported_by;
            $intelligence->Former_member = $request->Former_member;
            $intelligence->party = $request->party;
            $intelligence->Date_connection = $request->Date_connection;
            $intelligence->Travel = $request->Travel;
            $intelligence->Reason_travelling = $request->Reason_travelling;
            $intelligence->another_passport = $request->another_passport;
            $intelligence->country_passport = $request->country_passport;

            $intelligence->user_id = $request->user()->id;

            if ($request->hasFile('attach')) {
                $file = $request->file('attach');
                $newName = 'intelligence_' . $request->employee_id . '.' . $file->getClientOriginalExtension();

                $file->move(public_path('upload/intelligence/party'), $newName);

                $intelligence->attach = $newName;
            } else {
                $intelligence->attach = 'no';
            }

            $intelligence->save();

            return response()->json([
                'status' => Response::HTTP_OK,
                'message' => 'Intelligence members added successfully!'
            ], Response::HTTP_OK);
        } catch (Exception $e) {
            Log::error('Error Store Data:' . $e->getMessage());
            return response()->json([
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => 'failed Store Data '
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    public function search_intelligence($id)
    {
        try {

            $intelligence_data = intelligence::where('employee_id', $id)->first();
            $family_data = family::where('employee_id', $id)->first();

            return response()->json([
                'intelligence_data' => $intelligence_data,
                'family_data' => $family_data
            ]);
        } catch (Exception $e) {
            Log::error('Error Store Data:' . $e->getMessage());
            return response()->json([
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => 'failed Store Data '
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
