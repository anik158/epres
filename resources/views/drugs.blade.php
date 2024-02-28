@extends('layouts.layout')

@section('content')
    <div class="row">
        <div class="col-md-offset-1 col-md-10">
            <div class="panel">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col col-sm-3 col-xs-12">
                            <h4 class="title">Drugs</h4>
                        </div>
                        <div class="col-sm-9 col-xs-12 text-right">
                            <div class="btn_group">

                                <form action="{{ route('drugs-search') }}" method="GET" role="search" style="display: inline-block;">
                                    <label>
                                        <input type="text" class="form-control col-sm-9 " name="search" placeholder="Search">
                                    </label>
                                    <button class="btn btn-default" title="Search" type="submit">Search<i class="fa fa-search"></i></button>
                                </form>
                                <a class="btn btn-info" href="{{route('drug-create')}}" title="Create">Create<i class="fa fa-file"></i></a>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-body table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Strength</th>
                            <th>Dosage Form</th>
                            <th>Generic</th>
                            <th>Company</th>
                            <th>Applicable For</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($drugs as $drug)
                            <tr>
{{--                                <td>{{ $drug->id }}</td>--}}
{{--                                <td>{{ $drug->name }}</td>--}}
{{--                                <td>{{ $drug->strength }}</td>--}}
{{--                                <td>{{ $drug->dosage_form }}</td>--}}
{{--                                <td>{{ $drug->generic }}</td>--}}
{{--                                <td>{{ $drug->company }}</td>--}}
{{--                                <td>{{ $drug->applicable_for }}</td>--}}

                                <td>{{ $drug['id'] }}</td>
                                <td>{{ $drug['name'] }}</td>
                                <td>{{ $drug['strength'] }}</td>
                                <td>{{ $drug['dosage_form'] }}</td>
                                <td>{{ $drug['generic'] }}</td>
                                <td>{{ $drug['company'] }}</td>
                                <td>{{ $drug['applicable_for'] }}</td>
                                <td>
                                    <ul class="action-list" style="display: flex">
                                       {{-- <li><a class="btn btn-warning" href="/drugs_edit/{{ $drug->id }}" data-tip="edit">Edit<i class="fa fa-edit"></i></a></li> --}}
                                        <li><a class="btn btn-warning" href="/drugs_edit/{{ $drug['id'] }}" data-tip="edit">Edit<i class="fa fa-edit"></i></a></li>

                                        <li>
{{--                                            <form action="/drugs/{{ $drug->id }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this item?');">--}}
                                            <form action="/drugs/{{ $drug['id'] }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this item?');">
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
                        {{ $drugs->links('vendor.pagination.bootstrap-4') }}

                    </nav>

{{--                <div class="panel-footer">--}}
{{--                    <div class="row">--}}
{{--                        @isset($drugs)--}}
{{--                        {{$drugs->links()}}--}}
{{--                        @endisset--}}
{{--                    </div>--}}
{{--                </div>--}}
            </div>
        </div>
    </div>

@endsection
