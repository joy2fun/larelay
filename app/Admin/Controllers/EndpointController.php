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
    protected function grid()
    {
        return Grid::make(new Endpoint(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('slug');
            $grid->column('title');
            $grid->column('webhook_uri')->display(fn () => '/api/endpoint/' . $this->slug);
            $grid->column('enabled')->switch();
            $grid->column('updated_at')->sortable();
        
            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
                $filter->equal('enabled')->select(Endpoint::enabled);
            });
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
            $form->radio('enabled')->options(Endpoint::enabled)->default("1");
        
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
