<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\intelligence;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

class intelligenceController extends Controller
{

    public function store_intelligence(Request $request)
    {

        try {

            $validatedData_family = $request->validate([
                'family_name' => 'required',
                'family_option' => 'required',
                'family_occupation' => 'required',
                'family_party' => 'required',
            ]);

            $family = json_encode([app()->getLocale() => [
                'name' => $validatedData_family['family_name'],
                'option' => $validatedData_family['family_option'],
                'occupation' => $validatedData_family['family_occupation'],
                'party' => $validatedData_family['family_party'],
            ]]);

            $validatedData = $request->validate([
                'employee_id' => 'required',
                'supported_by' => 'required',
                'Former_member' => 'required',
                'party' => 'required',
                'Date_connection' => 'required|date',
                'Travel' => 'required|boolean',
                'Reason_travelling' => 'nullable|string',
                'another_passport' => 'required|boolean',
                'country_passport' => 'nullable|string',
                'attach' => 'required|file',
            ]);

            $supported_by = json_encode([app()->getLocale() => [
                'supported_by' => $validatedData['supported_by'],
            ]]);
            $Former_member = json_encode([app()->getLocale() => [
                'Former_member' => $validatedData['Former_member'],
            ]]);
            $Reason_travelling = json_encode([app()->getLocale() => [
                'Reason_travelling' => $validatedData['Reason_travelling'],
            ]]);
            $country_passport = json_encode([app()->getLocale() => [
                'country_passport' => $validatedData['country_passport'],
            ]]);

            $intelligence = new intelligence();
            $intelligence->employee_id = $validatedData['employee_id'];
            $intelligence->supported_by = $supported_by;
            $intelligence->Former_member = $Former_member;
            $intelligence->party_id = $validatedData['party'];
            $intelligence->Date_connection = $validatedData['Date_connection'];
            $intelligence->Travel = $validatedData['Travel'];
            $intelligence->Reason_travelling = $Reason_travelling;
            $intelligence->another_passport = $validatedData['another_passport'];
            $intelligence->country_passport = $country_passport;
            $intelligence->family = $family;
            $intelligence->user_id = $request->user()->id;


            if ($request->hasFile('attach')) {
                $file = $request->file('attach');
                $newName = 'intelligence_' . $validatedData['employee_id'] . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('upload/intelligence/party'), $newName);
                $intelligence->attach = $newName;
            } else {
                $intelligence->attach = 'no';
            }

            // Save intelligence entry
            $intelligence->save();

            return response()->json([
                'status' => Response::HTTP_OK,
                'message' => 'Intelligence members added successfully!'
            ], Response::HTTP_OK);
        } catch (Exception $e) {
            Log::error('Error Store Data: ' . $e->getMessage());
            return response()->json([
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => 'Failed to store data.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }




    public function edit_intelligence($id)
    {
        $intelligence_data = intelligence::where('employee_id', $id)->first();
        return 'View Name';
    }

    public function update_intelligence(Request $request, $id)
    {
        try {
             $intelligence = Intelligence::findOrFail($id);

             $validatedData_family = $request->validate([
                'family_name' => 'required',
                'family_option' => 'required',
                'family_occupation' => 'required',
                'family_party' => 'required',
            ]);

            $family = json_encode([app()->getLocale() => [
                'name' => $validatedData_family['family_name'],
                'option' => $validatedData_family['family_option'],
                'occupation' => $validatedData_family['family_occupation'],
                'party' => $validatedData_family['family_party'],
            ]]);

             $validatedData = $request->validate([
                'employee_id' => 'required',
                'supported_by' => 'required',
                'Former_member' => 'required',
                'party' => 'required',
                'Date_connection' => 'required|date',
                'Travel' => 'required|boolean',
                'Reason_travelling' => 'nullable|string',
                'another_passport' => 'required|boolean',
                'country_passport' => 'nullable|string',
                'attach' => 'nullable|file',
            ]);
            $supported_by = json_decode($intelligence->supported_by, true);
            $supported_by[app()->getLocale()] = ['supported_by' => $request->supported_by,];


            $Former_member = json_decode($intelligence->Former_member, true);
            $Former_member[app()->getLocale()] = ['Former_member' => $request->Former_member,];

            $Reason_travelling = json_decode($intelligence->Reason_travelling, true);
            $Reason_travelling[app()->getLocale()] = ['Reason_travelling' => $request->Reason_travelling,];

            $country_passport = json_decode($intelligence->country_passport, true);
            $country_passport[app()->getLocale()] = ['country_passport' => $request->country_passport,];

            // Update intelligence entry
            $intelligence->employee_id = $validatedData['employee_id'];
            $intelligence->supported_by = $supported_by;
            $intelligence->Former_member = $Former_member;
            $intelligence->party_id = $validatedData['party'];
            $intelligence->Date_connection = $validatedData['Date_connection'];
            $intelligence->Travel = $validatedData['Travel'];
            $intelligence->Reason_travelling = $Reason_travelling;
            $intelligence->another_passport = $validatedData['another_passport'];
            $intelligence->country_passport = $country_passport;
            $intelligence->family = $family;
            $intelligence->user_id = $request->user()->id;


            if ($request->hasFile('attach')) {
                $file = $request->file('attach');
                $newName = 'intelligence_' . $validatedData['employee_id'] . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('upload/intelligence/party'), $newName);
                $intelligence->attach = $newName;
            }


            $intelligence->save();

            return response()->json([
                'status' => Response::HTTP_OK,
                'message' => 'Intelligence members updated successfully!'
            ], Response::HTTP_OK);
        } catch (Exception $e) {
            Log::error('Error Update Data: ' . $e->getMessage());
            return response()->json([
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => 'Failed to update data.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }




    public function search_intelligence($id)
    {


        try {

            $intelligence_data = intelligence::findOrFail($id);

            return response()->json([
                'intelligence_data' => $intelligence_data,
            ]);
        } catch (Exception $e) {
            Log::error('Error Store Data:' . $e->getMessage());
            return response()->json([
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => 'failed Store Data '
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function delete($id)
    {
        try {
            // Find the intelligence record by ID
            $intelligence = intelligence::findOrFail($id);

            // Check if there's an associated file and delete it
            if ($intelligence->attach && file_exists(public_path('upload/intelligence/party/' . $intelligence->attach))) {
                unlink(public_path('upload/intelligence/party/' . $intelligence->attach));
            }

            // Delete the record from the database
            $intelligence->delete();

            return response()->json([
                'status' => Response::HTTP_OK,
                'message' => 'Intelligence record deleted successfully!'
            ], Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json([
                'status' => Response::HTTP_NOT_FOUND,
                'message' => 'Intelligence record not found.'
            ], Response::HTTP_NOT_FOUND);
        } catch (Exception $e) {
            Log::error('Error deleting data: ' . $e->getMessage());
            return response()->json([
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => 'Failed to delete the record.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function restore_softDelete($id)
    {
        $health = intelligence::withTrashed()->find($id);

        if ($health) {
            $health->restore();
            return response()->json(['message' => 'restored'], 200);
        }

        return response()->json(['message' => 'not found'], 404);
    }
}
