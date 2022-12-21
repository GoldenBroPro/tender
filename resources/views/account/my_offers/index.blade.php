@extends('layout/account')

@section('content')
    <div class="row">
        <div class="col-12 ">

            <div class="table-responsive">

                <table class="table table-striped table-bordered table-hover dataTables-mybids">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>ID</th>
                            <th>Категория</th>
                            <th>Осталось дней</th>
                            <th>Статус</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($Offers as $Offer)
                            <tr>

                                <td>{{ $Offer->id }}</td>
                                <td>{{ $Offer->tm_tender_id }}</td>
                                <td>{{ $Offer->tender->category->name }}</td>
                                <td>{{ $Offer->tender->daysRemain() }}</td>
                                <td> <span
                                        class=" label label-{{ $Offer->offerStatus->class_name }}">{{ $Offer->offerStatus->name }}</span>
                                </td>
                                <td><a class="linkos" target="_blank" href="{{ url('offer', $Offer->id) }}">Смотреть</a></td>

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
                $('.dataTables-mybids').DataTable({
                    pageLength: 10,
                    responsive: true
                });
            }
            createDataTable();
        });
    </script>
@endsection
