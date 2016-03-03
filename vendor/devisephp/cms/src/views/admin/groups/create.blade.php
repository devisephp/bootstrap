@extends('devise::admin.layouts.master')

@section('title')
    <div id="dvs-admin-title">
        <h1><span class="ion-ios-people"></span> New Group</h1>
    </div>
@stop

@section('subnavigation')
    <div id="dvs-admin-actions">
        <?= link_to(URL::route('dvs-groups'), 'List of Groups', array('class'=>'dvs-button dvs-button-secondary')) ?>
    </div>
@stop

@section('main')
	<div class="dvs-admin-form-horizontal">
	    <?= Form::open(array('route' => array('dvs-groups-store'))) ?>
		    <div class="dvs-form-group">
		        <?= Form::label('Name') ?>
		        <?= Form::text('name') ?>
                <span data-dvs-document="name" class="dvs-document-button"></span>
			</div>

            <div class="dvs-form-group">
                <div class="dvs-submit-margin">&nbsp;</div>
	               <?= Form::submit('Create Group', array('class' => 'dvs-button dvs-button-solid dvs-button-success')) ?>
                </div>
            </div>
	    <?= Form::close() ?>
	</div>
@stop