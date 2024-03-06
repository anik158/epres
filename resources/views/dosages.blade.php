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
                    <div class="panel">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col col-sm-3 col-xs-12">
                                    <h4 class="title">Dosage <span>Form</span></h4>
                                </div>

                                <div class="col-sm-9 col-xs-12 text-right">
                                    <div class="btn_group">

                                        <form action="{{ route('dosage-search') }}" method="GET" role="search" style="display: inline-block;">
                                            <label>
                                                <input type="text" class="form-control col-sm-9 " name="search" placeholder="Search">
                                            </label>
                                            <button class="btn btn-default" title="Search" type="submit">Search<i class="fa fa-search"></i></button>
                                        </form>
                                        <a class="btn btn-info" href="{{route('dosage-create')}}" title="Create">Create<i class="fa fa-file"></i></a>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Icon</th>
                                    <th>Name</th>
                                    <th>short Name</th>
                                    <th>Base Name</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($dosages as $dosage)
                                    <tr>
                                        <td> <img src="{{ asset('storage/uploads/dosages/' . $dosage['image']) }}" alt="drugs_icon"> </td>
                                        <td>{{ $dosage['name'] }}</td>
                                        <td>{{ $dosage['short_name'] }}</td>
                                        <td>{{ $dosage['base_name'] }}</td>
                                        <td>
                                            <ul style="display: flex; " class="action-list">
                                                <li class="list-group-item"><a class="btn btn-warning" href="/dosages_edit/{{ $dosage['id'] }}" data-tip="edit">Edit<i class="fa fa-edit"></i></a></li>

                                                <li class="list-group-item">
                                                    <form action="/dosages/{{ $dosage['id'] }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this item?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger" data-tip="delete">Del<i class="fa fa-trash"></i></button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div>
                        <nav class="mt-4">
                            {{ $dosages->links('vendor.pagination.bootstrap-4') }}
                        </nav>

                    </div>
                </div>
            </div>
        </section>

    </main>

@endsection

