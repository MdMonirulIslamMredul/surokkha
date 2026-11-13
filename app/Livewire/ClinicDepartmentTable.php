<?php

namespace App\Livewire;

use App\Models\ClinicDepartment;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Lazy;
use Livewire\WithPagination;
use Rappasoft\LaravelLivewireTables\Views\Column;

#[Lazy]
class ClinicDepartmentTable extends LivewireTableComponent
{
    use WithPagination;

    public $showButtonOnHeader = true;

    public $buttonComponent = 'clinic_departments.add-button';

    public $showFilterOnHeader = false;

    public $paginationIsEnabled = true;

    protected $model = ClinicDepartment::class;

    protected $listeners = ['refresh' => '$refresh', 'resetPage'];

    public function placeholder()
    {
        return view('livewire.skeleton_files.common_skeleton');
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setDefaultSort('created_at', 'desc')
            ->setQueryStringStatus(false);

        $this->setTdAttributes(function (Column $column, $row, $columnIndex, $rowIndex) {
            if ($column->isField('title') || $column->isField('short_description')) {
                return [
                    'class' => 'p-4',
                ];
            }

            return [];
        });
    }

    public function columns(): array
    {
        return [
            Column::make(__('messages.icon'), 'id')
                ->view('clinic_departments.columns.image'),
            Column::make('Department Name', 'title')
                ->view('clinic_departments.columns.title')
                ->sortable()
                ->searchable(),
            Column::make(__('messages.common.description'), 'short_description')
                ->sortable()
                ->searchable(),
            Column::make(__('messages.common.status'), 'is_active')
                ->view('clinic_departments.columns.status')
                ->sortable(),
            Column::make(__('messages.common.action'), 'id')
                ->view('clinic_departments.action'),
            Column::make('created_at')->sortable()->hideIf(1),
        ];
    }
}
