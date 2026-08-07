<?php

use App\Models\App\AppFile;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

    if (!function_exists('app_update_session')) {
        function app_update_session($key, $data)
        {
        session()->forget($key);
        session([$key => $data]);
        session()->save();
        }
    }
    if (!function_exists('fun_set_locale')) {
        function fun_set_locale($locale)
        {
               // Optional: allow only supported locales
        $supported = ['en', 'it', 'sq','us']; // add your supported locales
        if ($locale && in_array($locale, $supported)) {
            App::setLocale($locale);
            Session::put('locale', $locale); // save in session
        } elseif (Session::has('locale')) {
            // fallback to session locale if parameter not provided
            App::setLocale(Session::get('locale'));
        } else {

            App::setLocale(config('app.locale')); // default locale
        }
        }
    }
    if (!function_exists('fun_save_file')) {
    function fun_save_file($file, string $directory = 'uploads', $disk = null)
    {
        $disk = $disk ?? config('filesystems.default');

        // Step 1: Create a blank AppFile record to get the ID
        $appFile = AppFile::create([
            'disk' => $disk,
        ]);

        // Step 2: Use the model ID as the filename
        $extension = $file->getClientOriginalExtension();
        $originalName = $file->getClientOriginalName();
        $fileName = $appFile->id . '.' . $extension;

        // Step 3: Store the file using the generated filename
        $path = $file->storeAs($directory, $fileName, $disk);

        // Step 4: Update the model with the real path and filename
        $appFile->update([
            'path' => $path,
            'file_name' => $fileName,
            'original_name' => $originalName,
        ]);

        // Step 5: Return a custom object
        $returnObj = new stdClass();
        $returnObj->id = $appFile->id;
        $returnObj->file = $appFile;

        return $returnObj;
    }
}
