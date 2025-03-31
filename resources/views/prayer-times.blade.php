@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h1 class="h3 mb-0">Kohët e namazeve</h1>
                    <button id="get-location" class="btn btn-sm btn-light">
                        <i class="bi bi-geo-alt"></i> Use My Location
                    </button>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i> Kohët kalkulohen në bazë të vendit. Ato mund të dallojnë nga vendi në vend.
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card mb-4">
                                <div class="card-header bg-success text-white">
                                    <h5 class="mb-0">Kohët sot</h5>
                                </div>
                                <div class="card-body">
                                    @if (isset($today['data']['timings']))
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <div>
                                                <i class="bi bi-sunrise text-warning me-2"></i>
                                                <strong>Sabahu</strong>
                                            </div>
                                            <span>{{ $today['data']['timings']['Fajr'] ?? '5:30 AM' }}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <div>
                                                <i class="bi bi-sun text-warning me-2"></i>
                                                <strong>Lindja e diellit</strong>
                                            </div>
                                            <span>{{ $today['data']['timings']['Sunrise'] ?? '6:45 AM' }}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <div>
                                                <i class="bi bi-sun-fill text-warning me-2"></i>
                                                <strong>Dreka</strong>
                                            </div>
                                            <span>{{ $today['data']['timings']['Dhuhr'] ?? '1:15 PM' }}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <div>
                                                <i class="bi bi-sun text-warning me-2"></i>
                                                <strong>Ikindija</strong>
                                            </div>
                                            <span>{{ $today['data']['timings']['Asr'] ?? '4:45 PM' }}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <div>
                                                <i class="bi bi-sunset text-warning me-2"></i>
                                                <strong>Akshami</strong>
                                            </div>
                                            <span>{{ $today['data']['timings']['Maghrib'] ?? '7:20 PM' }}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <div>
                                                <i class="bi bi-moon-stars text-warning me-2"></i>
                                                <strong>Jacia</strong>
                                            </div>
                                            <span>{{ $today['data']['timings']['Isha'] ?? '8:45 PM' }}</span>
                                        </li>
                                    </ul>
                                    @else
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <div>
                                                <i class="bi bi-sunrise text-warning me-2"></i>
                                                <strong>Sabahu</strong>
                                            </div>
                                            <span>5:30 AM</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <div>
                                                <i class="bi bi-sun text-warning me-2"></i>
                                                <strong>Lindja e diellit</strong>
                                            </div>
                                            <span>6:45 AM</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <div>
                                                <i class="bi bi-sun-fill text-warning me-2"></i>
                                                <strong>Dreka</strong>
                                            </div>
                                            <span>1:15 PM</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <div>
                                                <i class="bi bi-sun text-warning me-2"></i>
                                                <strong>Ikindija</strong>
                                            </div>
                                            <span>4:45 PM</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <div>
                                                <i class="bi bi-sunset text-warning me-2"></i>
                                                <strong>Akshami</strong>
                                            </div>
                                            <span>7:20 PM</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <div>
                                                <i class="bi bi-moon-stars text-warning me-2"></i>
                                                <strong>Jacia</strong>
                                            </div>
                                            <span>8:45 PM</span>
                                        </li>
                                    </ul>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">Namazi i xhumasë</h5>
                                </div>
                                <div class="card-body">
                                    <p><strong>Fillon:</strong> Në kohën e drekës</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">{{ $monthName ?? Carbon\Carbon::now()->format('F') }} {{ $year ?? Carbon\Carbon::now()->year }}</h5>
                                    <form action="{{ route('prayer-times') }}" method="GET" class="d-flex">
                                        <select name="month" class="form-select form-select-sm me-2">
                                            @for ($i = 1; $i <= 12; $i++)
                                                <option value="{{ $i }}" {{ ($month ?? Carbon\Carbon::now()->month) == $i ? 'selected' : '' }}>
                                                    {{ Carbon\Carbon::create(0, $i, 1)->format('F') }}
                                                </option>
                                            @endfor
                                        </select>
                                        <select name="year" class="form-select form-select-sm me-2">
                                            @for ($i = Carbon\Carbon::now()->year - 1; $i <= Carbon\Carbon::now()->year + 1; $i++)
                                                <option value="{{ $i }}" {{ ($year ?? Carbon\Carbon::now()->year) == $i ? 'selected' : '' }}>
                                                    {{ $i }}
                                                </option>
                                            @endfor
                                        </select>
                                        <button type="submit" class="btn btn-sm btn-primary">Shiko</button>
                                    </form>
                                </div>
                                <div class="card-body">
                                    @if (isset($monthly['data']))
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-sm">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Data</th>
                                                    <th>Sabahu</th>
                                                    <th>Dreka</th>
                                                    <th>Ikindija</th>
                                                    <th>Akshami</th>
                                                    <th>Jacia</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($monthly['data'] as $day)
                                                <tr>
                                                    <td>{{ \Carbon\Carbon::parse($day['date']['gregorian']['date'])->format('d') }}</td>
                                                    <td>{{ $day['timings']['Fajr'] }}</td>
                                                    <td>{{ $day['timings']['Dhuhr'] }}</td>
                                                    <td>{{ $day['timings']['Asr'] }}</td>
                                                    <td>{{ $day['timings']['Maghrib'] }}</td>
                                                    <td>{{ $day['timings']['Isha'] }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    @else
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-sm">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Data</th>
                                                    <th>Sabahu</th>
                                                    <th>Dreka</th>
                                                    <th>Ikindija</th>
                                                    <th>Akshami</th>
                                                    <th>Jacia</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td>5:30 AM</td>
                                                    <td>1:15 PM</td>
                                                    <td>4:45 PM</td>
                                                    <td>7:20 PM</td>
                                                    <td>8:45 PM</td>
                                                </tr>
                                                <tr>
                                                    <td>2</td>
                                                    <td>5:31 AM</td>
                                                    <td>1:15 PM</td>
                                                    <td>4:45 PM</td>
                                                    <td>7:19 PM</td>
                                                    <td>8:44 PM</td>
                                                </tr>
                                                <tr>
                                                    <td>3</td>
                                                    <td>5:32 AM</td>
                                                    <td>1:15 PM</td>
                                                    <td>4:44 PM</td>
                                                    <td>7:18 PM</td>
                                                    <td>8:43 PM</td>
                                                </tr>
                                                <tr>
                                                    <td>4</td>
                                                    <td>5:33 AM</td>
                                                    <td>1:15 PM</td>
                                                    <td>4:44 PM</td>
                                                    <td>7:17 PM</td>
                                                    <td>8:42 PM</td>
                                                </tr>
                                                <tr>
                                                    <td>5</td>
                                                    <td>5:34 AM</td>
                                                    <td>1:15 PM</td>
                                                    <td>4:43 PM</td>
                                                    <td>7:16 PM</td>
                                                    <td>8:41 PM</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card mt-4">
                        <div class="card-header">
                            <h5 class="mb-0">Imsakije</h5>
                        </div>
                        <div class="card-body">
                            <p>Gjatë muajit të bekuar të Ramazanit, orari ndryshon:</p>
                            
                            <div class="alert alert-secondary mt-3">
                                <h6>Orari i Ramazanit:</h6>
                                <ul class="mb-0">
                                    <li><strong>Sabahu:</strong> 20 min pas Imsakut</li>
                                    <li><strong>Iftar:</strong> Në kohën e Akshamit</li>
                                    <li><strong>Taravi</strong></li>
                                    <li><strong>Tespih namaz (Nata e 27):</strong> 15 min pas Taravisë</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const locationBtn = document.getElementById('get-location');
    
    if (locationBtn) {
        locationBtn.addEventListener('click', function() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    const latitude = position.coords.latitude;
                    const longitude = position.coords.longitude;
                    
                    // Redirect to the same page with coordinates
                    window.location.href = `{{ route('prayer-times') }}?latitude=${latitude}&longitude=${longitude}`;
                }, function(error) {
                    alert('Could not get your location: ' + error.message);
                });
            } else {
                alert('Geolocation is not supported by your browser');
            }
        });
    }
});
</script>
@endsection