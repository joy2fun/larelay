<?php

namespace App\Admin\Controllers;

use App\Models\Endpoint;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class EndpointController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    public function grid()
    {
        return Grid::make(new Endpoint(), function (Grid $grid) {
            $grid->model()->orderByDesc('id');
            $grid->column('id')->sortable();
            $grid->column('slug')->editable();
            $grid->column('title')->editable();
            $grid->column('url')->link(null, '_blank');
            $grid->column('enabled')->switch();
            $grid->column('updated_at')->sortable();
        
            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('enabled')->select(Endpoint::enabled);
            });

            $grid->disableRefreshButton();
            $grid->disableViewButton();
            $grid->quickSearch(['title', 'slug']);
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new Endpoint(), function (Form $form) {
            
            $form->text('slug')->required();
            $form->text('title')->required();
            $form->switch('enabled')->default(1);
        });
    }
}
