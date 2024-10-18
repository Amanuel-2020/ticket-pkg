@extends('Dashboard::master')
@section('breadcrumb')
    <li><a href="{{route('tickets.index')}}" title="Tickets">Tickets</a></li>
@endsection
@section('content')
    <div class="tab__box">
        <div class="tab__items">
            <a class="tab__item {{request()->status == "" ? "is-active": ""}}" href="{{route("tickets.index")}}">
                All Tickets</a>
            @can(\Abd\RolePermissions\Models\Permission::PERMISSION_MANAGE_TICKETS)
                <a class="tab__item {{request()->status == \Abd\Ticket\Models\Ticket::STATUS_OPEN ? "is-active": ""}}"
                   href="?{{request()->getQueryString()}}&status={{\Abd\Ticket\Models\Ticket::STATUS_OPEN}}">
                    New (Unread)</a>
                <a class="tab__item {{request()->status == \Abd\Ticket\Models\Ticket::STATUS_REPLIED ? "is-active": ""}}"
                   href="?{{request()->getQueryString()}}&status={{\Abd\Ticket\Models\Ticket::STATUS_REPLIED}}">
                    Replied</a>
                <a class="tab__item {{request()->status == \Abd\Ticket\Models\Ticket::STATUS_CLOSE ? "is-active": ""}}"
                   href="?{{request()->getQueryString()}}&status={{\Abd\Ticket\Models\Ticket::STATUS_CLOSE}}">
                    Closed</a>
                <a class="tab__item {{request()->status == \Abd\Ticket\Models\Ticket::STATUS_PENDING ? "is-active": ""}}"
                   href="?{{request()->getQueryString()}}&status={{\Abd\Ticket\Models\Ticket::STATUS_PENDING}}">
                    Pending</a>
            @endcan
            <a class="tab__item" href="{{route("tickets.create")}}">Submit New Ticket</a>
        </div>
    </div>
    @can(\Abd\RolePermissions\Models\Permission::PERMISSION_MANAGE_TICKETS)
        <div class="bg-white padding-20">
            <div class="t-header-search">
                <form action="{{route("tickets.index")}}">
                    <div class="t-header-searchbox font-size-13">
                        <input type="text" class="text search-input__box font-size-13" name="title"
                               value="{{request()->title}}" placeholder="Search Tickets"/>
                        <div class="t-header-search-content">
                            <input type="text" class="text" name="email" value="{{request()->email}}"
                                   placeholder="Email">
                            <input type="text" class="text" name="name" value="{{request()->name}}"
                                   placeholder="Full Name">
                            <input type="text" class="text margin-bottom-20" name="date" value="{{request()->date}}"
                                   placeholder="Date">
                            <button class="btn btn-brand" type="submit">Search</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endcan
    <div class="row no-gutters">
        <div class="col-12 margin-left-10 margin-bottom-15 border-radius-3">
            <p class="box__title">Tickets</p>
            <div class="table__box">
                <table class="table">
                    <thead role="rowgroup">
                    <tr role="row" class="title-row">
                        <th>ID</th>
                        <th>Ticket Title</th>
                        <th>Sender Name</th>
                        <th>Sender Email</th>
                        <th>Last Updated</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($tickets as $ticket)
                        <tr role="row" class="">
                            <td>{{$ticket->id}}</td>
                            <td><a href="{{route('tickets.show', $ticket->id)}}">{{$ticket->title}}</a></td>
                            <td>{{$ticket->user->name}}</td>
                            <td>{{$ticket->user->email}}</td>
                            <td>{{\Morilog\Jalali\Jalalian::fromCarbon($ticket->updated_at)}}</td>
                            <td>@lang($ticket->status)</td>
                            <td>
                                <a href="{{route("tickets.close", $ticket->id)}}">Close Ticket</a>
                                @can(\Abd\RolePermissions\Models\Permission::PERMISSION_MANAGE_TICKETS)
                                    <a href=""
                                       onclick="deleteItem(event, '{{ route('tickets.destroy', $ticket->id)}}');"
                                       class="item-delete mlg-15" title="Delete"></a>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
