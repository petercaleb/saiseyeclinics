@extends('users.layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1> {{ $clinic->clinic }} </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('users.dashboard.index') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('users.patients.index') }}">Patients</a>
                        </li>
                        <li class="breadcrumb-item active">
                            {{ $patient->first_name }} {{ $patient->last_name }} Profile
                        </li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                @include('users.includes.patients.sidebar')
                <div class="col-md-9">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="callout callout-info">
                                <h5>
                                    Full Names
                                </h5>

                                <p>
                                    {{ $patient->first_name }} {{ $patient->last_name }}
                                </p>
                            </div>
                        </div>
                        <!--/.col -->
                        <div class="col-md-6">
                            <div class="callout callout-info">
                                <h5>
                                    ID/Passport Number
                                </h5>

                                <p>
                                    {{ $patient->id_number }}
                                </p>
                            </div>
                        </div>
                        <!--/.col -->
                    </div>
                    <!--/.row -->

                    <div class="row">
                        <div class="col-md-6">
                            <div class="callout callout-info">
                                <h5>
                                    Phone Number
                                </h5>

                                <p>
                                    {{ $patient->phone }}
                                </p>
                            </div>
                        </div>
                        <!--/.col -->
                        <div class="col-md-6">
                            <div class="callout callout-info">
                                <h5>
                                    Email Address
                                </h5>

                                <p>
                                    {{ $patient->email }}
                                </p>
                            </div>
                        </div>
                        <!--/.col -->
                    </div>
                    <!--/.row -->

                    <div class="row">
                        <div class="col-md-6">
                            <div class="callout callout-info">
                                <h5>
                                    Date of birth
                                </h5>

                                <p>
                                    {{ date('d, F, Y', strtotime($patient->dob)) }}
                                </p>
                            </div>
                        </div>
                        <!--/.col -->
                        <div class="col-md-6">
                            <div class="callout callout-info">
                                <h5>
                                    Gender
                                </h5>

                                <p>
                                    {{ $patient->gender }}
                                </p>
                            </div>
                        </div>
                        <!--/.col -->
                    </div>
                    <!--/.row -->

                    <div class="row">
                        <div class="col-md-6">
                            <div class="callout callout-info">
                                <h5>
                                    Next of kin
                                </h5>

                                <p>
                                    {{ $patient->next_of_kin }}
                                </p>
                            </div>
                        </div>
                        <!--/.col -->
                        <div class="col-md-6">
                            <div class="callout callout-info">
                                <h5>
                                    Next of kin contacts
                                </h5>

                                <p>
                                    {{ $patient->next_of_kin_contact }}
                                </p>
                            </div>
                        </div>
                        <!--/.col -->
                    </div>
                    <!--/.row -->

                    <div class="row">
                        <div class="col-md-6">
                            <div class="callout callout-info">
                                <h5>
                                    Address
                                </h5>

                                <p>
                                    {{ $patient->address }}
                                </p>
                            </div>
                        </div>
                        <!--/.col -->
                        <div class="col-md-6">
                            <div class="callout callout-info">
                                <h5>
                                    Added By (Doctor/Optometrist)
                                </h5>

                                <p>
                                    {{ $patient->user->first_name }} {{ $patient->user->last_name }}
                                </p>
                            </div>
                        </div>
                        <!--/.col -->
                    </div>
                    <!--/.row -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="callout callout-info">
                                <h5>
                                    Date Added
                                </h5>

                                <p>
                                    {{ date('d, F, Y', strtotime($patient->date_in)) }}
                                </p>
                            </div>
                        </div>
                        <!--/.col -->

                        <div class="col-md-6">
                            <div class="callout callout-info">
                                <h5>
                                    Card Number
                                </h5>

                                <p>
                                    {{ $patient->card_number }}
                                </p>
                            </div>
                        </div>
                        <!--/.col -->
                    </div>
                    <!--/.row -->
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection

