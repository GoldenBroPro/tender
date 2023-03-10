@extends('layout/offer')

@section('content-right')
    @foreach ($TenderOffers as $Offer)
        <div class="panel panel-primary">
            <div class="panel-heading text-white">
                <h4><strong>{{ $Offer->id }}</strong></h4>
            </div>
            <div class="panel-body">
                <table class="table table-striped">
                    <tr>
                        <td>Статус</td>
                        <td> <span
                                class=" label label-{{ $Offer->offerStatus->class_name }}">{{ $Offer->offerStatus->name }}</span>

                        </td>
                    </tr>
                    <tr>
                        <td>Поставщик</td>
                        <td>{{ $Offer->createdBy->user->firstname }} {{ $Offer->createdBy->user->lastname }}</td>
                    </tr>
                    <tr>
                        <td>Компания</td>
                        <td>{{ $Offer->createdBy->company_name }}</td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td><a
                                href="mailto:{{ $Offer->createdBy->contact_email }}">{{ $Offer->createdBy->contact_email }}</a>
                        </td>
                    </tr>
                    <tr>
                        <td>Контакты</td>
                        <td><a
                                href="tel:{{ $Offer->createdBy->contact_mobile }}">{{ $Offer->createdBy->contact_mobile }}</a>&nbsp;
                            / &nbsp;<a
                                href="tel:{{ $Offer->createdBy->contact_office }}">{{ $Offer->createdBy->contact_office }}</a>
                        </td>
                    </tr>
                    <tr>
                        <td>Сумма ставки </td>
                        <td>{{ $Offer->bid_amount }} ₽</td>
                    </tr>
                    <tr>
                        <td>Период</td>
                        <td>{{ $Offer->period }} </td>
                    </tr>
                    <tr>
                        <td>Примечание</td>
                        <td>{{ $Offer->note }} </td>
                    </tr>

                    <tr class="table-dark">
                        @if ($Offer->om_offer_status_id === config('global.offer_status_pending'))
                            <td>Действие</td>
                            <td>
                                <form method="POST" action="{{ url('/offer-actions/update-state') }}">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="offer_id" value="{{ $Offer->id }}" />
                                    <input type="hidden" name="tender_id" value="{{ $Tender->id }}" />
                                    <input class="btn btn-secondary btn-lg" name="action" type="submit"
                                        value="{{ config('global.offer_status_action_approve') }}" />
                                    &nbsp;
                                    <input class="btn btn-danger" name="action" type="submit"
                                        value="{{ config('global.offer_status_action_reject') }}" />
                                </form>
                            </td>
                        @endif

                        @if ($Offer->om_offer_status_id !== config('global.offer_status_pending'))
                            <td>Действие</td>
                            <td>
                                <form method="POST" action="{{ url('/offer-actions/update-state') }}">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="offer_id" value="{{ $Offer->id }}" />
                                    <input type="hidden" name="tender_id" value="{{ $Tender->id }}" />
                                    <input class="btn btn" name="action" type="submit"
                                        value="{{ config('global.offer_status_action_revert') }}" />
                                </form>
                            </td>
                        @endif
                    </tr>
                </table>
            </div>

        </div>
    @endforeach

    {{ $TenderOffers->links() }}
@endsection
