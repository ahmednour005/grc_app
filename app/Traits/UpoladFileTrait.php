<?php

namespace App\Traits;

/**
 * This trait for handling store or delete file
 *
 */
trait UpoladFileTrait
{
    /*
    * How to use
    * 1. storeFile($request->file('file'), 'uploads/users')
    * 2. storeFile($request->file('file'), 'uploads/users', public_path() . "/uploaded-files/supplier/logo/xyz.png")
    * 3. storeFile($request->file('file'), 'uploads/users', public_path() . "/uploaded-files/supplier/logo/xyz.png", 'xyz2')*
    */
    public function storeFile($file, $publicPath, $oldStoredFileURL = null, $newStoredFileName = null)
    {
        // Start get file name
        if (!$newStoredFileName)
            $newStoredFileName = time() . '_' . $file->getClientOriginalName();

        // $newStoredFileName .= '.' . $file->getClientOriginalExtension();
        // End get file name


        // Start delete old stored file to server
        if ($oldStoredFileURL && file_exists($oldStoredFileURL))
            unlink($oldStoredFileURL);
        // End delete old stored file to server


        // Start store file to server
        $file->move(public_path($publicPath), $newStoredFileName);
        // End store file to server

        return $publicPath . '/' . $newStoredFileName;
    }

    /*
    * How to use
    * 1. deleteStoredFile(public_path() . "/uploaded-files/supplier/logo/xyz.png")
    */
    public function deleteStoredFile($oldStoredFileURL)
    {
        // Start delete old stored file to server
        if ($oldStoredFileURL && file_exists($oldStoredFileURL))
            return unlink($oldStoredFileURL);
        // End delete old stored file to server
    }
}
