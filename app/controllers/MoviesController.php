<?php

class MoviesController extends BaseController {
    public function __construct() {
        $this->beforeFilter('csrf', array('on'=>'post'));
    }

    public function postCreate() {
        $validator = Validator::make(Input::all(), Movie::$rules);

        if($validator->passes()) {
            $movie = new Movie;
            $movie->type = Input::get('type');
            $movie->name = Input::get('name');
            $movie->year = Input::get('year');
            $movie->runtime = Input::get('runtime');
            $movie->genre = Input::get('genre');
            $movie->description = Input::get('description');
            $movie->save();

            return Redirect::to(Input::get('ressource'))->with('message', 'Vielen Dank, dein Film wurde erfolgreich gespeichert!');
        } else {
            return Redirect::to(Input::get('ressource'))->with('message', 'Leider ist ein Fehler aufgetreten. Versuche es doch noch einmal.')->withErrors($validator)->withInput();
        }
    }
}