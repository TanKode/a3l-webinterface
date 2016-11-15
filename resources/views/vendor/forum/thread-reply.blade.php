@extends('forum::layouts.master')

@section('title', trans('forum::base.new_reply') . ' - ' . $thread->title)

@section('content')

@include(
    'forum::partials.forms.post',
    array(
        'form_url'          => $thread->replyRoute,
        'form_classes'      => '',
        'show_title_field'  => false,
        'post_content'      => '',
        'submit_label'      => trans('forum::base.reply'),
        'cancel_url'        => $thread->route
    )
)
@overwrite
