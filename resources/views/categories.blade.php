@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Categories') }}</div>

              <div class="card-body">
                <!-- table list start -->
                <table class="table table-striped">
                    <thead>
                        <tr>
                          <th scope="col" width="10%" class="text-center">Id Category</th>
                          <th scope="col" width="65%" class="text-start">Name</th>
                          <th scope="col" width="10%" class="text-center">User Id</th>
                          <th scope="col" width="15%" class="text-center">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($data as $item)
                            <tr>
                                <th class="text-center">{{ $item->id }}</th>
                                <td class="text-start">{{ $item->name }}</td>
                                <td class="text-center">{{ $item->user_id }}</td>
                                <td class="text-center">
                                  
                                  <a href="/category/detail/{{ $item->id }}" class="btn btn-sm btn-primary"><i class="bi bi-info-circle"></i></a>
                                  <a href="#updateModal{{  $item->id }}" role="button" data-bs-toggle="modal" class="btn btn-sm btn-success"><i class="bi bi-pencil-square"></i></a>
                                  <a href="/category/delete/{{ $item->id }}" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></a>
                                </td>
                            </tr>
                        @endforeach
                      </tbody>
                </table>
                <!-- table list end -->

                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal" data-bs-whatever="@sdasd">
                  Add Category
                </button>

                <!-- create modal start -->
                <div class="modal fade" id="createModal" tabindex="-1" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">New Category</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <form method="post" action="/category/create">
                          @csrf
                          <div class="mb-3">
                            <label for="name" class="col-form-label form-control-sm">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                          </div>
                          <div class="mb-3">
                            <label for="message-text" class="col-form-label">User Id</label>
                            <select class="form-select form-select-sm" id="user_id" name="user_id" required>
                              <option value="" selected>Select User Id</option>
                              @foreach ($users as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                              @endforeach
                            </select>
                          </div>
                      </div>
                      <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Insert</button>
                      </form>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- create modal end -->

                <!-- update modal start -->
                @foreach ($data as $item)
                <div class="modal fade" id="updateModal{{  $item->id }}" tabindex="-1" aria-labelledby="detaillModal" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Update Category</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <form method="post" action="/category/update">
                          @csrf
                          <div class="mb-3">
                            <input type="hidden" class="form-control" id="id" name="id" value="{{ $item->id }}" required>                            
                            <label for="name" class="col-form-label form-control-sm">Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $item->name }}" required>
                          </div>
                          <div class="mb-3">
                            <label for="message-text" class="col-form-label">User Id</label>
                            <select class="form-select form-select-sm" id="user_id" name="user_id" required>
                              <option value="" selected>Select User Id</option>
                              @foreach ($users as $item)
                                <option value="{{ $item->id }}" 
                                    @if ($item->id == $data[0]->user_id)
                                      {{ 'selected' }}
                                    @endif>
                                  {{ $item->id }}
                                </option>
                              @endforeach
                            </select>
                          </div>
                      </div>
                      <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Update</button>
                      </form>
                      </div>
                    </div>
                  </div>
                </div>
                @endforeach
                <!-- update modal end -->
              </div>
            </div>
        </div>
    </div>
</div>
@endsection
