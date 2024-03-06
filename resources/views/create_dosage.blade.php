


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
                                    <h4 class="title">Add Dosage Form</h4>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body">
                            <form action="/dosages" method="POST" class="form-horizontal" enctype="multipart/form-data">
                                @csrf
                                <label for="name" class="col-sm-2 control-label">Name<span class="text-danger">*</span></label>
                                <div class="col-sm-10">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="name" name="name" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="short_name" class="col-sm-2 control-label">Short Name<span class="text-danger">*</span></label>
                                    <div class="col-sm-10">
                                        <input type="text" id="short_name" class="form-control" name="short_name" required><br>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label for="base_name" class="col-sm-2 control-label">Base Name<span class="text-danger">*</span></label>
                                    <div class="col-sm-10">
                                        <input type="text" id="base_name" class="form-control" name="base_name" required><br>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="image" class="col-sm-2 control-label">Icon <i class="bi bi-image"></i></label>
                                    <div class="col-sm-10">
                                        <input type="file" id="image" name="image"><br>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                        <a href="{{route('dosage-list')}}" class="btn btn-warning">Go Back</a>
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




