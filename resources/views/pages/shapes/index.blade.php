@extends('layout.app')

@section('body-section')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-4">
                            <h4 class="card-title">Shapes</h4>
                        </div>
                        <div class="col-sm-8">
                            <div class="text-sm-end">
                                <a href="{{ route('shapes.create') }}"
                                    class="btn btn-primary btn-rounded waves-effect waves-light mb-2 me-2">
                                    <i class="mdi mdi-plus me-1"></i> Add New Shape
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table align-middle table-nowrap table-check">
                            <thead class="table-light">
                                <tr>
                                    <th class="align-middle">ID</th>
                                    <th class="align-middle">Name</th>
                                    <th class="align-middle">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($shapes as $shape)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $shape->name }}</td>
                                        <td>
                                            <div class="d-flex gap-3">
                                                <a href="{{ route('shapes.edit', ['shape' => $shape->id]) }}"
                                                    class="text-success"><i class="mdi mdi-pencil font-size-18"></i></a>

                                                @php
                                                    $url = route('shapes.destroy', ['shape' => $shape->id]);
                                                @endphp

                                                <a href="#" onclick="showDeleteModal('{{ $url }}')" class="text-danger">
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