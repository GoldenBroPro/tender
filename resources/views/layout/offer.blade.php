@extends('layout/main')

@section('content')
    <div class="row m-t">
        <div class="col-6">
            <div class="panel panel-default">
                <div class="panel-heading text-primary">
                    <h4><strong>Общие сведения</strong></h4>
                </div>
                <div class="panel-body">
                    <table class="table table-striped">
                        <tr>
                            <td>ID</td>
                            <td>{{ $Tender->id }}</td>
                        </tr>
                        <tr>
                            <td>Название</td>
                            <td>{{ $Tender->title }}</td>
                        </tr>
                        <tr>
                            <td>Описание</td>
                            <td>{{ $Tender->description }}</td>
                        </tr>
                        <tr>
                            <td>Категория</td>
                            <td>
                                <span class="d-inline-flex">
                                    {{ $Tender->category->name }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td>Начальная цена</td>
                            <td>{{ sprintf('%0.2f', $Tender->estimate_cost) }} ₽</td>
                        </tr>
                        <tr>
                            <td>Сумма задатка </td>
                            <td>{{ sprintf('%0.2f', $Tender->deposit) }} ₽</td>
                        </tr>
                        <tr>
                            <td>Дата начала</td>
                            <td>{{ $Tender->getStartDate() }}</td>
                        </tr>
                        <tr>
                            <td>Дата окончания</td>
                            <td>{{ $Tender->getEndDate() }}</td>
                        </tr>
                        <tr>
                            <td>Адрес</td>
                            <td>{{ $Tender->location }}</td>
                        </tr>
                    </table>
                </div>
            </div>

        </div>
        <div class="col-6">
            @yield('content-right')
        </div>
    </div>
@endsection
