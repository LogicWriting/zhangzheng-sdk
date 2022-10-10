<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\CutGood;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class CutGoodController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new CutGood(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('goods_name');
            $grid->column('image_url')->display(function ($path){
                return json_decode($path,true);
            })->image('',100,100);
            $grid->column('min_price');
            $grid->column('start_time');
            $grid->column('end_time');
            $grid->column('people_limit');
            $grid->column('cut_count');
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
                // 更改为 rightSide 布局

            });
        });
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     *
     * @return Show
     */
    protected function detail($id)
    {
        return Show::make($id, new CutGood(), function (Show $show) {
            $show->field('id');
            $show->field('goods_name');
            $show->field('image_url');
            $show->field('min_price');
            $show->field('start_time');
            $show->field('end_time');
            $show->field('people_limit');
            $show->field('cut_count');
            $show->field('created_at');
            $show->field('updated_at');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new CutGood(), function (Form $form) {
            $form->display('id');
            $form->text('goods_name');
            $form->multipleImage('image_url')->saving(function ($path){
                return json_encode($path);
            })->uniqueName()->autoUpload()->saveFullUrl();
            $form->text('min_price');
            $form->text('start_time');
            $form->text('end_time');
            $form->text('people_limit');
            $form->text('cut_count');

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
