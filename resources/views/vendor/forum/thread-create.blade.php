@extends('forum::layouts.master')

@section('title', trans('forum::base.new_thread') . ' - ' . $category->title)

@section('content')

@include(
    'forum::partials.forms.post',
    array(
        'form_url'            => $category->newThreadRoute,
        'form_classes'        => '',
        'show_title_field'    => true,
        'post_content'        => '',
        'submit_label'        => trans('forum::base.send'),
        'cancel_url'          => ''
    )
)
@overwrite
