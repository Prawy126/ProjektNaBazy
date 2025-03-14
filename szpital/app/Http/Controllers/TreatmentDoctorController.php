<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Doctor;
use App\Models\Procedure;
use App\Models\TreatmentDoctor;
use Illuminate\Support\Facades\DB;
use PDO;
use Illuminate\Support\Facades\Gate;

class TreatmentDoctorController extends Controller
{
    public function index()
    {
        if (Gate::denies('access-admin')) {
            abort(403);
        }

        $doctors = Doctor::select('id', 'name', 'surname')->get();
        $procedures = Procedure::select('id', 'date')->get();
        $treatmentDoctors = DB::select('SELECT * FROM TREATMENTS_DOCTORS');

        return view('adminElements.doctorsTreatments', compact('doctors', 'procedures', 'treatmentDoctors'));
    }

    public function store(Request $request)
    {
        if (Gate::denies('access-admin')) {
            abort(403);
        }

        try {
            DB::transaction(function () use ($request) {
                $pdo = DB::getPdo();
                $stmt = $pdo->prepare('
                    BEGIN
                        ADD_TREATMENTS_DOCTORS(:p_PROCEDURE_ID, :p_DOCTOR_ID);
                    END;
                ');

                $doctor_id = $request->input('doctor');
                $procedure_id = $request->input('procedure');

                $stmt->bindParam(':p_DOCTOR_ID', $doctor_id, PDO::PARAM_INT);
                $stmt->bindParam(':p_PROCEDURE_ID', $procedure_id, PDO::PARAM_INT);

                $stmt->execute();
            });

            return redirect()->route('treatmentDoctor.index')
                             ->with('success', 'Treatment successfully assigned to doctor.');
        } catch (\PDOException $e) {
            if ($e->getCode() == '20001') {
                return redirect()->route('treatmentDoctor.index')
                                 ->withErrors([
                                    'Błąd' => 'Nie można przypisać lekarza do zabiegu, ponieważ prowadzi już zabieg w tym czasie',
                                ]);
            }

            return redirect()->route('treatmentDoctor.index')
            ->withErrors([
                'Błąd' => 'Wystąpił błąd',
            ]);
        }
    }


    public function destroy($id)
    {
        if (Gate::denies('access-admin')) {
            abort(403);
        }

        DB::transaction(function () use ($id) {
            $pdo = DB::getPdo();
            $stmt = $pdo->prepare('
                BEGIN
                    DELETE_TREATMENTS_DOCTORS(:p_ID);
                END;
            ');

            $stmt->bindParam(':p_ID', $id, PDO::PARAM_INT);
            $stmt->execute();
        });

        $doctors = Doctor::all();
        $procedures = Procedure::all();
        $treatmentDoctors = TreatmentDoctor::all();
        return redirect()->route('treatmentDoctor.index', compact('doctors', 'procedures', 'treatmentDoctors'));
    }

    public function update(Request $request, $id)
    {
        if (Gate::denies('access-admin')) {
            abort(403);
        }

        $validated = $request->validate([
            'doctor_id' => 'required|integer',
        ], [
            'doctor_id.required' => 'Pole lekarz jest wymagane.',
            'doctor_id.integer' => 'Pole lekarz musi być liczbą całkowitą.',
        ]);

        $newDoctorId = $validated['doctor_id'];

        try {
            DB::transaction(function () use ($id, $newDoctorId) {
                $pdo = DB::getPdo();
                $stmt = $pdo->prepare('
                    BEGIN
                        UPDATE_TREATMENTS_DOCTORS(:p_PROCEDURE_ID, :p_NEW_DOCTOR_ID);
                    END;
                ');

                $stmt->bindParam(':p_PROCEDURE_ID', $id, PDO::PARAM_INT);
                $stmt->bindParam(':p_NEW_DOCTOR_ID', $newDoctorId, PDO::PARAM_INT);

                $stmt->execute();
            });

            return redirect()->route('treatmentDoctor.index')->with('success', 'Doctor updated successfully.');
        } catch (\PDOException $e) {
            if ($e->getCode() == '20004') {
                return redirect()->route('treatmentDoctors.edit', $id)->withErrors([
                    'Błąd' => 'Ten doktor już bierze udział w zabiegu w tym czasie.',
                ]);
            }

            return redirect()->route('treatmentDoctors.edit', $id)->withErrors([
                'Błąd' => 'Wystąpił błąd',
            ]);
        }
    }


    public function edit($id)
    {
        if (Gate::denies('access-admin')) {
            abort(403);
        }

        $treatmentDoctor = null;

        DB::transaction(function () use ($id, &$treatmentDoctor) {
            $pdo = DB::getPdo();
            $stmt = $pdo->prepare('
                BEGIN
                    GET_TREATMENTS_DOCTORS(:p_PROCEDURE_ID, :p_RESULT);
                END;
            ');

            $stmt->bindParam(':p_PROCEDURE_ID', $id, PDO::PARAM_INT);
            $stmt->bindParam(':p_RESULT', $resultCursor, PDO::PARAM_STMT);

            $stmt->execute();

            oci_execute($resultCursor, OCI_DEFAULT);
            oci_fetch_all($resultCursor, $result, 0, -1, OCI_FETCHSTATEMENT_BY_ROW);

            if (!empty($result)) {
                $treatmentDoctor = $result[0];
            }
        });

        $doctors = Doctor::select('id', 'name', 'surname')->get();
        $procedures = Procedure::select('id', 'date')->get();

        return view('adminElements.treatmentsDoctorEdit', compact('treatmentDoctor', 'doctors', 'procedures'));
    }
}
