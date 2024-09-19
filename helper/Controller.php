<?php /** @noinspection ALL */


class Controller extends System {

    public function load_model($model_name = false) {

        if(! $model_name) return;
        $model_path = PATH_MODEL . $model_name . '.php';

        if(file_exists($model_path)) {

            require_once($model_path);
            $model_name = preg_replace( '/[^a-zA-Z0-9]/is', '', $model_name );

            if(class_exists($model_name)) {
                return new $model_name();
            }

        }

    }

}