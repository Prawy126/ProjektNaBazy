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

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'nurse_id' => 'required|integer|exists:nurses,id',
            'user_id' => 'required|integer|exists:users,id',
            'time_visit' => 'required|integer|min:1',
            'room_id' => 'required|integer|exists:rooms,id',
        ], [
            'name.required' => 'Pole imię jest wymagane.',
            'name.string' => 'Pole imię musi być ciągiem znaków.',
            'name.max' => 'Pole imię nie może przekraczać 255 znaków.',
            'surname.required' => 'Pole nazwisko jest wymagane.',
            'surname.string' => 'Pole nazwisko musi być ciągiem znaków.',
            'surname.max' => 'Pole nazwisko nie może przekraczać 255 znaków.',
            'nurse_id.required' => 'Pole id pielęgniarki jest wymagane.',
            'nurse_id.integer' => 'Pole id pielęgniarki musi być liczbą całkowitą.',
            'nurse_id.exists' => 'Podana pielęgniarka nie istnieje.',
            'user_id.required' => 'Pole id użytkownika jest wymagane.',
            'user_id.integer' => 'Pole id użytkownika musi być liczbą całkowitą.',
            'user_id.exists' => 'Podany użytkownik nie istnieje.',
            'time_visit.required' => 'Pole czas wizyty jest wymagane.',
            'time_visit.date' => 'Pole czas wizyty musi być prawidłową datą.',
            'time_visit.min'=> 'Czas pobytu musi być większy niż zero',
            'room_id.required' => 'Pole id sali jest wymagane.',
            'room_id.integer' => 'Pole id sali musi być liczbą całkowitą.',
            'room_id.exists' => 'Podana sala nie istnieje.',
        ]);

        DB::transaction(function () use ($validated) {
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

            $stmt->bindParam(':name', $validated['name'], PDO::PARAM_STR);
            $stmt->bindParam(':surname', $validated['surname'], PDO::PARAM_STR);
            $stmt->bindParam(':nurse_id', $validated['nurse_id'], PDO::PARAM_INT);
            $stmt->bindParam(':user_id', $validated['user_id'], PDO::PARAM_INT);
            $stmt->bindParam(':time_visit', $validated['time_visit'], PDO::PARAM_STR);
            $stmt->bindParam(':room_id', $validated['room_id'], PDO::PARAM_INT);
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

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'nurse_id' => 'required|integer|exists:nurses,id',
            'user_id' => 'required|integer|exists:users,id',
            'time_visit' => 'required|integer|min:1',
            'room_id' => 'required|integer|exists:rooms,id',
        ], [
            'name.required' => 'Pole imię jest wymagane.',
            'name.string' => 'Pole imię musi być ciągiem znaków.',
            'name.max' => 'Pole imię nie może przekraczać 255 znaków.',
            'surname.required' => 'Pole nazwisko jest wymagane.',
            'surname.string' => 'Pole nazwisko musi być ciągiem znaków.',
            'surname.max' => 'Pole nazwisko nie może przekraczać 255 znaków.',
            'nurse_id.required' => 'Pole id pielęgniarki jest wymagane.',
            'nurse_id.integer' => 'Pole id pielęgniarki musi być liczbą całkowitą.',
            'nurse_id.exists' => 'Podana pielęgniarka nie istnieje.',
            'user_id.required' => 'Pole id użytkownika jest wymagane.',
            'user_id.integer' => 'Pole id użytkownika musi być liczbą całkowitą.',
            'user_id.exists' => 'Podany użytkownik nie istnieje.',
            'time_visit.required' => 'Pole czas wizyty jest wymagane.',
            'time_visit.date' => 'Pole czas wizyty musi być prawidłową datą.',
            'time_visit.min' => 'Czas pobytu musi być większy niż zero',
            'room_id.required' => 'Pole id sali jest wymagane.',
            'room_id.integer' => 'Pole id sali musi być liczbą całkowitą.',
            'room_id.exists' => 'Podana sala nie istnieje.',
        ]);

        DB::transaction(function () use ($validated, $id) {
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

            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':name', $validated['name'], PDO::PARAM_STR);
            $stmt->bindParam(':surname', $validated['surname'], PDO::PARAM_STR);
            $stmt->bindParam(':nurse_id', $validated['nurse_id'], PDO::PARAM_INT);
            $stmt->bindParam(':user_id', $validated['user_id'], PDO::PARAM_INT);
            $stmt->bindParam(':time_visit', $validated['time_visit'], PDO::PARAM_STR);
            $stmt->bindParam(':room_id', $validated['room_id'], PDO::PARAM_INT);
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
