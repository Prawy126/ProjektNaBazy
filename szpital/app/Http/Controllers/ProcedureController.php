<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\TreatmentType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDO;
use Illuminate\Support\Facades\Gate;

class ProcedureController extends Controller
{
    public function index(Request $request)
    {
        if (Gate::denies('access-admin')) {
            abort(403);
        }

        $search = $request->input('search', '');
        $procedures = DB::table('PROCEDURES')
            ->where('ID', 'like', "%$search%")
            ->orWhere('TREATMENT_TYPE_ID', 'like', "%$search%")
            ->get();


        $treatmentTypes = TreatmentType::select('id', 'name')->get();
        $rooms = Room::select('id', 'rnumber')->get();
        return view('zabiegiTab', compact('procedures','treatmentTypes','rooms'));
    }

    public function store(Request $request)
    {
        if (Gate::denies('access-admin')) {
            abort(403);
        }

        $treatmentTypeId = $request->input('treatment_type_id');
        $roomId = $request->input('room_id');
        $date = $request->input('date');
        $time = $request->input('time');
        $cost = $request->input('cost');
        //$status = $request->input('status');

        DB::transaction(function () use ($treatmentTypeId, $roomId, $date, $time, $cost, ) {
            $pdo = DB::getPdo();
            $stmt = $pdo->prepare('
                CALL ADD_PROCEDURE(:p0, :p1, TO_TIMESTAMP(:p2, \'YYYY-MM-DD HH24:MI:SS\'), :p3, :p4)
            ');

            $stmt->bindParam(':p0', $treatmentTypeId, PDO::PARAM_INT);
            $stmt->bindParam(':p1', $roomId, PDO::PARAM_INT);
            $stmt->bindParam(':p2', $date, PDO::PARAM_STR);
            $stmt->bindParam(':p3', $time, PDO::PARAM_STR);
            $stmt->bindParam(':p4', $cost, PDO::PARAM_INT);
            //$stmt->bindParam(':p5', , PDO::PARAM_INT);

            $stmt->execute();
        });

        return redirect()->route('proceduresIndex');
    }

    public function show($id)
    {
        if (Gate::denies('access-admin')) {
            abort(403);
        }

        $procedure = null;

        DB::transaction(function () use ($id, &$procedure) {
            $pdo = DB::getPdo();
            $stmt = $pdo->prepare('
                BEGIN
                    HOSPITAL.GET_PROCEDURE(:id, :procedure);
                END;
            ');

            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':procedure', $procedure, PDO::PARAM_STMT);
            $stmt->execute();

            oci_execute($procedure, OCI_DEFAULT);
            oci_fetch_all($procedure, $result, 0, -1, OCI_FETCHSTATEMENT_BY_ROW);

            if (!empty($result)) {
                $procedure = $result[0];
            }
        });

        if (empty($procedure)) {
            return redirect()->route('proceduresIndex')->with('error', 'Procedure not found.');
        }

        $treatmentTypes = TreatmentType::select('id', 'name')->get();
        $rooms = Room::select('id', 'rnumber')->get();

        return view('edycjaZabiegi', compact('procedure','treatmentTypes','rooms'));
    }

    public function update(Request $request, $id)
    {
        if (Gate::denies('access-admin')) {
            abort(403);
        }

        $treatmentTypeId = $request->input('treatment_type_id');
        $roomId = $request->input('room_id');
        $date = $request->input('date');
        $time = $request->input('time');
        $cost = $request->input('cost');
        //$status = $request->input('status');

        DB::transaction(function () use ($id, $treatmentTypeId, $roomId, $date, $time, $cost) {
            $pdo = DB::getPdo();
            $stmt = $pdo->prepare('
                CALL UPDATE_PROCEDURE(:p0, :p1, :p2, :p3, :p4, :p5)
            ');

            $stmt->bindParam(':p0', $id, PDO::PARAM_INT);
            $stmt->bindParam(':p1', $treatmentTypeId, PDO::PARAM_INT);
            $stmt->bindParam(':p2', $roomId, PDO::PARAM_INT);
            $stmt->bindParam(':p3', $date, PDO::PARAM_STR);
            $stmt->bindParam(':p4', $time, PDO::PARAM_STR);
            $stmt->bindParam(':p5', $cost, PDO::PARAM_INT);
           // $stmt->bindParam(':p6', $status, PDO::PARAM_INT);

            $stmt->execute();
        });

        return redirect()->route('proceduresIndex');
    }

    public function destroy($id)
    {
        if (Gate::denies('access-admin')) {
            abort(403);
        }

        DB::transaction(function () use ($id) {
            $pdo = DB::getPdo();
            $stmt = $pdo->prepare('CALL DELETE_PROCEDURE(:p0)');
            $stmt->bindParam(':p0', $id, PDO::PARAM_INT);
            $stmt->execute();
        });

        return redirect()->route('proceduresIndex');
    }
}
