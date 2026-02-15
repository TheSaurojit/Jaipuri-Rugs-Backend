@extends('layout.app')


@section('body-section')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Update Product</h4>



                    <form action="{{ route('products.update', ['product' => $product->id]) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf

                        <x-form-field type="text" label="title" name="title" id="input-title" placeholder="enter title"
                            value="{{ $product->title }}" />


                        <div class="mb-3">
                            <label for="description" class="form-label"> Description</label>
                            <textarea class="form-control" id="description" name="description" rows="5" placeholder="Enter description">{{ $product->description }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="category_id" class="form-label">Category</label>
                            <select class="form-control" id="category_id" name="category_id" required>
                                <option value="">Select Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>


                        <x-form-field type="text" label="meta keywords" name="meta_keywords" id="input-meta_keywords"
                            placeholder="enter meta keywords" value="{{ $product->meta_keywords }}" />

                        <x-form-field type="number" label="price" name="price" id="input-price"
                            placeholder="enter price" value="{{ $product->price }}" />

                        <x-form-field type="number" label="quantity" name="quantity" id="input-quantity"
                            placeholder="enter quantity" value="{{ $product->quantity }}" />


                        {{-- Product Variations --}}
                        <div class="mb-3">
                            <label class="form-label">Product Variations</label>


                            <div id="variation-container">
                                @foreach ($product->variations as $index => $variation)
                                    <div class="row mb-2 variation-row">

                                        {{-- Hidden ID --}}
                                        <input type="hidden" name="variations[{{ $index }}][id]"
                                            value="{{ $variation->id }}">


                                        <div class="col-md-5">
                                            <input type="text"
                                                name="variations[{{ $index }}][size]"
                                                class="form-control"
                                                value="{{ $variation->size }}"
                                                placeholder="Enter size (e.g. 7x9 inch)"
                                                
                                                >
                                        </div>

                                        <div class="col-md-5">
                                            <input type="number"
                                                name="variations[{{ $index }}][price]"
                                                class="form-control"
                                                value="{{ $variation->price }}"
                                                placeholder="Enter price"
                                                
                                                >
                                        </div>

                                        <div class="col-md-2">
                                            <button type="button"
                                                    class="btn btn-danger remove-variation"
                                                    data-variation-id="{{ $variation->id }}"
                                                    >
                                                Remove
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>


                            <button type="button" class="btn btn-sm btn-success mt-2" id="add-variation">
                                + Add More
                            </button>
                        </div>

                        <div class="mb-3">
                        <input type="hidden" name="remove_variations" value="" id="remove_variations">
                        </div>


                        <div class="mb-4">
                            <label class="form-label">Current Images</label>
                            <div class="row" id="existing-images">


                                @foreach ($product->multipleImages as $image)
                                    @php
                                        $index = $image->id;
                                    @endphp

                                    <div class="col-md-3 mb-3">
                                        <div class="card">
                                            <img src="{{ $image->path }}" class="card-img-top"
                                                style="height:150px; object-fit:cover;">
                                            <div class="card-body p-2 text-center">
                                                <div class="form-check">
                                                    <input class="form-check-input " type="checkbox" name="remove_images[]"
                                                        value="{{ $index }}" id="remove-{{ $index }}">
                                                    <label class="form-check-label" for="remove-{{ $index }}">
                                                        Remove
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach


                            </div>
                        </div>



                        {{-- images start --}}
                        <div class="mb-3" style="padding: 10px 0">
                            <label for="images" class="form-label"> Images</label>
                            <input type="file" name="images[]" id="images" class="form-control" multiple
                                accept="image/*">
                        </div>
                        <div class="row" id="preview-container"></div>

                        {{-- images end --}}



                        <div class="d-flex gap-2">
                            <!-- Save as Draft -->
                            <button type="submit" name="draft" class="btn btn-secondary" value="draft">
                                Save as Draft
                            </button>

                            <!-- Publish -->
                            <button type="submit" name="publish" class="btn btn-primary" value="publish">
                                Publish
                            </button>
                        </div>
                    </form>

                </div>
                <!-- end card body -->
            </div>
            <!-- end card -->
        </div>
    </div>
@endsection


@section('script-section')

    {{-- variant script --}}
    <script src="/js/custom/variant.js"></script>

    {{-- images script section --}}
    <script src="/js/custom/image.js"></script>

   
@endsection
