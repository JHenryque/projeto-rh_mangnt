<x-layout-app page-title="Human resources">

    <div class="w-100 p-4">

        <h3>Human Resources Colaborator</h3>

        <hr>

        @if($colaborators->count() === 0)
            <div class="text-center my-5">
                <p>No departments found.</p>
                <a href="{{ route('colaborators.new-colaborator') }}" class="btn btn-primary">Create a new Colaborator</a>
            </div>
        @else
            <div class="mb-3">
                <a href="{{ route('colaborators.new-colaborator') }}" class="btn btn-primary">Create a new Colaborator</a>
            </div>
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

                                    <a href="{{ route('colaborators.edit-colarator', ['id'=> $colaborator->id]) }}" class="btn btn-sm btn-outline-dark ms-3"><i class="fa-regular fa-pen-to-square me-2"></i>Edit</a>
                                    <a href="{{ route('colaborators.delete-colarator', ['id'=> $colaborator->id]) }}" class="btn btn-sm btn-outline-danger ms-3"><i class="fa-regular fa-trash-can me-2"></i>Delete</a>

                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif

    </div>

</x-layout-app>
