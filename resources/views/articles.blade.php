@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Articles') }}</div>

                <div class="card-body">
                    <button type="button" class="btn btn-primary btn-sm mb-3" data-bs-toggle="modal" data-bs-target="#createModal" data-bs-whatever="@sdasd">
                        Add New Article
                    </button>

                    <div class="row row-cols-1 row-cols-md-3 g-4 mb-3" >
                        @foreach ($data as $item)
                        <div class="col">
                          <div class="card h-100 rounded shadow">
                            <img src="{{ asset("image/$item->image") }}" class="card-img-top" alt="image" style="object-fit: cover; max-height: 15rem; min-height: 15rem;">
                            <div class="card-body">
                              <h5 class="card-title fw-bold">{{ $item->title }}</h5>
                              <p class="card-text">{{ $item->content }}</p>
                            </div>
                            <div class="card-footer">
                                <div class="d-flex mb-2">
                                    <div class="me-auto p-2">
                                        <small class="text-muted">{{ $item->updated_at }}</small>
                                    </div>
                                    <div class="p-2">
                                        <a class="mx-3 my-2" href="/article/detail/{{ $item->id }}" class=""><i class="bi bi-info-circle"></i>Detail</a>
                                        <a class="mx-3 my-2" href="#updateModal{{  $item->id }}" role="button" data-bs-toggle="modal" class=""><i class="bi bi-pencil-square"></i>Update</a>
                                        <a class="mx-3 my-2" href="/article/delete/{{ $item->id }}" class=""><i class="bi bi-trash"></i>Delete</a>
                                    </div>
                                </div>
                            </div>
                          </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- pagination start -->
                    <div class="d-flex justify-content-center">{{ $data->links() }}</div>
                    <!-- pagination end -->

                     <!-- create modal start -->
                    <div class="modal fade" id="createModal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add New Article</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                            <form method="post" enctype="multipart/form-data" action="/article/create">
                                @csrf
                                <div class="mb-3">
                                    <label for="title" class="col-form-label form-control-sm">Title</label>
                                    <input type="text" class="form-control" id="title" name="title" required>
                                </div>
                                <div class="mb-3">
                                    <label for="content" class="col-form-label form-control-sm">Content</label>
                                    <textarea class="form-control" placeholder="Write article content here" id="content" name="content"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="image" class="col-form-label form-control-sm">Image</label>
                                    <input type="file" class="form-control" id="image" name="image" required>
                                </div>
                                <div class="mb-3">
                                    <label for="user_id" class="col-form-label">User Id</label>
                                    <select class="form-select form-select-sm" id="user_id" name="user_id" required>
                                        <option value="" selected>Select User</option>
                                        @foreach ($users as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="category_id" class="col-form-label">Category Id</label>
                                    <select class="form-select form-select-sm" id="category_id" name="category_id" required>
                                        <option value="" selected>Select Category</option>
                                        @foreach ($categories as $item)
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
                                        <h5 class="modal-title" id="exampleModalLabel">Update Article</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <img src="{{ asset("image/$item->image") }}" class="card-img-top" alt="image"style="object-fit: cover; max-height: 18rem;">
                                    <div class="modal-body">
                                        <form method="post" action="/article/update" enctype="multipart/form-data">
                                            @csrf
                                            <div class="mb-3">
                                                <input type="hidden" class="form-control" id="id" name="id" value="{{ $item->id }}">
                                                <label for="title" class="col-form-label form-control-sm">Title</label>
                                                <input type="text" class="form-control" id="title" name="title" value="{{ $item->title }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="content" class="col-form-label form-control-sm">Content</label>
                                                <textarea class="form-control" placeholder="Write article content here" id="content" name="content">{{ $item->content }}</textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label for="image" class="col-form-label form-control-sm">Image</label>
                                                <input type="file" class="form-control" id="image" name="image">
                                            </div>
                                            <div class="mb-3">
                                                <label for="user_id" class="col-form-label">User Id</label>
                                                <select class="form-select form-select-sm" id="user_id" name="user_id" required>
                                                    <option value="" selected>Select User</option>
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
                                            <div class="mb-3">
                                                <label for="category_id" class="col-form-label">Category Id</label>
                                                <select class="form-select form-select-sm" id="category_id" name="category_id" required>
                                                    <option value="" selected>Select Category</option>
                                                        @foreach ($categories as $item)
                                                        <option value="{{ $item->id }}"
                                                            @if ($item->id == $data[0]->category_id)
                                                            {{ 'selected' }}
                                                            @endif>{{ $item->name }}</option>
                                                        @endforeach
                                                </select>
                                            </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </div>
                                    </form>
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
