<?php

namespace App\Admin\Controllers;

use App\Models\Endpoint;
use App\Models\EndpointTarget;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class EndpointTargetController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(EndpointTarget::with('endpoint'), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('endpoint.title', 'endpoint');
            $grid->column('title');
            $grid->column('uri');
            $grid->column('method')->dropdown(EndpointTarget::methods);
            $grid->column('headers');
            $grid->column('body');
            $grid->column('enabled')->switch();
            $grid->column('updated_at')->sortable();
        
            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
                $filter->equal('endpoint_id', 'endpoint')->select(Endpoint::pluck('title', 'id'));
                $filter->equal('enabled')->select(EndpointTarget::enabled);
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
        return Form::make(new EndpointTarget(), function (Form $form) {
            
            $form->select('endpoint_id')->options(Endpoint::pluck('title', 'id'))->required();
            $form->text('title')->required();
            $form->text('uri')->required();
            $form->radio('method')->options(EndpointTarget::methods)->required();
            $form->jsoneditor('headers');
            $form->jsoneditor('body');
            $form->radio('enabled')->options(EndpointTarget::enabled)->default("1");
        
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
