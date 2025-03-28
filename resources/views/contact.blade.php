@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h1 class="h3 mb-0">Kontakto</h1>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-4 mb-md-0">
                            <h4>Dërgoni një mesazh</h4>                            
                            <form>
                                @csrf
                                <div class="mb-3">
                                    <label for="name" class="form-label">Emri</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email Adresa</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                                <div class="mb-3">
                                    <label for="message" class="form-label">Mesazhi</label>
                                    <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Dërgo</button>
                            </form>
                        </div>
                        
                        <div class="col-md-6">
                            <h4>Informacione për kontaktim</h4>
                            <div class="mb-4">
                                <p class="mb-1"><strong>Adresa:</strong></p>
                                <p>Rruga 113<br>Tetovë, Maqedonia e Veriut, 1200</p>
                            </div>
                            
                            <div class="mb-4">
                                <p class="mb-1"><strong>Telefon (WhatsApp/Viber):</strong></p>
                                <p>(123) 456-7890</p>
                            </div>
                            
                            <div class="mb-4">
                                <p class="mb-1"><strong>Email:</strong></p>
                                <p>info@mosquename.org</p>
                            </div>

                            <div class="mb-4">
                                <p class="mb-1"><strong>Facebook:</strong></p>
                                <p>facebook@mosquename.org</p>
                            </div>
                            
                            <div class="mt-4">
                                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d12345.678901234567!2d-73.98765432109876!3d40.12345678901234!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNDDCsDA3JzI0LjQiTiA3M8KwNTknMTUuNiJX!5e0!3m2!1sen!2sus!4v1234567890123!5m2!1sen!2sus" 
                                        width="100%" height="225" style="border:0;" allowfullscreen="" loading="lazy" 
                                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection