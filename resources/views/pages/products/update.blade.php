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


                        @php
                            $hasShapes = $product->variations->whereNotNull('shape_id')->count() > 0;
                        @endphp

                        {{-- Product Variations Toggle --}}
                        <div class="mb-3">
                            <label class="form-label d-block">Does this product have shapes?</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="has_shapes" id="has_shapes_no" value="0" 
                                    {{ !$hasShapes ? 'checked' : '' }} 
                                    {{ $hasShapes ? 'disabled' : '' }}>
                                <label class="form-check-label" for="has_shapes_no">No</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="has_shapes" id="has_shapes_yes" value="1" 
                                    {{ $hasShapes ? 'checked' : '' }} 
                                    {{ !$hasShapes ? 'disabled' : '' }}>
                                <label class="form-check-label" for="has_shapes_yes">Yes</label>
                            </div>
                            @if(!$hasShapes)
                                <small class="text-muted d-block">Shape selection is disabled for existing products without shapes.</small>
                            @else
                                <small class="text-muted d-block">Cannot switch to simple variations for products with shapes.</small>
                            @endif
                        </div>

                        {{-- Simple Variations Container --}}
                        <div id="simple-variation-section" class="mb-3" style="display: {{ !$hasShapes ? 'block' : 'none' }};">
                            <label class="form-label">Variations</label>
                            <div id="simple-variation-container">
                                @if(!$hasShapes)
                                    @foreach($product->variations as $index => $variation)
                                    <div class="row mb-2 variation-row">
                                        <input type="hidden" name="variations[{{ $variation->id }}][id]" value="{{ $variation->id }}">
                                        <div class="col-md-5">
                                            <input type="text" name="variations[{{ $variation->id }}][size]" class="form-control" value="{{ $variation->size }}" placeholder="Enter size (e.g. 7x9 inch)">
                                        </div>
                                        <div class="col-md-5">
                                            <input type="number" name="variations[{{ $variation->id }}][price]" class="form-control" value="{{ $variation->price }}" placeholder="Enter price">
                                        </div>
                                        <div class="col-md-2">
                                            <button type="button" class="btn btn-danger remove-variation" data-variation-id="{{ $variation->id }}">Remove</button>
                                        </div>
                                    </div>
                                    @endforeach
                                @endif
                            </div>
                            <button type="button" class="btn btn-sm btn-success mt-2" id="add-simple-variation">+ Add Variation</button>
                        </div>

                        {{-- Shape Based Variations Container --}}
                        <div id="shape-variation-section" class="mb-3" style="display: {{ $hasShapes ? 'block' : 'none' }};">
                            <label class="form-label">Shape Based Variations</label>
                            <div id="shape-group-container">
                                @if($hasShapes)
                                    @foreach($product->variations->groupBy('shape_id') as $shapeId => $variations)
                                        @php 
                                            $shape = $variations->first()->shape; 
                                            // Fallback if shape is null (shouldn't happen if foreign key enforced, but handled just in case)
                                            $shapeName = $shape ? $shape->name : 'Unknown Shape';
                                        @endphp
                                        <div class="card mb-3 border">
                                            <div class="card-body bg-light">
                                                <div class="d-flex justify-content-between align-items-center mb-3">
                                                    <select class="form-control w-50" name="shape_group_{{ $loop->index }}_id" required>
                                                        @foreach($shapes as $s)
                                                            <option value="{{ $s->id }}" {{ $s->id == $shapeId ? 'selected' : '' }}>{{ $s->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <button type="button" class="btn btn-danger btn-sm remove-shape-group">Remove Group</button>
                                                </div>
                                                
                                                <div class="shape-variations-list">
                                                    @foreach($variations as $variation)
                                                        <div class="row mb-2 variation-row">
                                                            <input type="hidden" name="variations[{{ $variation->id }}][id]" value="{{ $variation->id }}">
                                                            <input type="hidden" name="variations[{{ $variation->id }}][shape_id]" value="{{ $shapeId }}" class="shape-id-input">
                                                            <div class="col-md-5">
                                                                <input type="text" name="variations[{{ $variation->id }}][size]" class="form-control" value="{{ $variation->size }}" placeholder="Size">
                                                            </div>
                                                            <div class="col-md-5">
                                                                <input type="number" name="variations[{{ $variation->id }}][price]" class="form-control" value="{{ $variation->price }}" placeholder="Price">
                                                            </div>
                                                            <div class="col-md-2">
                                                                <button type="button" class="btn btn-danger btn-sm remove-variation" data-variation-id="{{ $variation->id }}">X</button>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                
                                                <button type="button" class="btn btn-sm btn-info mt-2 add-variation-to-shape" data-group-id="{{ $loop->index }}">+ Add Variation</button>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <button type="button" class="btn btn-sm btn-primary mt-2" id="add-shape-group">+ Add Shape Group</button>
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
    <script>
        window.availableShapes = @json($shapes ?? []);
    </script>
    <script src="/js/custom/variant.js"></script>

    {{-- images script section --}}
    <script src="/js/custom/image.js"></script>

   
@endsection
