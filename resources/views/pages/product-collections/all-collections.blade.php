@extends('layout.app')

@section('body-section')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-sm-4">
                        <h4 class="card-title">Product Collections</h4>
                    </div>
                    <div class="col-sm-8">
                        <div class="text-sm-end">
                            <a href="{{ route('product-collections.create') }}"
                                class="btn btn-primary btn-rounded waves-effect waves-light mb-2 me-2">
                                <i class="mdi mdi-plus me-1"></i> Add New Collection
                            </a>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table align-middle table-nowrap table-check">
                        <thead class="table-light">
                            <tr>
                                <th class="align-middle">ID</th>
                                <th class="align-middle">Collection Name</th>
                                <th class="align-middle">Products Count</th>
                                <th class="align-middle">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($collections as $collection)
                            <tr>
                                <td>{{ $loop->iteration }} </td>
                                <td>{{ $collection->name }}</td>
                                <td>{{ $collection->products_count }}</td>
                                <td>
                                    <div class="d-flex gap-3">
                                        <a href="{{ route('product-collections.edit', $collection->id) }}" class="text-success"><i
                                                class="mdi mdi-pencil font-size-18"></i></a>

                                        @php
                                        $url = route('product-collections.destroy', $collection->id);
                                        @endphp
                                        <a href="#" class="text-danger"
                                            onclick="showDeleteModal('{{ $url }}')">
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