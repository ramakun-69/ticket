@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="row mb-3">
                <div class="col-12">
                    <a href="{{ url()->previous() }}" class="btn btn-danger btn-sm">{{ __('Back') }}</a>
                </div>
            </div>
            <div class="row">
                <div class="{{ Auth::user()->role != 'admin' ? 'col-6' : 'col-12' }}">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-3">{{ $title }}</h4>

                            <div class="row">
                                <div class="col-5">
                                    <p class="mb-0">{{ __('Ticket Number') }}</p>
                                </div>
                                <div class="col-1 text-end">:</div>
                                <div class="col-6">{{ $ticket->ticket_number }}</div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-5">
                                    <p class="mb-0">{{ __('Technician') }}</p>
                                </div>
                                <div class="col-1 text-end">:</div>

                                <div class="col-6">

                                    @foreach ($ticket?->technician->where('status', 1) as $tech)
                                        <li>{{ $tech?->technician?->name }}</li>
                                    @endforeach
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-5">
                                    <p class="mb-0">{{ __('Type') }}</p>
                                </div>
                                <div class="col-1 text-end">:</div>
                                <div class="col-6">{{ __($ticket->type) }}</div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-5">
                                    <p class="mb-0">{{ __('Category') }}</p>
                                </div>
                                <div class="col-1 text-end">:</div>
                                <div class="col-6">{{ Str::ucfirst($ticket->asset->category) }}</div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-5">
                                    <p class="mb-0">{{ __('Asset Number') }}</p>
                                </div>
                                <div class="col-1 text-end">:</div>
                                <div class="col-6">{{ $ticket->asset->code }}</div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-5">
                                    <p class="mb-0">
                                        {{ $ticket->asset->category == 'service' ? __('Sevice') : __('Asset Name') }}
                                    </p>
                                </div>
                                <div class="col-1 text-end">:</div>
                                <div class="col-6">{{ $ticket->asset->name }}</div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-5">
                                    <p class="mb-0">{{ __('Location') . ' ' . __('PIC ') }}</p>
                                </div>
                                <div class="col-1 text-end">:</div>
                                <div class="col-6">
                                    {{ $ticket->type == 'produksi' ? $ticket->asset?->location?->name : $ticket->asset?->pic?->name }}
                                </div>
                            </div>
                            @if ($ticket->asset->type != 'service')
                                <div class="row mt-2">
                                    <div class="col-5">
                                        <p class="mb-0">{{ __('Condition') }}</p>
                                    </div>
                                    <div class="col-1 text-end">:</div>
                                    <div class="col-6">{{ __($ticket->condition) }}</div>
                                </div>
                            @endif
                            <div class="row mt-2">
                                <div class="col-5">
                                    <p class="mb-0">{{ __('Problem Description') }}</p>
                                </div>
                                <div class="col-1 text-end">:</div>
                                <div class="col-6">{{ __($ticket->description) }}</div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-5">
                                    <p class="mb-0">{{ __('Damaged Time') }}</p>
                                </div>
                                <div class="col-1 text-end">:</div>
                                <div class="col-6">{{ toDateTimeIndo($ticket->damage_time) }}</div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-5">
                                    <p class="mb-0">{{ __('Downtime') }}</p>
                                </div>
                                <div class="col-1 text-end">:</div>
                                <div class="col-6">
                                    @if ($ticket->start_time != null && $ticket->finish_time != null)
                                        {{ downtime($ticket->start_time, $ticket->finish_time) }}
                                    @endif
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-5">
                                    <p class="mb-0">{{ __('Finish Time') }}</p>
                                </div>
                                <div class="col-1 text-end">:</div>
                                <div class="col-6">{{ $ticket->finish_time ? toDateTimeIndo($ticket->finish_time : "") }}</div>
                            </div>

                        </div> <!-- end card body-->
                    </div> <!-- end card -->
                </div>
                @if (Auth::user()->role != 'admin')
                    <div class="col-6">
                        <div class="d-lg-flex mb-4">


                            <div class="w-100 user-chat mt-4 mt-sm-0 card mb-0">

                                <div class="card-body">
                                    <div id="ticket-id" data-ticket-id="{{ $ticket->id }}"></div>
                                    <div class="pb-3 ">
                                        <div class="row">
                                            <div class="col-md-11 col-10">
                                                <h5 class="font-size-15 mb-1 text-truncate">{{ __('Comment') }}</h5>
                                            </div>


                                        </div>

                                    </div>

                                    <div class="chat-conversation py-3">
                                        <ul id="replies" class="list-unstyled mb-0 pe-3" data-simplebar
                                            style="max-height: 43vh; overflow-y: auto;">
                                            <div id="replies"></div>
                                        </ul>
                                        @if ($ticket->status != 'closed')
                                            <form action="" method="post" id="form-reply">
                                                @csrf
                                                <div class="px-lg-3">
                                                    <div class="pt-3">
                                                        <div class="row">
                                                            @if (Auth::user()->role == 'atasan' ||
                                                                    (Auth::user()->role == 'atasan teknisi' && $ticket->status != 'waiting approval') ||
                                                                    Auth::user()->role == 'teknisi' ||
                                                                    Auth::user()->role == 'staff')
                                                                <div class="col">
                                                                    <div class="position-relative">
                                                                        <input type="hidden" class="form-control"
                                                                            value="{{ $ticket->id }}" name="ticket_id">
                                                                        <input type="text"
                                                                            class="form-control chat-input"
                                                                            id="input-message" name="comment"
                                                                            placeholder="{{ __('Enter Message') }}"
                                                                            autocomplete="off">
                                                                    </div>
                                                                </div>
                                                                <div class="col-auto">
                                                                    <button type="submit"
                                                                        class="btn btn-danger chat-send w-md waves-effect waves-light"
                                                                        id="btn-submit" disabled>
                                                                        <span class="d-none d-sm-inline-block me-2">
                                                                            <span class="send-text">Send</span>
                                                                            <span class="spinner-border text-white"
                                                                                style="width: 15px; height: 15px; display: none"></span>
                                                                        </span>
                                                                        <i class="mdi mdi-send"></i>
                                                                    </button>
                                                                </div>
                                                            @endif

                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div><!-- end col-->
    </div>
    @widget('comment')
@endsection
