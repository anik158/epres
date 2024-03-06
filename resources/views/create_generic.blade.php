

@extends('layouts.layout')

@section('content')
    <div class="row">
        <div class="col-md-offset-1 col-md-10">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col col-sm-3 col-xs-12">
                            <h4 class="title">Add Generic</h4>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <form action="/generics" method="POST" class="form-horizontal">
                        @csrf
                        <label for="name" class="col-sm-2 control-label">Name <span class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <div class="form-group">
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="composition" class="col-sm-2 control-label">Composition</label>
                            <div class="col-sm-10">
                                <textarea type="text" id="composition" class="form-control" name="composition"></textarea><br>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="indications" class="col-sm-2 control-label">Indications</label>
                            <div class="col-sm-10">
                                <textarea type="text" id="indications" class="form-control" name="indications"></textarea><br>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="therapeutic_class" class="col-sm-2 control-label">Therapeutic Class</label>
                            <div class="col-sm-10">
                                <textarea type="text" id="therapeutic_class" class="form-control" name="therapeutic_class"></textarea><br>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="pharmacology" class="col-sm-2 control-label">Pharmacology</label>
                            <div class="col-sm-10">
                                <textarea type="text" id="pharmacology" class="form-control" name="pharmacology"></textarea><br>
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="dosage" class="col-sm-2 control-label">Dosage</label>
                            <div class="col-sm-10">
                                <textarea type="text" id="dosage" class="form-control" name="dosage"></textarea><br>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="administration" class="col-sm-2 control-label">Administration</label>
                            <div class="col-sm-10">
                                <textarea type="text" id="administration" class="form-control" name="administration"></textarea><br>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="interaction" class="col-sm-2 control-label">Interaction</label>
                            <div class="col-sm-10">
                                <textarea type="text" id="interaction" class="form-control" name="interaction"></textarea><br>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="contraindications" class="col-sm-2 control-label">Contraindications</label>
                            <div class="col-sm-10">
                                <textarea type="text" id="contraindications" class="form-control" name="contraindications"></textarea><br>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="side_effects" class="col-sm-2 control-label">Side Effects</label>
                            <div class="col-sm-10">
                                <textarea type="text" id="side_effects" class="form-control" name="side_effects"></textarea><br>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="pregnancy_lactation" class="col-sm-2 control-label">Pregnancy & Lactation</label>
                            <div class="col-sm-10">
                                <textarea type="text" id="pregnancy_lactation" class="form-control" name="pregnancy_lactation"></textarea><br>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="precautions" class="col-sm-2 control-label">Precautions</label>
                            <div class="col-sm-10">
                                <textarea type="text" id="precautions" class="form-control" name="precautions"></textarea><br>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="pediatric_use" class="col-sm-2 control-label">Pediatric Use</label>
                            <div class="col-sm-10">
                                <textarea type="text" id="pediatric_use" class="form-control" name="pediatric_use"></textarea><br>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="overdose_effects" class="col-sm-2 control-label">Overdose Effects</label>
                            <div class="col-sm-10">
                                <textarea type="text" id="overdose_effects" class="form-control" name="overdose_effects"></textarea><br>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="reconstitution" class="col-sm-2 control-label">Reconstitution</label>
                            <div class="col-sm-10">
                                <textarea type="text" id="reconstitution" class="form-control" name="reconstitution"></textarea><br>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="storage_condition" class="col-sm-2 control-label">Storage Condition</label>
                            <div class="col-sm-10">
                                <textarea type="text" id="storage_condition" class="form-control" name="storage_condition"></textarea><br>
                            </div>
                        </div>



                        <div class="form-group">
                            <label for="applicable_for" class="col-sm-2 control-label">Applicable For</label>
                            <div class="col-sm-10">
                                <select class="form-select" id="applicable_for" name="applicable_for">
                                    <option selected>Open this select menu</option>
                                    @foreach($applicable as $ap)
                                        <option value="{{ $ap->category }}">{{ $ap->category }}</option>
                                    @endforeach
                                </select>

                            </div>
                        </div>


                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="{{route('generic-list')}}" class="btn btn-warning">Go Back</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection



