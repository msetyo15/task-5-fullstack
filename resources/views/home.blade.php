@extends('layouts.app')

@section('content')
<style>
    .label{
        text-decoration: none;
        font-size: 25px;
    }
    .label-icon{
        font-size: 3rem;
    }
    .number{
        font-size: 3rem;
    }
</style>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-sm-6">
                            <div class="row">
                                <label class="label-icon"><i class="bi bi-bookmarks"></i></label>
                                <span class="number">{{ $categories }}</span>
                                <a href="category" class="label">Categories</a>
                            </div>
                        </div>
                        
                        <div class="col-sm-6">
                            <div class="row">
                                <label class="label-icon"><i class="bi bi-book"></i></i></label>
                                <span class="number">{{ $articles }}</span>
                                <a href="article" class="label">Articles</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
