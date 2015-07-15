@extends('devise::admin.layouts.master')

@section('title')
    <div id="dvs-admin-title">
        <h1><span class="ion-android-menu"></span> Menus</h1>
    </div>
@stop

@section('subnavigation')
    <div id="dvs-admin-actions">
        <?= Form::select('language_id', $languages, (!Input::has('language_id')) ? Config::get('devise.languages.primary_language_id') : Input::get('language_id'), array('id' => 'lang-select', 'class' => 'dvs-select dvs-button-solid')) ?>
    </div>
@stop

@section('main')
    <div class="dvs-admin-form-vertical">

        <h4>Create New Menu</h4>

    	<?= Form::open(['route' => 'dvs-menus-store']) ?>
    		<div class="dvs-form-group">

    	    	<?= Form::text('name', null, array('placeholder' => 'Menu Name', 'class' => 'form-control')) ?>
                <?= Form::hidden('language_id', (!Input::has('language_id')) ? Config::get('devise.languages.primary_language_id') : Input::get('language_id')) ?>
    		</div>

    		<?= Form::submit('Create New Menu', array('class' => 'dvs-button dvs-button-success dvs-button-solid')) ?>
        <?= Form::close() ?>
    </div>

    <table class="dvs-admin-table">
    	<thead>
    		<tr>
    			<th class="dvs-tac"><?= Sort::link('name','Menu Name') ?></th>
                <th class="dvs-tac"><?= Sort::link('language_id','Language') ?></th>
                <th><?= Sort::clearSortLink('Clear Sort', array('class'=>'dvs-button dvs-button-small dvs-button-outset')) ?></th>
    		</tr>
    	</thead>

    	<tbody id="menus">
    		@foreach($menus as $menu)
    			<tr>
                    <td class="dvs-tac"><?= $menu->name ?></td>
    				<td class="dvs-tac"><?= $menu->language->name ?></td>
    				<td class="dvs-tac">
    					<a href="<?= route('dvs-menus-edit', $menu->id) ?>" class="dvs-button dvs-button-small">Edit</a>
                        @if (!$page->dvs_admin)
    						<?php /* Form::delete(URL::route('dvs-menus-destroy', array($menu->id)), 'Delete', null, array('class'=>'dvs-button dvs-button-small dvs-button-danger')) */ ?>
    					@endif
                    </td>
    			</tr>
    		@endforeach
    	</tbody>

        <tfoot>
            <tr>
                <td colspan="3"><?= $menus->appends(Input::except(['page']))->render() ?></td>
            </tr>
        </tfoot>
    </table>

    <script>devise.require(['app/admin/admin'])</script>
@stop