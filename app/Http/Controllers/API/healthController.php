<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\health;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class healthController extends Controller
{

    public function all()
    {
        $data = health::latest()->get();

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
    public function store(Request $request)
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
            $heath = new health;

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
        $data = health::findorfail($id);
        return 'view name';
    }

    public function update(Request $request, $id)
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

            $health = health::findOrFail($id);

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
                $newName = 'Health_' . $request->employee_id . '.' . $file->getClientOriginalExtension();
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

    public function show($id)
    {
        $health = health::where('id', $id)->first();
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

    public function softDelete($id)
    {
        $health = Health::find($id);

        if ($health) {
            $health->delete();
            return response()->json(['message' => 'deleted'], 200);
        }

        return response()->json(['message' => 'not found'], 404);
    }

    public function restore_softDelete($id)
    {
        $health = Health::withTrashed()->find($id);

        if ($health) {
            $health->restore();
            return response()->json(['message' => 'restored'], 200);
        }

        return response()->json(['message' => 'not found'], 404);
    }
}
