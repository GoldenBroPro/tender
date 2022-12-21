@extends('layout/account')

@section('content')
    @include('include.flash')
    @include('include.errors')

    <div class="row m-t">
        <div class="col-12 ">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover dataTables-userManagement">
                    <thead>
                        <tr>
                            <th>Имя</th>
                            <th>Фамилия</th>
                            <th>Статус</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($userList as $user)
                            <tr>
                                <td>{{ $user->firstname }}</td>
                                <td>{{ $user->lastname }}</td>
                                <td>
                                    @if ($user->um_user_status_id == 1)
                                        <span class="badge badge-primary">Активный</span>
                                    @elseif($user->um_user_status_id == 2)
                                        <span class="badge badge-danger">Заблокирован</span>
                                    @else
                                        <span class="badge badge-danger">Заблокирован</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($user->um_user_status_id == 1)
                                        <a class="btn btn-sm btn-danger"
                                            href="{{ url('/account/admin/user-management/change-status', $user->id) }}">Заблокировать</a>
                                    @elseif($user->um_user_status_id == 2)
                                        <a class="btn btn-sm btn-primary custom"
                                            href="{{ url('/account/admin/user-management/change-status', $user->id) }}">Разблокировать</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <script>
        $(document).ready(function() {

            function createDataTable() {
                $('.dataTables-userManagement').DataTable({
                    pageLength: 10,
                    responsive: true
                });
            }


            createDataTable();

        });
    </script>
@endsection
