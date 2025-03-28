@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h1 class="h3 mb-0">Kohët e namazeve</h1>
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
                                <div class="card-header">
                                    <h5 class="mb-0">Kohët e namazeve</h5>
                                </div>
                                <div class="card-body">
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
                                            <!-- Additional rows would continue here -->
                                        </tbody>
                                    </table>
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
@endsection