<div>
    <div class="row">
        <div class="col-12 mb-4">
            <div class="row">
                <div class="col-xxl-3 col-xl-4 col-sm-6 widget">
                    <a class="text-decoration-none" href="{{ route('appointments.index') }}">
                        <div
                            class="bg-white shadow-md rounded-10 p-xxl-10 px-7 py-10 d-flex align-items-center justify-content-between my-3">
                            <div
                                class="bg-primary widget-icon rounded-10 d-flex align-items-center justify-content-center">
                                <i class="fas fa-calendar-check fs-1 text-white"></i>
                            </div>
                            <div class="text-end">
                                <h2 class="fs-1-xxl fw-bolder text-primary">
                                    {{ $totlaAppointment }}</h2>
                                <h3 class="mb-0 fs-5 fw-bold text-dark">
                                    {{ __('messages.dashboard.total_appointment') }}
                                </h3>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-xxl-3 col-xl-4 col-sm-6 widget">
                    <a class="text-decoration-none" href="{{ route('appointments.index') }}">
                        <div
                            class="bg-white shadow-md rounded-10 p-xxl-10 px-7 py-10 d-flex align-items-center justify-content-between my-3">
                            <div
                                class="bg-primary widget-icon rounded-10 d-flex align-items-center justify-content-center">
                                <i class="fa-regular fa-calendar-plus fs-1 text-white"></i>
                            </div>
                            <div class="text-end">
                                <h2 class="fs-1-xxl fw-bolder text-primary">
                                    {{ $todayAppointment }}</h2>
                                <h3 class="mb-0 fs-5 fw-bold text-dark">
                                    {{ __('messages.dashboard.today_appointment') }}
                                </h3>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-xxl-3 col-xl-4 col-sm-6 widget">
                    <a class="text-decoration-none" href="{{ route('live.consultation.index') }}">
                        <div
                            class="bg-white shadow-md rounded-10 p-xxl-10 px-7 py-10 d-flex align-items-center justify-content-between my-3">
                            <div
                                class="bg-primary widget-icon rounded-10 d-flex align-items-center justify-content-center">
                                <i class="fa fa-video fs-1 text-white"></i>
                            </div>
                            <div class="text-end">
                                <h2 class="fs-1-xxl fw-bolder text-primary">
                                    {{ $totalMeeting }}</h2>
                                <h3 class="mb-0 fs-5 fw-bold text-dark">
                                    {{ __('messages.dashboard.total_meeting') }}
                                </h3>
                            </div>
                        </div>
                    </a>
                </div>
                @if ($modules['Bills'] == true)
                    <div class="col-xxl-3 col-xl-4 col-sm-6 widget">
                        <a class="text-decoration-none" href="{{ route('employee.bills.index') }}">
                            <div
                                class="bg-white shadow-md rounded-10 p-xxl-10 px-7 py-10 d-flex align-items-center justify-content-between my-3">
                                <div
                                    class="bg-primary widget-icon rounded-10 d-flex align-items-center justify-content-center">
                                    <i class="fa-solid fa-coins fs-1 text-white"></i>
                                </div>
                                <div class="text-end">
                                    <h2 class="fs-1-xxl fw-bolder text-primary">
                                        {{getCurrencySymbol().' '. formatCurrency($patientBill)}}</h2>
                                    <h3 class="mb-0 fs-5 fw-bold text-dark">
                                        {{ __('messages.dashboard.total_bills') }}
                                    </h3>
                                </div>
                            </div>
                        </a>
                    </div>
                @endif
                {{-- Appointment table --}}
                <div class="col-xxl-12 col-12 mb-7">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="mb-4">
                                {{ __('messages.dashboard.recent_appointments') }}
                            </h3>
                            <livewire:dashboard-appointment-table>
                        </div>
                    </div>
                </div>
                {{-- end Appointment table --}}

                {{-- Treatments & Prescribed Medicines --}}
                <div class="col-xxl-6 col-12 mb-7">
                    <div class="card h-100">
                        <div class="card-header border-0 pt-5">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bolder fs-3 text-dark">
                                    <i class="fa-solid fa-file-prescription text-primary me-2"></i> Treatments & Prescriptions
                                </span>
                                <span class="text-muted mt-1 fw-bold fs-7">Your recent medical treatments and prescribed medicines</span>
                            </h3>
                        </div>
                        <div class="card-body py-3">
                            <div class="table-responsive">
                                <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                                    <thead>
                                        <tr class="fw-bolder text-muted bg-light">
                                            <th class="ps-4 rounded-start">Doctor</th>
                                            <th>Date</th>
                                            <th>Medicines & Dosage</th>
                                            <th class="rounded-end text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($prescriptions as $pres)
                                            <tr>
                                                <td class="ps-4 fw-bold">
                                                    {{ $pres->doctor->doctorUser->full_name ?? 'Doctor' }}
                                                </td>
                                                <td>{{ $pres->created_at->format('d M, Y') }}</td>
                                                <td>
                                                    @if(!empty($pres->pt_rx))
                                                        <div class="fs-7 text-success fw-bold mb-1">
                                                            <i class="fas fa-hand-holding-medical me-1"></i> PT: {{ \Illuminate\Support\Str::limit($pres->pt_rx, 50) }}
                                                        </div>
                                                    @endif
                                                    @if($pres->getMedicine && $pres->getMedicine->count() > 0)
                                                        @foreach($pres->getMedicine->take(2) as $med)
                                                            <div class="fs-7">
                                                                <i class="fas fa-pills text-primary me-1"></i>
                                                                <strong>{{ $med->medicines->first()->name ?? $med->medicine }}</strong>
                                                                <span class="text-muted">({{ $med->dosage ?? '' }} - {{ $med->day ?? '' }})</span>
                                                            </div>
                                                        @endforeach
                                                        @if($pres->getMedicine->count() > 2)
                                                            <span class="badge bg-light-primary text-primary fs-8">+{{ $pres->getMedicine->count() - 2 }} more</span>
                                                        @endif
                                                    @elseif(empty($pres->pt_rx))
                                                        <span class="text-muted fs-7">No medicines listed</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{ route('prescription.show', $pres->id) }}" class="btn btn-icon btn-sm btn-light-primary" title="View Prescription">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center py-6 text-muted">
                                                    No prescriptions recorded yet.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Diagnostic & Laboratory Tests / Results --}}
                <div class="col-xxl-6 col-12 mb-7">
                    <div class="card h-100">
                        <div class="card-header border-0 pt-5">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bolder fs-3 text-dark">
                                    <i class="fa-solid fa-flask text-success me-2"></i> Diagnostic Tests & Lab Results
                                </span>
                                <span class="text-muted mt-1 fw-bold fs-7">Your ordered pathology, radiology tests, and results</span>
                            </h3>
                        </div>
                        <div class="card-body py-3">
                            <div class="table-responsive">
                                <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                                    <thead>
                                        <tr class="fw-bolder text-muted bg-light">
                                            <th class="ps-4 rounded-start">Bill / Order #</th>
                                            <th>Tests & Services</th>
                                            <th>Paid</th>
                                            <th>Date</th>
                                            <th class="rounded-end text-center">Receipt</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($testBills as $tb)
                                            <tr>
                                                <td class="ps-4 fw-bold text-primary">
                                                    {{ $tb->bill_number }}
                                                </td>
                                                <td>
                                                    @foreach($tb->items->take(2) as $item)
                                                        <div class="fs-7">
                                                            <span class="badge bg-light-secondary text-dark me-1">{{ $item->item_type }}</span>
                                                            {{ $item->item_name }}
                                                        </div>
                                                    @endforeach
                                                    @if($tb->items->count() > 2)
                                                        <span class="badge bg-light-info text-info fs-8">+{{ $tb->items->count() - 2 }} more</span>
                                                    @endif
                                                </td>
                                                <td class="fw-bold text-success">
                                                    {{ getCurrencySymbol() }} {{ number_format($tb->net_amount, 2) }}
                                                </td>
                                                <td>{{ $tb->created_at->format('d M, Y') }}</td>
                                                <td class="text-center">
                                                    <a href="{{ route('test-service-bills.pdf', $tb->id) }}" target="_blank" class="btn btn-icon btn-sm btn-light-info" title="Download PDF Receipt">
                                                        <i class="fas fa-file-pdf"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center py-6 text-muted">
                                                    No diagnostic tests or services billed yet.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
