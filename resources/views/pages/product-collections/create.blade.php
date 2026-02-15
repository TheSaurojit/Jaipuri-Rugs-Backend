@extends('layout.app')

@section('body-section')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Create Product Collection</h4>

                <form action="{{ route('product-collections.store') }}" method="POST">
                    @csrf

                    <x-form-field type="text" label="Collection Name" name="name" id="input-name"
                        placeholder="Enter collection name" />

                    <div class="mb-3">
                        <label class="form-label">Select Products</label>
                        <div class="row">
                            @foreach ($products as $product)
                            <div class="col-md-4 mb-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="products[]"
                                        value="{{ $product->id }}" id="product-{{ $product->id }}">
                                    <label class="form-check-label" for="product-{{ $product->id }}">
                                        {{ $product->title }}
                                    </label>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div>
                        <button type="submit" class="btn btn-primary w-md">Create Collection</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection