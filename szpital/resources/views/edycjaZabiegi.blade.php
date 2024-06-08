<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

@include('shared.head')

<body>

    @include('shared.navbar')

    @include('shared.scripts')

    <div class="container">
        <h2 class="mt-4">Edytuj dane: Zabiegi</h2>
        <form method="POST" action="{{ route('proceduresUpdate',$procedure['ID']) }}">
            @csrf
            @method('PUT')
            <div class="form-group row mb-4">
                <label for="inputID" class="col-md-2 col-form-label">ID:</label>
                <div class="col-md-4">
                    <input type="number" class="form-control" id="inputID" name="id" placeholder="ID" value="{{ $procedure["ID"] }}">
                </div>
            </div>
            <div class="form-group row mb-4">
                <label for="inputIDRodzajZabiegu" class="col-md-2 col-form-label">ID Rodzaju zabiegu:</label>
                <div class="col-md-4">
                    <input type="number" class="form-control" id="inputIDRodzajZabiegu" name="treatment_type_id" placeholder="ID Rodzaju zabiegu" value="{{ $procedure["TREATMENT_TYPE_ID"] }}">
                </div>
            </div>
            <div class="form-group row mb-4">
                <label for="inputIDSala" class="col-md-2 col-form-label">ID Sali:</label>
                <div class="col-md-4">
                    <input type="number" class="form-control" id="inputIDSala" name="room_id" placeholder="ID Sali" value="{{ $procedure["ROOM_ID"] }}">
                </div>
            </div>
            <div class="form-group row mb-4">
                <label for="inputData" class="col-md-2 col-form-label">Data:</label>
                <div class="col-md-4">
                    <input type="datetime" class="form-control" id="inputData" name="date" placeholder="Data" value="{{ $procedure["DATE"] }}">
                </div>
            </div>
            <div class="form-group row mb-4">
                <label for="inputCzasTrwania" class="col-md-2 col-form-label">Czas trwania:</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" id="inputCzasTrwania" name="time" placeholder="Czas trwania" value="{{ $procedure["TIME"] }}">
                </div>
            </div>
            <div class="form-group row mb-4">
                <label for="inputKoszt" class="col-md-2 col-form-label">Koszt:</label>
                <div class="col-md-4">
                    <input type="number" class="form-control" id="inputKoszt" name="cost" placeholder="Koszt" value="{{ $procedure["COST"] }}">
                </div>
            </div>
            <div class="form-group row mb-4">
                <label for="inputStatus" class="col-md-2 col-form-label">Status:</label>
                <div class="col-md-4">
                    <input type="number" class="form-control" id="inputStatus" name="status" placeholder="Status" value="{{ $procedure["STATUS"] }}">
                </div>
            </div>
            <div class="form-group row mb-4">
                <div class="offset-md-2 col-md-1">
                    <button type="submit" class="btn btn-primary mb-2">Zatwierdź</button>
                </div>
                <div class="offset-md-1 col-md-1">
                    <button type="button" class="btn btn-primary" onclick="window.location.href='{{ route('proceduresIndex') }}'">Wyjście</button>
                </div>
            </div>
        </form>
    </div>

    @include('shared.footer')

</body>

</html>
