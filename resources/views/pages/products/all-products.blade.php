@extends('layout.app')


@section('body-section')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-sm-4">
                        <!-- Helper text or search if needed -->
                        <h4 class="card-title">Products</h4>
                    </div>
                    <div class="col-sm-8">
                        <div class="text-sm-end">
                            <a href="{{ route('products.create') }}"
                                class="btn btn-primary btn-rounded waves-effect waves-light mb-2 me-2">
                                <i class="mdi mdi-plus me-1"></i> Add New Product
                            </a>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table align-middle table-nowrap table-check">
                        <thead class="table-light">
                            <tr>

                                <th class="align-middle">ID</th>
                                <th class="align-middle">Title</th>
                                <th class="align-middle">Category</th>

                                <th class="align-middle">Status</th>
                                <th class="align-middle">Quantity</th>


                                <th class="align-middle">Image</th>
                                <th class="align-middle">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>



                            @foreach ($products as $product)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $product->title }}</td>
                                <td>{{ $product->category->name }}</td>

                                <td class="{{ $product->is_active == true ? 'text-success' : 'text-danger' }} ">{{ Str::title($product->is_active ? 'Published' : 'Draft') }}</td>


                                <td>{{ $product->quantity }}</td>


                                <td>
                                    <img src="{{ $product->singleImage?->path }}" alt=""
                                        class="img-fluid" style="width: 100px; height: 100px;">

                                </td>

                                <td>
                                    <div class="d-flex gap-3">
                                        <a href="{{ route('products.update', ['product' => $product->id]) }}" class="text-success"><i
                                                class="mdi mdi-pencil font-size-18"></i></a>


                                        @php
                                        $url = route('products.delete', ['product' => $product->id]);
                                        @endphp

                                        <a href="#"
                                            onclick="showDeleteModal('{{ $url }}')" class="text-danger">

                                            <i class="mdi mdi-delete font-size-18"></i>
                                        </a>
                                    </div>
                                </td>

                            </tr>

                            @endforeach






                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection