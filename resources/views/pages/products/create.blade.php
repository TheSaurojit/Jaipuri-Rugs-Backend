@extends('layout.app')


@section('body-section')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Create Product</h4>



                    <form action="{{ route('products.create') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <x-form-field type="text" label="title" name="title" id="input-title" placeholder="enter title" />


                        <div class="mb-3">
                            <label for="description" class="form-label"> Description</label>
                            <textarea class="form-control" id="description" name="description" rows="5"
                                placeholder="Enter description"></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="category_id" class="form-label">Category</label>
                            <select class="form-control" id="category_id" name="category_id" required>
                                <option value="">Select Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>


                        <x-form-field type="text" label="meta keywords" name="meta_keywords" id="input-meta_keywords"
                            placeholder="enter meta keywords" />

                        <x-form-field type="number" label="price" name="price" id="input-price" placeholder="enter price" />

                        <x-form-field type="number" label="quantity" name="quantity" id="input-quantity"
                            placeholder="enter quantity" />

                        {{-- Product Variations --}}
                        <div class="mb-3">
                            <label class="form-label d-block">Does this product have shapes?</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="has_shapes" id="has_shapes_no" value="0"
                                    checked>
                                <label class="form-check-label" for="has_shapes_no">No</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="has_shapes" id="has_shapes_yes"
                                    value="1">
                                <label class="form-check-label" for="has_shapes_yes">Yes</label>
                            </div>
                        </div>

                        {{-- Simple Variations Container --}}
                        <div id="simple-variation-section" class="mb-3">
                            <label class="form-label">Variations</label>
                            <div id="simple-variation-container">
                                <div class="row mb-2 variation-row">
                                    <div class="col-md-5">
                                        <input type="text" name="variations[0][size]" class="form-control"
                                            placeholder="Enter size (e.g. 7x9 inch)">
                                    </div>
                                    <div class="col-md-5">
                                        <input type="number" name="variations[0][price]" class="form-control"
                                            placeholder="Enter price (e.g. 1100)">
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-danger remove-variation">Remove</button>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-sm btn-success mt-2" id="add-simple-variation">+ Add
                                Variation</button>
                        </div>

                        {{-- Shape Based Variations Container --}}
                        <div id="shape-variation-section" class="mb-3" style="display: none;">
                            <label class="form-label">Shape Based Variations</label>
                            <div id="shape-group-container">
                                {{-- Shape groups will be added here --}}
                            </div>
                            <button type="button" class="btn btn-sm btn-primary mt-2" id="add-shape-group">+ Add Shape
                                Group</button>
                        </div>


                        {{-- images start --}}
                        <div class="mb-3" style="padding: 10px 0">
                            <label for="images" class="form-label"> Images</label>
                            <input type="file" name="images[]" id="images" class="form-control" multiple accept="image/*">
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