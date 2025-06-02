<x-layout-app pageTitle="Colaborators">

    <div class="w-100 p-4">

        <h3>All colaborators</h3>

        <hr>
        <div class="my-3">
            <a href="{{ route('rh.management.new-colaborator') }}" class="btn btn-primary">Create a new colaborator</a>
        </div>

        <!-- table  Página Admin Com Todos os Colaboradores -->
        @if($colaborators->count() === 0)
            <div class="text-center my-5">
                <p>No departments found.</p>
                <a href="{{ route('rh.management.new-colaborator') }}" class="btn btn-primary">Create a new colaborator</a>
            </div>
        @else
            <table class="table" id="table">
                <thead class="table-dark">
                <th>Nome</th>
                <th>E-mail</th>
                <th>Active</th>
                <th>Department</th>
                <th>Role</th>
                <th>Admission date</th>
                <th>Salary</th>
                <th></th>
                </thead>
                <tbody>
                @foreach($colaborators as $colaborator)
                    <tr>
                        <td>{{ $colaborator->name }}</td>
                        <td>{{ $colaborator->email }}</td>
                        <td>
                            @empty($colaborator->email_verified_at)
                                <div class="badge bg-danger">No</div>
                            @else
                                <div class="badge bg-success">Yes</div>
                            @endempty
                        </td>
                        <td>{{ $colaborator->department->name }}</td>
                        <td>{{ $colaborator->role }}</td>
                        <td>{{ $colaborator->detail->admission_date }}</td>
                        <td>{{ $colaborator->detail->salary }}</td>

                        <td>
                            <div class="d-flex gap-3 justify-content-end">

                               @if(empty($colaborator->deleted_at))
                                    <a href="{{ route('rh.management.edit-colaborator', ['id' => $colaborator->id ]) }}" class="btn btn-sm btn-outline-dark ms-3"><i class="fa-regular fa-edit me-2"></i>Edit</a>
                                    <a href="#" class="btn btn-sm btn-outline-danger ms-3"><i class="fa-regular fa-trash-can me-2"></i>Delete</a>
                                    <a href="{{ route('rh.management.details', ['id'=> $colaborator->id]) }}" class="btn btn-sm btn-outline-dark ms-3"><i class="fa-regular fa-eye me-2"></i>Details</a>
                                @else
                                    <a href="#" class="btn btn-sm btn-outline-danger ms-3"><i class="fa-solid fa-trash-arrow-up me-2"></i>Restore</a>
                                @endif

                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>

</x-layout-app>
