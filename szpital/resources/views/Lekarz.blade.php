<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

@include('shared.head')

<body>

    @include('shared.navbar')

    @include('shared.scripts')


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <div class="container mt-5 mb-4">
        <h2 class="mb-4">Witaj Lekarz!</h2>
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Liczba zabiegów na dziś:</h5>
                        <p class="card-text">45</p>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="container mt-4">
        <h2>Planowane zabiegi:</h2>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Kolumna 1</th>
                        <th scope="col">Kolumna 2</th>
                        <th scope="col">Kolumna 3</th>
                        <th scope="col">Kolumna 4</th>
                        <th scope="col">Kolumna 5</th>
                        <th scope="col">Kolumna 6</th>
                        <th scope="col">Kolumna 7</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row">1</th>
                        <td>Dane 1</td>
                        <td>Dane 2</td>
                        <td>Dane 3</td>
                        <td>Dane 4</td>
                        <td>Dane 5</td>
                        <td>Dane 6</td>
                        <td>Dane 7</td>
                        <td><a href="#">Edytuj</a></td>
                    </tr>
                    <tr>
                        <th scope="row">2</th>
                        <td>Dane 8</td>
                        <td>Dane 9</td>
                        <td>Dane 10</td>
                        <td>Dane 11</td>
                        <td>Dane 12</td>
                        <td>Dane 13</td>
                        <td>Dane 14</td>
                        <td><a href="#">Edytuj</a></td>
                    </tr>
                    <tr>
                        <th scope="row">3</th>
                        <td>Dane 15</td>
                        <td>Dane 16</td>
                        <td>Dane 17</td>
                        <td>Dane 18</td>
                        <td>Dane 19</td>
                        <td>Dane 20</td>
                        <td>Dane 21</td>
                        <td><a href="#">Edytuj</a></td>
                    </tr>
                    <tr>
                        <th scope="row">4</th>
                        <td>Dane 22</td>
                        <td>Dane 23</td>
                        <td>Dane 24</td>
                        <td>Dane 25</td>
                        <td>Dane 26</td>
                        <td>Dane 27</td>
                        <td>Dane 28</td>
                        <td><a href="#">Edytuj</a></td>
                    </tr>
                    <tr>
                        <th scope="row">5</th>
                        <td>Dane 29</td>
                        <td>Dane 30</td>
                        <td>Dane 31</td>
                        <td>Dane 32</td>
                        <td>Dane 33</td>
                        <td>Dane 34</td>
                        <td>Dane 35</td>
                        <td><a href="#">Edytuj</a></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="row">
            <div class="col-md-3">
                <button type="button" class="btn btn-primary">Zobacz więcej</button>
            </div>
        </div>

    </div>


    @include('shared.footer')

</body>

</html>
