<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Patient;
use PDO;
use Illuminate\Support\Facades\Gate;

class PatientController extends Controller
{
    public function index()
    {
        if (Gate::denies('access-admin')) {
            abort(403);
        }

        $patients = Patient::all();
        return view('pacjenciTab', ['patients' => $patients]);
    }

    public function dashboard()
    {
        if (Gate::denies('access-patient')) {
            abort(403);
        }

        $patients = Patient::all();
        return view('pacjent', ['patients' => $patients]);
    }

    public function store(Request $request)
    {
        if (Gate::denies('access-admin')) {
            abort(403);
        }

        DB::transaction(function () use ($request) {
            $pdo = DB::getPdo();
            $stmt = $pdo->prepare("
                DECLARE
                    v_patient users_pkg.patient_rec;
                BEGIN
                    v_patient.name := :name;
                    v_patient.surname := :surname;
                    v_patient.nurse_id := :nurse_id;
                    v_patient.user_id := :user_id;
                    v_patient.time_visit := :time_visit;
                    v_patient.room_id := :room_id;
                    users_pkg.add_patient(v_patient);
                END;
            ");

            $name = $request->input('name');
            $surname = $request->input('surname');
            $nurse_id = $request->input('nurse_id');
            $user_id = $request->input('user_id');
            $time_visit = $request->input('time_visit');
            $room_id = $request->input('room_id');

            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':surname', $surname, PDO::PARAM_STR);
            $stmt->bindParam(':nurse_id', $nurse_id, PDO::PARAM_INT);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->bindParam(':time_visit', $time_visit, PDO::PARAM_INT);
            $stmt->bindParam(':room_id', $room_id, PDO::PARAM_INT);
            $stmt->execute();
        });

        return redirect()->route('patientIndex')->with('success', 'Patient created successfully.');
    }

    public function show($id)
    {
        if (Gate::denies('access-admin')) {
            abort(403);
        }

        $patient = null;

        DB::transaction(function () use ($id, &$patient) {
            $pdo = DB::getPdo();
            $stmt = $pdo->prepare('BEGIN users_pkg.get_patient(:id, :cursor); END;');
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            $cursor = null;
            $stmt->bindParam(':cursor', $cursor, PDO::PARAM_STMT);
            $stmt->execute();

            oci_execute($cursor, OCI_DEFAULT);
            oci_fetch_all($cursor, $result, 0, -1, OCI_FETCHSTATEMENT_BY_ROW);

            if (!empty($result)) {
                $patient = $result[0];
            }
        });

        if (empty($patient)) {
            return redirect()->route('patientIndex')->with('error', 'Patient not found.');
        }

        return view('edycjaPacjenci', compact('patient'));
    }

    public function update(Request $request, $id)
    {
        if (Gate::denies('access-admin')) {
            abort(403);
        }

        DB::transaction(function () use ($request, $id) {
            $pdo = DB::getPdo();
            $stmt = $pdo->prepare("
                DECLARE
                    v_patient users_pkg.patient_rec;
                BEGIN
                    v_patient.id := :id;
                    v_patient.name := :name;
                    v_patient.surname := :surname;
                    v_patient.nurse_id := :nurse_id;
                    v_patient.user_id := :user_id;
                    v_patient.time_visit := :time_visit;
                    v_patient.room_id := :room_id;
                    users_pkg.update_patient(v_patient);
                END;
            ");

            $name = $request->input('name');
            $surname = $request->input('surname');
            $nurse_id = $request->input('nurse_id');
            $user_id = $request->input('user_id');
            $time_visit = $request->input('time_visit');
            $room_id = $request->input('room_id');

            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':surname', $surname, PDO::PARAM_STR);
            $stmt->bindParam(':nurse_id', $nurse_id, PDO::PARAM_INT);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->bindParam(':time_visit', $time_visit, PDO::PARAM_INT);
            $stmt->bindParam(':room_id', $room_id, PDO::PARAM_INT);
            $stmt->execute();
        });

        return redirect()->route('patientIndex')->with('success', 'Patient updated successfully.');
    }

    public function destroy($id)
    {
        if (Gate::denies('access-admin')) {
            abort(403);
        }

        try {
            DB::transaction(function () use ($id) {
                $pdo = DB::getPdo();
                $stmt = $pdo->prepare('BEGIN users_pkg.delete_patient(:id); END;');
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                $stmt->execute();
            });

            return redirect()->route('patientIndex')->with('success', 'Patient deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('patientIndex')->with('error', 'Error deleting patient: ' . $e->getMessage());
        }
    }
}
