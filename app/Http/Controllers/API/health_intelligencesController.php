<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Response;
use Exception;
use Illuminate\Support\Facades\Log;

use App\Http\Controllers\Controller;
use App\Models\health_intelligence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class health_intelligencesController extends Controller
{
    public function show($id)
    {
        $health = health_intelligence::where('id', $id)->first();
        if ($health) {
            return response()->json([
                'status' => Response::HTTP_OK,
                'data' => $health
            ], Response::HTTP_OK);
        } else {
            return response()->json([
                'status' => Response::HTTP_NOT_FOUND,
                'message' => 'Not Found'
            ], Response::HTTP_NOT_FOUND);
        }
    }

    public function all()
    {
        $data = health_intelligence::latest()->get();

        if ($data->isEmpty()) {
            return response()->json(
                [
                    'status' => Response::HTTP_NOT_FOUND,
                    'message' => 'Empty'
                ],
                Response::HTTP_NOT_FOUND
            );
        } else {
            return response()->json(
                [
                    'message' => $data,
                    'status' => Response::HTTP_OK
                ],
                Response::HTTP_OK
            );
        }
    }

    // health

    public function health_store(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'employee_id' => 'required|unique:healths,employee_id',
                'boold_group' => 'required',
                'cm' => 'required',
                'weight' => 'required',
                'document_health' => 'required|file|mimes:pdf,jpeg,jpg,png,pdf|max:2048'
            ]
        );

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        try {
            $heath = new health_intelligence();

            $heath->employee_id = $request->employee_id;
            $heath->boold_group = $request->boold_group;
            $heath->Heart_disease = $request->Heart_disease == true ? '1' : '0';

            $heath->Blood_pressure = $request->Blood_pressure == true ? '1' : '0';
            $heath->suger = $request->suger == true ? '1' : '0';
            $heath->cm = $request->cm;
            $heath->weight = $request->weight;

            $heath->bones_joints = $request->bones_joints == true ? '1' : '0';
            $heath->Kidney_disease = $request->Kidney_disease == true ? '1' : '0';

            $heath->Liver_disease = $request->Liver_disease == true ? '1' : '0';
            $heath->Mental_illness = $request->Mental_illness == true ? '1' : '0';
            $heath->medicine = $request->medicine == true ? '1' : '0';
            $heath->Food = $request->Food == true ? '1' : '0';

            $heath->etc = $request->etc == true ? '1' : '0';
            $heath->surgery_injury = $request->surgery_injury == true ? '1' : '0';
            $heath->physical_ability = $request->physical_ability == true ? '1' : '0';

            $heath->glasses = $request->glasses == true ? '1' : '0';
            $heath->hear = $request->hear == true ? '1' : '0';
            // $heath->party_id = $request->party_id;
            $heath->user_id = $request->user()->id;


            $heath->Note1 = json_encode([app()->getLocale() => ['Note1' =>  $request->Note,]]);

            $heath->detail = json_encode([app()->getLocale() => ['detail' =>  $request->detail,]]);

            $heath->medicine_list = json_encode([app()->getLocale() => ['medicine_list' =>  $request->medicine_list,]]);

            $heath->physical_ability_detail = json_encode([app()->getLocale() =>
            ['physical_ability_detail' =>  $request->physical_ability_detail,]]);

            if ($request->hasFile('document_health')) {


                $file = $request->file('document_health');
                $newName = 'Health_' . $request->employee_id . '.' . $file->getClientOriginalExtension();

                $file->move(public_path('upload/Health_document'), $newName);

                $heath->document_health = $newName;
            } else {
                $heath->document_health = 'no';
            }

            $heath->save();
            return response()->json([
                'status' => Response::HTTP_OK,
                'message' => 'Add successful'
            ], Response::HTTP_OK);
            // return response()->json(['message' => 'بەسەرکەوتووی تۆمارکرا'], 200);
        } catch (Exception $e) {
            Log::error('Error Store Data:' . $e->getMessage());
            return response()->json([
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => 'failed Store Data '
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    public function edit($id)
    {
        $data = health_intelligence::findorfail($id);
        return 'view name';
    }

    public function health_update(Request $request, $id)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'boold_group' => 'required',
                'cm' => 'required',
                'weight' => 'required',
                'document_health' => 'nullable|file|mimes:pdf,jpeg,jpg,png|max:2048'
            ]
        );
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        try {

            $health = health_intelligence::findOrFail($id);

            $health->boold_group = $request->boold_group;
            $health->Heart_disease = $request->Heart_disease == true ? '1' : '0';
            $health->Blood_pressure = $request->Blood_pressure == true ? '1' : '0';
            $health->suger = $request->suger == true ? '1' : '0';
            $health->cm = $request->cm;
            $health->weight = $request->weight;
            $health->bones_joints = $request->bones_joints == true ? '1' : '0';
            $health->Kidney_disease = $request->Kidney_disease == true ? '1' : '0';
            $health->Liver_disease = $request->Liver_disease == true ? '1' : '0';
            $health->Mental_illness = $request->Mental_illness == true ? '1' : '0';
            $health->medicine = $request->medicine == true ? '1' : '0';
            $health->Food = $request->Food == true ? '1' : '0';
            $health->etc = $request->etc == true ? '1' : '0';

            $health->surgery_injury = $request->surgery_injury == true ? '1' : '0';
            $health->physical_ability = $request->physical_ability == true ? '1' : '0';
            $health->glasses = $request->glasses == true ? '1' : '0';
            $health->hear = $request->hear == true ? '1' : '0';
            $health->user_id = $request->user()->id;


            $Note1 = json_decode($health->Note1, true);
            $Note1[app()->getLocale()] = ['Note1' => $request->Note1,];
            $health->Note1 = $Note1;

            $detail = json_decode($health->detail, true);
            $detail[app()->getLocale()] = ['detail' => $request->detail,];
            $health->detail = $detail;


            $medicine_list = json_decode($health->medicine_list, true);
            $medicine_list[app()->getLocale()] = ['medicine_list' => $request->medicine_list,];
            $health->medicine_list = $medicine_list;


            $physical_ability_detail = json_decode($health->physical_ability_detail, true);
            $physical_ability_detail[app()->getLocale()] = ['physical_ability_detail' => $request->physical_ability_detail,];
            $health->physical_ability_detail = $physical_ability_detail;


            if ($request->hasFile('document_health')) {
                if ($health->document_health && file_exists(public_path('upload/Health_document/' . $health->document_health))) {
                    unlink(public_path('upload/Health_document/' . $health->document_health));
                }

                $file = $request->file('document_health');
                $newName = 'Health_' . $health->employee_id . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('upload/Health_document'), $newName);

                $health->document_health = $newName;
            }

            $health->save();

            return response()->json([
                'status' => Response::HTTP_OK,
                'message' => 'Update successful'
            ], Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json([
                'status' => Response::HTTP_NOT_FOUND,
                'message' => 'Health record not found.'
            ], Response::HTTP_NOT_FOUND);
        } catch (Exception $e) {
            Log::error('Error updating data: ' . $e->getMessage());
            return response()->json([
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => 'Failed to update data.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    //intelligences


    public function update_intelligence(Request $request, $id)
    {
        try {
            $intelligence = health_intelligence::findOrFail($id);

            $validatedData_family = $request->validate([
                'family_name' => 'required',
                'family_option' => 'required',
                'family_occupation' => 'required',
                'family_party' => 'required',
            ]);
            $family = json_decode($intelligence->family_data, true);
            $family[app()->getLocale()] = [
                'name' => $request->family_name,
                'option' => $request->family_option,
                'occupation' => $request->family_occupation,
                'party' => $request->family_party
            ];

            $validatedData = $request->validate([
                // 'employee_id' => 'required',
                'supported_by' => 'required',
                'Former_member' => 'required',
                'party' => 'required',
                'Date_connection' => 'required|date',
                'Travel' => 'required|boolean',
                'Reason_travelling' => 'nullable|string',
                'another_passport' => 'required|boolean',
                'country_passport' => 'nullable|string',
                'attach' => 'required|file|mimes:pdf,jpeg,jpg,png,pdf|max:2048',
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
            // $intelligence->employee_id = $validatedData['employee_id'];
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
                $newName = 'intelligence_' . $intelligence->employee_id . '.' . $file->getClientOriginalExtension();
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

            $intelligence_data = health_intelligence::findOrFail($id);
            // return all data
            return response()->json([
                'data' => $intelligence_data
            ]);

            // get family_data
            // return response()->json([
            //     'data' => json_decode($intelligence_data->family_data, true)['en']['name'] ?? null,
            // ]);

        } catch (Exception $e) {
            Log::error('Error Store Data:' . $e->getMessage());
            return response()->json([
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => 'failed Search Data '
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function softDelete($id)
    {
        $health = health_intelligence::find($id);

        if ($health) {
            $health->delete();
            return response()->json(['message' => 'deleted'], 200);
        }

        return response()->json(['message' => 'not found'], 404);
    }

    public function restore_softDelete($id)
    {
        $health = health_intelligence::withTrashed()->find($id);

        if ($health) {
            $health->restore();
            return response()->json(['message' => 'restored'], 200);
        }

        return response()->json(['message' => 'not found'], 404);
    }
}
