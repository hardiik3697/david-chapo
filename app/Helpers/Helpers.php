<?php
    if (!function_exists('_settings')) {
        function _settings($key = '') {
            if($key == '')
                return NULL;

            $data = DB::table('settings')->select('value')->where(['key' => $key])->first();

            if(!empty($data))
                return $data->value;
            else
                return NULL;
        }
    }

    if (!function_exists('_path')) {
        function _path($folder = '') {
            if($folder == '')
                return asset('/uploads/').'/';
            else
                return asset('/uploads/').'/'.$folder.'/';
        }
    }
?>