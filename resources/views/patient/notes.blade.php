@extends('layouts.patient')

@section('title', 'Work/School Notes - OurPhoneMD')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-file-alt me-2"></i>Work/School Notes
                    </h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle me-2"></i>
                        <strong>Coming Soon:</strong> Medical note requests for work or school absences are being developed.
                    </div>

                    <div class="text-center py-5">
                        <i class="fas fa-file-alt fa-3x text-muted mb-3"></i>
                        <h4 class="text-muted">Medical Notes</h4>
                        <p class="text-muted">Request and manage your medical notes for work or school here.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
