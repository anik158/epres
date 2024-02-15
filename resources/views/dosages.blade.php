@extends('layouts.layout')

@section('content')
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

                                <form action="{{ route('dosage-list') }}" method="GET" role="search" style="display: inline-block;">
                                    <input type="text" class="form-control col-sm-9 " name="search" placeholder="Search">
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
                            <th>Name</th>
                            <th>Short Name</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($dosages as $dosage)
                            <tr>
                                <td>{{ $dosage->name }}</td>
                                <td>{{ $dosage->short_name }}</td>
                                <td>
                                    <ul style="display: flex; " class="action-list">
                                        <li><a class="btn btn-warning" href="/dosages_edit/{{ $dosage->id }}" data-tip="edit">Edit<i class="fa fa-edit"></i></a></li>

                                        <li>
                                            <form action="/dosages/{{ $dosage->id }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this item?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger" data-tip="delete">Del<i class="fa fa-trash"></i></button>
                                            </form>
                                        </li>
                                    </ul>
                                    </ul>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="panel-footer">
                    <div class="row">
                        <div class="col col-sm-6 col-xs-6">showing <b>5</b> out of <b>25</b> entries</div>
                        <div class="col-sm-6 col-xs-6">
                            <ul class="pagination hidden-xs pull-right">
                                <li><a href="#"><</a></li>
                                <li class="active"><a href="#">1</a></li>
                                <li><a href="#">2</a></li>
                                <li><a href="#">3</a></li>
                                <li><a href="#">4</a></li>
                                <li><a href="#">5</a></li>
                                <li><a href="#">></a></li>
                            </ul>
                            <ul class="pagination visible-xs pull-right">
                                <li><a href="#"><</a></li>
                                <li><a href="#">></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
