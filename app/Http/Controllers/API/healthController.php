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



        $user_id = '0';
        if (Auth::check()) {
            Auth::user()->id;
        }
        $validator = Validator::make(
            $request->all(),
            [
                'person_code' => 'required|unique:healths,person_code',
                'boold_group' => 'required',
                'cm' => 'required',
                'document_health' => 'required|file|mimes:pdf,jpeg,jpg,png,pdf|max:2048'
            ]
        );
        // $request->validate(
        //         [
        //             'person_code' => 'required|unique:healths,person_code',
        //             'boold_group' => 'required',
        //             'cm' => 'required',
        //             'document_health' => 'required|file|mimes:pdf,jpeg,jpg,png,pdf|max:2048'
        //         ]
        //     );
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        try {
            $heath = new health;

            $heath->person_code = $request->person_code;
            $heath->boold_group = $request->boold_group;
            $heath->Heart_disease = $request->Heart_disease == true ? '1' : '0';

            $heath->Blood_pressure = $request->Blood_pressure == true ? '1' : '0';
            $heath->suger = $request->suger == true ? '1' : '0';
            $heath->cm = $request->cm;
            $heath->bones_joints = $request->bones_joints == true ? '1' : '0';
            $heath->Kidney_disease = $request->Kidney_disease == true ? '1' : '0';

            $heath->Liver_disease = $request->Liver_disease == true ? '1' : '0';
            $heath->Mental_illness = $request->Mental_illness == true ? '1' : '0';
            $heath->Note1 = $request->Note1;
            $heath->medicine = $request->medicine == true ? '1' : '0';
            $heath->Food = $request->Food == true ? '1' : '0';

            $heath->etc = $request->etc == true ? '1' : '0';
            $heath->detail = $request->detail;
            $heath->medicine_list = $request->medicine_list;
            $heath->surgery_injury = $request->surgery_injury == true ? '1' : '0';
            $heath->physical_ability = $request->physical_ability == true ? '1' : '0';

            $heath->physical_ability_detail = $request->physical_ability_detail;
            $heath->glasses = $request->glasses == true ? '1' : '0';
            $heath->hear = $request->hear == true ? '1' : '0';
            $heath->user_id = $user_id;
            if ($request->hasFile('document_health')) {


                $file = $request->file('document_health');
                $newName = 'Health_' . $request->person_code . '.' . $file->getClientOriginalExtension();

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
}