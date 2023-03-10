@extends('layout/account')

@section('content')
    <div class="row m-t">
        <div class="col-12 ">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover dataTables-draftTenders">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Название</th>
                            <th>Описание</th>
                            <th>Статус</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($draftTenders as $tenders)
                            <tr>
                                <td>{{ $tenders->id }}</td>
                                <td>{{ $tenders->title }}</td>
                                <td>{{ $tenders->description }}</td>
                                <td><span class="badge badge-default">ЧЕРНОВИК</span></td>
                                <td>
                                    <a class="btn btn-sm btn-default float-right m-r"
                                        href="{{ url('/account/admin/drafts/edit', $tenders->id) }}"><i
                                            class="fa fa-edit"></i></a>
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
                $('.dataTables-draftTenders').DataTable({
                    pageLength: 10,
                    responsive: true
                });
            }


            createDataTable();

        });
    </script>
@endsection
