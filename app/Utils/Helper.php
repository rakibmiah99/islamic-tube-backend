<?php

namespace App\Utils;

class Helper
{
    static function ApiResponse($message, $data = null, $statusCode = 200, $success = true)
    {
        return response()->json([
            'status' => $success ? 'success' : 'error',
            'message' => $message,
            'figure' => $data,
        ], $statusCode);
    }

    public static function GetImage($path){
        return env("APP_URL").$path;
    }


    public static function FileUpload($request_key, $path){
        $uploadPath = env("APP_ENV") == "local" ? public_path($path) : base_path($path);
        if ($file = request()->file($request_key)){
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($uploadPath, $filename);

            // Save the file path in the database
            $photoPath = request()->root()."/$path/" . $filename;
            return $photoPath;
        }
        else{
            return false;
        }
    }



    public static function RemoveFile($path){
        if($path){
            try{
                $path = explode(request()->root(), $path);
                $path = $path[1];
            }
            catch(\Exception $e){
                $path = null;
            }
        }

        $filePath = env("APP_ENV") == "local" ? public_path($path) : base_path($path);

        // Delete the file from the server
        if ($path && file_exists($filePath)) {
            unlink($filePath);
        }

    }

    static public function ReadMarkdownFile($path)
    {
        if(env("APP_FOR") == "pwr"){
            $path = 'markdown/pwr/'.$path;
        }
        else{
            $path = 'markdown/'.$path;
        }
        $markdownFile = resource_path($path);
        // Check if the file exists
        if (!file_exists($markdownFile)) {
            abort(404, 'Markdown file not found');
        }

        // Read the content of the .md file
        return $markdownContent = file_get_contents($markdownFile);
    }

    static public function API_URL()
    {
        if(env("APP_FOR") == "pwr"){
            return 'https://api.programmingwithrakib.com';
        }
        else{
            return 'https://practice-api.sakibul-islam.xyz';
        }
    }

    static public function OpenSSLEncrypt($data)
    {
        $key = env('CUSTOM_ENCRYPTION_KEY'); // Custom key (can be stored in .env)
        $cipher = "aes-256-cbc";  // Cipher method (AES-256-CBC is commonly used)

        $iv = substr(hash('sha256', $key), 0, 16); // Initialization Vector (16 bytes)

        // Encrypting the data
        $encrypted = openssl_encrypt($data, $cipher, $key, 0, $iv);

        return $encrypted;
    }

    public static function OpenSSLDecrypt($encryptedData)
    {
        $key = env('CUSTOM_ENCRYPTION_KEY'); // Custom key
        $cipher = "aes-256-cbc";

        $iv = substr(hash('sha256', $key), 0, 16);  // Initialization Vector (16 bytes)

        // Decrypting the data
        $decrypted = openssl_decrypt($encryptedData, $cipher, $key, 0, $iv);

        return $decrypted;
    }

}
