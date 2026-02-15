@extends('layout.app')

@section('body-section')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Update Product Collection</h4>

                <form action="{{ route('product-collections.update', $collection->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <x-form-field type="text" label="Collection Name" name="name" id="input-name"
                        placeholder="Enter collection name" value="{{ $collection->name }}" />

                    <div class="mb-3">
                        <label class="form-label">Select Products</label>
                        <div class="row">
                            @foreach ($products as $product)
                            <div class="col-md-4 mb-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="products[]"
                                        value="{{ $product->id }}" id="product-{{ $product->id }}"
                                        {{ in_array($product->id, $selectedProducts) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="product-{{ $product->id }}">
                                        {{ $product->title }}
                                    </label>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div>
                        <button type="submit" class="btn btn-primary w-md">Update Collection</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection