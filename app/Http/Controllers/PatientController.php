<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePatientRequest;
use App\Http\Requests\UpdatePatientRequest;
use App\Models\Patient;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use LaravelIdea\Helper\App\Models\_IH_Patient_C;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Support\Collection
     */
    public function index()
    {
//        return Patient::all();
        return DB::table('patients')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StorePatientRequest $request
     * @return Patient[]|Collection|_IH_Patient_C|void
     */
    public function store(StorePatientRequest $request)
    {
        Patient::create([
            'name' => ucwords($request->name),
            'phone' => $request->phone,
            'age' => $request->age,
            'location' => ucwords($request->location),
            'email' => $request->email,
            'device_id' => $request->device_id,
            'discharge_date' => $request->discharge_date,
            'vital_signs' => $request->vital_signs,
            'medication' => $request->medication,
            'allergies' => $request->allergies,
            'emergency_contacts' => $request->emergency_contacts,
            'medical_notes' => $request->medical_notes,
        ]);
        return Patient::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param Patient $patient
     * @return Response
     */
    public function show(Patient $patient)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Patient $patient
     * @return Response
     */
    public function edit(Patient $patient)
    {
        //
    }

    public function updatePatient(Request $request)
    {
        $patient = Patient::find($request->id);
        $patient->update($request->except(['id', 'created_at', 'updated_at']));
        return Patient::all();

    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdatePatientRequest $request
     * @param Patient $patient
     * @return array
     */
    public function update(UpdatePatientRequest $request, Patient $patient)
    {
        return $request->validated();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return string[]
     */
//    public function destroy(Patient $patient)
//    {
//        //
//    }
    public function destroy(Request $request)
    {
        $affected_rows = DB::table('patients')
            ->where('name', strtolower($request->name))
            ->delete();

        if ($affected_rows > 0) {
            return [
                'status' => 'ok',
                'message' => 'deleted'
            ];

        }
        return [
            'status' => 'failed',
            'message' => 'Patient could not be deleted'
        ];
    }
}
