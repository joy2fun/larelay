<?php

namespace App\Admin\Controllers;

use App\Models\Endpoint;
use App\Models\EndpointTarget;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;
use Symfony\Component\ExpressionLanguage\SyntaxError;

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
            $grid->model()->orderByDesc('endpoint_id');
            $grid->column('id')->sortable();
            $grid->column('endpoint.url', 'endpoint');
            $grid->column('title');
            $grid->column('rule')->hide();
            $grid->column('uri');
            $grid->column('headers')->hide();
            $grid->column('body')->hide();
            $grid->column('method')->dropdown(EndpointTarget::methods);
            $grid->column('enabled')->switch();
            $grid->column('created_at')->hide();
            $grid->column('updated_at');

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('endpoint_id', 'endpoint')->select(Endpoint::all()->pluck('url', 'id'));
                $filter->equal('enabled')->select(EndpointTarget::enabled);
            });

            $grid->disableColumnSelector(false);
            $grid->disableRefreshButton();
            $grid->disableViewButton();
            $grid->quickSearch(['endpoint.title', 'title']);
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
            $form->select('endpoint_id', 'Endpoint')->options(Endpoint::all()->pluck('title-and-url', 'id'))->required();
            $form->text('title')->required();
            $form->textarea('rule')->rules(function (Form $form) {
                try {
                    strlen($form->rule) && (new ExpressionLanguage)->lint($form->rule, ['req', 'now']);
                } catch (SyntaxError $e) {
                    return fn (string $attribute, mixed $value, \Closure $fail) => $fail($e->getMessage());
                }
            });
            $form->text('uri')->required();
            $form->radio('method')->options(EndpointTarget::methods)->default('POST');
            $form->jsoneditor('headers')->rules(function (Form $form) {
                try {
                    foreach(EndpointTarget::parsePlaceHolders($form->headers) as $expr) {
                        (new ExpressionLanguage)->lint($expr, ['req', 'now']);
                    }
                } catch (SyntaxError $e) {
                    return fn (string $attribute, mixed $value, \Closure $fail) => $fail($e->getMessage());
                }
            });;
            $form->jsoneditor('body')->rules(function (Form $form) {
                try {
                    foreach(EndpointTarget::parsePlaceHolders($form->body) as $expr) {
                        (new ExpressionLanguage)->lint($expr, ['req', 'now']);
                    }
                } catch (SyntaxError $e) {
                    return fn (string $attribute, mixed $value, \Closure $fail) => $fail($e->getMessage());
                }
            });
            $form->switch('enabled')->default(1);
        });
    }
}
