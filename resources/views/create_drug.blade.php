@extends('layouts.auth')

@section('styles')
    <!-- Favicons -->
    <link href="{{asset('assets/auth/img/favicon.png')}}" rel="icon">
    <link href="{{asset('assets/auth/img/apple-touch-icon.png')}}" rel="icon">


    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{asset('assets/auth/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/auth/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
    <link href="{{asset('assets/auth/vendor/boxicons/css/boxicons.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/auth/vendor/quill/quill.snow.css')}}" rel="stylesheet">
    <link href="{{asset('assets/auth/vendor/quill/quill.bubble.css')}}" rel="stylesheet">
    <link href="{{asset('assets/auth/vendor/remixicon/remixicon.css')}}" rel="stylesheet">
    <link href="{{asset('assets/vendor/simple-datatables/style.css')}}" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="{{asset('assets/auth/css/style.css')}}" rel="stylesheet">
@endsection


@section('main-content')

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Data Tables</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item">Tables</li>
                    <li class="breadcrumb-item active">Data</li>
                </ol>
            </nav>
        </div>

        <section class="section">
            <div class="row">
                <div class="col-md-offset-1 col-md-10">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col col-sm-3 col-xs-12">
                                    <h4 class="title">Add Drug</h4>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body">
                            <form action="/drugs" method="POST" class="form-horizontal">
                                @csrf
                                <label for="name" class="col-sm-2 control-label">Name</label>
                                <div class="col-sm-10">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="name" name="name" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="strength" class="col-sm-2 control-label">Strength</label><br>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="strength" name="strength"><br>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="dosage_form" class="col-sm-2 control-label">Dosage Form</label>
                                    <div class="col-sm-10">
                                        <select class="form-select" name="dosage_form">
                                            <option selected>Open this select menu</option>
                                            @foreach($dosages as $dosage)
                                                <option value="{{ $dosage->name }}">{{ $dosage->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="generic" class="col-sm-2 control-label">Generic</label>
                                    <div class="col-sm-10">
                                        <select class="form-select" name="generic">
                                            <option selected>Open this select menu</option>
                                            @foreach($generics as $generic)
                                                <option value="{{ $generic->name }}">{{ $generic->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="company" class="col-sm-2 control-label">Company</label>
                                    <div class="col-sm-10">
                                        <select class="form-select" name="company">
                                            <option selected>Open this select menu</option>
                                            @foreach($companies as $company)
                                                <option value="{{ $company->name }}">{{ $company->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="applicable_for" class="col-sm-2 control-label">Applicable For</label>
                                    <div class="col-sm-10">
                                        <select class="form-select" name="applicable_for">
                                            <option selected>Open this select menu</option>
                                            @foreach($applicables as $applicable)
                                                <option value="{{ $applicable->category }}">{{ $applicable->category }}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>


                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                        <a href="{{route('drug-list')}}" class="btn btn-warning">Go Back</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>

@endsection





