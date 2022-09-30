@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __("Detail Article #$data->id") }}</div>
                <div class="row g-0">
                  <div class="col-md-12">
                    <div class="card-body">
                      <h5 class="card-title fw-bold">{{ $data->title }}</h5>
                      <div class="row">
                        <div class="col-md-4">
                          <img src="{{ asset("image/$data->image") }}" class="img-fluid p-1" alt="image" style="object-fit: cover; max-height: 13rem; min-height: 13rem;">
                        </div>

                        <div class="col-md-8">
                          <table class="table">
                              <tr>
                                <th>Category</td>
                                <td>{{ $data->categories->name }}</td>
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
                          </table>
                        </div>

                        <div class="col-md-12 mt-3">
                          <p class="card-text">{{ $data->content }}</p>
                        </div>
                      </div>


                      {{-- <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p> --}}
                    </div>
                  </div>
                </div>
                <div class="card-footer"><button class="btn btn-sm btn-primary" onclick="window.history.go(-1); return false;">Back</button></div>
            </div>
        </div>
    </div>
</div>
@endsection
