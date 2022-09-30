@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Detail Category') }}</div>

                <div class="card-body">
                    <table class="table">
                          <tr>
                            <th>Id</td>
                            <td>{{ $data->id }}</td>
                          </tr>

                          <tr>
                            <th>Name</td>
                            <td>{{ $data->name }}</td>
                          </tr>

                          <tr>
                            <th>User Name</td>
                            <td>{{ $data->user->name }}</td>
                          </tr>

                          <tr>
                            <th>User Email</td>
                            <td>{{ $data->user->email }}</td>
                          </tr>

                          <tr>
                            <th>Created at</td>
                            <td>{{ $data->created_at }}</td>
                          </tr>
                          
                          <tr>
                            <th>Updated at</td>
                            <td>{{ $data->updated_at }}</td>
                          </tr>
                        </tbody>
                      </table>
                </div>

                <div class="card-footer"><button class="btn btn-sm btn-primary" onclick="window.history.go(-1); return false;">Back</button></div>
            </div>
        </div>
    </div>
</div>
@endsection
