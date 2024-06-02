<div class="col-md-12">
    <form action="" method="POST">
        @csrf
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="doctorId">Id lekarza</label>
                <select id="doctorId" class="form-select" name="doctor">
                    @foreach($doctors as $doctor)
                        <option value="{{ $doctor->id }}">{{ $doctor->id }} {{ $doctor->name }} {{ $doctor->surname }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-6">
                <label for="procedureId">Id zabiegu</label>
                <select id="procedureId" class="form-select" name="procedure">
                    @foreach($procedures as $procedure)
                        <option value="{{ $procedure->id }}">{{ $procedure->id }} {{ $procedure->procedure_name }} {{ $procedure->date }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Prześlij</button>
    </form>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title mb-4">Zabiegi - Lekarze:</h5>
            <table class="table table-bordered mb-4">
                <thead>
                    <tr>
                        <th scope="col">Id lekarza</th>
                        <th scope="col">Id zabiegu</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($treatmentDoctors as $treatmentDoctor)
                        <tr>
                            <td>{{ $treatmentDoctor->doctor_id }}</td>
                            <td>{{ $treatmentDoctor->procedure_id }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
