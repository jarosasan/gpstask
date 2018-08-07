@extends('layouts.app')
@section('content')
    <div class="container ">
        <form  class="w-50 forma"  action="{{route('device.store')}}" method="post">
            @csrf
            <div class="form-group ">
                <label for="exampleInputEmail1">Device</label>
                <input type="text" name="name" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Device ID">
                @if($errors->has('name'))
                    <div class="col">
                        <small id="passwordHelp" class="text-danger">
                            {{ $errors->first('name') }}
                        </small>
                    </div>
                @endif
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Coordinates</label>
                <input type="text" name="latlon" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="9.0200417°, -79.5189333°">
                @if($errors->has('latlon'))
                    <div class="col">
                        <small id="passwordHelp" class="text-danger">
                            {{ $errors->first('latlon') }}
                        </small>
                    </div>
                @endif
            </div>
            <div class="form-group">
                <label for="exampleFormControlSelect1">Location</label>
                <select name="place" class="form-control" id="exampleFormControlSelect1">
                    <option></option>
                    <option value="home">Home</option>
                    <option value="work">Work</option>
                </select>
                @if($errors->has('place'))
                    <div class="col">
                        <small id="passwordHelp" class="text-danger">
                            {{ $errors->first('place') }}
                        </small>
                    </div>
                @endif
            </div>
            <button type="submit" class="btn btn-primary">Send</button>
        </form>
    </div>
@endsection